<?php
namespace WojciechM\KramBundle\Repository;

use Doctrine\ORM\EntityRepository;
use WojciechM\KramBundle\Entity\Expense;

/**
 * ExpenseRepository
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExpenseRepository extends EntityRepository {
	public function findTotal() {
		return $this->getEntityManager()->createQuery("SELECT SUM(e.amount)
			FROM WojciechMKramBundle:Expense e")
			->getSingleScalarResult();
	}
}
