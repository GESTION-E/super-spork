<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */

class SucursalDao extends Dao{

    /** @var PDO */
    
    public function __construct() {
        $this->modelo = new Sucursal();
        parent::__construct('db','sucursal','ent,suc');
    }
}