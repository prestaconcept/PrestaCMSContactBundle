<?php
/**
 * This file is part of the PrestaCMSContactBundle.
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSContactBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class MessageAdmin extends Admin
{
    /**
     * The translation domain to be used to translate messages
     *
     * @var string
     */
    protected $translationDomain = 'PrestaCMSContactBundle';

    /**
     * {@inheritdoc}
     */
    protected $parentAssociationMapping = 'contact';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('edit');
        $collection->remove('delete');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        if (!$this->isChild()) {
            $datagridMapper->add('contact');
        }

        $datagridMapper->add(
            'createdAt',
            'doctrine_orm_date_range',
            array(
                'field_options' => array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'attr'   => array(
                        'class' => 'datepicker',
                    ),
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        if (!$this->isChild()) {
            $listMapper->add('contact');
        }

        $listMapper
            ->add('shortContent')
            ->add('createdAt')
            ->add('_action', 'actions', array('actions' => array('show' => array())));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('contact')
            ->add('content')
            ->add('createdAt');
    }
}
