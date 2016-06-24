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
class ChequeRechazoDao extends Dao{

    /** @var PDO */
    
    public function __construct() {
        $this->modelo = new ChequeRechazo();
        parent::__construct('db','cheque_rechazo','fecha,proceso,cmc7,rechazo');
    }
}