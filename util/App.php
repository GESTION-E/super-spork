<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2015 GESTION-E S.R.L. All rights reserved.
 *
 *
 */

/**
 * Main application class.
 */
final class App {

    const DEFAULT_PAGE = 'home';
    const PAGE_DIR = '../page/';
    const LAYOUT_DIR = '../layout/';

        static $permiso = array (
            
            'image' => 'au',
        );

    /**
     * System config.
     */
    public function init() {
        // error reporting - all errors for development (ensure you have display_errors = On in your php.ini file)
        //error_reporting(E_ALL | E_STRICT);
        mb_internal_encoding('UTF-8');
        set_exception_handler(array($this, 'handleException'));
        // session
        session_start();
    }

    /**
     * Run the application!
     */
    public function run($page = null) {
        if ($page==null) {
            $page = $this->getPage();
        }
        //Utils::logip('Usuario: '. Usuario::getUserid() . ' - Ejecuta: ' . $_SERVER['QUERY_STRING']);
        $log = new Log();
        $log->registra($page,'-',$_SERVER['QUERY_STRING']);
        if (array_key_exists($page, self::$permiso)) {
            $reqs = explode(',', self::$permiso[$page]);
            foreach ($reqs as $req) {
                if (Usuario::askPermiso($req)) {
                    return $this->runPage($page);
                }
            }
            Utils::logip('Acceso denegado: "' . $page . '"');
            Utils::goback('Acceso denegado: "' . $page . '"');
        }
        return $this->runPage($page);
        
    }

    /**
     * Exception handler.
     */
    public function handleException( $ex) {
        $extra = array('message' => $ex->getMessage());
        Utils::logip($ex->getMessage() . ' file ' . $ex->getFile() . ' line ' . $ex->getLine());
        Utils::logip($ex->getTraceAsString().'\n');
        
        if ($ex instanceof NotFoundException) {
            header('HTTP/1.0 404 Not Found');
            $this->runPage('404', $extra);
        } else {
            // TODO log exception
            header('HTTP/1.1 500 Internal Server Error');
            $this->runPage('500', $extra);
        }
        die();
    }

    public function getPage() {
        $page = self::DEFAULT_PAGE;
        if (array_key_exists('page', $_GET)) {
            $page = $_GET['page'];
        }
        return $this->checkPage($page);
    }

    private function checkPage($page) {
        if (!preg_match('/^[a-z0-9-]+$/i', $page)) {
            throw new NotFoundException('Unsafe page "' . $page . '" requested');
        }
        if (!$this->hasScript($page) && !$this->hasTemplate($page)) {
            throw new NotFoundException('Page "' . $page . '" not found');
        }
        return $page;
    }

    private function runPage($page, array $extra = array()) {
        $run = false;
             
        if ($this->hasScript($page)) {
            $run = true;
            require $this->getScript($page);
        }
        
        if ($this->hasTemplate($page)) {
            $run = true;
            // data for main template
            $template = $this->getTemplate($page);
            $flashes = null;
            if (Flash::hasFlashes()) {
                $flashes = Flash::getFlashes();
            }
            require $this->getLayout($page);
        }
        if (!$run) {
            die('Page "' . $page . '" has neither script nor template!');
        }
    }

    private function getScript($page) {
        return self::PAGE_DIR . $page . '.php';
    }

    private function getTemplate($page) {
        return self::PAGE_DIR . $page . '.phtml';
    }
    private function getLayout($page) {
        if (file_exists(self::LAYOUT_DIR . $page . '.phtml')) {
            return self::LAYOUT_DIR . $page . '.phtml';
        } else {
        return self::LAYOUT_DIR . 'index.phtml';
        }
    }

    private function hasScript($page) {
        return file_exists($this->getScript($page));
    }

    private function hasTemplate($page) {
        return file_exists($this->getTemplate($page));
    }
    
    public function validaSesion() {
        
        if($_SERVER["HTTPS"] != "on") {
            header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            die();
        }
        
        if (!isset($_SESSION['activo'])) {
            Utils::logip('login');
            $this->run('login');
            die();
        }
        
        Usuario::recover();
    }
}

		require '../util/loadClass.php';
        $app = new App();
        $app->init();
        $app->validaSesion();
        $app->run();
