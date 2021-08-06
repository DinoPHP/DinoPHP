<?php

/**
 * @author Ahmed Mohamed Ibrahim
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Bubble\AssetFunction\Context;

/**
 * A context that does nothing.
 *
 
 */
class NullContext implements ContextInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBasePath()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function isSecure()
    {
        return false;
    }
}
