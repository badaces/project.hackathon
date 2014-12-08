<?php

namespace App\Web\Plates\Extension;

use CBC\Utility\Configuration;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class AssetResolverExtension implements ExtensionInterface
{
    /**
     * @var bool
     */
    private $isLocal;

    public function __construct(Configuration $configuration)
    {
        $this->isLocal = $configuration->get('app.local');
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('asset', [$this, 'asset']);
    }

    public function asset($path)
    {
        $actualPath = $path;
        $newPath = '/web/%s';

        if ($this->isLocal) {
            $newPath = '/%s';
        }

        $hasLeadingSlash = strpos($path, '/') === 0;

        if ($hasLeadingSlash) {
            $actualPath = substr($actualPath, 1);
        }

        return sprintf('/web/%s', $actualPath);
    }
}
