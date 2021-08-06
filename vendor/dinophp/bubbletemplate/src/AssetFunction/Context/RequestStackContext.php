<?php

/**
 * @author Ahmed Mohamed Ibrahim
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Bubble\AssetFunction\Context;

use Bubble\HttpFoundation\RequestStack;

/**
 * Uses a RequestStack to populate the context.
 *
 
 */
class RequestStackContext implements ContextInterface
{
    private $requestStack;
    private $basePath;
    private $secure;

    public function __construct(RequestStack $requestStack, string $basePath = '', bool $secure = false)
    {
        $this->requestStack = $requestStack;
        $this->basePath = $basePath;
        $this->secure = $secure;
    }

    /**
     * {@inheritdoc}
     */
    public function getBasePath()
    {
        if (!$request = $this->requestStack->getMainRequest()) {
            return $this->basePath;
        }

        return $request->getBasePath();
    }

    /**
     * {@inheritdoc}
     */
    public function isSecure()
    {
        if (!$request = $this->requestStack->getMainRequest()) {
            return $this->secure;
        }

        return $request->isSecure();
    }
}
