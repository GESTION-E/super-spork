<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2015 GESTION-E S.R.L. All rights reserved.
 */

/**
 * model class representing one Persona item.
 */
final class Persona extends Modelo {

    public function __construct(Persona $modelo = null) {
        $this->dt = array (
        );
        $this->properties = array(
                'id' => null,
                'nombre' => null,
                'ent' => null,
                'suc' => null,
                'centro' => null,
                'email' => null,
                'estado' => null,
                'permisos' => null);
    }

    public static function getAllEstados() {
        return array('ACTIVO', 'BLOQUEADO');
    }

    public function valida() {
        $errors = array();
        if (($this->getId() == null) || ($this->getId() == '')) {
            $errors[] = array('id', 'Debe ingresar un identificador de Usuario');
        }

        if (($this->getNombre() == null) || ($this->getNombre() == '')) {
            $errors[] = array('nombre', 'Debe ingresar el Nombre del usuario');
        }

        if (($this->getPermisos() == null) || ($this->getPermisos() == '')) {
            $errors[] = array('permisos', 'Debe elegir al menos un permiso para el usuario');
        }

        if (($this->getEnt() == null) || ($this->getEnt() == '')) {
            $errors[] = array('ent', 'Debe elegir una entidad');
        }

        if (($this->getSuc() == null) || ($this->getSuc() == '')) {
            $errors[] = array('suc', 'Debe elegir una sucursal');
        }

        if (!in_array($this->getSuc(),Usuario::getSucs())) {
            $errors[] = array('suc', 'Debe elegir una sucursal válida');
        }

        if (($this->getCentro() == null) || ($this->getCentro() == '')) {
            $errors[] = array('centro', 'Debe elegir un centro');
        }

        $cd = new CentroDao();
        $centro = new Centro();
        $centro->setCentro($this->getCentro());
        if ($cd->findCount($centro)==0) {
            $errors[] = array('centro', 'Debe elegir un centro válido');
        }

        if (($this->getEstado() == null) || ($this->getEstado() == '')) {
            $errors[] = array('estado', 'Debe definir un estado válido');
        }

        if (!(in_array($this->getEstado(), Persona::getAllEstados()))) {
            $errors[] = array('estado', 'Debe definir un estado válido');
        }

        $permisos = explode(',', $this->getPermisos());
        foreach ($permisos as $key) {
            if (!Usuario::getDescPermiso($key)) {
                $errors[] = array('permisos', 'Permiso inválido: '. $key);
            }
        }

        if (count($permisos) == 0) {
        $errors[] = array('permisos', 'Debe elegir al menos un permiso para el usuario');
        }

        return $errors;
    }

}
