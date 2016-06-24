<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author Daniel
 */
final class Usuario {

    //put your code here

    private static $userid;
    private static $nombre;
    private static $ent;
    private static $suc;
    private static $sucs = array();
    private static $centro;
    private static $permisos = array();
    private static $nombreEntidad;
    private static $nombreSucursal;
    private static $nombreCentro;
    private static $logo;
    private static $email;
    private static $cache = array();

    public function initDaemon($daemon) {
        return self::init($daemon);
    }

    public static function recover() {
        Usuario::$userid = $_SESSION['usuario']['userid'];
        Usuario::$nombre = $_SESSION['usuario']['nombre'];
        Usuario::$ent = $_SESSION['usuario']['ent'];
        Usuario::$suc = $_SESSION['usuario']['suc'];
        Usuario::$sucs = $_SESSION['usuario']['sucs'];
        Usuario::$centro = $_SESSION['usuario']['centro'];
        Usuario::$permisos = $_SESSION['usuario']['permisos'];
        Usuario::$nombreEntidad = $_SESSION['usuario']['nombreEntidad'];
        Usuario::$nombreSucursal = $_SESSION['usuario']['nombreSucursal'];
        Usuario::$nombreCentro = $_SESSION['usuario']['nombreCentro'];
        Usuario::$logo = $_SESSION['usuario']['logo'];
        Usuario::$email = $_SESSION['usuario']['email'];
        Usuario::$cache = $_SESSION['usuario']['cache'];
        return false;
    }

    public static function init($id) {
        Usuario::$userid = $id;

        $dao = new PersonaDao();
        $usuario = $dao->findById(Usuario::$userid);

        if ($usuario == null) {
            return true;
        }

        if ($usuario->getEstado() !== 'ACTIVO') {
            return true;
        }

        Usuario::$nombre = $usuario->getNombre();
        Usuario::$ent = $usuario->getEnt();
        Usuario::$suc = $usuario->getSuc();
        Usuario::$centro = $usuario->getCentro();
        Usuario::$email = $usuario->getEmail();
        Usuario::$permisos = explode(',', $usuario->getPermisos());
        
        Usuario::$sucs = array(Usuario::$suc);
        if (Usuario::$suc == 0) {
            $search = new Sucursal();
            $sd = new SucursalDao();
            $search->setEnt(Usuario::$ent);
            if (Usuario::$centro != 0) {
                $search->setCentro(Usuario::$centro);
            }
            $ss = $sd->find($search);
            foreach ($ss as $s) {
                Usuario::$sucs[] = $s->getSuc();
            }
        }
        
        $ed = new EntidadDao();
        $entidad = $ed->findById(Usuario::$ent);
        if ($entidad == null) {
            return true;
        }
        Usuario::$nombreEntidad = $entidad->getNombre();
        Usuario::$logo = $entidad->getLogo();
        
        $sd = new SucursalDao();
        $sucursal = $sd->findById(Usuario::$ent . ',' . Usuario::$suc);
        if ($sucursal == null) {
            return true;
        }
        Usuario::$nombreSucursal = $sucursal->getNombre();
        
        $cd = new CentroDao();
        $centro = $cd->findById(Usuario::$centro);
        if ($centro == null) {
            return true;
        }
        Usuario::$nombreCentro = $centro->getNombre();

        $_SESSION['usuario'] = array(
            'userid' => Usuario::$userid ,
            'nombre' => Usuario::$nombre ,
            'ent' => Usuario::$ent ,
            'suc' => Usuario::$suc ,
            'sucs' => Usuario::$sucs ,
            'centro' => Usuario::$centro ,
            'permisos' => Usuario::$permisos ,
            'nombreEntidad' => Usuario::$nombreEntidad ,
            'nombreSucursal' => Usuario::$nombreSucursal ,
            'nombreCentro' => Usuario::$nombreCentro ,
            'logo' => Usuario::$logo ,
            'email' => Usuario::$email ,
            'cache' => array() , 
        );

        return false;
    }

    public static function getUserid() {
        return Usuario::$userid;
    }

    public static function getNombre() {
        return Usuario::$nombre;
    }
    
    public static function getEnt() {
        return Usuario::$ent;
    }
        
    public static function getSuc() {
        return Usuario::$suc;
    }

    public static function getSucs() {
        return Usuario::$sucs;
    }
            
    public static function getCentro() {
        return Usuario::$centro;
    }
    
    public static function getLogo() {
        return Usuario::$logo;
    }

    public static function getEmail() {
        return Usuario::$email;
    }

    public static function getPermisos() {
        return Usuario::$permisos;
    }
    
    public static function getNombreEntidad() {
        return Usuario::$nombreEntidad;
    }
    
    public static function getNombreSucursal() {
        return Usuario::$nombreSucursal;
    }
    
    public static function getNombreCentro() {
        return Usuario::$nombreCentro;
    }
    
    public static function getCache($seccion) {
        return (array_key_exists($seccion, Usuario::$cache))? Usuario::$cache[$seccion] : null;
    }
    
    public static function setCache($seccion, $valor) {
        Usuario::$cache[$seccion] = $valor;
        $_SESSION['usuario']['cache'] = Usuario::$cache;
    }

    public static function checkPermiso($operacion) {
        if (!(Usuario::askPermiso($operacion))) {
            Utils::logip('Acceso denegado:' . $operacion);
            Utils::goback('Acceso denegado');
        }
    }

    public static function askPermiso($operacion) {
        $op = str_split($operacion);
        foreach (Usuario::$permisos as $permiso) {
            $per = str_split($permiso);
            $ok = true;
            for ($i=0; $i++; $i<count($op)) {
                if ($op[$i]='-') continue;
                if ($op[$i]!=$per[$i]) {
                    $ok = false;
                    break;
                }
            }
            if ($ok) return true;
        }
        return false;
    }

    public static function getDescPermiso($permiso) {
        $descPermiso = Usuario::getAllDescPermiso();
        return $descPermiso[$permiso];
    }

    public static function getAllDescPermiso() {
        $descPermiso = array(
            'ew' => 'Revisor de Cámara enviada',
            'rw' => 'Revisor de Cámara recibida',
            'cw' => 'Revisor de Cheques en cartera', 
            'es' => 'Supervisor de Cámara enviada',
            'rs' => 'Supervisor de Cámara recibida',
            'cs' => 'Supervisor de Cheques en cartera',
            'eq' => 'Consultar Cámara enviada',
            'rq' => 'Consultar Cámara recibida',
            'cq' => 'Consultar Cheques en cartera',
            'ap' => 'Administrador de parámetros',
            'ai' => 'Administrador de interfaces',
            'au' => 'Administrador de usuarios',
        );
        return $descPermiso;
    }
    
    public static function valida($username,$password) {
        $adServer = "ldap://domaincontroller.mydomain.com";
        $ldap = ldap_connect($adServer);

        $ldaprdn = 'mydomain' . "\\" . $username;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $bind = @ldap_bind($ldap, $ldaprdn, $password);
        
//-------------------------
$bind = " ";
//-------------------------

        if ($bind) {
            @ldap_close($ldap);
            if (Usuario::init($username)) {
                $_SESSION['activo'] = NULL;
                $_SESSION['usuario'] = NULL;
                return 'Usuario no registrado en el sistema';
            } else {
                $_SESSION['activo'] = 1;
                return '';
            }
        } else {
            $_SESSION['activo'] = NULL;
            $_SESSION['usuario'] = NULL;
            return "Usuario/Contraseña inválida";
        }
    }
}
