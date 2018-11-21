<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * venta
 *
 * @ORM\Table(name="venta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ventaRepository")
 */
class venta
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
     * @ORM\Column(name="fecha_venta", type="datetime")
     */
    private $fechaVenta;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;

/**
     * One venta has One reserva.
     * @ORM\OneToOne(targetEntity="reserva", inversedBy="ventas")
     * @ORM\JoinColumn(name="idReserva_id", referencedColumnName="id")
     */
    private $idReserva;

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
     * Set fechaVenta
     *
     * @param \DateTime $fechaVenta
     *
     * @return venta
     */
    public function setFechaVenta($fechaVenta)
    {
        $this->fechaVenta = $fechaVenta;

        return $this;
    }

    /**
     * Get fechaVenta
     *
     * @return \DateTime
     */
    public function getFechaVenta()
    {
        return $this->fechaVenta;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return venta
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }
}
