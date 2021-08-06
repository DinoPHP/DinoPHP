<?php

/**
 * @author Ahmed Mohamed Ibrahim
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Bubble\AssetFunction\VersionStrategy;

/**
 * Disable version for all assets.
 *
 
 */
class EmptyVersionStrategy implements VersionStrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getVersion(string $path)
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function applyVersion(string $path)
    {
        return $path;
    }
}
