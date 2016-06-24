<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 */

final class Centro extends Modelo {

    public function __construct() {
        $this->dt = array (       
        );
        $this->properties = array(
                'centro' => null,
                'nombre' => null);
    }
    public function valida() {
        $errors = array();
        if (($this->getCentro() == null) || ($this->getCentro() == '')) {
            $errors[] = array('centro', 'Debe ingresar un identificador para el Centro');
        }

        if (($this->getNombre() == null) || ($this->getNombre() == '')) {
            $errors[] = array('nombre', 'Debe ingresar el Nombre el Centro');
        }
        return $errors;
    }
}
