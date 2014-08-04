<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirect('week');
    }
}
