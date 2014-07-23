<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:51
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Mappers;

use Rentatool\Application\ENFramework\Models\IDatabaseConnection;

class RentalObjectMapper
{
    /**
     * @var \Rentatool\Application\ENFramework\Models\IDatabaseConnection
     */
    private $databaseConnection;

    private $indexSQL = '
    SELECT
       id,
       user_id AS userId,
       name,
       available
    FROM
      rental_object';

    private $createSQL = '
       INSERT INTO
        rental_object
          (
            user_id,
            name,
            available
          )
      VALUES
        (
          :userId,
          :name,
          :available
        )
    ';

    private $readSQL = '
    SELECT
       id,
       user_id
       name,
       available
    FROM
      rental_object
    WHERE
      id = :id';

    private $updateSQL = '
       UPDATE
           rental_object
        SET
          user_id = user_id,
          name = :name,
          available = :available
        WHERE
          id = :id
    ';

    private $deleteSQL = '
        DELETE
          FROM
            rental_object
        WHERE
          id = :id

    ';

    public function __construct(IDatabaseConnection $databaseConnection){
        $this->databaseConnection = $databaseConnection;
    }

    public function index()
    {
        $rentalObjects = $this->databaseConnection->runQuery($this->indexSQL, array());
        return $rentalObjects;
    }

    public function create(array $DBParameters)
    {
        unset($DBParameters['id']);
         $DBParameters['available'] = (int)$DBParameters['available']; // TODO remove two lines.
         $DBParameters['userId'] = (int)$DBParameters['userId'];
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

    public function delete($id)
    {
        $query = $this->deleteSQL;
        return $this->databaseConnection->runQuery($query, array('id' => $id));
    }
}