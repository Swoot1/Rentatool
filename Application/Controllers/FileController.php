<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 11/09/14
 * Time: 17:13
 */

namespace Application\Controllers;

use Application\PHPFramework\Response\Factories\ResponseFactory;
use Application\Services\FileService;

class FileController{
   /**
    * @var \Application\Services\FileService
    */
   private $fileService;
   private $response;

   public function __construct(FileService $fileService, ResponseFactory $responseFactory){
      $this->fileService = $fileService;
      $this->response = $responseFactory->build();
   }

   public function create(array $data){
      $file = $this->fileService->create($data);

      return $this->response
         ->setResponseData($file)
         ->setStatusCode(201);

   }
} 