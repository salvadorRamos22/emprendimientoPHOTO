<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * reserva
 *
 * @ORM\Table(name="reserva")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\reservaRepository")
 */
class reserva
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
     * @var \DateTime
     *
     * @ORM\Column(name="reserva_fecha", type="datetime")
     */
    private $reservaFecha;

    /**
     * @var string
     *
     * @ORM\Column(name="reserva_lugar", type="string", length=100)
     */
    private $reservaLugar;


/**
     * Many reserva have One Usuario.
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="reservas")
     * @ORM\JoinColumn(name="idUsuario_id", referencedColumnName="id")
     */
    private $idUsuario;

     /**
     * One reserva has One reserva_tipo_servicio.
     * @ORM\OneToOne(targetEntity="reserva_tipo_servicio")
     * @ORM\JoinColumn(name="reservaTipoId_id", referencedColumnName="id")
     */
    private $reservaTipoId;


       /**
     * One reserva has One venta.
     * @ORM\OneToOne(targetEntity="venta", mappedBy="idReserva")
     */
    private $ventas;


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
     * Set reservaFecha
     *
     * @param \DateTime $reservaFecha
     *
     * @return reserva
     */
    public function setReservaFecha($reservaFecha)
    {
        $this->reservaFecha = $reservaFecha;

        return $this;
    }

    /**
     * Get reservaFecha
     *
     * @return \DateTime
     */
    public function getReservaFecha()
    {
        return $this->reservaFecha;
    }

    /**
     * Set reservaLugar
     *
     * @param string $reservaLugar
     *
     * @return reserva
     */
    public function setReservaLugar($reservaLugar)
    {
        $this->reservaLugar = $reservaLugar;

        return $this;
    }

    /**
     * Get reservaLugar
     *
     * @return string
     */
    public function getReservaLugar()
    {
        return $this->reservaLugar;
    }

    
}
