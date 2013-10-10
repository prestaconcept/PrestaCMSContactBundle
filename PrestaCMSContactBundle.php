<?php
/**
 * This file is part of the PrestaCMSContactBundle
 *
 * (c) PrestaConcept <www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSContactBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class PrestaCMSContactBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->addRegisterMappingsPass($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        if (class_exists('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass')) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createXmlMappingDriver(
                    array(
                        realpath($this->getPath()  . '/Resources/config/doctrine-model') => 'Presta\CMSContactBundle\Model',
                        realpath($this->getPath()  . '/Resources/config/doctrine-orm')   => 'Presta\CMSContactBundle\Doctrine\Orm'
                    ),
                    array('presta_cms_contact.persistence.orm.manager_name'),
                    'presta_cms_contact.backend_type_orm'
                )
            );
        }
    }
}
