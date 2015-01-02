<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-02
 * Time: 16:54
 * To change this template use File | Settings | File Templates.
 */

namespace Application\PHPFramework\Interfaces;

interface IIntegrationAdapter {

   public function getUrl();

   public function getRequestHeaders();

   public function getRequestBody();

}