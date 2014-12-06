<?php

namespace App\Web\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class AssetResolverExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('asset', [$this, 'asset']);
    }

    public function asset($path)
    {
        $actualPath = $path;

        $hasLeadingSlash = strpos($path, '/') === 0;

        if ($hasLeadingSlash) {
            $actualPath = substr($actualPath, 1);
        }

        return sprintf('/web/%s', $actualPath);
    }
}
