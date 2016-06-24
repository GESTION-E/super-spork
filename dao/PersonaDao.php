<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */

class PersonaDao extends Dao{

    /** @var PDO */
    
    public function __construct() {
        $this->modelo = new Persona();
        parent::__construct('db','persona','id');
    }
 
}