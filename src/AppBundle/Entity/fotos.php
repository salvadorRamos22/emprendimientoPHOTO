<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * fotos
 *
 * @ORM\Table(name="fotos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\fotosRepository")
 */
class fotos
{
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
     * @ORM\Column(name="foto_link", type="text")
     */
    private $fotoLink;

    /**
     * @var string
     *
     * @ORM\Column(name="foto_descripcion", type="text")
     */
    private $fotoDescripcion;


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

