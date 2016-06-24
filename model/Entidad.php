<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 */

final class Entidad extends Modelo {

    public function __construct(Entidad $modelo = null) {
        $this->dt = array (     
        );
        $this->properties = array(
                'ent' => null,
                'logo' => null,
                'nombre' => null);
    }
    
    public function valida() {
        $errors = array();
        if (($this->getEnt() == null) || ($this->getEnt() == '')) {
            $errors[] = array('ent', 'Debe ingresar un número de Entidad');
        }
        if (($this->getNombre() == null) || ($this->getNombre() == '')) {
            $errors[] = array('nombre', 'Debe ingresar el Nombre de la Entidad');
        }
        return $errors;
    }
}
