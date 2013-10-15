<?php
/**
 * This file is part of the PrestaCMSContactBundle.
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Presta\CMSContactBundle\Model;


use Presta\CMSContactBundle\Strategy\StrategyInterface;
use Symfony\Component\Form\Form;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
abstract class ContactManager
{
    /**
     * @var string
     */
    protected $modelClassName;

    /**
     * @var string
     */
    protected $modelMessageClassName;

    /**
     * @var StrategyInterface
     */
    protected $strategy;

    /**
     * @param string $modelClassName
     */
    public function setModelClassName($modelClassName)
    {
        $this->modelClassName = $modelClassName;
    }

    /**
     * @param string $modelMessageClassName
     */
    public function setModelMessageClassName($modelMessageClassName)
    {
        $this->modelMessageClassName = $modelMessageClassName;
    }

    /**
     * @param StrategyInterface $strategy
     */
    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @return Contact
     */
    protected function getNewContactInstance()
    {
        return new $this->modelClassName();
    }

    /**
     * @return Message
     */
    protected function getNewMessageInstance()
    {
        return new $this->modelMessageClassName();
    }

    /**
     * @param mixed $object
     */
    abstract public function create($object);

    /**
     * @param mixed $object
     */
    abstract public function update($object);

    abstract public function flush();

    /**
     * {@inheritDoc}
     */
    abstract public function findContactBy(array $criteria);

    /**
     * Return a contact for this email
     *
     * @return Contact
     */
    public function getContactForEmail($email)
    {
        $contact = $this->findContactBy(array('email' => $email));

        if ($contact == null) {
            $contact = $this->getNewContactInstance();
            $contact->setEmail($email);
            $this->create($contact);
        }

        return $contact;
    }

    /**
     * @param  Contact $contact
     * @param  string  $content
     * @return Message
     */
    public function createMessageForContact(Contact $contact, $content)
    {
        $message = $this->getNewMessageInstance();
        $message->setContact($contact);
        $message->setContent($content);
        $this->create($message);

        return $message;
    }

    /**
     * @param Form $form
     */
    public function handle(Form $form)
    {
        $data    = $form->getData();
        $contact = $this->getContactForEmail($data['email']);

        if (strlen($contact->getName()) < strlen($data['name'])) {
            $contact->setName($data['name']);
            $this->update($contact);
        }

        $message = $this->createMessageForContact($contact, $data['message']);
        $this->flush();

        return $this->strategy->handle($message);
    }
}
