<?php

namespace Instaxer;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;


class YamlLoader
{
    public function locator($name)
    {
        $configDirectories = array(__DIR__ . '/../config');

        $locator = new FileLocator($configDirectories);
        return $locator->locate($name, null, false);
    }

    public function load($resource, $type = null)
    {
        $configValues = Yaml::parse(file_get_contents($resource));
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo(
                $resource,
                PATHINFO_EXTENSION
            );
    }
}
