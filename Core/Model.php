<?php
/**
 * Created by PhpStorm.
 * User: Asmoria
 * Date: 01.12.2015
 * Time: 10:09
 */

namespace Asmoria\Core;

//use Asmoria\Core\Configuration;

class Model
{

    protected $table;
    protected $prefix;
    protected $idField = "id";
    public $id;

    public function __construct($id = NULL)
    {
        $sth = Configuration::getInstance()->connection->prepare("
        SELECT *
        FROM " . $this->prefix . "_" . $this->table
        );
        $sth->execute();
        $sth->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    protected function select($fields = "*", $where = "")
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
        FROM " . $this->prefix . "_" . $this->table
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
        $stmt = Configuration::getInstance()->connection->prepare('SELECT * FROM ' . $this->prefix . '_' . $this->table . ' WHERE ' . $this->idField . '=?');
        try {
            if ($stmt->execute([$id]))
                return $stmt->fetchObject(get_called_class());
            else throw new \Exception("No id field or wrong input parameters");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}