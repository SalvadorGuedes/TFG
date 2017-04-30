<?php

namespace generalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use generalBundle\Entity\Images;
use generalBundle\Entity\consulta;
use generalBundle\Form\ImagesType;
use generalBundle\Form\BusquedaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class generalController extends Controller {

    /**
     * @Route("/general/index")
     */
    public function indexAction($imagen) {
        return $this->render('generalBundle::index.html.twig', array('ruta_imagen' => $imagen));
    }

    /**
     * @Route("/general/index2")
     */
    public function index2Action($imagen) {
        return $this->render('generalBundle::index2.html.twig', array('ruta_imagen' => $imagen));
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
    public function pictureAction($imagen) {
        

        return $this->render('generalBundle::central.html.twig', array('ruta_imagen' => $imagen));
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
//            $imagen->setName($fileName);
//            $em->persist($imagen);
//            $em->flush();
        }
        return $this->render('generalBundle::index.html.twig', array('ruta_imagen' => $fileName));
    }

    /**
     * @Route("/general/formulariobusqueda")
     */
    public function formulariobusquedaAction(Request $request) {
        $consulta = new consulta();
        $form = $this->createForm(BusquedaType::class, $consulta);
        return $this->render('generalBundle::formulariobusqueda.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/general/busqueda")
     */
    public function busquedaAction(Request $request) {
        $consulta = new consulta();
        $form = $this->createForm(BusquedaType::class, $consulta);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            print_r($consulta->getName());die();
        }
    }

    /**
     * @Route("/general/conocenos")
     */
    public function conocenosAction() {
        return $this->render('generalBundle::conocenos.html.twig');
    }

}
