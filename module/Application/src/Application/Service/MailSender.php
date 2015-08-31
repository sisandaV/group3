<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MailSender
 *
 * @author chitondop
 */

namespace Application\Service;

 use Zend\Mail;
 use Zend\Mail\Message;
 use Zend\Mail\Transport\Sendmail;
 use Zend\Mime;

 // This class is used to deliver an E-mail message to recipient.
 class MailSender {

 // Sends the contact mail message.
    public function sendContactMail($sender, $recipient, $subject, $text)
    {

        $result = false;
        try {

        // Create E-mail message
        $mail = new Message();
        $mail->setFrom($sender);
        $mail->addTo($recipient);
        $mail->setSubject($subject);
        $mail->setBody($text);

        // Send E-mail message
        $transport = new Sendmail('-f'.$sender);
        $transport->send($mail);
        $result = true;
        } catch(\Exception $e) {
        $result = false;
        }

        // Return status
        return $result;
    }
    
    public function sendCareerMail($sender, $recipient, $subject, $text, $filepath, $candidateName)
    {

        $result = false;
        try {
        //add attachment
        $text = new Mime\Part($text);
        $text->type = Mime\Mime::TYPE_TEXT;
        $text->charset = 'utf-8';

        $fileContent = fopen($filepath, 'r');
        $attachment = new Mime\Part($fileContent);
        $attachment->type = 'application/pdf';
        $attachment->filename = $candidateName;
        $attachment->disposition = Mime\Mime::DISPOSITION_ATTACHMENT;
        // Setting the encoding is recommended for binary data
        $attachment->encoding = Mime\Mime::ENCODING_BASE64;

        // then add them to a MIME message
        $mimeMessage = new Mime\Message();
        $mimeMessage->setParts(array($text, $attachment));
        

        // and finally we create the actual email
        $message = new Message();
        $message->setBody($mimeMessage);
        $message->setFrom($sender);
        $message->addTo($recipient);
        $message->setSubject($subject);
        
        // Send E-mail message
        $transport = new Sendmail('-f'.$sender);
        $transport->send($message);
        $result = true;
        } catch(\Exception $e) {
        $result = false;
        }

        // Return status
        return $result;
    }
 }
