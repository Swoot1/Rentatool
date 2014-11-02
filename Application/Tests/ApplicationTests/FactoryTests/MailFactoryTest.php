<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 05/10/14
 * Time: 14:15
 */

namespace Tests\FactoryTests;


use Application\Factories\MailFactory;
use Application\Models\MailContent;
use Application\PHPFramework\Configurations\MailConfiguration;

class MailFactoryTest extends \PHPUnit_Framework_TestCase{

   public function testBuild(){
      $mailContent = new MailContent(
         array('recipientEmail' => 'elin.nilsson@elin.se',
               'subject'        => 'Fantastiska testfall',
               'bodyHTML'       => '<h1>Rubrik</h1><p>Massa härlig text.</p>',
               'bodyPlainText'  => 'Rubrik och massa härlig text.')
      );

      $mailConfiguration = new MailConfiguration();

      $mailFactory = new MailFactory(new \PHPMailer(), $mailConfiguration);
      $mail        = $mailFactory->build($mailContent);

      $this->assertInstanceOf('\PHPMailer', $mail);
   }
} 