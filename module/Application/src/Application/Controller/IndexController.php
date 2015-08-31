<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;

use Application\Model\Customer;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Application\Form\ContactForm;
use Application\Form\RegistrationForm;
use Application\Form\LoginForm;
use Application\Model\Register;

class IndexController extends AbstractActionController
{
    protected $customerTable;
    public function indexAction()
    {
        return new ViewModel();
    }
    
     public function getCustomerTable()
     {
         if (!$this->customerTable) {
             $sm = $this->getServiceLocator();
             $this->customerTable = $sm->get('Application\Model\CustomerTable');
         }
         return $this->customerTable;
     }
     
     public function customersAction()
     {
          return new ViewModel(array(
             'customers' => $this->getCustomerTable()->fetchAll(),
         ));
     }
    
    public function contactAction()
    {
        
        if($this->getRequest()->isPost()) 
        {

            // Retrieve form data from POST variables
            $data = $this->params()->fromPost();

            // ... Do something with the data ...
            //var_dump($data);
        }

        return new ViewModel();
    }
    
    public function contactusAction()
    {
        // Check if user has submitted the form
         // Create Contact Us form
        $form = new ContactForm();
        
        // Check if user has submitted the form
        if($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
                $customer = new Customer();
                $customer->exchangeArray($data);
                /*$email = $data['email'];
                $subject = $data['subject'];
                $body = $data['body'];
                $payment = $data['payment'];*/
                
                //$customer->exchangeArray($form->getData());
                $this->getCustomerTable()->saveCustomer($customer);
                
                
                /*// Send E-mail
                $mailSender = new MailSender();
                if(!$mailSender->sendMail('no-reply@example.com', $email, $subject, $body)) {
                    // In case of error, redirect to "Error Sending Email" page
                    return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'index', 'action'=>'sendError'));
                }*/
                
                // Redirect to "Thank You" page
                return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'index', 'action'=>'thankYou'));
            }               
        } 
        
        // Pass form variable to view
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function loginAction()
	{
		$user = $this->identity();
		$form = new LoginForm();
		$form->get('submit')->setValue('Login');
		$messages = null;

		$request = $this->getRequest();
                if ($request->isPost()) 
                {
                        $registerFormFilters = new Register();
                        $form->setInputFilter($registerFormFilters->getInputFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$data = $form->getData();
				$sm = $this->getServiceLocator();
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
				$config = $this->getServiceLocator()->get('Config');
				$staticSalt = $config['static_salt'];

				$authAdapter = new AuthAdapter($dbAdapter,
                                        'registration', // there is a method setTableName to do the same
                                        'usr_name', // there is a method setIdentityColumn to do the same
                                        'usr_password', // there is a method setCredentialColumn to do the same
                                        "MD5(CONCAT('$staticSalt', ?, usr_password_salt)) AND usr_active = 1" // setCredentialTreatment(parametrized string) 'MD5(?)'
										  );
				$authAdapter
					->setIdentity($data['usr_name'])
					->setCredential($data['usr_password'])
				;
				
				$auth = new AuthenticationService();
				// or prepare in the globa.config.php and get it from there. Better to be in a module, so we can replace in another module.
				// $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
				// $sm->setService('Zend\Authentication\AuthenticationService', $auth); // You can set the service here but will be loaded only if this action called.
				$result = $auth->authenticate($authAdapter);			
				
				switch ($result->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						// do stuff for nonexistent identity
						break;

					case Result::FAILURE_CREDENTIAL_INVALID:
						// do stuff for invalid credential
						break;

					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(
							null,
							'usr_password'
						));
						$time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
//						if ($data['rememberme']) $storage->getSession()->getManager()->rememberMe($time); // no way to get the session
						if ($data['rememberme']) {
							$sessionManager = new \Zend\Session\SessionManager();
							$sessionManager->rememberMe($time);
						}
						break;

					default:
						// do stuff for other failure
						break;
				}				
				foreach ($result->getMessages() as $message) {
					$messages .= "$message\n"; 
				}			
			 }
		}
		return new ViewModel(array('form' => $form, 'messages' => $messages));
	}
        
        public function logoutAction()
	{
		$auth = new AuthenticationService();
		// or prepare in the globa.config.php and get it from there
		// $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
		}			
		
		$auth->clearIdentity();
//		$auth->getStorage()->session->getManager()->forgetMe(); // no way to get the sessionmanager from storage
		$sessionManager = new \Zend\Session\SessionManager();
		$sessionManager->forgetMe();
		
		return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'logout'));		
	}	
    
    public function thankYouAction() 
    {
        return new ViewModel();
    }

    public function kidneyAction() {
        return new ViewModel();
    }

    public function eventsAction() {
        return new ViewModel();
    }
 public function aboutAction() {
        return new ViewModel();
    }
    public function galleryAction() {
        return new ViewModel();
    }

    public function blogAction() {
        return new ViewModel();
    }
 public function donationsAction() {
        return new ViewModel();
    }
}
