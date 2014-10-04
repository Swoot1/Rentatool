<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 01/10/14
 * Time: 11:46
 */

namespace Application\Models;


use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\EmailValidation;
use Application\PHPFramework\Validation\TextValidation;
use Application\PHPFramework\Models\GeneralModel;

class MailContent extends GeneralModel{

   protected $recipientEmail;
   protected $subject;
   protected $bodyHTML;
   protected $bodyPlainText;

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(array(
                                                            new TextValidation(
                                                               array(
                                                                  'propertyName' => 'subject',
                                                                  'genericName'  => 'rubrik',
                                                                  'maxLength'    => '140'
                                                               )
                                                            ),
                                                            new TextValidation(
                                                               array(
                                                                  'propertyName' => 'bodyPlainText',
                                                                  'genericName'  => 'innehåll',
                                                                  'maxLength'    => '3000'
                                                               )
                                                            ),
                                                            new EmailValidation(
                                                               array(
                                                                  'propertyName' => 'recipientEmail',
                                                                  'genericName'  => 'mottagarens epost-adress'
                                                               )
                                                            )
                                                         ));
   }

   public function getRecipientEmail(){
      return $this->recipientEmail;
   }

   public function getSubject(){
      return $this->subject;
   }

   public function getBodyHTML(){
      return $this->bodyHTML;
   }

   public function getBodyPlainText(){
      return $this->bodyPlainText;
   }
} 