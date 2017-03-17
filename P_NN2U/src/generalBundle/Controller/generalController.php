<?php

namespace generalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use generalBundle\Entity\Images;
use generalBundle\Form\ImagesType;

class generalController extends Controller
{
    /**
     * @Route("/general/index")
     */
    public function indexAction()
    {
        return $this->render('generalBundle::index.html.twig');
    }
    
    /**
     * @Route("/general/form")
     */
    public function formAction(Request $request){
        $image = new Images();
        $form = $this->createForm(ImagesType::class,$image);
         
    return $this->render('generalBundle::fileExplore.html.twig', array(
            'form' => $form->createView()
        ));
}
    
    
}