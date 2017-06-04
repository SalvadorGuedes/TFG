<?php

namespace generalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Peticiones
 *
 * @ORM\Table(name="peticiones", indexes={@ORM\Index(name="idconsulta_idx", columns={"idconsulta"}), @ORM\Index(name="idimagen_idx", columns={"idimagen"})})
 * @ORM\Entity
 */
class Peticiones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idpeticiones", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpeticiones;

    /**
     * @var \Consulta
     *
     * @ORM\ManyToOne(targetEntity="Consulta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idconsulta", referencedColumnName="id")
     * })
     */
    private $idconsulta;

    /**
     * @var \Images
     *
     * @ORM\ManyToOne(targetEntity="Images")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idimagen", referencedColumnName="id")
     * })
     */
    private $idimagen;
    
    function getIdpeticiones() {
        return $this->idpeticiones;
    }

    function getIdconsulta() {
        return $this->idconsulta;
    }

    function getIdimagen() {
        return $this->idimagen;
    }

    function setIdconsulta($idconsulta) {
        $this->idconsulta = $idconsulta;
    }

    function setIdimagen($idimagen) {
        $this->idimagen = $idimagen;
    }

}

