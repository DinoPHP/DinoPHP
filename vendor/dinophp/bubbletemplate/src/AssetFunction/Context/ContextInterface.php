<?php

/**
 * @author Ahmed Mohamed Ibrahim
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Bubble\AssetFunction\Context;

/**
 * Holds information about the current request.
 *
 
 */
interface ContextInterface
{
    /**
     * Gets the base path.
     *
     * @return string The base path
     */
    public function getBasePath();

    /**
     * Checks whether the request is secure or not.
     *
     * @return bool true if the request is secure, false otherwise
     */
    public function isSecure();
}
