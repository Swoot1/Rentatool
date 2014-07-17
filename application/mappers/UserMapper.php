<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:42
 */

namespace Rentatool\Application\Mappers;

use Rentatool\Application\ENFramework\Models\IDatabaseConnection;

class UserMapper
{

    /**
     * @var \Rentatool\Application\ENFramework\Models\IDatabaseConnection
     */
    private $databaseConnection;
    private $indexSQL = '
    SELECT
       id,
       username,
       email
    FROM
      user';

    private $createSQL = '
       INSERT INTO
        user
          (
          username,
          email,
          password
          )
      VALUES
        (
          :username,
          :email,
          :password
        )
    ';

    private $readSQL = '
    SELECT
       id,
       username,
       email
    FROM
      user
    WHERE
      id = :id';

    private $getUserByEmailSQL = '
        SELECT
            id,
            username,
            email,
            password
        FROM
          user
        WHERE
          email = :email
    ';

    private $updateSQL = '
       UPDATE
           user
        SET
          username = :username,
          email = :email,
          password = :password
        WHERE
          id = :id
    ';

    private $deleteSQL = '
        DELETE
          FROM
            user
        WHERE
          id = :id

    ';

    public function __construct(IDatabaseConnection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    public function index()
    {
        $users = $this->databaseConnection->runQuery($this->indexSQL, array());
        return $users;
    }

    public function create(array $DBParameters)
    {
        unset($DBParameters['id']);
        $query = $this->createSQL;
        return $this->databaseConnection->runQuery($query, $DBParameters);
    }

    public function update(array $DBParameters)
    {
        $query = $this->updateSQL;
        return $this->databaseConnection->runQuery($query, $DBParameters);
    }

    public function read($id)
    {
        $result = $this->databaseConnection->runQuery($this->readSQL, array('id' => $id));
        return array_shift($result);
    }

    public function getUserByEmail($email)
    {
        $result = $this->databaseConnection->runQuery($this->getUserByEmailSQL, array('email' => $email));
        return array_shift($result);
    }

    public function delete($id)
    {
        $query = $this->deleteSQL;
        return $this->databaseConnection->runQuery($query, array('id' => $id));
    }
} 