<?php
namespace Karser\CustomInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class Installer extends LibraryInstaller
{
    /** @var array */
    private $installer_paths = null;

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

    private function getInstallerPaths()
    {
        if (is_null($this->installer_paths)) {
            $extra = $this->composer->getPackage()->getExtra();
            $this->installer_paths = isset($extra['installer-paths']) ? $extra['installer-paths'] : [];
        }

        return $this->installer_paths;
    }

    public function getInstallPath(PackageInterface $package)
    {
        $paths = $this->getInstallerPaths();
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
