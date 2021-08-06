<?php



namespace Bubble\RuntimeLoader;

/**
 * Creates runtime implementations for Bubble elements (filters/functions/tests).
*
 */
interface RuntimeLoaderInterface
{
    /**
     * Creates the runtime implementation of a Bubble element (filter/function/test).
     *
     * @return object|null The runtime instance or null if the loader does not know how to create the runtime for this class
     */
    public function load(string $class);
}
