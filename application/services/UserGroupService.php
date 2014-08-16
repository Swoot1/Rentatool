<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-14
 * Time: 20:55
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Services;

use Rentatool\Application\Collections\UserGroupCollection;
use Rentatool\Application\Mappers\UserGroupMapper;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Rentatool\Application\Models\UserGroup;

class UserGroupService{

   private $userGroupMapper;

   public function __construct(UserGroupMapper $userGroupMapper){
      $this->userGroupMapper = $userGroupMapper;
   }


   public function index(){
      $userGroups = $this->userGroupMapper->index();

      return new UserGroupCollection($userGroups);
   }


   public function read($id){
      $userGroup = $this->userGroupMapper->read($id);

      return $userGroup ? new UserGroup($userGroup) : null;
   }


   public function update($id, array $data){
      $userGroup         = new UserGroup($data);
      $existingUserGroup = $this->userGroupMapper->read($id);

      if (!$existingUserGroup){
         throw new NotFoundException('Gruppen finns inte.');
      }

      $this->userGroupMapper->update($userGroup->getDBParameters());

      return $userGroup;
   }


   public function create(array $data){
      $userGroup = new UserGroup($data);
      $this->userGroupMapper->create($userGroup->getDBParameters());

      return $userGroup;
   }


   public function delete($id){
      $existingUserGroup = $this->userGroupMapper->read($id);

      if (!$existingUserGroup){
         throw new NotFoundException('Gruppen finns inte.');
      }

      $this->userGroupMapper->delete($id);
   }

}