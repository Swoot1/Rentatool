<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-14
 * Time: 21:10
 * To change this template use File | Settings | File Templates.
 */

namespace Application\ENFramework\Helpers;


use Application\ENFramework\Models\IDatabaseConnection;

class Session{

   private $database;

   public function __construct(IDatabaseConnection $database){
      $this->database = $database;

      session_name('User');

      session_set_save_handler(
         array($this, "_open"),
         array($this, "_close"),
         array($this, "_read"),
         array($this, "_write"),
         array($this, "_destroy"),
         array($this, "_gc")
      );

      session_start();
   }

   public function _open(){
      return !empty($this->database);
   }

   public function _close(){
      return true;
   }

   public function _read($id){
      $result = $this->database->runQuery('SELECT data FROM sessions WHERE id = :id', ['id' => $id]);
      $data   = array_shift($result);

      return !empty($data) ? $data['data'] : '';
   }

   public function _write($id, $data){
      $access = time();
      $this->database->runQuery('REPLACE INTO sessions VALUES (:id, :access, :data)', ['id' => $id, 'access' => $access, 'data' => $data]);
   }

   public function _destroy($id){
      $this->database->runQuery('DELETE FROM sessions WHERE id = :id', ['id' => $id]);
   }

   public function _gc($max){
      $old = time() - $max;
      $this->database->runQuery('DELETE * FROM sessions WHERE access < :old', ['old' => $old]);
   }
}
