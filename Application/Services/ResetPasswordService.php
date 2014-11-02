<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 30/09/14
 * Time: 10:21
 */

namespace Application\Services;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\ErrorHandling\Exceptions\NotFoundException;
use Application\PHPFramework\Validation\AlphaNumericValidation;
use Application\Factories\MailFactory;
use Application\Factories\ResetPasswordFactory;
use Application\Mappers\ResetPasswordMapper;
use Application\Models\MailContent;
use Application\Models\ResetPassword;
use Application\Models\User;

class ResetPasswordService{

   private $resetPasswordMapper;
   private $resetPasswordFactory;
   private $userService;

   public function __construct(ResetPasswordMapper $resetPasswordMapper, ResetPasswordFactory $resetPasswordFactory, UserService $userService){
      $this->resetPasswordMapper  = $resetPasswordMapper;
      $this->resetPasswordFactory = $resetPasswordFactory;
      $this->userService          = $userService;
   }

   public function create(array $data, MailFactory $mailFactory){
      $user              = $this->userService->getUserByEmail($this->getEmailFromArray($data));
      $resetPassword     = $this->resetPasswordFactory->build($user);
      $resetPasswordData = $this->resetPasswordMapper->create($resetPassword->getDBParameters());
      $resetPassword     = new ResetPassword($resetPasswordData);

      $this->sendResetPasswordEmail($resetPassword, $mailFactory, $user);
   }

   private function sendResetPasswordEmail(ResetPassword $resetPassword, MailFactory $mailFactory, User $user){

      $linkAddress = sprintf('%s/rentatool/#/passwords/new?resetCode=%s', $_SERVER['SERVER_NAME'], $resetPassword->getResetCode());
      $mailContent = new MailContent(array(
                                        'subject'        => 'Återställning av lösenord.',
                                        'recipientEmail' => $user->getEmail(),
                                        'bodyHTML'       => sprintf('Följ den här länken för att återställa ditt lösenord: <a href="%s">Klicka här!</a>', $linkAddress),
                                        'bodyPlainText'  => sprintf('Öppna den här adressen i din webbläsare för att återställa ditt lösenord %s', $linkAddress)
                                     ));

      $mail = $mailFactory->build($mailContent);

      if (!$mail->send()){
         throw new ApplicationException(sprintf('Mailer Error: %s', $mail->ErrorInfo));
      }
   }

   public function readActiveResetPassword($resetCode){
      $this->validateResetCode($resetCode);
      $result = $this->resetPasswordMapper->readActiveResetPassword($resetCode);

      if ($result === null){
         throw new NotFoundException('Det finns ingen aktiv lösenordsåterställning.');
      }

      return new ResetPassword($result);

   }

   /**
    * Instead of making a model with only the reset code I put the validation here.
    * @param $resetCode
    * @return bool
    */
   private function validateResetCode($resetCode){
      $resetCodeValidation = new AlphaNumericValidation(
         array(
            'propertyName' => 'resetCode',
            'genericName'  => 'återställningskod',
            'maxLength'    => 13
         )
      );

      $resetCodeValidation->validate($resetCode);

      return true;
   }

   /**
    * @param array $data
    * @return bool
    */
   private function getEmailFromArray(array $data){

      $email = array_key_exists('email', $data) ? $data['email'] : false;

      return $email;
   }

   public function delete($id){
      $this->resetPasswordMapper->delete($id);
   }
} 