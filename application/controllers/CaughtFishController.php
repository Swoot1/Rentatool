<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 19:27
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Controllers;

use Rentatool\Application\ENFramework\Helpers\Response;
use Rentatool\Application\Services\CaughtFishService;

class CaughtFishController
{
    /**
     * @var \Rentatool\Application\Services\CaughtFishService
     */
    private $caughtFishService;

    public function __construct(CaughtFishService $caughtFishService)
    {
        $this->caughtFishService = $caughtFishService;
    }

    public function index()
    {
        $caughtFishService = $this->caughtFishService;
        $caughtFish = $caughtFishService->index();
        $response = new Response();
        $response->setData($caughtFish->toArray());
        return $response;
    }

    public function create(array $data)
    {
        $caughtFishService = $this->caughtFishService;
        return $caughtFishService->create($data);
    }
}