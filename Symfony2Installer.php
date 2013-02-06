<?php
namespace Karser\CustomInstaller;

use Composer\Installers\BaseInstaller;

class Symfony2Installer extends BaseInstaller
{
    protected $locations = array(
        'bundle' => 'src/{$vendor}/{$name}/',
    );

    protected function mapCustomInstallPaths(array $paths, $name)
    {
        // allow for wildcard in name, e.g., "vendor/*-bundle"
        foreach ($paths as $path => $names) {
            $pattern = str_replace('*', '.*', '{^(' . implode('|', $names) . ')$}');

            if (preg_match($pattern, $name)) {
                return $path;
            }
        }

        return false;
    }
}
