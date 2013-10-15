<?php
/**
 * This file is part of the PrestaCMSContactBundle.
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSContactBundle\Block;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Form;
use Presta\CMSCoreBundle\Block\BaseBlockService;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class ContactBlockService extends BaseBlockService
{
    /**
     * @var string
     */
    protected $template = 'PrestaCMSContactBundle:Block:block_contact.html.twig';

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @return Form
     */
    protected function getContactForm()
    {
        return $this->formFactory->create('presta_cms_contact', array(), array());
    }

    /**
     * @param FormFactory $formFactory
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function trans($id, array $parameters = array())
    {
        return $this->translator->trans($id, $parameters, 'PrestaCMSContactBundle');
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSettings()
    {
        return array(
            'title' => $this->trans('block.default.title'),
            'intro' => $this->trans('block.default.intro')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAdditionalViewParameters(BlockInterface $block)
    {
        $settings = array_merge($this->getDefaultSettings(), $block->getSettings());

        $settings['form'] = $this->getContactForm()->createView();

        return $settings;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormSettings(FormMapper $formMapper, BlockInterface $block)
    {
        return array(
            array('title', 'text', array('required' => false, 'label' => $this->trans('form.label.title'))),
            array('intro', 'textarea', array('required' => false, 'label' => $this->trans('form.label.intro')))
        );
    }
}
