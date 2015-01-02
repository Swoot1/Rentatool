<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-02
 * Time: 20:42
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Mappers;


use Application\PHPFramework\Interfaces\IIntegrationAdapter;

class ContractMapper {

   public function create(IIntegrationAdapter $adapter) {
      $ch = curl_init($adapter->getUrl());
      curl_setopt($ch, CURLOPT_POSTFIELDS, $adapter->getRequestBody());
      curl_setopt($ch, CURLOPT_HTTPHEADER, $adapter->getRequestHeaders());
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_exec($ch);
   }

}