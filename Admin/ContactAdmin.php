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
use Sonata\AdminBundle\Form\FormMapper;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class ContactAdmin extends Admin
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
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with($this->trans('form.fieldset.label_general'))
                ->add('name', null, array('label' => 'form.label.name'))
                ->add('email', 'email', array('label' => 'form.label.email'))
            ->end();
    }
}
