<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * fotos
 *
 * @ORM\Table(name="fotos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FotoRepository")
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
     * @ORM\Column(name="descripcion", type="text")
     */
    private $fotoDescripcion;


    /**
     * @var string
     *
     * @Assert\Image()
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
     * @return Foto
     */
    public function setFotoLink($fotoLink)
    {
        $this->fotoLink = $fotoLink;

        return $this;
    }


    /**
     * Set nombre
     *
     * @param string $titulo
     *
     * @return Foto
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
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
     * @return Foto
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


    /**
     * Set idCategoria
     *
     * @param int $idCategoria
     *
     * @return Foto
     */
    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }

    /**
     * Get idCategoria
     *
     * @return int
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }
}
