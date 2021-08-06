<?php



namespace Bubble\Loader;

use Bubble\Error\LoaderError;
use Bubble\Source;

/**
 * Interface all loaders must implement.
*
 */
interface LoaderInterface
{
    /**
     * Returns the source context for a given template logical name.
     *
     * @throws LoaderError When $name is not found
     */
    public function getSourceContext(string $name): Source;

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @throws LoaderError When $name is not found
     */
    public function getCacheKey(string $name): string;

    /**
     * @param int $time Timestamp of the last modification time of the cached template
     *
     * @throws LoaderError When $name is not found
     */
    public function isFresh(string $name, int $time): bool;

    /**
     * @return bool
     */
    public function exists(string $name);
}
