<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */
 
/**
 * abstract class Dao
 * 
 * .
 */
class ChequeDao extends Dao{

    /** @var PDO */
    
    public function __construct() {
        $this->modelo = new Cheque();
        parent::__construct('db','cheque','fecha,proceso,archivo,secuencia');
    }
    
    public function getImagen($fecha,$proceso,$cmc7,$fd) {
        return file_get_contents(self::getImagenFileName($fecha,$proceso,$cmc7,$fd));
    }
    
    public function convierte($fecha, $proceso) {
        $n=0;
        $dirRaiz = self::getDirBase($fecha,$proceso);
        $dir = $dirRaiz.'origen/';
        
        if (is_dir($dir)) {
            self::mkEstruct($dirRaiz);
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if (filetype($dir.$file)=='file') {
                        if (pathinfo($file, PATHINFO_EXTENSION)=='tif') {
                            self::convFile($dir,$file,$dirRaiz);
                            $n++;
                        }
                    }
                }
                closedir($dh);
            }
        }
        return $n;
    }
    
    private function getImagenFileName($fecha,$proceso,$cmc7,$fd) {
        $file = $cmc7.'.tif';
        $md5 = md5($file);
        return self::getDirBase($fecha,$proceso).$md5[0].'/'.$md5[1].'/'.$file.$fd.'.B64';
    }
    
    private function getDirBase($fecha,$proceso) {
        $conf = Config::getConfig('imagen');
        return $conf['dirbase'].Utils::formatDateISO($fecha).'/'.$proceso.'/';
    }
    
    private function mkEstruct($dirRaiz) {
        $hex = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f');
        foreach ($hex as $h1) {
            foreach ($hex as $h2) {
                @mkdir($dirRaiz.$h1.'/'.$h2, 0777, true);
            }
        }
    }
    
    private function convFile($dir,$file,$dirRaiz) {
        $md5 = md5($file);
        $pathbase = $dirRaiz.$md5[0].'/'.$md5[1].'/'.$file;
        $images = new Imagick($dir.$file);
        foreach($images as $i=>$image) {
                $image->setImageFormat('PNG8');
                $image->thumbnailImage(768,0);
                file_put_contents($pathbase.$i.'.B64', 'data:image/png;base64,'.base64_encode($image->getImageBlob()));
        }
    }
    
}