<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 */

final class ChequeRechazo extends Modelo {

    public function __construct() {
        $this->dt = array ('fecha'    
        );
        $this->properties = array(
                'fecha' => null,
                'proceso' => null,
                'cmc7' => null,
                'rechazo' => null);
    }
}
