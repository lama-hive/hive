<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Factory;

use Exception;
use Lamahive\Hive\Framework\ObjectManager;
use ReflectionClass;
use ReflectionParameter;

readonly class AbstractFactory
{
    /**
     * @throws Exception
     */
    protected function make(string $fqn, array $params = [])
    {
        try {
            $rc = new ReflectionClass($fqn);

            $constParams = $rc->getConstructor()?->getParameters();
            if (is_null($constParams)) {
                return new $fqn;
            }

            $populatedParams = $this->populateParams($constParams, $params);

            return new $fqn(...$populatedParams);
        } catch (Exception $exception) {
            // @todo custom exception
            throw $exception;
        }
    }

    /**
     * @param ReflectionParameter[] $constParams
     * @param array $params
     * @return array
     * @throws Exception
     */
    private function populateParams(array $constParams, array $params): array
    {
        $populated = [];
        foreach ($constParams as $constParam) {
            $populated[$constParam->getName()] = $params[$constParam->getName()] ?? $this->makeObject($constParam->getType()?->getName());
        }

        return $populated;
    }

    /**
     * @throws Exception
     */
    private function makeObject(string $fqn): object
    {
        try {
            return ObjectManager::getContainer()->get($fqn);
        } catch (Exception $e) {
            // @todo custom exception
            throw $e;
        }
    }
}
