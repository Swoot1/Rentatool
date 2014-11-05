<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/11/14
 * Time: 21:39
 */

namespace Application\Services;


use Application\Factories\MailFactory;
use Application\Mappers\ConfirmRentPeriodMapper;
use Application\Models\MailContent;
use Application\Models\User;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException;
use Application\PHPFramework\Validation\TextValidation;

class ConfirmRentPeriodService{

   private $confirmRentPeriodMapper;

   public function __construct(ConfirmRentPeriodMapper $confirmRentPeriodMapper){
      $this->confirmRentPeriodMapper = $confirmRentPeriodMapper;
   }

   public function confirmRentPeriod($id, User $currentUser){

      $isOwner = $this->confirmRentPeriodMapper->isRentalObjectOwner($id, $currentUser->getId());

      if ($isOwner === false){
         throw new ApplicationException('Kan inte godkänna uthyrningsperioder vars uthyrningsobjekt du inte är ägare av.');
      }

      $this->confirmRentPeriodMapper->confirmRentPeriod($id);

      return true;
   }

   public function sendRentPeriodConfirmation($id, $emailContent, MailFactory $mailFactory){
      $user = $this->getUserFromRentPeriodId($id);
      $this->validateEmailContent($emailContent);
      $mailContent = new MailContent(
         array(
            'subject'        => 'Bekräftelse från uthyrare.',
            'recipientEmail' => $user->getEmail(),
            'bodyHTML'       => $emailContent, // TODO lägg till info om objektet
            'bodyPlainText'  => $emailContent
         )
      );

      $mail = $mailFactory->build($mailContent);

      if (!$mail->send()){
         throw new ApplicationException(sprintf('Mailer Error: %s', $mail->ErrorInfo));
      }
   }

   private function validateEmailContent($emailContent){
      $emailValidation = new TextValidation(
         array(
            'genericName'  => 'meddelande',
            'propertyName' => 'email')
      );

      $emailValidation->validate($emailContent);
   }

   private function getUserFromRentPeriodId($id){
      $userData = $this->confirmRentPeriodMapper->getUserFromRentPeriodId($id);

      if ($userData === null){
         throw new NotFoundException('Kunde inte hitta användaren.');
      }

      return new User($userData);
   }
} 