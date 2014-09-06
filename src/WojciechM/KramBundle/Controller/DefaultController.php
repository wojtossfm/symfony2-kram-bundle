<?php

namespace WojciechM\KramBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;

use WojciechM\KramBundle\Controller\ExtendedController;
use WojciechM\KramBundle\Presentation\BalancePresentation;

class DefaultController extends ExtendedController
{
    public function dashboardAction() {
    	return $this->render("WojciechMKramBundle:Dashboard:dashboard.html.twig");
    }
    
    public function balanceWidgetAction() {
    	$em = $this->getDoctrine()->getManager();
    	$users = $em->getRepository("WojciechMKramBundle:User")->findForBalance(array("active"=>True));
    	$payments = $em->getRepository("WojciechMKramBundle:Payment")->findTotal();
		$expenses = $em->getRepository("WojciechMKramBundle:Expense")->findTotal();
		$week = $em->getRepository("WojciechMKramBundle:Week")->findCurrent();
		return $this->render("WojciechMKramBundle:Dashboard:balance_widget_inner.html.twig",
			array(
				  "entities"=>$users,
				  "presentation"=>new BalancePresentation(),
				  "total"=>0 + $payments - $expenses,
				  "collectors"=>$week->getCollectors(),
				));
    }
}
