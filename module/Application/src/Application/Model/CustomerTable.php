<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomerTable
 *
 * @author Pepukayi
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;   

class CustomerTable 
{
    protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()      //retrieve all the records in the customer table
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getCustomer($email)     // retrieves one record of customer depending on their email address 
     {
         $email  = $email;
         $rowset = $this->tableGateway->select(array('email' => $email));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $email");
         }
         return $row;
     }

     public function saveCustomer(Customer $cust)    // will save record to database 
     {
         $data = array(
             'email' => $cust->email,
             'subject'  => $cust->subject,
             'body'  => $cust->body,
             'payment'  => $cust->payment,
         );

         $email = $cust->email;
         if ($email == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getCustomer($email)) {
                 $this->tableGateway->update($data, array('email' => $email));
             } else {
                 throw new \Exception('Email does not exist');
             }
         }
     }

     public function deleteCustomer($email)   // delete a record 
     {
         $this->tableGateway->delete(array('email' => $email));
     }
}
