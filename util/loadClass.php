<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


        
        /**
     * Class loader.
     */
    
    function loadClass($name) {
        static $super = array(
            'Entidad' => '../model/Modelo.php',
            'Persona' => '../model/Modelo.php',
            'Sucursal' => '../model/Modelo.php',
            'Centro' => '../model/Modelo.php',
            'Nivel' => '../model/Modelo.php',
            'Rechazo' => '../model/Modelo.php',
            'ChequeRechazo' => '../model/Modelo.php',
            'Cheque' => '../model/Modelo.php',
            'Log' => '../model/Modelo.php',
            'Param' => '../model/Param.php',
            'EntidadDao' => '../dao/Dao.php',
            'PersonaDao' => '../dao/Dao.php',
            'SucursalDao' => '../dao/Dao.php',
            'CentroDao' => '../dao/Dao.php',            
            'NivelDao' => '../dao/Dao.php',  
            'RechazoDao' => '../dao/Dao.php', 
            'ChequeRechazoDao' => '../dao/Dao.php', 
            'ChequeDao' => '../dao/Dao.php', 
            'LogDao' => '../dao/Dao.php', 
            'ParamDao' => '../dao/Dao.php',  
        );
        static $classes = array(
            'Config' => '../config/Config.php',
            'Flash' => '../flash/Flash.php',
            'NotFoundException' => '../exception/NotFoundException.php',
            'MemberAccessException' => '../exception/MemberAccessException.php',
            'Dao' => '../dao/Dao.php',
            'EntidadDao' => '../dao/EntidadDao.php',
            'PersonaDao' => '../dao/PersonaDao.php',
            'SucursalDao' => '../dao/SucursalDao.php',
            'CentroDao' => '../dao/CentroDao.php',
            'RechazoDao' => '../dao/RechazoDao.php',
            'ChequeRechazoDao' => '../dao/ChequeRechazoDao.php',
            'ChequeDao' => '../dao/ChequeDao.php',
            'LogDao' => '../dao/LogDao.php',
            'NivelDao' => '../dao/NivelDao.php',
            'ParamDao' => '../dao/ParamDao.php',
            'Entidad' => '../model/Entidad.php',
            'Persona' => '../model/Persona.php',
            'Modelo' => '../model/Modelo.php',
            'Sucursal' => '../model/Sucursal.php',
            'Centro' => '../model/Centro.php',
            'Nivel' => '../model/Nivel.php',
            'Rechazo' => '../model/Rechazo.php',
            'ChequeRechazo' => '../model/ChequeRechazo.php',
            'Cheque' => '../model/Cheque.php',
            'Log' => '../model/Log.php',
            'Param' => '../model/Param.php',
            'Utils' => '../util/Utils.php',
            'Usuario' => '../util/Usuario.php',
            'Excel' => '../PHPExcel/Excel.php',
            'PHPExcel' => '../PHPExcel/PHPExcel.php',
            'FPDF' => '../fpdf/FPDF.php',      
            'Imagen' => '../Imagick/Imagen.php',            
        );
        
        
        if (array_key_exists($name, $super)) {
            require_once $super[$name];
        }
        
        if (array_key_exists($name, $classes)) {
            // die ('Class "' . $name . '" not found.');
            require_once $classes[$name];
        }
    }
        
    spl_autoload_register('loadClass');
