<?php

namespace Kcb\Bundle\VereinsheimBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class KcbVereinsheimExtension extends Extension {

    public function load(array $config, ContainerBuilder $container) {
        $locator = new FileLocator(__DIR__ . '/../Resources/config');
        $loader = new XmlFileLoader($container, $locator);
        $loader->load('services.xml');
    }

}