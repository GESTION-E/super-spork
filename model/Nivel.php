<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 */

final class Nivel extends Modelo {

    public function __construct(Nivel $modelo = null) {
        $this->dt = array (
        );
        $this->properties = array(
                'cantidad' => null,
                'hasta' => null);
    }

    public function valida() {
        $errors = array();
        if (($this->getCantidad() == null) || ($this->getCantidad() == '')) {
            $errors[] = array('cantidad', 'Debe ingresar la cantidad de revisores');
        }
        if (($this->getHasta() == null) || ($this->getHasta() == '')) {
            $errors[] = array('hasta', 'Debe ingresar un Importe tope');
        }
        if (!is_numeric($this->getCantidad())) {
            $errors[] = array('cantidad', 'Debe ingresar valores numéricos sin decimales');
        }
        if (!is_numeric($this->getHasta())) {
            $errors[] = array('hasta', 'Debe ingresar un valores numéricos sin decimales');
        }
        return $errors;
    }
    


}
