<?php

namespace User\Controller;

use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use RuntimeException;
use User\Form\Auth\CreateForm;
use User\Model\Table\UsersTable;

class AuthController extends AbstractActionController
{
    private $usersTable;

    public function __construct(UsersTable $usersTable)
    {
        $this->usersTable = $usersTable;
    }

    public function createAction()
    {
        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        $form = new CreateForm();
        $request = $this->getRequest();

        if($request->isPost()) {
            $formData = $request->getPost()->toArray();
            //$form->setInputFilter($this->usersTable->getCreateFormFilter());
            $form->setData($formData);
            if($form->isValid()) {
                try {
                    $data = $form->getData();
                    $this->usersTable->saveAccount($data);
                    $this->flashMessenger()->addSuccessMessage('Account successfully created. You can now login');

                    return $this->redirect()->toRoute('home');
                } catch(RuntimeException $exception) {
                    $this->flashMessenger()->addErrorMessage($exception->getMessage());
                    return $this->redirect()->refresh();
                }
            }
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }
}