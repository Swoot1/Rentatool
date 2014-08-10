<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 20:28
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Collections;

use Rentatool\Application\ENFramework\Helpers\Interfaces\IGetDBParameters;
use Rentatool\Application\ENFramework\Helpers\Interfaces\IToArray;

abstract class GeneralCollection implements IToArray, IGetDBParameters{

   protected $data = array();
   protected $model;

   /**
    * @param array $data
    */
   public function __construct(array $data = array()){
      foreach ($data as $modelData){
         if ($modelData instanceof $this->model){
            $this->data[] = $modelData;
         } else{
            $this->data[] = new $this->model($modelData);
         }
      }

      return $this;
   }

   /**
    * @return array
    */
   public function toArray(){
      $result = array();

      foreach ($this->data as $model){
         $result[] = $model->toArray();
      }

      return $result;
   }

   /**
    * @return array
    */
   public function getDBParameters(){
      $result = array();

      foreach ($this->data as $model){
         $result[] = $model->getDBParameters();
      }

      return $result;
   }
}