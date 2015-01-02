<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-02
 * Time: 16:48
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Adapters;

use Application\Models\Customer;
use Application\PHPFramework\Configurations\FortnoxConfiguration;
use Application\PHPFramework\Interfaces\IIntegrationAdapter;

class FortnoxCustomerAdapter implements IIntegrationAdapter{

   private $customer;

   public function __construct(Customer $customer){
      $this->customer = $customer;
   }

   public function getUrl() {
      return FortnoxConfiguration::getUrl() . '/customers/';
   }

   public function getRequestHeaders(){
      return FortnoxConfiguration::getRequestHeaders();
   }

   public function getRequestBody(){
      $customerData = $this->customer->getDBParameters();
      $customerArray = array_combine(
         array_map('ucfirst', array_keys($customerData)),
         array_values($customerData)
      );

      return json_encode(['Customer' => $customerArray]);
   }
}