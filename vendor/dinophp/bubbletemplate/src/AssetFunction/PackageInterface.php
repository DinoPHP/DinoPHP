<?php

/**
 * @author Ahmed Mohamed Ibrahim
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Bubble\AssetFunction;

/**
 * Asset package interface.
 *

 */
interface PackageInterface
{
    /**
     * Returns the asset version for an asset.
     *
     * @return string The version string
     */
    public function getVersion(string $path);

    /**
     * Returns an absolute or root-relative public path.
     *
     * @return string The public path
     */
    public function getUrl(string $path);
}
