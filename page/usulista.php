<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */

if (($suc = Utils::getUrlParam('suc'))=='') $sucursal = null;
if (($centro   = Utils::getUrlParam('centro'))=='') $centro = null;
if (($estado   = Utils::getUrlParam('estado'))=='') $estado = null;
if ($estado = 'Todos') $estado = null;

$dao = new PersonaDao();
$search = new Persona();

$search->setSuc($suc);
$search->setCentro($centro);
$search->setEstado($estado);

$pagina = 0;
$paginas = 0;
$REGISTROS = 100;
Utils::setPaginado($pagina,$paginas,$dao,$search,'suc',$REGISTROS);

// data for template

$personas = $dao->find($search,'id',($pagina*$REGISTROS),$REGISTROS,'suc');

$estados = array_merge(array('Todos'), Persona::getAllEstados());