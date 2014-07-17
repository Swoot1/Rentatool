<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 19:31
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Mappers;

use Rentatool\Application\ENFramework\Models\IDatabaseConnection;

class CaughtFishMapper
{
    /**
     * @var \Rentatool\Application\ENFramework\Models\IDatabaseConnection
     */
    private $databaseConnection;

    private $indexSQL = 'SELECT
        caught_fish.id AS id,
        fish_id AS fishId,
        user_id AS userId,
        weight,
        measurement
        FROM caught_fish';

    private $createSQL = '
       INSERT INTO
        caught_fish
          (
          fish_id,
          user_id,
          weight,
          measurement
          )
      VALUES
        (
          :fishId,
          :userId,
          :weight,
          :measurement
          )
    ';

    public function __construct(IDatabaseConnection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    public function index()
    {
        $caughtFishData = $this->databaseConnection->runQuery($this->indexSQL);
        return $caughtFishData;
    }

    public function create($params)
    {
        unset($params['id']);
        $result = $this->databaseConnection->runQuery($this->createSQL, $params);
        return $result;
    }
}