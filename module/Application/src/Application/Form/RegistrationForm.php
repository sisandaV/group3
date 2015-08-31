<?php
namespace Application\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'first_name',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'First name',
            ),
        ));
        

        $this->add(array(
            'name' => 'usr_name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));
		
        $this->add(array(
            'name' => 'usr_email',
            'attributes' => array(
                'type'  => 'email',
            ),
            'options' => array(
                'label' => 'E-mail',
            ),
        ));	
		
        $this->add(array(
            'name' => 'usr_password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
		
        $this->add(array(
            'name' => 'usr_password_confirm',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Confirm Password',
            ),
        ));	
//
//        $this->add(array(
//            'type' => 'captcha',
//            'name' => 'captcha',
//            'attributes' => array(
//                ),
//            'options' => array(
//                'label' => 'Human check',
//            'captcha' => array(
//                'class' => 'Image',
//                'imgDir' => 'public/img/captcha',
//                'suffix' => '.png',
//                'imgUrl' => '/img/captcha/',
//                'imgAlt' => 'CAPTCHA Image',
//                'font' => './public/fonts/ThorneShaded.ttf',
//                'fsize' => 24,
//                'width' => 350,
//                'height' => 100,
//                'expiration' => 600,
//                'dotNoiseLevel' => 40,
//                'lineNoiseLevel' => 3
//                ),
//            ),
//        ));
                
                // Add the CSRF field
        $this->add(array(
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                'timeout' => 600
                )
            ),
         ));
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Submit',
                'id' => 'submitbutton',
            ),
        )); 
    }
}