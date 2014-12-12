<?php
namespace WojciechM\KramBundle\Repository;

use Doctrine\ORM\EntityRepository;
use WojciechM\KramBundle\Entity\Week;
use WojciechM\KramBundle\Entity\Debt;

/**
 * WeekRepository
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WeekRepository extends EntityRepository {
	
	public function __construct($em, $class)
	{
		parent::__construct($em, $class);
		$this->generateTillCurrent();
	}
	
	private function generateTillCurrent() {
		$em = $this->getEntityManager();
		$sample = new Week();
		$lastArr = $this->findLastNWeeksAndPayments(1);
		$users = $em->getRepository('WojciechMKramBundle:User')->findBy(array("active"=>True));
		if (!empty($lastArr)) {
			$last = $lastArr[0];
			$lastStart = clone $last->getStart();
			$lastEnd = clone $last->getEnd();
			$interval = new \DateInterval("P7D");
			$fee = $last->getFee();
			while($sample->getStart() > $lastStart) {
				$last = new Week();
				$last->setStart($lastStart->add($interval));
				$last->setEnd($lastEnd->add($interval));
				$last->setFee($fee);
				foreach($users as $user) {
					$debt = new Debt();
					$debt->setWeek($last);
					$debt->setUser($user);
					$debt->setAmount($fee);
					$last->addDebt($debt);
					$em->persist($debt);
				}
				$em->persist($last);
				$lastStart = clone $last->getStart();
				$lastEnd = clone $last->getEnd();
			}
		} else {
			$sample->setFee(0);
			$em->persist($sample);
			$last = $sample;
		}
		$em->flush();
	}
	
	public function findAll() {
		return $this->findBy(array(), array('start' => 'ASC', 'end'=>'ASC'));
	}
	
	private function getAllWithJoinsQuery() {
		return $this->getEntityManager()
			->createQuery("SELECT w FROM WojciechMKramBundle:Week w ".
			//	"LEFT JOIN w.payments p ".
			//	"LEFT JOIN w.expenses e ".
			//	"LEFT JOIN w.debts d ".
			//	"LEFT JOIN w.shoppers s ".
			//	"LEFT JOIN w.collectors c ".
				"ORDER BY w.start DESC, w.end DESC");
	}
	
	public function findAllWithJoins() {
		return $this->getAllWithJoinsQuery()->getResult();
	}
	
	public function findLastNWeeksAndPayments($n) {
		return $this->getAllWithJoinsQuery()
			->setMaxResults($n)
			->getResult();
	}

	public function findCurrent() {
		$last = $this->findLastNWeeksAndPayments(1);
		$last = $last[0];
		return $last;
	}
	
	public function getLastFee() {
		$entity = $this->getEntityManager()
			->createQuery("SELECT w FROM WojciechMKramBundle:Week w ORDER BY w.start DESC, w.end DESC")
			->setMaxResults(1)
			->getOneOrNullResult();
		return $entity ? $entity->getFee() : 0;
	}

}
