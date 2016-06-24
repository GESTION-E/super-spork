<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */

/**
 * Miscellaneous utility methods.
 */
final class Utils {

    private function __construct() {
    }

    /**
     * Generate link.
     * @param string $page target page
     * @param array $params page parameters
     * @return string
     */
    public static function createLink($page, array $params = array()) {
        $params = array_merge(array('page' => $page), $params);
        // TODO add support for Apache's module rewrite
        return 'index.php?' .http_build_query($params);
    }

    /**
     * Format date.
     * @param DateTime $date date to be formatted
     * @return string formatted date
     */
    public static function formatDateTimeISO(DateTime $date) {
    //    return $date->format(DateTime::ISO8601);
            return $date->format('Y-m-d H:i:s');
    }
    public static function formatDateISO(DateTime $date) {
    //    return $date->format(DateTime::ISO8601);
            return $date->format('Y-m-d');
    }

    /**
     * Format date.
     * @param DateTime $date date to be formatted
     * @return string formatted date
     */
    public static function formatDate(DateTime $date = null) {
        if ($date === null) {
            return '';
        }
        return $date->format('d/m/Y');
    }

    /**
     * Format date and time.
     * @param DateTime $date date to be formatted
     * @return string formatted date and time
     */
    public static function formatDateTime(DateTime $date = null) {
        if ($date === null) {
            return '';
        }
        return $date->format('d/m/Y H:i:s');
    }

    /**
     * Redirect to the given page.
     * @param $page
     * @param array $params page parameters
     */
    public static function redirect($page, array $params = array()) {
        header('Location: ' . self::createLink($page, $params));
        die();
    }
    
    /**
     * Redirect to the last page.
     */
    public static function gobackok($message = '') {
        if (strlen(trim($message))) {
            Flash::addFlash($message);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
    /**
     * Redirect to the last page.
     */
    public static function goback($message = '') {
        if (strlen(trim($message))) {
            Flash::addFlash($message);
        }
        header('Location: ' . self::createLink('home'));
        die();
    }
    
    /**
     * Logs suspicious IP addresses.
     */
    public static function logip($message = '') {
//        $v_ip = $_SERVER['REMOTE_ADDR'];
//        $v_date = date("Y-m-d H:i:s");
//        $log = '../files/log.txt';
//        $userid = Usuario::getUserid();
//        $fp = fopen($log, "a");
//        fputs($fp, "$v_ip;$v_date;$userid;$message \n");
//        fclose($fp);
          error_log($message);
    }
    
    /**
     * Get value of the URL param.
     * @param $name
     * @throws NotFoundException
     * @return string parameter value
     */
    public static function getMandatoryUrlParam($name) {
        if (!array_key_exists($name, $_GET)) {
            throw new NotFoundException('URL parameter "' . $name . '" not found.');
        }
        return $_GET[$name];
    }
    
    public static function getMandatoryPostParam($name) {
        if (!array_key_exists($name, $_POST)) {
            throw new NotFoundException('Param POST "' . $name . '" no encontrado.');
        }
        return $_POST[$name];
    }
    
    public static function getUrlParam($name) {
        return (!array_key_exists($name, $_GET))? null : $_GET[$name];
    }
    
    public static function getPostParam($name) {
        return (!array_key_exists($name, $_POST))? null : $_POST[$name];
    }
    
    public static function existsPostParam($name) {
        return array_key_exists($name, $_POST);
    }

    /**
     * Capitalize the first letter of the given string
     * @param string $string string to be capitalized
     * @return string capitalized string
     */
    public static function capitalize($string) {
        if (strlen($string)>2) {
            return ucfirst(mb_strtolower($string));
        } else {
            return strtoupper($string);
        }
    }

    /**
     * Escape the given string
     * @param string $string string to be escaped
     * @return string escaped string
     */
    public static function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES);
    }
    
    

