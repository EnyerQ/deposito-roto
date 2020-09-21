<?php
/**
 * Created by PhpStorm.
 * User: tactika
 * Date: 22/08/2015
 * Time: 5:59 PM
 */

class Ventadetalle {

    private $id;
    private $producto_id;
    private $venta_id;
    private $cantidad;
    private $descuento;

    function __construct($producto_id, $venta_id, $cantidad, $descuento)
    {
        $this->producto_id = $producto_id;
        $this->venta_id = $venta_id;
        $this->cantidad = $cantidad;
        $this->descuento = $descuento;
    }

    /**
     * @return mixed
     */
    public function getProductoId()
    {
        return $this->producto_id;
    }

    /**
     * @param mixed $producto_id
     */
    public function setProductoId($producto_id)
    {
        $this->producto_id = $producto_id;
    }

    /**
     * @return mixed
     */
    public function getVentaId()
    {
        return $this->venta_id;
    }

    /**
     * @param mixed $venta_id
     */
    public function setVentaId($venta_id)
    {
        $this->venta_id = $venta_id;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * @param mixed $descuento
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }




}