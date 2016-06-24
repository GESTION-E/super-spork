<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */
        
        $dao = new ChequeDao();
        $search  = new Cheque();
        $fecha   = null;
        $enfecha = null;
        $proceso = 1;
        $centro  = null;
        $depsuc  = null;
        $ent     = null;
        $suc     = null;
        $cp      = null;
        $nro     = null;
        $cta     = null;
        $importe = null;
        $estado  = null;
        Utils::getParametros($search,$fecha,$enfecha,$proceso,$centro,$sucdep,$ent,$suc,$cp,$nro,$cta,$importe,$estado);

        $pagina = 0;
        $paginas = 0;
        $REGISTROS = 100;
        Utils::setPaginado($pagina,$paginas,$dao,$search,'depsuc',$REGISTROS);

        $documentos = $dao->find($search, '', ($pagina*$REGISTROS),$REGISTROS,'depsuc');
        
        $estados = array('9' => 'Todos') + Cheque::getAllEstados();

        $modifica = ($enfecha && (Usuario::askPermiso('ew') || Usuario::askPermiso('es')))? true : false;
