<?php
namespace WojciechM\KramBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use WojciechM\KramBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface {
	/**
	 * {@inheritDoc}
	 */
	public function load(ObjectManager $manager) {
		$factory = $this->container->get('security.encoder_factory');
		$user = new User();
		$encoder = $factory->getEncoder($user);
		$user->setUsername('admin');
		$user->setFirstName("Admin");
		$user->setLastName("Basic");
		$user->setEmail('admin@gmail.com');
		$user->setIsActive(true);
		$user->setIsAdmin(true);
		$user->setPassword($encoder->encodePassword('admin', $user->getSalt()));
		$manager->persist($user);
		$manager->flush();
	}
	
	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
	}

}
