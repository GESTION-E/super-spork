<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2015 GESTION-E S.R.L. All rights reserved.
 *
 *
 */
 
class DaoLogicDelete extends Dao {

    public function __construct($dbconf,$tabla,$id,$autoid=false) {
        self::$db_count++;
        $this->tabla = $tabla;
        $this->select = 'SELECT * FROM  ' . $this->tabla . '  WHERE deleted = 0 AND ';
        $this->count = 'SELECT count(*) FROM  ' . $this->tabla . '  WHERE deleted = 0 AND ';
        $this->config = Config::getConfig($dbconf);
        $this->id = $id;
        $this->autoid = $autoid;
    }
    
    public function delete(Modelo $modelo) {
		$modelo->setModificado(new DateTime());
		$modelo->setUserid(Usuario::getUserid());
        $modelo->setDeleted(1);
        parent::update($modelo);
    }
    
    public function insert(Modelo $modelo) {
	    $modelo->setModificado(new DateTime());
		$modelo->setUserid(Usuario::getUserid());
        $modelo->setDeleted(0);
		parent::insert($modelo);
    }

    public function update(Modelo $modelo) {
		$modelo->setModificado(new DateTime());
		$modelo->setUserid(Usuario::getUserid());
        $modelo->setDeleted(0);
        parent::update($modelo);
    }
}
