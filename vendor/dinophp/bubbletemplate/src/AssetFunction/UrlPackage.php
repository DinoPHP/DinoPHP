<?php

/**
 * @author Ahmed Mohamed Ibrahim
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Bubble\AssetFunction;

use Bubble\AssetFunction\Context\ContextInterface;
use Bubble\AssetFunction\VersionStrategy\VersionStrategyInterface;
use mysql_xdevapi\Exception;

class UrlPackage extends Package
{
    private $baseUrls = [];
    private $sslPackage;

    /**
     * @param string|string[] $baseUrls Base asset URLs
     */
    public function __construct($baseUrls, VersionStrategyInterface $versionStrategy, ContextInterface $context = null)
    {
        parent::__construct($versionStrategy, $context);

        if (!\is_array($baseUrls)) {
            $baseUrls = (array) $baseUrls;
        }

        if (!$baseUrls) {
            throw new Exception('You must provide at least one base URL.');
        }

        foreach ($baseUrls as $baseUrl) {
            $this->baseUrls[] = rtrim($baseUrl, '/');
        }

        $sslUrls = $this->getSslUrls($baseUrls);

        if ($sslUrls && $baseUrls !== $sslUrls) {
            $this->sslPackage = new self($sslUrls, $versionStrategy);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl(string $path)
    {
        if ($this->isAbsoluteUrl($path)) {
            return $path;
        }

        if (null !== $this->sslPackage && $this->getContext()->isSecure()) {
            return $this->sslPackage->getUrl($path);
        }

        $url = $this->getVersionStrategy()->applyVersion($path);

        if ($this->isAbsoluteUrl($url)) {
            return $url;
        }

        if ($url && '/' != $url[0]) {
            $url = '/'.$url;
        }

        return $this->getBaseUrl($path).$url;
    }

    /**
     * Returns the base URL for a path.
     *
     * @return string The base URL
     */
    public function getBaseUrl(string $path)
    {
        if (1 === \count($this->baseUrls)) {
            return $this->baseUrls[0];
        }

        return $this->baseUrls[$this->chooseBaseUrl($path)];
    }

    /**
     * Determines which base URL to use for the given path.
     *
     * Override this method to change the default distribution strategy.
     * This method should always return the same base URL index for a given path.
     *
     * @return int The base URL index for the given path
     */
    protected function chooseBaseUrl(string $path)
    {
        return (int) fmod(hexdec(substr(hash('sha256', $path), 0, 10)), \count($this->baseUrls));
    }

    private function getSslUrls(array $urls)
    {
        $sslUrls = [];
        foreach ($urls as $url) {
            if ('https://' === substr($url, 0, 8) || '//' === substr($url, 0, 2)) {
                $sslUrls[] = $url;
            } elseif (null === parse_url($url, \PHP_URL_SCHEME)) {
                throw new InvalidArgumentException(sprintf('"%s" is not a valid URL.', $url));
            }
        }

        return $sslUrls;
    }
}
