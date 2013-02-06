<?php
namespace Karser\CustomInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class Installer extends LibraryInstaller
{
    protected function mapCustomInstallPaths(array $paths, $name)
    {
        foreach ($paths as $path => $names) {
            $pattern = str_replace('*', '.*', '{^(' . implode('|', $names) . ')$}');
            if (preg_match($pattern, $name)) {
                return $path;
            }
        }

        return false;
    }

    public function getInstallPath(PackageInterface $package)
    {
        $extra = $this->composer->getPackage()->getExtra();
        $paths = $extra['installer-paths'];
        if (!empty($paths)) {
            $prettyName = $package->getPrettyName();
            $customPath = $this->mapCustomInstallPaths($paths, $prettyName);
            if ($customPath !== false) {
                return $customPath . $package->getTargetDir();
            }
        }

        return parent::getInstallPath($package);
    }

    public function supports($packageType)
    {
        return true;
    }
}
