<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * fotos
 *
 * @ORM\Table(name="fotos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\fotosRepository")
 */
class Foto
{   //*****************************************ATRIBUTOS*******************************************
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="text")
     */
    private $titulo;


    /**
     * @var string
     *
     * @ORM\Column(name="foto_link", type="text")
     */
    private $fotoLink;


    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="fotos")
     * @ORM\JoinColumn(name="idCategoria", referencedColumnName="id")
     */
    private $idCategoria;





//***************************************METODOS***************************************************
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fotoLink
     *
     * @param string $fotoLink
     *
     * @return fotos
     */
    public function setFotoLink($fotoLink)
    {
        $this->fotoLink = $fotoLink;

        return $this;
    }

    /**
     * Get fotoLink
     *
     * @return string
     */
    public function getFotoLink()
    {
        return $this->fotoLink;
    }

    /**
     * Set fotoDescripcion
     *
     * @param string $fotoDescripcion
     *
     * @return fotos
     */
    public function setFotoDescripcion($fotoDescripcion)
    {
        $this->fotoDescripcion = $fotoDescripcion;

        return $this;
    }

    /**
     * Get fotoDescripcion
     *
     * @return string
     */
    public function getFotoDescripcion()
    {
        return $this->fotoDescripcion;
    }
}
