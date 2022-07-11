<?php

namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Form\Auth\LoginForm;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
        $loginForm = new LoginForm();

        return (new ViewModel([
            'form' => $loginForm,
        ]))->setTemplate('user/auth/login');
    }
}