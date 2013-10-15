<?php
/**
 * This file is part of the PrestaCMSContactBundle.
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSContactBundle\Strategy;

use Presta\CMSContactBundle\Model\Message;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class EmailStrategy implements StrategyInterface
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var EngineInterface
     */
    protected $templateEngine;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $emailFrom;

    /**
     * @var string
     */
    protected $emailTo;

    /**
     * @param Translator $translator
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param EngineInterface $templateEngine
     */
    public function setTemplateEngine($templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    /**
     * @param \Swift_Mailer $mailer
     */
    public function setMailer($mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $emailFrom
     */
    public function setEmailFrom($emailFrom)
    {
        $this->emailFrom = $emailFrom;
    }

    /**
     * @param string $emailTo
     */
    public function setEmailTo($emailTo)
    {
        $this->emailTo = $emailTo;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Message $message)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($this->translator->trans('email.subject', array(), 'PrestaCMSContactBundle'))
            ->setFrom($this->emailFrom)
            ->setTo($this->emailTo)
            ->setBody(
                $this->templateEngine->render(
                    'PrestaCMSContactBundle:Default:contact-email.txt.twig',
                    array('message' => $message)
                )
            );

        $this->mailer->send($message);
    }
}
