<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 */

final class Sucursal extends Modelo {

    public function __construct(Sucursal $modelo = null) {
        $this->dt = array (
        );
        $this->properties = array(
                'ent' => null,
                'suc' => null,
                'centro' => null,
                'nombre' => null,
                'email' => null);
    }
    
    public function valida() {
        $errors = array();
        if (($this->getEnt() == null) || ($this->getEnt() == '')) {
            $errors[] = array('ent', 'Debe ingresar un número de Entidad');
        }
        if (($this->getSuc() == null) || ($this->getSuc() == '')) {
            $errors[] = array('suc', 'Debe ingresar un número de Sucursal');
        }
        if (($this->getCentro() == null) || ($this->getCentro() == '')) {
            $errors[] = array('centro', 'Debe ingresar un número de Centro al que correspond la Sucursal');
        }
        if (($this->getNombre() == null) || ($this->getNombre() == '')) {
            $errors[] = array('nombre', 'Debe ingresar el Nombre de la Sucursal');
        }
        if (($this->getEmail() == null) || ($this->getEmail() == '')) {
            $errors[] = array('nombre', 'Debe ingresar una dirección de email de contacto');
        }
        return $errors;
    }

}
