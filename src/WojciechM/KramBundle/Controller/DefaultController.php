<?php

namespace WojciechM\KramBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;

use WojciechM\KramBundle\Controller\ExtendedController;

class DefaultController extends ExtendedController
{
    public function dashboardAction() {
    	return $this->render("WojciechMKramBundle:Dashboard:dashboard.html.twig");
    }
    
    public function balanceWidgetAction() {
    	$em = $this->getDoctrine()->getManager();
    	$users = $em->getRepository("WojciechMKramBundle:User")->findForBalance(array("active"=>True));
    	return $this->render("WojciechMKramBundle:Dashboard:balance_widget_inner.html.twig", array("users"=>$users));
    }
    
    public function shoppingWidgetAction () {
    	$em = $this->getDoctrine()->getManager();
    	$users = $em->getRepository("WojciechMKramBundle:ShoppingList")->find(array("active"=>True));
    	return $this->render("WojciechMKramBundle:Dashboard:shopping_widget_inner.html.twig", array("users"=>$users));
    }
}