    // function to parse the http auth header
    public static function http_digest_parse($txt) {
        // proteger contra datos perdidos
        $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
        $data = array();
        $keys = implode('|', array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        return $needed_parts ? false : $data;
    }
    
    // función para comprobar los permisos de acceso a directorios
    public static function checkdir($tipo, $dir, $accion) {
        switch ($tipo) {
        case 'op':
           Usuario::checkPermiso(($accion=='write') ? 'pem' : 'prc');
           $dao = new OpDao();
           $op = $dao->findById($dir);
           if (!(isset($op))) {return false;}
           if ($op->getEmisor()==Usuario::getCuit()) {return true;}
           if ($op->getReceptor()==Usuario::getCuit()) {return ($accion=='read')? true : false;}
           return false;
           
        case 'imp':
           Usuario::checkPermiso('ip');
           return ($dir==Usuario::getUserid())? true : false;
           
        case 'msg':
           Usuario::checkPermiso(($accion=='write') ? 'me' : 'mc');
           if ($dir==Usuario::getUserid()) {
               return true;
           }
           $dao = new MensajeDao();
           $mensaje = $dao->findById($dir);
           if ($mensaje->getEmisor()==Usuario::getCuit()) {
               return true;
           }
           if ($mensaje->getReceptor()==Usuario::getCuit()) {
               return true;
           }
           return false;

        case 'gen':
           return ($accion=='read')? true : false;
            
        default :
        return false;
        }
    }
    
    public static function Upload($tipo, $dir) {

        $allowedExts = array("txt","gif", "jpeg", "jpg", "png", "pdf", "xlsx", "xls", "docx", "doc", "pptx", "ppt","csv");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = strtolower(end($temp));

        if (!(($_FILES["file"]["size"] < 10000000) && ($_FILES["file"]["size"] > 20) && in_array($extension, $allowedExts) && ($_FILES['file']['error'] == UPLOAD_ERR_OK))) {
            Utils::logip('Upload.php 26');
            return 'ERROR: Archivo no permitido';
        }

/*        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
        switch ($mime) {
            case 'text/plain':
            case 'image/jpeg':
            case 'image/gif':
            case 'image/png':
            case 'image/x-png':
            case 'application/pdf':
            case 'application/msword':
            case 'application/vnd.ms-excel':
            case 'application/vnd.ms-office':
            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                break;
            default:
                Utils::logip('upload.php 46');
                return 'ERROR: Archivo no permitido';
        }
*/
        if (!(Utils::checkdir($tipo, $dir, 'write'))) {
            Utils::logip('upload.php 51');
            return 'ERROR: Archivo no permitido';
        }

        $dire = '../files/' . $tipo . '/' . $dir . '/';
        if (file_exists($dire . $_FILES["file"]["name"])) {
            return ('El archivo ' . $_FILES["file"]["name"] . ' ya existe');
        } else {
            if (!(file_exists($dire))) {
                mkdir($dire);
                copy('../files/.htaccess', $dire . '.htaccess');
            }
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $dire . $_FILES["file"]["name"])) {
            //Flash::addFlash('Archivo ' . $_FILES["file"]["name"] . ' subido correctamente');
                return false;
            } else {
                return 'ERROR: Problemas al subir el archivo';
            }
        }
    }


    public static function validaCuit($cuit) {
        $d = str_split($cuit);
        if (!(count($d)==11)) {
            return true;
        }
        $resto = (11-($d[0]*5+$d[1]*4+$d[2]*3+$d[3]*2+$d[4]*7+$d[5]*6+$d[6]*5+$d[7]*4+$d[8]*3+$d[9]*2)%11);
        switch ($resto) {
            case 10:
                $resto = 9;
                break;
            case 11:
                $resto = 0;
        }
        return ($d[10]==$resto)? false : true;
    }
    
    public static function getUltimoDiaMes($elAnio,$elMes) {
        return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }
    
    public static function strtofloat($strValue) { 
        $floatValue = ereg_replace("(^[0-9]*)(\\.|,)([0-9]*)(.*)", "\\1.\\3", $strValue); 
        if (!is_numeric($floatValue)) {$floatValue = ereg_replace("(^[0-9]*)(.*)", "\\1", $strValue); }
        if (!is_numeric($floatValue)) {$floatValue = 0; }
        return $floatValue; 
    }
    
    public static function formatMoney($importe,$long=1) {
        return str_pad(number_format($importe, 2, ',', '.'),$long, " ", STR_PAD_LEFT);
    }
    
    public static function getNavbar() {
        $mc = new Memcache;
        $mc->connect('localhost',11211);
        if (!($navbar = $mc->get('Navbar'))) {
            $navbar = 'ok';
            $mc->set('Navbar',$navbar);
        }
        return $navbar;
    }

    public static function setPaginado(&$pagina,&$paginas,$dao,$search,$restringe,$REGISTROS = 100) {
        if (($pagina   = Utils::getUrlParam('pagina'))=='') $pagina = null;
        if ($pagina==null) $pagina = 0;
        $paginas = (int)(($dao->findCount($search,$restringe)) / $REGISTROS);
        if (array_key_exists('next', $_GET)) {
            $pagina++;
        } elseif (array_key_exists('prev', $_GET)) {
            $pagina--;
        } elseif (array_key_exists('first', $_GET)) {
            $pagina = 0;
        } elseif (array_key_exists('last', $_GET)) {
            $pagina = $paginas;
        }
        if ($pagina>$paginas) {
                $pagina = $paginas;
        }
        if ($pagina<0) {
                $pagina = 0;
        }
    }

    public static function getParametros(&$search,&$fecha,&$enfecha,&$proceso,&$centro,&$sucdep,&$ent,&$suc,&$cp,&$nro,&$cta,&$importe,&$estado) {
        if (($centro  = Utils::getUrlParam('centro'))=='') $centro = null;
        if (($sucdep  = Utils::getUrlParam('sucdep'))=='') $sucdep = null;
        if (($ent     = Utils::getUrlParam('ent'))=='') $ent = null;
        if (($suc     = Utils::getUrlParam('suc'))=='') $suc = null;
        if (($cp      = Utils::getUrlParam('cp'))=='') $cp = null;
        if (($nro     = Utils::getUrlParam('nro'))=='') $nro = null;
        if (($cta     = Utils::getUrlParam('cta'))=='') $cta = null;
        if (($importe = Utils::getUrlParam('importe'))=='') $importe = null;
        if (($estado  = Utils::getUrlParam('estado'))=='') $estado = null;
        if (($fecha   = Utils::getUrlParam('fecha'))=='') $fecha = null;

        $p = new Param();  
        $fecha_env = $p->getFecha_enviada();
        if ($fecha==null) {
                $fecha = $fecha_env;
                $enfecha = true;
        } else {
                $f1 = new DateTime($fecha);
                $f2 = new DateTime($fecha_env);
                $enfecha = ($f1==$f2)? true : false; 
        }

        $search->setFecha($fecha);
        $search->setProceso($proceso);

        $search->setDepcentro($centro);
        $search->setDepsuc($sucdep);
        $search->setEnt($ent);
        $search->setSuc($suc);
        $search->setCp($cp);
        $search->setNro($nro);
        $search->setCta($cta);
        if ($importe!=null) {
                $search->setImporte(array($importe,9999999999999.99));
        }
        if (($estado=='10')||($estado=='0')) {
                $search->setEstado(array(0,5));
        } elseif ($estado=='9') {
                $search->setEstado(null);
        } elseif ($estado==null) {
                $estado = '9';
                $search->setEstado(null);
        } else {
                $search->setEstado($estado);
        }
    }
}
