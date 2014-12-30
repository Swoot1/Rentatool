<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-12-30
 * Time: 20:15
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Services;


use Application\Factories\MailFactory;
use Application\Mappers\RentalNotificationMapper;
use Application\Models\MailContent;
use Application\Models\RentalNotification;
use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class RentalNotificationService{

   private $mailFactory;
   private $rentalNotificationMapper;

   public function __construct(MailFactory $mailFactory, RentalNotificationMapper $rentalNotificationMapper){
      $this->mailFactory              = $mailFactory;
      $this->rentalNotificationMapper = $rentalNotificationMapper;
   }

   public function create($rentalObjectId){
      $data               = $this->rentalNotificationMapper->read($rentalObjectId);
      $rentalNotification = new RentalNotification($data);
      $mailContent        = new MailContent(array(
                                                 'subject'        => 'Ditt objekt har hyrts ut',
                                                 'recipientEmail' => $rentalNotification->getRenterEmail(),
                                                 'bodyHTML'       => sprintf('Ditt objekt "%s" har hyrts ut. För detaljer, logga in på <a href="http://hyrdet.se">hyrdet.se</a>', $rentalNotification->getRentalObjectName()),
                                                 'bodyPlainText'  => sprintf('Ditt objekt %s har hyrts ut. För detaljer, logga in på hyrdet.se', $rentalNotification->getRentalObjectName())
                                            ));

      $mail = $this->mailFactory->build($mailContent);

      if (!$mail->send()){
         throw new ApplicationException(sprintf('Mailer Error: %s', $mail->ErrorInfo));
      }
   }
}