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
class LogDao extends Dao{

    /** @var PDO */

    public function __construct() {
        $this->modelo = new Log();
        parent::__construct('db','log','id',true);
    }

    public function insert(Modelo $modelo) {
        $params = array();
        $primero = true;
        foreach ($modelo->getProperties() as $property => $value) {
            if (($property==$this->id)&&($this->autoid)) continue;
            $this->checkdt($value);
            if ($primero) {
                $sql = 'INSERT INTO ' . $this->tabla . ' (`' . $property . '`';
                $sql2 = ':' . $property;
                $primero = false;
            } else {
                $sql .= ', `' . $property . '`';
                $sql2 .= ', ' . ':' . $property;
            }
            $params[$property] = $value;
        } 
        $sql .= ') VALUES (' . $sql2 . ')';

        //Log::registra('INSERT',$sql.' '.serialize($params));
        return $this->execute($sql, $params);
    }
}