<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-02
 * Time: 16:48
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Adapters;

use Application\Models\Contract;
use Application\PHPFramework\Configurations\FortnoxConfiguration;
use Application\PHPFramework\Interfaces\IIntegrationAdapter;

class FortnoxContractAdapter implements IIntegrationAdapter{

   private $contract;

   public function __construct(Contract $contract) {
      $this->contract = $contract;
      $this->contract->setContractTemplate(FortnoxConfiguration::getContractTemplate());
   }

   public function getUrl() {
      return FortnoxConfiguration::getUrl() . '/contracts/';
   }

   public function getRequestHeaders(){
      return FortnoxConfiguration::getRequestHeaders();
   }

   public function getRequestBody(){
      $customerData = $this->contract->getDBParameters();
      $customerArray = array_combine(
         array_map('ucfirst', array_keys($customerData)),
         array_values($customerData)
      );

      return json_encode(['Contract' => $customerArray]);
   }
}