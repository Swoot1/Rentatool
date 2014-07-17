<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 19:46
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Models;


class DatabaseConnection implements IDatabaseConnection
{
    /**
     * @var \PDO
     */
    private $databaseConnection;

    public function __construct()
    {
        $databaseConnection = new \PDO(sprintf('sqlite:%s/Rentatool/test.sq3', PROJECT_ROOT));
        $databaseConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->databaseConnection = $databaseConnection;
    }

    public function runQuery($query, $params = array())
    {
        $queryResult = array();
        $DBConnection = $this->databaseConnection;

        $stmt = $DBConnection->prepare($query);
        $stmt->execute($params);

        while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $queryResult[] = $result;
        }

        return $queryResult;
    }
}