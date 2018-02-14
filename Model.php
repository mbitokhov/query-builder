<?php

namespace QueryBuilder;

use QueryBuilder\Grammar\MysqlGrammar;

class Model
{

    protected $primaryKey = 'id';

    protected $table = '';

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function newQuery()
    {
        $query = new Query(new MysqlGrammar);
        $builder = new Builder($query);

        return $builder->setModel($this);
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->newQuery(), $method), $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        return call_user_func_array(array((new static), $method), $parameters);
    }
}
