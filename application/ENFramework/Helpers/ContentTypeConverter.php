<?php
/**
 * User: Elin
 * Date: 2014-07-31
 * Time: 08:17
 */

namespace Rentatool\Application\ENFramework\Helpers;


class ContentTypeConverter {
   /**
    * Returns the data array as json.
    * @param $data
    * @return string
    */
   public function convertDataToJSON($data) {
      return json_encode($data, JSON_UNESCAPED_UNICODE);
   }

   /**
    * Returns the data array as xml.
    * http://stackoverflow.com/questions/1397036/how-to-convert-array-to-simplexml
    * @param array $data
    * @return mixed
    */
   public function convertDataToXML(array $data) {
      $simpleXMLElement = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root/>');
      $this->arrayToXML($data, $simpleXMLElement);

      return $simpleXMLElement->asXML();
   }

   /**
    * Adds data to a simple xml element recursively.
    * @param array $data
    * @param \SimpleXMLElement $simpleXMLElement
    */
   private function arrayToXML(array $data, \SimpleXMLElement $simpleXMLElement) {

      foreach ($data as $key => $value) {
         if (is_array($value)) {
            if (!is_numeric($key)) {
               $subNode = $simpleXMLElement->addChild($key);
               $this->arrayToXML($value, $subNode);
            } else {
               $subNode = $simpleXMLElement->addChild("item$key");
               $this->arrayToXML($value, $subNode);
            }
         } else {
            $simpleXMLElement->addChild($key, htmlspecialchars($value));
         }
      }
   }
} 