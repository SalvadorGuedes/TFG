<?php

namespace generalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use generalBundle\Entity\Images;
use generalBundle\Form\ImagesType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class generalController extends Controller {

    /**
     * @Route("/general/index")
     */
    public function indexAction() {
        return $this->render('generalBundle::index.html.twig');
    }

    /**
     * @Route("/general/form")
     */
    public function formAction(Request $request) {
        $image = new Images();
        $form = $this->createForm(ImagesType::class, $image);

        return $this->render('generalBundle::fileExplore.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/general/picture")
     */
    public function pictureAction(Request $request) {
        $ruta = "base.png";
        return $this->render('generalBundle::base.html.twig', array('ruta_imagen' => $ruta ));
    }

    /**
     * @Route("/general/vinculador")
     */
    public function vinculadorAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $imagen = new Images();
        $form = $this->createForm(ImagesType::class, $imagen);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $imagen->getName();
            $extension = $file->guessExtension();
            $fecha = new \DateTime();
            $fileName = $fecha->format('YmdHis') . '.' . $extension;
            $file->move(
                    $this->getParameter('images_directory'), $fileName
            );
        }
        return $this->render('generalBundle::index.html.twig');
    }

}
