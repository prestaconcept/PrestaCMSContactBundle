<?php
/**
 * This file is part of the PrestaCMSContactBundle.
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'presta_cms_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'form.label.name', 'translation_domain' => 'PrestaCMSContactBundle'))
            ->add('email', 'email', array('label' => 'form.label.email', 'translation_domain' => 'PrestaCMSContactBundle'))
            ->add('message', 'textarea', array('label' => 'form.label.message', 'translation_domain' => 'PrestaCMSContactBundle'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(
            array(
                'name'      => new NotBlank(),
                'email'     => new Email(),
                'message'   => new NotBlank(),
            )
        );

        $resolver->setDefaults(
            array(
                'constraints' => $collectionConstraint
            )
        );
    }
}
