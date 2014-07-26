<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository("WojciechMKramBundle:Week")->findCurrent();
        return $this->render('WojciechMKramBundle:Default:index.html.twig', array('week'=>$entity));
    }
}
