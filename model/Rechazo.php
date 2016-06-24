<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 */

final class Rechazo extends Modelo {

    public function __construct(Rechazo $modelo = null) {
        $this->dt = array (
        );
        $this->properties = array(
                'numero' => null,
                'descripcion' => null,
                'depositaria' => null,
                'girada' => null);
    }
    
    public function getRechazosGirada() {
        $r = array();
        $rechazos = $this->getAll();
        foreach ($rechazos as $rechazo) {
            if ($rechazo->getGirada()) $r[] = $rechazo;
        }
        return $r;
    }
    
    public function getRechazosDepositaria() {
        $r = array();
        $rechazos = $this->getAll();
        foreach ($rechazos as $rechazo) {
            if ($rechazo->getDepositaria()) $r[] = $rechazo;
        }
        return $r;
    }
    
    public function valida() {
        $errors = array();
        if (($this->getNumero() == null) || ($this->getNumero() == '')) {
            $errors[] = array('ent', 'Debe ingresar un número de Rechazo');
        }
        if (($this->getDescripcion() == null) || ($this->getDescripcion() == '')) {
            $errors[] = array('descripcion', 'Debe ingresar una descripción para el Rechazo');
        }
        if ((($this->getDepositaria() == null) || ($this->getDepositaria() == '')) &&
            (($this->getGirada() == null) || ($this->getGirada() == ''))) {
            $errors[] = array('descripcion', 'Debe indicar si el Rechazo es aplicable a Depositaria, Girada o ambos');
        }
        return $errors;
    }
    
    

}
