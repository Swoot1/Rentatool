<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:51
 */

namespace Rentatool\Application\Services;

use Rentatool\Application\Collections\FishCollection;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;
use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\NotFoundException;
use Rentatool\Application\Mappers\FishMapper;
use Rentatool\Application\Models\Fish;

class FishService
{
    /**
     * @var \Rentatool\Application\Mappers\FishMapper
     */
    private $fishMapper;

    public function __construct(FishMapper $fishMapper)
    {
        $this->fishMapper = $fishMapper;
    }

    public function index()
    {
        $fishData = $this->fishMapper->index();
        return new FishCollection($fishData);
    }

    public function create(array $data)
    {
        $fishModel = new Fish($data);
        $DBParameters = $fishModel->getDBParameters();
        $result = $this->fishMapper->create($DBParameters);
        return $fishModel;
    }

    public function read($id)
    {
        $fishData = $this->fishMapper->read($id);
        return $fishData ? new Fish($fishData) : null;
    }

    public function update($id, $requestData)
    {
        $savedFish = $this->read($id);

        if ($savedFish == null) {
            throw new NotFoundException('Kunde inte hitta fisk.');
        }

        $fish = new Fish($requestData);

        $this->fishMapper->update($fish->getDBParameters());
        return $requestData ? new Fish($requestData) : null;
    }

    public function delete($id)
    {
        return $this->fishMapper->delete($id);
    }
}