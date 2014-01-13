<?php

/**
 * Main docblock
 *
 * PHP version 5
 *
 * @category  Db
 * @package   DbUtil
 * @author    Edouard Kombo <edouard.kombo@gmail.com>
 * @copyright 2013-2014 Edouard Kombo
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   GIT: 1.0.0
 * @link      http://www.breezeframework.com/thetrollinception.php
 * @since     1.0.0
 */
namespace TTI\DbUtil;

use TTI\AbstractFactory\ConceiveAbstraction;

/**
 * PdoDriver responsibility is to handle database storage with PDO
 *
 * @category Db
 * @package  DbUtil
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://www.breezeframework.com/thetrollinception.php
 */
class PdoDriver extends ConceiveAbstraction
{
    /**
     *
     * @var resource $pdo Pdo resource 
     */
    protected $pdo = null; 
    
    /**
     *
     * @var string $sql Sql received
     */
    protected $sql;     
    
    /**
     * Constructor
     * 
     * @param string  $hostname Database hostname
     * @param string  $username Database username
     * @param string  $password Database password
     * @param string  $database Database name
     * @param integer $port     Database port
     */
    public function __construct($hostname, $username, $password, $database, $port)
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=".$hostname.";port=".$port.";".
                "dbname=".$database, $username, $password,
                array(PDO::ATTR_PERSISTENT => true)
            );
        } catch(\PDOException $e) {
            trigger_error(
                'Error: Could not make a database link ('.
                $e->getMessage().').'.'Error Code: ' .$e->getCode().' <br/>'
            );
        }    
    }
    
    /**
     * Cloner
     * 
     * @return void
     */
    public function __clone()
    {
    }      
    
    
    /**
     * Database encoding
     * 
     * @param string $encodage Encode type
     * 
     * @return \TTI\DbUtil\PdoDriver
     */
    protected function encode($encodage)
    {
        $this->pdo->exec("SET NAMES '$encodage'");
        $this->pdo->exec("SET CHARACTER SET $encodage");
        $this->pdo->exec("SET CHARACTER_SET_CONNECTION=$encodage");
        $this->pdo->exec("SET SQL_MODE = ''");
        
        return (object) $this;
    }

    /**
     * Prepare sql query
     * 
     * @param string $sql Sql query
     * 
     * @return \TTI\DbUtil\PdoDriver
     */
    protected function prepare($sql)
    {
        $this->sql = $sql;
        $this->pdo->prepare($this->sql);
        return (object) $this;
    }

    /**
     * Bind sql query params
     * 
     * @param string $param  Key used in the query
     * @param string $var    Value of the key used
     * @param mixed  $type   Data type of the value used
     * @param int    $length Length of the data
     * 
     * @return \TTI\DbUtil\PdoDriver
     */
    protected function bindParam($param, $var, $type=PDO::PARAM_STR, $length=0)
    {
        if ($length) {
            $this->pdo->bindParam($param, $var, $type, $length);
        } else {
            $this->pdo->bindParam($param, $var, $type);
        }
        
        return (object) $this;
    }
    
    
    /**
     * Execute the rest of the save method part
     * 
     * @return \TTI\DbUtil\stdClass
     */
    private function _execute()
    {
        $data = array();
        while ($row = $this->pdo->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        $result = new stdClass();
        $result->row = ( isset($data[0]) ? $data[0] : array() );
        $result->rows = (array) $data;
        $result->count = (integer) $this->pdo->rowCount();

        return (object) $result;        
    }

    /**
     * Finalize the query
     * 
     * @throws PDOException
     * @return \TTI\DbUtil\stdClass
     */
    protected function save()
    {
        try {
            if (!$this->pdo OR !$this->pdo->execute()) {
                throw new \PDOException;
            }
            return (object) $this->_execute();
            
        } catch(PDOException $e) {
            trigger_error(
                'Error: ' . $e->getMessage() . ' Error Code : ' . 
                $e->getCode() . ' <br />' . $this->sql
            );
        }
    }    

    /**
     * Return last insert id
     * 
     * @return integer
     */
    public function lastId()
    {
        return (integer) $this->pdo->lastInsertId();
    }
}
