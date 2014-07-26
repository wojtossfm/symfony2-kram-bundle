<?php
namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WojciechM\KramBundle\Entity\PaymentType;

class LoadPaymentTypeData implements FixtureInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function load(ObjectManager $manager)
	{
		$this->addOne($manager, "regular");
		$this->addOne($manager, "sick-leave");
		$this->addOne($manager, "leave");
		$this->addOne($manager, "expense");
		$manager->flush();
	}
	
	public function addOne(ObjectManager $manager, $name) {
		$one = new PaymentType();
		$one->setName($name);
		$manager->persist($one);
	}
}