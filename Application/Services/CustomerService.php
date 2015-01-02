<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-02
 * Time: 17:54
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Services;


use Application\Adapters\FortnoxCustomerAdapter;
use Application\Mappers\CustomerMapper;
use Application\Models\Customer;

class CustomerService{

   public function create(){
      $customerMapper = new CustomerMapper();
      $customer       = new Customer([
                                     'name'     => 'Anki',
                                     'address1' => 'Fjädergatan 3',
                                     'address2' => '',
                                     'zipCode'  => '123412',
                                     'city'     => 'Ankeborg'
                                     ]);

      $customerAdapter = new FortnoxCustomerAdapter($customer);
      $customerMapper->create($customerAdapter);
   }

}