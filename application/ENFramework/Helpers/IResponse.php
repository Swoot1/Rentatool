<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-07-08
 * Time: 20:40
 */
namespace GoFish\Application\ENFramework\Helpers;


/**
 * Class Header
 * Creates and can execute a header() based on its data.
 * @package GoFish\Application\ENFramework\Helpers
 */
interface IResponse
{
    public function setStatusCode($code);

    /**
     * Returns a response to the user based on the objects data.
     * @return $this
     */
    public function sendResponse();

    public function setData($data);
}