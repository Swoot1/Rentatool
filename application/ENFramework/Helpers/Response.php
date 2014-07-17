<?php
/**
 * User: Elin
 * Date: 2014-07-07
 * Time: 11:29
 */

namespace Rentatool\Application\ENFramework\Helpers;

use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

/**
 * Class Header
 * Creates and can execute a header() based on its data.
 * @package Rentatool\Application\ENFramework\Helpers
 */
class Response implements IResponse
{

    private $protocol;
    private $statusCode = 200;
    private $contentType = 'application/json';
    private $charset = 'utf-8';
    private $data;

    public function __construct()
    {
        $this->setProtocol();
    }

    private function setProtocol()
    {
        $this->protocol = isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
        return $this;
    }

    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * Returns a response to the user based on the objects data.
     * @return $this
     */
    public function sendResponse()
    {
        $this->sendHeaders();
        $this->sendData();

        return $this;
    }

    /**
     * Sends the appropriate headers based on the objects data.
     * @return $this
     */
    private function sendHeaders()
    {
        $statusCodeText = $this->getResponseCodeString();
        $charset = $this->getCharsetString();
        $contentType = $this->getContentTypeString();

        header(sprintf("%s %s", $this->protocol, $statusCodeText), true, $this->statusCode);
        header($charset);
        header($contentType);

        return $this;
    }

    private function sendData()
    {
        echo $this->getFormattedData();
        return $this;
    }

    private function getContentTypeString()
    {
        return $this->contentType ? sprintf('Content-Type: %s', $this->contentType) : '';
    }

    private function getResponseCodeString()
    {
        return $this->statusCode ? sprintf('%s %s', $this->statusCode, $this->getResponseCodeText()) : '';
    }

    /**
     * Returns the text that should go with the response code.
     * @return string
     */
    private function getResponseCodeText()
    {
        switch ($this->statusCode) {
            case 100:
                $text = 'Continue';
                break;
            case 101:
                $text = 'Switching Protocols';
                break;
            case 200:
                $text = 'OK';
                break;
            case 201:
                $text = 'Created';
                break;
            case 202:
                $text = 'Accepted';
                break;
            case 203:
                $text = 'Non-Authoritative Information';
                break;
            case 204:
                $text = 'No Content';
                break;
            case 205:
                $text = 'Reset Content';
                break;
            case 206:
                $text = 'Partial Content';
                break;
            case 300:
                $text = 'Multiple Choices';
                break;
            case 301:
                $text = 'Moved Permanently';
                break;
            case 302:
                $text = 'Moved Temporarily';
                break;
            case 303:
                $text = 'See Other';
                break;
            case 304:
                $text = 'Not Modified';
                break;
            case 305:
                $text = 'Use Proxy';
                break;
            case 400:
                $text = 'Bad Request';
                break;
            case 401:
                $text = 'Unauthorized';
                break;
            case 402:
                $text = 'Payment Required';
                break;
            case 403:
                $text = 'Forbidden';
                break;
            case 404:
                $text = 'Not Found';
                break;
            case 405:
                $text = 'Method Not Allowed';
                break;
            case 406:
                $text = 'Not Acceptable';
                break;
            case 407:
                $text = 'Proxy Authentication Required';
                break;
            case 408:
                $text = 'Request Time-out';
                break;
            case 409:
                $text = 'Conflict';
                break;
            case 410:
                $text = 'Gone';
                break;
            case 411:
                $text = 'Length Required';
                break;
            case 412:
                $text = 'Precondition Failed';
                break;
            case 413:
                $text = 'Request Entity Too Large';
                break;
            case 414:
                $text = 'Request-URI Too Large';
                break;
            case 415:
                $text = 'Unsupported Media Type';
                break;
            case 500:
                $text = 'Internal Server Error';
                break;
            case 501:
                $text = 'Not Implemented';
                break;
            case 502:
                $text = 'Bad Gateway';
                break;
            case 503:
                $text = 'Service Unavailable';
                break;
            case 504:
                $text = 'Gateway Time-out';
                break;
            case 505:
                $text = 'HTTP Version not supported';
                break;
            default:
                exit('Unknown http status code "' . htmlentities($this->statusCode) . '"');
                break;
        }

        return $text;
    }

    private function getCharsetString()
    {
        return $this->charset ? sprintf('Charset:%s', $this->charset) : '';
    }

    /**
     * Returns the data as a string formatted in the correct contentType.
     * @return string
     * @throws ErrorHandling\Exceptions\ApplicationException
     * @throws \Exception
     */
    private function getFormattedData()
    {
        $contentType = mb_strtolower($this->contentType);

        switch ($contentType) {
            case 'application/json':
                $formattedData = $this->convertDataToJSON();
                break;
            case 'application/xml':
                $formattedData = $this->convertDataToXML();
                break;
            default:
                throw new ApplicationException('Ange en giltig content-type.');
                break;
        }

        return $formattedData;
    }

    /**
     * Returns the data array as json.
     * @return string
     */
    private function convertDataToJSON()
    {
        return json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Returns the data array as xml.
     * http://stackoverflow.com/questions/1397036/how-to-convert-array-to-simplexml
     * @return mixed
     */
    private function convertDataToXML()
    {
        $simpleXMLElement = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root/>');
        $this->arrayToXML($this->data, $simpleXMLElement);
        return $simpleXMLElement->asXML();
    }

    /**
     * Adds data to a simple xml element recursively.
     * @param array $data
     * @param \SimpleXMLElement $simpleXMLElement
     */
    private function arrayToXML(array $data, \SimpleXMLElement $simpleXMLElement)
    {

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