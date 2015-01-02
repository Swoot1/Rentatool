<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-02
 * Time: 21:31
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Services;


use Application\Adapters\FortnoxContractAdapter;
use Application\Mappers\ContractMapper;
use Application\Models\Contract;

class ContractService{

   public function create(){
      $contractMapper  = new ContractMapper();
      $contract        = new Contract(['customerNumber' => '2']);
      $contractAdapter = new FortnoxContractAdapter($contract);

      $contractMapper->create($contractAdapter);
   }

}