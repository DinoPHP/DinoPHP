<?php



namespace Bubble\RuntimeLoader;

use Psr\Container\ContainerInterface;

/**
 * Lazily loads Bubble runtime implementations from a PSR-11 container.
 *
 * Note that the runtime services MUST use their class names as identifiers.
*
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class ContainerRuntimeLoader implements RuntimeLoaderInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function load(string $class)
    {
        return $this->container->has($class) ? $this->container->get($class) : null;
    }
}
