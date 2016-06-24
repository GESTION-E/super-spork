<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */
$errors = array();
$dao = new PersonaDao();
$persona = new Persona();
$edit = Utils::getUrlParam('id');
$permisos = array();
$descpermisos = Usuario::getAllDescPermiso();

if ($edit) {
    $persona = $dao->findById($edit);
    if (isset($persona)) {
        $p = explode(',', $persona->getPermisos());
        foreach ($descpermisos as $key => $value) {
            if (in_array($key, $p)) {
                $permisos[$key] = true;
            }
        }
    } else {
        Utils::logip('editusu.php A');
        Utils::goback('ERROR: mensaje incorrecto');
    }
} else {
    // set defaults
    $persona->setId('');
    $persona->setCentro('');
    $persona->setSuc('');
    $persona->setNombre('');
    $persona->setEmail('');
    $persona->setEstado('ACTIVO');
    $persona->setPermisos('');
}

if (Utils::getPostParam('cancel')) {
    Utils::redirect('usulista');
} elseif (Utils::getPostParam('save')) {
    $pagina = Utils::getPostParam('persona');

    $persona->setId($pagina['usuario']);
    $persona->setCentro($pagina['centro']);
    $persona->setEnt(Usuario::getEnt());
    $persona->setSuc($pagina['sucursal']);
    $persona->setNombre($pagina['nombre']);
    $persona->setEmail($pagina['email']);
    $persona->setEstado($pagina['estado']);
    
    $permisos = array();
    $permisos_str = '';
    $perm = Utils::getPostParam('permiso');
    $primero = true;
    foreach ($descpermisos as $key => $value) {
        if (isset($perm[$key])) {
            $permisos[$key] = true;
            if ($primero) {
                $permisos_str = $key;
                $primero = false;
            } else {
                $permisos_str .= ',' . $key;
            }
        }
    }
    $persona->setPermisos($permisos_str);

    $errors = $persona->valida();

    $dao = new PersonaDao();
    $p = $dao->findById($persona->getId());

    if ($edit) {
        if (!$p) {
            Utils::logip('editusu.php 94');
            Utils::goback('ERROR: mensaje incorrecto');
        }
    } else {
        if ($p) {
            $errors[] = array('usuario', 'Ese usuario ya existe. Pruebe con otro identificador.');
        }
    }

    // validate
    if (empty($errors)) {
        $log = new Log();
        if ($edit) {
            $dao->update($persona);
            $log->registra('usuedit-update',$persona->getId(),serialize($persona));
        } else {
            $dao->insert($persona);
            $log->registra('usuedit-add',$persona->getId(),serialize($persona));
        }
        Flash::addFlash('Usuario actualizado<br>');
        // redirect
        Utils::redirect('usulista');
    }
}