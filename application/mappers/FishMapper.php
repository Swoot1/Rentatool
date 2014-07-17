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

class FishMapper
{
    /**
     * @var \Rentatool\Application\ENFramework\Models\IDatabaseConnection
     */
    private $databaseConnection;

    private $indexSQL = '
    SELECT
       id,
       name
    FROM
      fish';

    private $createSQL = '
       INSERT INTO
        fish
          (
          name
          )
      VALUES
        (
          :name
        )
    ';

    private $readSQL = '
    SELECT
       id,
       name
    FROM
      fish
    WHERE
      id = :id';

    private $updateSQL = '
       UPDATE
           fish
        SET
          name = :name
        WHERE
          id = :id
    ';

    private $deleteSQL = '
        DELETE
          FROM
            fish
        WHERE
          id = :id

    ';

    public function __construct(IDatabaseConnection $databaseConnection){
        $this->databaseConnection = $databaseConnection;
    }

    public function index()
    {
        $fishes = $this->databaseConnection->runQuery($this->indexSQL, array());
        return $fishes;
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

    public function delete($id)
    {
        $query = $this->deleteSQL;
        return $this->databaseConnection->runQuery($query, array('id' => $id));
    }
}