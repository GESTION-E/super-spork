<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */

if (($numero = Utils::getPostParam('numero'))=='') $numero = null;
if (($descripcion = Utils::getPostParam('descripcion'))=='') $descripcion = null;
if (($depositaria = Utils::getPostParam('depositaria'))=='') $depositaria = null;
if (($girada = Utils::getPostParam('girada'))=='') $girada = null;

$r = new Rechazo();
$rechazos = $r->getAll();
$log = new Log();
if (Utils::getPostParam('update')) {
    sscanf($numero,'R%2d',$numero);
    foreach ($rechazos as $key => $value) {
        if ($value->getNumero()==$numero) {

            $rechazos[$key]->setDescripcion($descripcion);
            $rechazos[$key]->setDepositaria($depositaria);
            $rechazos[$key]->setGirada($girada);
            if (!$errors = $rechazos[$key]->valida()) {
                $r->setAll($rechazos);
                Flash::addFlash('Rechazo actualizado<br>');
                $log->registra('rechlista-update',$numero,$descripcion.'|Dep:'.$depositaria.'|Gir:'.$girada);
            }
            break;
        }
    }
    
} elseif (Utils::getPostParam('delete')) {
    sscanf($numero,'R%2d',$numero);
    foreach ($rechazos as $key => $value) {
        if ($value->getNumero()==$numero) {
            unset($rechazos[$key]);
            $r->setAll($rechazos);
            Flash::addFlash('Rechazo eliminado<br>');
            $log->registra('rechlista-delete',$numero);
            break;
        }
    }
    
} elseif (Utils::getPostParam('add')) {
    $nuevo = new Rechazo();
    $nuevo->setNumero($numero);
    $nuevo->setDescripcion($descripcion);
    $nuevo->setDepositaria($depositaria);
    $nuevo->setGirada($girada);
    if (!($errors = $nuevo->valida())) {
        $n = array();
        $new_added = false;
        foreach ($rechazos as $key => $value) {
            if ($value->getNumero() == $numero) {
                $errors = array(array('numero', 'Código de rechazo existente'));
                break;
            }
            if ($value->getNumero() > $numero) {
                if ($new_added) {
                    $n[] = $value;
                } else {
                    $new_added = true;
                    $n[] = $nuevo;
                    $n[] = $value;
                }
            } else {
                $n[] = $value;
            }
        }
        if (!$new_added) {
            $n[] = $nuevo;
        }
        if (!$errors) {
            $r->setAll($n);
            Flash::addFlash('Rechazo agregado<br>');
            $log->registra('rechlista-add',$numero,$descripcion.'|Dep:'.$depositaria.'|Gir:'.$girada);
        }
    }
}
$rechazos = $r->getAll();