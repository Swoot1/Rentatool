<?php
/**
 * User: Elin
 * Date: 2014-06-20
 * Time: 12:49
 */

namespace Rentatool\Application\ENFramework\Helpers\DependencyInjection;

use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

class DependencyInjection
{
    private $dependencyInjectionXML;

    public function __construct(\SimpleXMLElement $dependencyInjectionXML)
    {
        $this->dependencyInjectionXML = $dependencyInjectionXML;
    }

    public function getInstantiatedClass($className)
    {
        return $this->getClassFromXML(array('class' => $className));
    }

    /**
     * Gets the first resource as a reflection class that matches the associated array $attributes
     * @param array $attributes
     * @return null|object
     */
    private function getClassFromXML(array $attributes)
    {
        $matchingXMLElement = $this->getMatchingXMLElement($attributes);

        if ($matchingXMLElement) {
            $result = $this->createClassInstanceFromXML($matchingXMLElement);

        } else {
            $result = null;
        }

        return $result;

    }

    /**
     * Queries the xml for a dependency element with the corresponding
     * attributes returning the first match.
     * @param array $attributes
     * @return mixed
     */
    private function getMatchingXMLElement(array $attributes)
    {
        $attributesQuery = $this->getAttributesQuery($attributes);
        $matchingResources = $this->dependencyInjectionXML->xpath('dependencies/dependency' . $attributesQuery);
        return array_shift($matchingResources);
    }

    /**
     * Make a string of the attributes i.e. array('class' => 'user', 'id' => 'UserController')
     * becomes '[@class=user and @id=UserController]'
     * @param array $attributes
     * @return string
     */
    private function getAttributesQuery(array $attributes)
    {
        $attributeStrings = array();
        foreach ($attributes as $attributeName => $attributeValue) {
            $attributeStrings[] = sprintf('@%s="%s"', $attributeName, $attributeValue);
        }

        return count($attributeStrings) > 0 ? sprintf('[%s]', implode(' and ', $attributeStrings)) : '';
    }

    /**
     * Returns a reflection class of the class corresponding to the simpleXMLElement.
     * @param \SimpleXMLElement $matchingResource
     * @param array $dependencies
     * @return object
     */
    private function createClassInstanceFromXML(\SimpleXMLElement $matchingXMLElement)
    {
        $classDependencies = $this->getClassDependencies($matchingXMLElement);
        $className = sprintf('\%s\%s', (string)$matchingXMLElement->attributes()->namespace, (string)$matchingXMLElement->attributes()->class);
        $reflectionClass = new \ReflectionClass($className);

        return $reflectionClass->newInstanceArgs($classDependencies);

    }

    /**
     * Returns an array of the dependencies needed for creating the class
     * from matchingResource.
     * @param \SimpleXMLElement $matchingXMLElement
     * @return array
     * @throws \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
     */
    private function getClassDependencies(\SimpleXMLElement $matchingXMLElement)
    {
        $dependencies = array();

        foreach ($matchingXMLElement->dependencies->dependency as $dependency) {
            $dependencyClass = $this->getClassFromXML(array(
                    'namespace' => (string)$dependency['namespace'],
                    'class' => (string)$dependency['class'])
            );

            if ($dependencyClass == null) {
                throw new ApplicationException('Hittade inte dependency.');
            }

            $dependencies[] = $dependencyClass;
        }

        return $dependencies;
    }
} 