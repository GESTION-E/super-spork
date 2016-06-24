<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */
 
/**
 * abstract class Dao
 * 
 * .
 */
class CentroDao extends Dao{

    /** @var PDO */
    
    public function __construct() {
        $this->modelo = new Centro();
        parent::__construct('db','centro','centro');

    }
    
 
}