<?php

/**
 * @author Ahmed Mohamed Ibrahim
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Bubble\AssetFunction\VersionStrategy;

/**
 * Asset version strategy interface.
 *
 
 */
interface VersionStrategyInterface
{
    /**
     * Returns the asset version for an asset.
     *
     * @return string The version string
     */
    public function getVersion(string $path);

    /**
     * Applies version to the supplied path.
     *
     * @return string The versionized path
     */
    public function applyVersion(string $path);
}
