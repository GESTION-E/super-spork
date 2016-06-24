<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 */

final class Log extends Modelo {

    private static $nivel;

    public function __construct() {
        $this->dt = array ('fechahora'       
        );
        $this->properties = array(
                'id' => null,
                'fechahora' => null,
                'usuario' => null,
                'ip' => null,
                'evento' => null,
                'clave' => null,
                'datos' => null);
        if (!isset(self::$nivel)) {
            $log = Config::getConfig('log');
            self::$nivel = $log['nivel'];
        }
    } 

    public function registra($evento,$clave='-',$datos='') {
        if (self::$nivel==0) return;
        if ((self::$nivel==1)&&($clave=='-')) return;
        $dao = new LogDao();
        if (!($usu=Usuario::getUserid())) {
            $usu = '';
        }
        $this->setUsuario($usu);
        $this->setFechahora(new DateTime());
        $this->setIp($_SERVER['REMOTE_ADDR']);
        $this->setEvento($evento);
        $this->setClave($clave);
        $this->setDatos($datos);
        return $dao->insert($this);
    }
}
