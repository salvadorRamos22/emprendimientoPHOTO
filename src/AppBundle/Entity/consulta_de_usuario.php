<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * consulta_de_usuario
 *
 * @ORM\Table(name="consulta_de_usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\consulta_de_usuarioRepository")
 */
class consulta_de_usuario
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
     * @ORM\Column(name="consult_descrip", type="string", length=100)
     */
    private $consultDescrip;

/**
     * Many consulta_de_usuario have One Usuario.
     * @ORM\ManyToOne(targetEntity="usuario", inversedBy="consulta_u")
     * @ORM\JoinColumn(name="idUsuario_id", referencedColumnName="id")
     */
    private $idUsuario;
  


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
     * Set consultDescrip
     *
     * @param string $consultDescrip
     *
     * @return consulta_de_usuario
     */
    public function setConsultDescrip($consultDescrip)
    {
        $this->consultDescrip = $consultDescrip;

        return $this;
    }

    /**
     * Get consultDescrip
     *
     * @return string
     */
    public function getConsultDescrip()
    {
        return $this->consultDescrip;
    }

}

