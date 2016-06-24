<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2013 Gestión-e - Gestión Informática Eficiente. All rights reserved.
 *
 *
 */

/**
 * Application config.
 */
final class Config {

    /** @var array config data */
    private static $data = null;


    /**
     * @param null $section
     * @throws Exception
     * @return array
     */
    public static function getConfig($section = null) {
        if ($section === null) {
            return self::getData();
        }
        $data = self::getData();
        if (!array_key_exists($section, $data)) {
            throw new Exception('Unknown config section: ' . $section);
        }
        return $data[$section];
    }

    /**
     * @return array
     */
    private static function getData() {
        if (self::$data !== null) return self::$data;
        if ((self::$data = Usuario::getCache('config'))!=null) return self::$data;
              
        self::$data = parse_ini_file('../config/config.ini', true);
        Usuario::setCache('config',self::$data);
        return self::$data;
    }

}