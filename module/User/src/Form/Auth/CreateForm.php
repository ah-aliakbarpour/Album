<?php

namespace User\Form\Auth;

use Laminas\Form\Element;
use Laminas\Form\Form;

class CreateForm extends Form
{
    public function __construct()
    {
        parent::__construct('new_account');
        $this->setAttribute('method', 'post');

        // Username
        $this->add([
            'type' => Element\Text::class,
            'name' => 'username',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'required' => true,
                'size' => 40,
                'maxlength' => 25,
                'pattern' => '^[a-zA-Z0-9]+$',
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'placeholder' => 'Enter Your Username',
            ]
        ]);

        // Gender select
        $this->add([
            'type' => Element\Select::class,
            'name' => 'gender',
            'options' => [
                'label' => 'Gender',
                'empty_option' => 'Select...',
                'value_options' => [
                    'Female' => 'Female',
                    'Male' => 'Male',
                    'Other' => 'Other',
                ],
            ],
            'attributes' => [
                'required' => true,
                'class' => 'custom-select',
            ]
        ]);

        // Email
        $this->add([
            'type' => Element\Email::class,
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'required' => true,
                'size' => 40,
                'maxlength' => 128,
                'pattern' => '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'placeholder' => 'Enter Your Email',
            ]
        ]);

        // Birthday select
        $this->add([
            'type' => Element\DateSelect::class,
            'name' => 'birthday',
            'options' => [
                'label' => 'Select Your Birthday',
                'create_empty_option' => true,
                'max_year' => date('Y') - 13,
                'year_attributes' => [
                    'class' => 'custom-select w-30',
                    'style' => 'width: 140px;',
                ],
                'month_attributes' => [
                    'class' => 'custom-select w-30',
                    'style' => 'width: 140px;',
                ],
                'day_attributes' => [
                    'class' => 'custom-select w-30',
                    'style' => 'width: 140px;',
                ],
            ],
            'attributes' => [
                'required' => true,
            ]
        ]);

        // Password
        $this->add([
            'type' => Element\Password::class,
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'required' => true,
                'size' => 40,
                'maxlength' => 25,
                'autocomplete' => false,
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'placeholder' => 'Enter Your Password',
            ]
        ]);

        // Confirm Password
        $this->add([
            'type' => Element\Password::class,
            'name' => 'confirm_password',
            'options' => [
                'label' => 'Verify Password',
            ],
            'attributes' => [
                'required' => true,
                'size' => 40,
                'maxlength' => 25,
                'autocomplete' => false,
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'placeholder' => 'Enter Your Password Again',
            ]
        ]);

        // cross-site-request-forgery (csrf)
        $this->add([
            'type' => Element\Csrf::class,
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600,
                ],
            ],
        ]);

        // Submit Button
        $this->add([
            'type' => Element\Submit::class,
            'name' => 'create_account',
            'attributes' => [
                'value' => 'Create Account',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}