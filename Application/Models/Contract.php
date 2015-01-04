<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-02
 * Time: 20:44
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Models;


use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;

class Contract extends GeneralModel {

   protected $templateNumber;
   protected $customerNumber;
   protected $continuous = true;

   public function setUpValidation() {
      $this->_validation = new ValueValidationCollection(array());
   }

   public function setContractTemplate($contractTemplate) {
      $this->templateNumber = $contractTemplate;
   }

}