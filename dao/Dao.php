<?php
/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2015 GESTION-E S.R.L. All rights reserved.
 *
 *
 */
 
/**
 * abstract class Dao
 * 
 * .
 */
class Dao {

    /** @var PDO */
    static protected $db = null;
    static protected $db_count = 0;
    protected $tabla;
    protected $config;
    protected $id;
    protected $modelo;
    protected $ids = array();
    protected $select;
    protected $count;
    protected $autoid;
    
    public function __construct($dbconf,$tabla,$id,$autoid=false) {
        self::$db_count++;
        
        $this->tabla = $tabla;
        $this->select = 'SELECT * FROM  ' . $this->tabla;
        $this->count = 'SELECT count(*) FROM  ' . $this->tabla;
        
        
        $this->config = Config::getConfig($dbconf);
        $this->id = $id;
        $this->autoid = $autoid;
        
    }
    
    public function __destruct() {
        // close db connection
        //Utils::logip("\nDestruye: " .self::$db_count);
        self::$db_count--;
        if (self::$db_count <= 0) {
            self::$db_count = 0;
            self::$db = null;
        }
    }

    /**
     * @throws Exception
     * @return PDO
     */
    protected  function getDb() { 
        if (self::$db !== null) {
            return self::$db;
        }
        try {
            self::$db = new PDO($this->config['dsn'], $this->config['username'], $this->config['password']);
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        } catch (Exception $ex) {
            throw new Exception('DB connection error: ' . $ex->getMessage());
        }
        
        //Utils::logip("\nConstruye: ".self::$db_count);
        return self::$db;
    }

    /**
     * @param $sql
     * @param array $param
     * @throws Exception
     * @internal param \Modelo|\Persona $modelo
     * @return Persona
     */
    protected  function execute($sql, array $param) {
error_log('-------------EXE:'.$sql);
        $statement = $this->getDb()->prepare($sql);
        $this->executeStatement($statement, $param);
        if (!$statement->rowCount()) {
            if (!((strtoupper(substr(trim($sql), 0, 6))=='UPDATE'))&&!((strtoupper(substr(trim($sql), 0, 6))=='DELETE'))) {
                self::throwDbError(('Execute: ' . $sql . ' Param: ' . serialize($param)), $this->getDb()->errorInfo());
            }
        }
    }

    private  function executeStatement(PDOStatement $statement, array $params) {
        if (!$statement->execute($params)) {
            self::throwDbError('Execute st: ' . $statement->queryString . serialize($params), $this->getDb()->errorInfo());
        }
    }

    /**
     * @param $sql
     * @return PDOStatement
     */
    protected  function query($sql) {
error_log('-------------QRY:'.$sql);
        $statement = $this->getDb()->query($sql, PDO::FETCH_ASSOC);
        if ($statement === false) {
            self::throwDbError(('Query: ' . $sql),$this->getDb()->errorInfo());
        }
        return $statement;
    }

    private static function throwDbError($desc, array $errorInfo) {
        // TODO log error, send email, etc.
        throw new Exception('DB error: ' . $desc . ' ErrorInfo: ' . $errorInfo[0] . ', ' . $errorInfo[1] . ']: ' . $errorInfo[2]);
    }

    public function find(Modelo $search, $order = '', $base = 0, $limit = 1000, $restringe = null, $like = null) {
        if ($order=='') $order=$this->id;
        $sql = $this->select;
        $where = $this->getWhere($search,$restringe,$like);
        if (!empty($where)) $sql .= ' WHERE ' . $where;
        $sql .= ' order by ' . $order;
        $sql .= ' limit ' . $base . ',' . $limit;
        $result = array();
        foreach ($this->query($sql) as $row) {
            $child = clone($this->modelo);
            $result[] = $child->map($row);
        }
        return $result;
    }
    
    public function findCount(Modelo $search, $restringe = null, $like = null) {
        $sql = $this->count;
        $where = $this->getWhere($search,$restringe,$like);
        if (!empty($where)) $sql .= ' WHERE ' . $where;
        $row = $this->query($sql)->fetch();
        if (!$row) {
            return 0;
        }
        $filas = array_values($row);
        return (int)$filas[0];
    }
    
