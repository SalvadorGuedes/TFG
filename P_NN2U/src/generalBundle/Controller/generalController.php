<?php

namespace generalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class generalController extends Controller
{
    /**
     * @Route("/general/index")
     */
    public function indexAction()
    {
        return $this->render('generalBundle::index.html.twig');
    }
}