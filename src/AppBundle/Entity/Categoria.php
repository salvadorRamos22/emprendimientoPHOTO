<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Categoria
 *
 * @ORM\Table(name="categorias")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriaRepository")
 */
class Categoria
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
     * @ORM\Column(name="nombre", type="text")
     */
    private $nombreCategoria;


    /**
         * One Categoria has Many Fotos.
         * @ORM\OneToMany(targetEntity="Foto", mappedBy="idCategoria")
         */
        private $fotos;
        // ...

        public function __construct() {
            $this->fotos = new ArrayCollection();
        }




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
     * Set fotoDescripcion
     *
     * @param string $fotoDescripcion
     *
     * @return Categoria
     */
    public function setNombreCategoria($nombreCategoria)
    {
        $this->nombreCategoria = $nombreCategoria;

        return $this;
    }

    /**
     * Get fotoDescripcion
     *
     * @return string
     */
    public function getNombreCategoria()
    {
        return $this->nombreCategoria;
    }
}
