<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */

$n = new Nivel();
$niveles = $n->getAll();

if (Utils::getPostParam('update')) {
    $errors = array();
    $niveles_form = Utils::getPostParam('niveles-form');
    $niveles[0]->setHasta($niveles_form[0]);
    $niveles[1]->setHasta($niveles_form[1]);
    $niveles[2]->setHasta($niveles_form[2]);

    $errors[] = $niveles[0]->valida();
    $errors[] = $niveles[1]->valida();
    $errors[] = $niveles[2]->valida();

    if (empty($errors[0]) && empty($errors[1]) && empty($errors[2])) {
        Flash::addFlash('Niveles de autorización actualizados<br>');
        $log = new Log();
        $log->registra('nivlista-update','all','1:'.$niveles_form[0].' 2:'.$niveles_form[1].' 3:'.$niveles_form[2]);
        $n->setAll($niveles);
    }
}