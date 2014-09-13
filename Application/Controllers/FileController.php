<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 11/09/14
 * Time: 17:13
 */

namespace Application\Controllers;


use Application\ENFramework\Helpers\ResponseFactory;
use Application\ENFramework\Models\Request;
use Application\Services\FileService;

class FileController{
   /**
    * @var \Application\Services\RentalObjectService
    */
   private $request;
   /**
    * @var \Application\Services\FileService
    */
   private $fileService;
   private $response;

   public function __construct(Request $request, FileService $fileService,
                               ResponseFactory $responseFactory){
      $this->request     = $request;
      $this->fileService = $fileService;
      $this->response    = $responseFactory->createResponse();
   }

   public function create(array $data){
      $file = $this->fileService->create($data);

      return $this->response
         ->setResponseData($file)
         ->setStatusCode(201);

   }
} 