<?php
/**
 * User: Daniel
 * Date: 22/10/13
 * Time: 18:19
 * To change this template use File | Settings | File Templates.
 */

abstract class Modelo {
    protected $properties = array ();
    protected $dt;

    public function __call($methodName, $args) {
        $matches = array();
        if (preg_match('~^(set|get)([A-Z])(.*)$~', $methodName, $matches)) {
            $property = strtolower($matches[2]) . $matches[3];
            if (!array_key_exists($property,  $this->properties)) {
                throw new MemberAccessException('No existe la propiedad ' . $property . ' Propiedades: ' . serialize($this->properties));
            }
            switch($matches[1]) {
                case 'get':
                    return $this->properties[$property];
                case 'set':
                    $this->properties[$property] = $args[0];
                    return $this;
                case 'default':
                    throw new MemberAccessException('Method ' . $methodName . ' not exists');
            }
        } else {
            throw new MemberAccessException('Method ' . $methodName . ' not exists');
        }
    }
    
    public function getProperties() {
        return $this->properties;
    }
    
    public function getDateTimes() {
        return $this->dt;
    }

    public function map(array $row) {
        foreach ($row as $key => $value) {
            $keylower = strtolower($key);
            if (in_array($keylower, $this->dt)) {
                if ($d = DateTime::createFromFormat('Y-m-d H:i:s', $value)) {
                    $value = $d;
                } else if ($d = DateTime::createFromFormat('Y-m-d H:i:s', $value.' 00:00:00')) {
                    $value = $d;
                } else {
                    Utils::logip("Formato de fecha desconocido:".$value);
                }
            }
            if (array_key_exists($keylower, $this->properties)) {
                $this->properties[$keylower] = $value;
            }
        }
        return $this;
    }
    
    public function getAll() {
        $p = new Param();
        return unserialize($p->getParam(get_class($this)));
    }
    
    public function setAll(array $arr) {
        $p = new Param();
        return $p->setParam(get_class($this), serialize($arr));
    }
}
