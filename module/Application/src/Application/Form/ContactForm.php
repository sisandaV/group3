<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

 // A feedback form model
 class ContactForm extends Form
 {
    // Constructor.
    public function __construct()
    {
       // Define form name
       parent::__construct('contact-form');
       // Set POST method for this form
       $this->setAttribute('method', 'post');
       
       // (Optionally) set action for this form
       $this->setAttribute('action', '/contactus');
       
       $this->addElements();
       $this->addInputFilter();
    }
    
    protected function addElements()
    {
        // Add "email" field
        $this->add(array(            
            'type'  => 'text',
            'name' => 'email',
            'attributes' => array(
                'id' => 'email',
              
            ),
            'options' => array(
                'label' => 'Your E-mail',
            ),
        ));
        
        // Add "subject" field
        $this->add(array(
            'type'  => 'text',
            'name' => 'subject',
            'attributes' => array(
                'id' => 'subject'
            ),
            'options' => array(
                'label' => 'Subject',
            ),
        ));
        
        // Add "body" field
        $this->add(array(
            'type'  => 'textarea',
            'name' => 'body',
            'attributes' => array(                
                'id' => 'body'
            ),
            'options' => array(
                'label' => 'Message',
            ),
        ));
        
        
        $this->add(array(
            'type' => 'radio',
            'name' => 'payment',
            'options' => array(
                //'label' => 'Payment',
                'value_options' => array(
                    'pay' => 'Paypal',
                    'credit' => 'Credit Card',
                ),
                'Separator' => '      ',
            ),
        ));
        
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
            'type' => 'captcha',
            'name' => 'captcha',
            'attributes' => array(
                ),
            'options' => array(
                'label' => 'Human check',
            'captcha' => array(
                'class' => 'Image',
                'imgDir' => 'public/img/captcha',
                'suffix' => '.png',
                'imgUrl' => '/img/captcha/',
                'imgAlt' => 'CAPTCHA Image',
                'font' => './public/fonts/ThorneShaded.ttf',
                'fsize' => 24,
                'width' => 350,
                'height' => 100,
                'expiration' => 600,
                'dotNoiseLevel' => 40,
                'lineNoiseLevel' => 3
                ),
            ),
        ));
        
        
     
        // Add the submit button
        $this->add(array(
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => array(                
                'value' => 'Submit',
                'id' => 'submitbutton',
            ),
        ));
    }
    
     private function addInputFilter()
    {
         $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
        
        $inputFilter->add(array(
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),                    
                ),                
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
                        'options' => array(
                            'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                            'useMxCheck'    => false,                            
                        ),
                    ),
                ),
            )
        );
        
        $inputFilter->add(array(
                'name'     => 'subject',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    array('name' => 'StripNewLines'),
                ),                
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 128
                        ),
                    ),
                ),
            )
        );
        
        $inputFilter->add(array(
                'name'     => 'body',
                'required' => true,
                'filters'  => array(                    
                    array('name' => 'StripTags'),
                ),                
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 4096
                        ),
                    ),
                ),
            )
        );
    }
}