<?php

namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Form\Auth\CreateForm;

class AuthController extends AbstractActionController
{
    public function createAction()
    {
        $form = new CreateForm();

        return new ViewModel([
            'form' => $form,
        ]);
    }
}