    public function findById($claves) {
        $valor = explode(',',$claves);
        if (count($this->ids)==0) $this->ids = explode(',',$this->id);
        $sql = "";
        foreach ($valor as $i => $v) {
            $this->checkdt($v);
            $sql .=  ' AND ' . $this->ids[$i] . ' = ' . $this->getDb()->quote($v);  
        }
        
        $row = $this->query($this->select . ' WHERE ' . substr($sql, 4))->fetch();
        if (!$row) {
            return null;
        }
        $child = clone($this->modelo);
        return $child->map($row);
    }

    public function delete($modelo, $restringe=null, $like = null) {
        $where = $this->getWhere($modelo,$restringe,$like);
        $params = array();
        $sql = 'DELETE FROM ' . $this->tabla . ' WHERE ' . $where;

        return $this->execute($sql, $params);
    }

    protected function getWhere(Modelo $search, $restringe=null, $like = null) {
        $sql2 = "";
        foreach ($search->getProperties() as $property => $value) {
            if (!isset($value)) {
                continue;
            }
            if (is_array($value)) {
                $v1 = $value[0];
                $v2 = $value[1];
                if ($this->checkdt($v1)) $this->checkdt($v2);
                $sql2 .= ' AND (' . $property . ' >= '. $this->getDb()->quote($v1) . ' AND ' . $property . ' <= '. $this->getDb()->quote($v2) . ')';
            } elseif ($this->checkdt($value)) {
                $sql2 .= ' AND ' . $property . ' = '. $this->getDb()->quote($value);
            } elseif ($like==$property) {
                $sql2 .= ' AND ' . $property . ' LIKE ' . $this->getDb()->quote('%'.$value.'%');
            } else {
                $sql2 .= ' AND ' . $property . ' = '. $this->getDb()->quote($value);
            }
        }

        if ($restringe) {
            $sql2 .= ' AND ' . $restringe . ' IN ( ' . implode(',', Usuario::getSucs()) . ' )';
        }

        return substr($sql2, 4);
    }
    
    protected function checkdt(&$value) {
        if (is_a($value,'DateTime')) {
                    $value = $value->format('Y-m-d H:i:s');
                    return true;
        }
        return false;
    }

    public function insert(Modelo $modelo) {
        $params = array();
        $primero = true;
        foreach ($modelo->getProperties() as $property => $value) {
            if (($property==$this->id)&&($this->autoid)) continue;
            $this->checkdt($value);
            if ($primero) {
                $sql = 'INSERT INTO ' . $this->tabla . ' (`' . $property . '`';
                $sql2 = ':' . $property;
                $primero = false;
            } else {
                $sql .= ', `' . $property . '`';
                $sql2 .= ', ' . ':' . $property;
            }
            $params[$property] = $value;
        } 
        $sql .= ') VALUES (' . $sql2 . ')';

        return $this->execute($sql, $params);
    }

    public function update(Modelo $modelo) {
        if (count($this->ids)==0) $this->ids = explode(',',$this->id);
        $where = "";
        $primero = true;
        foreach ($this->ids as $i => $value) {
            if ($primero) {
                $where .= $value .'= :'.$value;
                $primero = false;
            } else {
                $where .= ' AND ' . $value .'= :'.$value;
            }
        }
        $primero = true;
        $params = array();
        foreach ($modelo->getProperties() as $property => $value) {
            $this->checkdt($value);
            $params[$property] = $value;
            if (($property==$this->id)&&($this->autoid)) continue;
            if ($primero) {
                $sql = 'UPDATE ' . $this->tabla . ' SET ' . $property . ' = :'. $property;
                $primero = false;
            } else {
                $sql .= ',' . $property . ' = :'. $property; 
            }
        } 
        $sql .= ' WHERE ' . $where;

        return $this->execute($sql, $params);
    }
}
