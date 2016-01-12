<?php
/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 01.12.2015
 * Time: 10:09
 */

namespace Asmoria\Core;

use Asmoria\Modules\Handler\HandlerController;

class Model
{

    protected $table;
    protected $prefix;
    protected $idField = "id";
    public $id;

    public function __construct($id = NULL)
    {
        $this->prefix ? $this->prefix = $this->prefix."_" : $this->prefix = "";
        $this->table = $this->prefix.$this->table;
    }


    public function getFields()
    {
        $sth = Configuration::getInstance()->connection->prepare("DESCRIBE ".$this->table);
        $fields = [];
        if($sth->execute()){
            $result = $sth->fetchAll();
            foreach ($result as $item) {
                $fields[$item['Field']] = NULL;
            }
        }
        else throw new HandlerController(new \Exception("Error when getting table fields"));
//        return implode(", ", $fields);
        return $fields;
    }

    public function save()
    {
        $fields = $this->getFields();
        $assoc = [];
        foreach ($fields as $k => $v) {
            if (property_exists($this, $k))
                $assoc[$k] = $this->$k;
            else $assoc[$k] = NULL;
        }
        $sql = 'INSERT INTO ' . $this->table;
        $sql .= ' (' . implode(', ', array_keys($assoc)) . ') ';
        $sql .= 'VALUES (' . implode(', ', array_fill(0, count(array_values($assoc)), '?')) . ')';

        $sth = Configuration::getInstance()->connection->prepare($sql);
        try{
        $sth->execute(array_values($assoc));
            return Configuration::getInstance()->connection->lastInsertId();
        }catch(\PDOException $e){
            throw new HandlerController($e);
        }
    }


    public function select($fields = "*", $where = "")
    {
        if (!is_array($fields) && !is_string($fields))
            throw new \Exception("Parameter was missed");
        if (is_array($fields)) {
            $fields = implode(", ", $fields);
        }
        $values = NULL;
        if ($where) {
            $keys = array_keys($where);
            $values = array_values($where);
            $where = " WHERE ";
            foreach ($keys as $key) {
                $where .= $key . "=?" . " AND ";
            }
            $where = rtrim($where, " AND ");
        }
        $sth = Configuration::getInstance()->connection->prepare("
        SELECT " . $fields . "
        FROM " . $this->table
            . $where
        );

        $sth->execute($values);

        $result = $sth->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        if (empty($result[1]))
            return reset($result);
        return $result;
    }

    public function getById($id)
    {
        $id = intval($id);
        $stmt = Configuration::getInstance()->connection->prepare('
            SELECT * FROM ' . $this->table . '
            WHERE ' . $this->idField . '=?');
        try {
            if ($stmt->execute([$id])){
                return $stmt->fetchObject(get_called_class());
            }
            else throw new HandlerController(new \Exception("No id field or wrong input parameters"));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function validate()
    {

    }
}