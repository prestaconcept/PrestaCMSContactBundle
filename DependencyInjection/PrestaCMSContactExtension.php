<?php
/**
 * This file is part of the PrestaCMSContactBundle
 *
 * (c) PrestaConcept <www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSContactBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class PrestaCMSContactExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('admin.xml');

        $hasProvider = false;
        if ($config['persistence']['orm']['enabled']) {
            $this->loadOrmProvider($config['persistence']['orm'], $loader, $container);
            $hasProvider = true;
        }

        if (!$hasProvider) {
            throw new InvalidConfigurationException(
                'PrestaCMSContactBundle, you need to either enable one of the persistence layers'
            );
        }
    }

    /**
     * Load configuration for Doctrine ORM persistence layer
     *
     * @param array             $config
     * @param XmlFileLoader     $loader
     * @param ContainerBuilder  $container
     */
    public function loadOrmProvider($config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        $container->setParameter($this->getAlias() . '.persistence.orm.manager_name', $config['manager_name']);
        $container->setParameter($this->getAlias() . '.backend_type_orm', true);
        $loader->load('persistence-orm.xml');
    }
}
