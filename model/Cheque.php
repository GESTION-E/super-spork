<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 */

final class Cheque extends Modelo {
    private $imagenfrente = null;
    private $imagendorso  = null;
    const ESTADOS = array (
            0 => 'Pendiente',
            1 => 'Pendiente - 1 Rev',
            2 => 'Pendiente - 2 Rev',
            3 => 'Pendiente - 3 Rev',
            4 => 'Pendiente - 4 Rev',
            5 => 'Pendiente-Sucursal',
            6 => 'Aprobado',
            7 => 'Rechazado');

    const PROCESOS = array (
            1 => 'Cámara Enviada',
            2 => 'Administración de Cartera',
            3 => 'Cámara Recibida');
    
    public function __construct() {
        $this->dt = array ('fecha'       
        );
        $this->properties = array(
                'fecha' => null,
                'proceso' => null,
                'archivo' => null,
                'secuencia' => null,
                'tipo' => null,
                'seccab' => null,
                'seclote' => null,
                'secind' => null,
                'registro' => null,
                'depent' => null,
                'depsuc' => null,
                'depcentro' => null,
                'reccentro' => null,
                'ent' => null,
                'suc' => null,
                'cp' => null,
                'cta' => null,
                'nro' => null,
                'importe' => null,
                'estado' => null,
                'revisores' => null);
    }
    
    public static function getAllEstados() {
        return self::ESTADOS;
    }

    public function getEstadoFormat() {
        return self::ESTADOS[$this->getEstado()];
    }

    public static function getAllProcesos() {
        return self::PROCESOS;
    }

    public function getProcesoFormat() {
        return self::PROCESOS[$this->getProceso()];
    }
    
    public function getCmc7() {
        return sprintf('%03d%03d%04d%08d%011d', 
            $this->properties['ent'],
            $this->properties['suc'],
            $this->properties['cp'],
            $this->properties['nro'],
            $this->properties['cta']);
    }
    
    public function setCmc7($cmc7) {
        return sscanf($cmc7,'%03d%03d%04d%08d%011d', 
            $this->properties['ent'],
            $this->properties['suc'],
            $this->properties['cp'],
            $this->properties['nro'],
            $this->properties['cta']);
    }
    
    public function getImagenFrente() {
        if ($this->imagenfrente==null) {
            $cd = new ChequeDao();
            $this->imagenfrente = $cd->getImagen(
                $this->properties['fecha'],
                $this->properties['proceso'],
                $this->getCmc7(),
                0);
        }
        return $this->imagenfrente;
    }
    
    public function getImagenDorso() {
        if ($this->imagendorso==null) {
            $cd = new ChequeDao();
            $this->imagendorso = $cd->getImagen(
                $this->properties['fecha'],
                $this->properties['proceso'],
                $this->getCmc7(),
                1);
        }
        return $this->imagendorso;
    }
    
    public function getRechazos() {
        $crd = new ChequeRechazoDao();
        $search = new ChequeRechazo();
        
        $search->setFecha($this->getFecha());
        $search->setProceso($this->getProceso());
        $search->setCmc7($this->getCmc7());
        
        $rechazo = array();
        $cheque_rechazo = $crd->Find($search); 
        foreach ($cheque_rechazo as $cr) {
                $rechazo[] = $cr->getRechazo();
        }
        return $rechazo;
    }
//---------------------------------------------------------
    public function actualizar(array $rechazos) {
        if ($rechazos==array()) {
            $this->aprobar();
        } else {
            $this->rechazar($rechazos);
        }
    }
    
    public function aprobar() {  
        $e = $this->getEstado();
        if ($e == 6) return;
        if (($e == 7)||($e == 5)) $e = 0;
        
        if ($e == 0) {
            $this->setRevisores(Usuario::getUserid());
        } else {
            $revisores = explode(';',$this->getRevisores());
            if (in_array(Usuario::getUserid(),$revisores)) return;
            $this->setRevisores($this->getRevisores().';'.Usuario::getUserid());
        }
        
        if ($this->getNivelesARevisar()>($e+1)) {
            $this->setEstado($e+1);
        } else {
            $this->setEstado(6);
        }
        
        $this->borrarRechazos();
        
        $cd = new ChequeDao();
        return $cd->update($this);
    }
    
