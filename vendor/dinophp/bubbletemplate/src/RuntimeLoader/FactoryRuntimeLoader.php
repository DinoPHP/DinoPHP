<?php



namespace Bubble\RuntimeLoader;

/**
 * Lazy loads the runtime implementations for a Bubble element.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class FactoryRuntimeLoader implements RuntimeLoaderInterface
{
    private $map;

    /**
     * @param array $map An array where keys are class names and values factory callables
     */
    public function __construct(array $map = [])
    {
        $this->map = $map;
    }

    public function load(string $class)
    {
        if (!isset($this->map[$class])) {
            return null;
        }

        $runtimeFactory = $this->map[$class];

        return $runtimeFactory();
    }
}
