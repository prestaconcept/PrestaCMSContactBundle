<?php
/**
 * This file is part of the PrestaCMSContactBundle.
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSContactBundle\Doctrine;


use Doctrine\Common\Persistence\ObjectManager;
use Presta\CMSContactBundle\Model\ContactManager as AbstractContactManager;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class ContactManager extends AbstractContactManager
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @param  ObjectManager $objectManager
     * @throws \InvalidArgumentException
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;

        if ($this->modelClassName == null) {
            throw new \InvalidArgumentException('ContactManager::modelClassName should be defined');
        }
        $this->repository = $objectManager->getRepository($this->modelClassName);
    }

    /**
     * {@inheritDoc}
     */
    public function create($object)
    {
        $this->objectManager->persist($object);
    }

    /**
     * {@inheritDoc}
     */
    public function update($object)
    {
        $this->objectManager->persist($object);
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        $this->objectManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findContactBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
}
