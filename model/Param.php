<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 */

final class Param extends Modelo {
    private static $params = array();
    private static $params_time = 0;

    public function __construct() {
        $this->dt = array (
        );
        $this->properties = array(
                'id' => null,
                'valor' => null);
    }
    
    public function __call($methodName, $args) {
        $matches = array();
        if (preg_match('~^(set|get)([A-Z])(.*)$~', $methodName, $matches)) {
            $property = strtolower($matches[2]) . $matches[3];
            if (!array_key_exists($property,  $this->properties)) {
                switch($matches[1]) {
                    case 'get':
                        return $this->getParam($property);
                    case 'set':
                        return $this->setParam($property, $args[0]);
                    case 'default':
                        throw new MemberAccessException('Method ' . $methodName . ' not exists');
                }
            } else {
                switch($matches[1]) {
                    case 'get':
                        return $this->properties[$property];
                    case 'set':
                        $this->properties[$property] = $args[0];
                        return $this;
                    case 'default':
                        throw new MemberAccessException('Method ' . $methodName . ' not exists');
                }
            }
        } else {
            throw new MemberAccessException('Method ' . $methodName . ' not exists');
        }
    }
    
    public function getParam($prop) {
        $this->getParams();
        return self::$params[$prop];
    }
    
    public function setParam($prop, $value) {
        $this->getParams();
        self::$params[$prop] = $value;
        Usuario::setCache('params',self::$params);
        $pd = new ParamDao();
        $p  = new Param();
        $p->setId($prop);
        $pd->delete($p);
        $p->setValor($value);
        $pd->insert($p);
    }
    
    private function getParams() {
        if ((self::$params != null)  &&
            ((time() - self::$params_time) < 600 )) return;
        if (((self::$params = Usuario::getCache('params'))!=null) &&
            ((time() - (self::$params_time = Usuario::getCache('params_time'))) < 600 )) return;
        $pd = new ParamDao();
        $p  = new Param();
        $p->setId('');
        $ps  = $pd->find($p, '', 0, 1000, null, 'id');
        foreach ($ps as $prow) {
            self::$params[$prow->getId()] = $prow->getValor();
        }
        self::$params_time = time();
        Usuario::setCache('params',self::$params);
        Usuario::setCache('params_time',self::$params_time);
    }
}