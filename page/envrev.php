<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */
        
        $dao     = new ChequeDao();
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

        if ($enfecha && 
            (Usuario::askPermiso('ew') || Usuario::askPermiso('es')) &&
            (Utils::existsPostParam('submit') || Utils::existsPostParam('sucursal')) ) {
                $cmc7 = Utils::getMandatoryPostParam('cmc7');
                $rechazo_form = Utils::getPostParam('rechazo_form');
                if ($rechazo_form==null) $rechazo_form = array(); 
                $search2 = clone $search;
                $search2->setCmc7($cmc7);
                if (!($a = $dao->find($search2, '', 0, 1,'depsuc'))) Utils::redirect('envlista');
                if (Utils::existsPostParam('submit')) {
                        $log = new Log();
                        $log->registra('envrev-confirma',$cmc7,implode(',',array_keys($rechazo_form)));
                        $a[0]->actualizar(array_keys($rechazo_form));
                }
                if (Utils::existsPostParam('sucursal')) {
                        $log = new Log();
                        $log->registra('envrev-sucursal',$cmc7);
                        $a[0]->enviarSuc(Utils::getPostParam('descripcion'));
                }
        }
        
        if (($idx  = Utils::getUrlParam('idx'))=='') $idx = 0;
        if (!($a = $dao->find($search, '', $idx, 1,'depsuc'))) Utils::redirect('envlista');
        
        $idx++;
        $cheque = $a[0];
        
        $r = new Rechazo();
        $motivos   = $r->getRechazosDepositaria();
        $rechazos  = $cheque->getRechazos();
        $cmc7      = $cheque->getCmc7();
        $revisores = explode(';', $cheque->getRevisores());
        
        $modifica = ($enfecha && (Usuario::askPermiso('ew') || Usuario::askPermiso('es')))? true : false;
        $recorre  = true;
