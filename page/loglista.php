<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */
        
        $dao = new LogDao();
        $search  = new Log();
        if (($secuencia = Utils::getUrlParam('secuencia'))=='') $secuencia = null;
        if (($fecha     = Utils::getUrlParam('fecha'))=='') $fecha = null;
        if (($usuario   = Utils::getUrlParam('usuario'))=='') $usuario = null;
        if (($ip        = Utils::getUrlParam('ip'))=='') $ip = null;
        if (($evento    = Utils::getUrlParam('evento'))=='') $evento = null;
        if (($clave     = Utils::getUrlParam('clave'))=='') $clave = null;

        if ($secuencia) $search->setId(array($secuencia,99999999999));
        if ($fecha)     $search->setFechahora(array(DateTime::createFromFormat('j/m/Y H:i:s', $fecha.' 00:00:00'),'3000-01-01 00:00:00'));
        $search->setUsuario($usuario);
        $search->setIp($ip);
        $search->setEvento($evento);
        $search->setClave($clave);

        $pagina = 0;
        $paginas = 0;
        $REGISTROS = 100;
        Utils::setPaginado($pagina,$paginas,$dao,$search,null,$REGISTROS);

        $registros = $dao->find($search, '', ($pagina*$REGISTROS),$REGISTROS);
        
