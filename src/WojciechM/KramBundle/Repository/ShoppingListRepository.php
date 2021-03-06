<?php
namespace WojciechM\KramBundle\Repository;

use Doctrine\ORM\EntityRepository;
use WojciechM\KramBundle\Entity\ShoppingList;

/**
 * WeekRepository
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShoppingListRepository extends EntityRepository {

	public function findAll() {
		return $this->findAllWithJoins();
	}
	
	private function getAllWithJoinsQuery() {
		return $this->getEntityManager()
			->createQuery("SELECT sl FROM WojciechMKramBundle:ShoppingList sl ".
				"LEFT JOIN sl.entries se ".
				"WHERE sl.id IN
					(SELECT MAX(sl.id) FROM WojciechMKramBundle:ShoppingList sl)");
	}
	
	private function getNWithJoins($n=NULL) {
		$inner = $this->getEntityManager()
			->createQuery("SELECT partial isl.{id} FROM
				WojciechMKramBundle:ShoppingList isl ORDER BY isl.id DESC"
		);
		if ($n && $n > 0) {
			$inner = $inner->setMaxResults($n);
		}
		$ids = $inner->getScalarResult();
		$ids = array_map(function($item){ return $item["isl_id"]; }, $ids);
		return $this->getEntityManager()
			->createQuery("SELECT sl, se FROM WojciechMKramBundle:ShoppingList sl ".
				"LEFT JOIN sl.entries se ".
				"WHERE sl.id IN (:ids)")
		->setParameter("ids", $ids);
	}
	
	public function findAllWithJoins() {
		return $this->getNWithJoins()->getResult();
	}

	public function findCurrent() {
		$lastArr = $this->getNWithJoins(1)->getResult();
		if (empty($lastArr)) {
			$last = new ShoppingList();
			$em = $this->getEntityManager();
			$em->persist($last);
			$em->flush();
		} else {
			$last = $lastArr[0];
		}
		return $last;
	}

}
