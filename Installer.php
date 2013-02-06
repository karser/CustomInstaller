<?php
namespace Karser\CustomInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class Installer extends LibraryInstaller
{
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

    public function getInstallPath(PackageInterface $package)
    {
//        $extra = $this->package->getExtra();
//        if (!empty($extra['installer-paths'])) {
//            $prettyName = $package->getPrettyName();
//            $customPath = $this->mapCustomInstallPaths($extra['installer-paths'], $prettyName);
//            if ($customPath !== false) {
//                list($vendor, $name) = explode('/', $prettyName);
//                $vendor = ucfirst($vendor);
//                $name = ucfirst($name);
//
//                return 'src/' . $vendor . '/' . $name . '/';
//            }
//        }

        return parent::getInstallPath($package);
    }

    public function supports($packageType)
    {
        return true;
    }
}
