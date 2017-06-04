<?php

namespace generalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use generalBundle\Entity\Images;
use generalBundle\Entity\Consulta;
use generalBundle\Entity\Peticiones;
use generalBundle\Form\ImagesType;
use generalBundle\Form\BusquedaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;

class generalController extends Controller {

    /**
     * @Route("/general/index")
     */
    public function indexAction($imagen) {
        return $this->render('generalBundle::index.html.twig', array('ruta_imagen' => $imagen));
    }

    /**
     * @Route("/general/llamada")
     */
    public function llamadaAction(Request $request) {
        $id_llamada = $request->request->get("busqueda");
        $foto_name = $request->request->get("foto");
        $em = $this->getDoctrine()->getManager();
        $llamada = $em->getRepository('generalBundle:Consulta')->findBy( array('id' => $id_llamada ));
        $foto = $em->getRepository('generalBundle:Images')->findBy( array('name' => trim($foto_name, " ") ));
        
        
        $mensaje = "";
        if (!$llamada) {
            $mensaje = 'Debe seleccionar una opción'; 
        }
        if (!$foto) {
            $mensaje = 'Foto no encontrada, vuelva a cargar la foto'; 
        }
        $salida = "ERROR";
        $peticion = -1;
        if($mensaje == ""){
            $peticion = new Peticiones();
            $peticion->setIdconsulta($llamada[0]);
            $peticion->setIdimagen($foto[0]);
            $em->persist($peticion);
            $em->flush();

            exec($llamada[0]->getRuta(), $output);
            $salida = $output[0];
            $peticion = $peticion->getIdpeticiones();
        }
        
        $response = new Response(json_encode(array('resultado' => $salida, 'peticion' => $peticion , 'mensaje' => $mensaje)));
        return $response;
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
            $imagen->setName($fileName);
            $em->persist($imagen);
            $em->flush();
        }
        return $this->render('generalBundle::index.html.twig', array('ruta_imagen' => $fileName));
//        if ($request->isXMLHttpRequest()) {
//            $file = $request->request->get("name") ;
//            $file->move(
//                    $this->getParameter('images_directory'), 'aaaa'
//            );
//                    print_r("PRUEBAS SASASA");
//            die();
////            return new JsonResponse(array('data' => $this->render('generalBundle::conocenos.html.twig')));
////            return $this->render('generalBundle::index.html.twig', array('ruta_imagen' => 'upload_fichero.png'));
//            return $this->render('generalBundle::conocenos.html.twig');
//        }
//
//        return new Response('This is not ajax!', 400);
    }

    /**
     * @Route("/general/formulariobusqueda")
     */
    public function formulariobusquedaAction(Request $request) {
        $consulta = new Consulta();
        $form = $this->createForm(BusquedaType::class, $consulta);
        return $this->render('generalBundle::formulariobusqueda.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/general/busqueda")
     */
    public function busquedaAction(Request $request) {
        $consulta = new Consulta();
        $form = $this->createForm(BusquedaType::class, $consulta);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            print_r($consulta->getName());
            die();
        }
    }

    /**
     * @Route("/general/conocenos")
     */
    public function conocenosAction() {
        return $this->render('generalBundle::conocenos.html.twig');
    }

}
