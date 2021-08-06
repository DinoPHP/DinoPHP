<?php

/**
 * @author Ahmed Mohamed Ibrahim
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Bubble\AssetFunction\VersionStrategy;

use Bubble\Contracts\HttpClient\HttpClientInterface;


class RemoteJsonManifestVersionStrategy implements VersionStrategyInterface
{
    private $manifestData;
    private $manifestUrl;
    private $httpClient;

    /**
     * @param string $manifestUrl Absolute URL to the manifest file
     */
    public function __construct(string $manifestUrl, HttpClientInterface $httpClient)
    {
        $this->manifestUrl = $manifestUrl;
        $this->httpClient = $httpClient;
    }

    /**
     * With a manifest, we don't really know or care about what
     * the version is. Instead, this returns the path to the
     * versioned file.
     */
    public function getVersion(string $path)
    {
        return $this->applyVersion($path);
    }

    public function applyVersion(string $path)
    {
        if (null === $this->manifestData) {
            $this->manifestData = $this->httpClient->request('GET', $this->manifestUrl, [
                'headers' => ['accept' => 'application/json'],
            ])->toArray();
        }

        return $this->manifestData[$path] ?? $path;
    }
}
