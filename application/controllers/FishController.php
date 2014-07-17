<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:50
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Controllers;

use Rentatool\Application\ENFramework\Helpers\Response;
use Rentatool\Application\Services\FishService;

class FishController
{
    /**
     * @var \Rentatool\Application\Services\FishService
     */
    private $fishService;

    public function __construct(FishService $fishService)
    {
        $this->fishService = $fishService;
    }

    /**
     * @return Response
     */
    public function index()
    {
        $fishService = $this->fishService;
        $response = new Response(); // TODO instantiate elsewhere?
        $fishCollection = $fishService->index();
        $response->setData($fishCollection->toArray());
        return $response;
    }

    public function create(array $data)
    {
        $fishService = $this->fishService;
        $fish = $fishService->create($data);
        $response = new Response(); // TODO instantiate elsewhere?
        $response->setData($fish->toArray())->setStatusCode(201);
        return $response;
    }

    public function read($id)
    {
        $fishService = $this->fishService;
        $fish = $fishService->read($id);
        $response = new Response(); // TODO instantiate elsewhere?
        $response->setData($fish->toArray());
        return $response;
    }

    public function update($id, $requestData)
    {
        $fishService = $this->fishService;
        $fish = $fishService->update($id, $requestData);
        $response = new Response(); // TODO instantiate elsewhere?
        $response->setData($fish->toArray());
        return $response;
    }

    public function delete($id)
    {
        $this->fishService->delete($id);
        $response = new Response(); // TODO instantiate elsewhere?
        $response->setStatusCode(204);
        return $response;
    }
}