<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Model\Register;
use Application\Model\RegisterTable;
use Application\Form\RegistrationForm;
use Application\Form\RegistrationFilter;

use Application\Form\ForgottenPasswordForm;
use Application\Form\ForgottenPasswordFilter;

use Zend\Mail\Message;

class RegistrationController extends AbstractActionController
{
	protected $registerTable;	
	
        public function getRegisterTable()
        {
            if (!$this->registerTable) {
                $sm = $this->getServiceLocator();
                $this->registerTable = $sm->get('Application\Model\RegisterTable');
            }
            return $this->registerTable;
        }
        
	public function registerAction()
	{
               // Check if user has submitted the form
         // Create Contact Us form
        $form = new RegistrationForm();
        
        // Check if user has submitted the form
        $request = $this->getRequest();
        if($request->isPost()) {
            
            // Fill in the form with POST data
                     
            $form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            
            // Validate form
            if($form->isValid()) {
                // Get filtered and validated data
                $data = $form->getData();
                
                $data = $this->prepareData($data);
                $user = new Register();
                $user->exchangeArray($data);
                
                //$user->exchangeArray($form->getData());
                $this->getRegisterTable()->saveUser($user);
                
                $mailSender = new \Application\Service\MailSender();
                
                $messageBody = "Please, click the link to confirm your registration => ". 
					$this->getRequest()->getServer('HTTP_ORIGIN').
					$this->url()->fromRoute('application/default', array(
						'controller' => 'registration', 
						'action' => 'confirm-email', 
						'id' => $user->usr_registration_token));
                
                $mailSender->sendContactMail('jonas.gift83@gmail.com', $user->usr_email, 'Your App Confirmation Email', $messageBody); 
                
                    $this->flashMessenger()->addMessage($user->usr_email);
                    return $this->redirect()->toRoute('application/default', 
                            array('controller'=>'registration', 'action'=>'registration-success'));
                            
        } 
        }
        // Pass form variable to view
        return new ViewModel(array(
            'form' => $form
        ));
		
	
        }
        
        public function confirmEmailAction()
	{
		$token = $this->params()->fromRoute('id');
		$viewModel = new ViewModel(array('token' => $token));
		try {
			$user = $this->getRegisterTable()->getUserByToken($token);
			$usr_id = $user->usr_id;
			$this->getRegisterTable()->activateUser($usr_id);
		}
		catch(\Exception $e) {
			$viewModel->setTemplate('application/registration/confirm-email-error.phtml');
		}
		return $viewModel;
	}
        
        public function registrationSuccessAction()
	{
		$usr_email = null;
		$flashMessenger = $this->flashMessenger();
		if ($flashMessenger->hasMessages()) {
			foreach($flashMessenger->getMessages() as $key => $value) {
				$usr_email .=  $value;
			}
		}
		return new ViewModel(array('usr_email' => $usr_email));
	}
        
        public function forgottenPasswordAction()
	{
		$form = new ForgottenPasswordForm();
		$form->get('submit')->setValue('Send');
		$request = $this->getRequest();
                if ($request->isPost()) {
			$form->setInputFilter(new ForgottenPasswordFilter($this->getServiceLocator()));
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$data = $form->getData();
				$usr_email = $data['usr_email'];
				$registerTable = $this->geRegisterTable();
				$auth = $registerTable->getUserByEmail($usr_email);
				$password = $this->generatePassword();
				$auth->usr_password = $this->encriptPassword($this->getStaticSalt(), $password, $auth->usr_password_salt);
//				$usersTable->changePassword($auth->usr_id, $password);
// 				or
				$registerTable->saveUser($auth);
				$this->sendPasswordByEmail($usr_email, $password);
				$this->flashMessenger()->addMessage($usr_email);
                return $this->redirect()->toRoute('application/default', array('controller'=>'registration', 'action'=>'password-change-success'));
			}					
		}		
		return new ViewModel(array('form' => $form));			
	}
	
	public function passwordChangeSuccessAction()
	{
		$usr_email = null;
		$flashMessenger = $this->flashMessenger();
		if ($flashMessenger->hasMessages()) {
			foreach($flashMessenger->getMessages() as $key => $value) {
				$usr_email .=  $value;
			}
		}
		return new ViewModel(array('usr_email' => $usr_email));
	}
        
        public function prepareData($data)
	{
		$data['usr_active'] = 0;
		$data['usr_password_salt'] = $this->generateDynamicSalt();				
		$data['usr_password'] = $this->encriptPassword(
			$this->getStaticSalt(), 
			$data['usr_password'], 
			$data['usr_password_salt']
		);
                //usrl_id => 1-guest, 2 registered-user, 3-admin
		$data['usrl_id'] = 2;
		$data['lng_id'] = 1;
//		$data['usr_registration_date'] = date('Y-m-d H:i:s');
		$date = new \DateTime();
		$data['usr_registration_date'] = $date->format('Y-m-d H:i:s');
		$data['usr_registration_token'] = md5(uniqid(mt_rand(), true)); // $this->generateDynamicSalt();
//		$data['usr_registration_token'] = uniqid(php_uname('n'), true);	
		$data['usr_email_confirmed'] = 0;
		return $data;
	}
        
         public function generateDynamicSalt()
        {
            $dynamicSalt = '';
            for ($i = 0; $i < 50; $i++) {
                    $dynamicSalt .= chr(rand(33, 126));
            }
            return $dynamicSalt;
        }
        
         public function getStaticSalt()
        {
            $staticSalt = '';
            $config = $this->getServiceLocator()->get('Config');
            $staticSalt = $config['static_salt'];		
            return $staticSalt;
        }
        
        public function encriptPassword($staticSalt, $password, $dynamicSalt)
       {
                   return $password = md5($staticSalt . $password . $dynamicSalt);
       }
       
		
}