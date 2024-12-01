<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Core;

use Lamahive\Hive\Framework\Core\Exception\ObjectBuildException;
use ReflectionClass;
use ReflectionException;

class DI
{
    private array $objects = [];

    /**
     * @throws ObjectBuildException
     */
    public function get(string $fqn): object
    {
        return $this->objects[$fqn] ?? $this->build($fqn);
    }

    public function register(string $fqn, object $object): void
    {
        $this->objects[$fqn] = $object;
    }

    /**
     * @throws ObjectBuildException
     */
    private function build(string $fqn): mixed
    {
        try {
            $reflection = new ReflectionClass($fqn);
            $dependencies = $this->load($reflection);

            $this->objects[$fqn] = new $fqn(...$dependencies);

            return $this->objects[$fqn];
        } catch (ReflectionException $e) {
            throw new ObjectBuildException("DI could not build an object $fqn", $e->getCode(), $e);
        }
    }

    /**
     * @throws ObjectBuildException
     */
    private function load(ReflectionClass $reflection): array
    {
        $constructor = $reflection->getConstructor();
        $parameters = $constructor ? $constructor->getParameters() : [];

        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependencies[] = $this->build($parameter->getType()->getName());
        }

        return $dependencies;
    }
}