    public function rechazar(array $rechazos) { 
        $this->setRevisores(Usuario::getUserid());
        $this->borrarRechazos();

        $cr = new ChequeRechazo();
        $cr->setFecha($this->getFecha());
        $cr->setProceso($this->getProceso());
        $cr->setCmc7($this->getCmc7());
        $crd = new ChequeRechazoDao();
        foreach ($rechazos as $value) {   
            $crc = clone $cr;
            $crc->setRechazo($value);
            $crd->insert($crc);
        }
        
        $this->setEstado(7);
        $cd = new ChequeDao();
        return $cd->update($this);
    }
//-------------------------------------
    public function enviarSuc($descripcion) {
        $this->setRevisores(Usuario::getUserid());
        $this->borrarRechazos();     
        $this->setEstado(5);
        $cd = new ChequeDao();
        $cd->update($this);

        $dao = new SucursalDao();
        $search = new Sucursal();
        if ($this->getProceso()==3) {
            $search->setEnt($this->getEnt());
            $search->setSuc($this->getSuc());
        } else {
            $search->setEnt($this->getDepent());
            $search->setSuc($this->getDepsuc());
        }
        $s = $dao->find($search);
        $sucursal = $s[0];

        $para   = $sucursal->getEmail();
        $desde   = Usuario::getEmail();
        $cc   = Usuario::getEmail();
        $co   = '';
        $email = Config::getConfig('email');
        $titulo = $email['titulo'].' CMC7: '.$this->getCmc7() ;
        
        $mensaje  = '<pre><p>';
        $mensaje .= 'Proceso :  ' . $this->getProcesoFormat() . '<br>';
        $mensaje .= 'Fecha   :  ' . Utils::formatDate($this->getFecha()) . '<br>';
        $mensaje .= '------------------------------<br>';
        $mensaje .= 'Entidad :  ' . $this->getEnt() . '<br>';
        $mensaje .= 'Sucursal:  ' . $this->getSuc() . '<br>';
        $mensaje .= 'CP      :  ' . $this->getCp() . '<br>';
        $mensaje .= 'Cheque  :  ' . $this->getNro() . '<br>';
        $mensaje .= 'Cuenta  :  ' . $this->getCta() . '<br>';
        $mensaje .= '------------------------------<br>';
        $mensaje .= 'Importe :$ ' . Utils::formatMoney($this->getImporte()) . '<br>';
        $mensaje .= '</p></pre>';
        $mensaje .= $descripcion;
        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $cabeceras  = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\n";
//      $cabeceras .= "To: " . $para . "\r\n";
        $cabeceras .= "From: " . $desde . "\r\n";
        $cabeceras .= "Cc: " . $cc . "\r\n";
        $cabeceras .= "Bcc: " . $co . "\r\n";
        // Enviarlo
        if (!mail($para, $titulo, $mensaje, $cabeceras)) {
            Utils::logip('------->Error al enviar email');
            Utils::logip('------->Para:' . $para);
            Utils::logip('------->Mensaje:' . $mensaje);
            Utils::logip('------->Cabeceras:' . $cabeceras);
        }
    }

    public function borrarRechazos() {
        $crd = new ChequeRechazoDao();
        $cr = new ChequeRechazo();
        
        $cr->setFecha($this->getFecha());
        $cr->setProceso($this->getProceso());
        $cr->setCmc7($this->getCmc7());
        
        $crd->delete($cr);
    }
    
    public function getNivelesARevisar() {
        $n = new Nivel();
        $ns = $n->getAll();
        foreach ($ns as $nivel) {
            if ($nivel->getHasta() > $this->getImporte()) return $nivel->getCantidad();
        }
    }
    
    public function getImporte() {
        return $this->properties['importe'] / 100;
    }

    public function setImporte($imp) {
        if (is_array($imp)) {
            $a = array();
            foreach ($imp as $value) {
                $a[] = $value * 100;
            }
            $this->properties['importe'] = $a;
        } else {
            $this->properties['importe'] = $imp * 100;
        }
    }
}