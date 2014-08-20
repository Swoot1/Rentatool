<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-15
 * Time: 22:51
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Mappers;


use Rentatool\Application\ENFramework\Models\IDatabaseConnection;

class UserGroupConnectionMapper{

   private $getGroupMembershipsSQL = '
      SELECT
         user.id,
         user.username
      FROM
         user
      LEFT JOIN
         users_groups_maps map
      ON
         map.user_id = user.id
      WHERE
         map.group_id = :id
   ';

   private $getUserGroupsSQL = '
      SELECT
         usergroup.id,
         usergroup.name
      FROM
        user_groups usergroup
      LEFT JOIN
        users_groups_maps map
      ON
        map.group_id = usergroup.id
      WHERE
        map.user_id = :id
   ';

   private $addGroupMembershipQuery = '
      INSERT INTO
      users_groups_maps
      (
         group_id,
         user_id
      )
      VALUES
      (
         :groupId,
         :userId
      )
   ';

   private $removeGroupMembershipQuery = '
      DELETE FROM
         users_groups_maps
      WHERE
         group_id = :groupId
      AND
         user_id = :userId
   ';


   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }


   public function getGroupMembers($groupId){
      $result = $this->databaseConnection->runQuery($this->getGroupMembershipsSQL, ['id' => $groupId]);

      return $result;
   }


   public function getUserGroups($userId){
      $result = $this->databaseConnection->runQuery($this->getUserGroupsSQL, ['id' => $userId]);

      return $result;
   }


   public function addUserToGroup(array $userGroupConnection){
      $result = $this->databaseConnection->runQuery($this->addGroupMembershipQuery, $userGroupConnection);

      return $result;
   }


   public function removeUserFromGroup(array $userGroupConnection){
      $result = $this->databaseConnection->runQuery($this->removeGroupMembershipQuery, $userGroupConnection);

      return $result;
   }

}