<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 06/11/14
 * Time: 17:28
 */

namespace Application\PaymentResources;


use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;

class StripePayment{
   public function pay(array $data){
      // TODO Set your secret key: remember to change this to your live secret key in production and since it secret, keep it safe
      // See your keys here https://dashboard.stripe.com/account
      \Stripe::setApiKey("sk_test_owxuj5mzwv4ST8AHY7ECgO78");

      // Get the credit card details submitted by the form
      $token = $data['stripeToken'];

      // Create the charge on Stripe's servers - this will charge the user's card
      try{
         $charge = \Stripe_Charge::create(array(
                                            "amount"      => 30,
                                            "currency"    => "sek",
                                            "card"        => $token,
                                            "description" => "payinguser@example.com")
         );
      } catch (\Stripe_CardError $e){
         throw new ApplicationException('Ett fel har inträffat och betalningen genomfördes inte.');
      }
   }
} 