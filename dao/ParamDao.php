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
class ParamDao extends Dao{

    /** @var PDO */
    
    public function __construct() {
        $this->modelo = new Param();
        parent::__construct('db','param','id');
    }
    
 
}