<?php

namespace QueryBuilder\Logic;

class WhereStatement
{
    protected $whereClauses = array();

    protected $booleans = array();

    public function getWhereClauses()
    {
        return $this->whereClauses;
    }

    public function getBooleans()
    {
        return $this->booleans;
    }

    public function where($column, $op, $value = null, $boolean = 'and')
    {
        if(func_num_args() === 2) {
            list($op, $value) = array('=', $op);
        }

        $clause = new WhereClause($column, $op, $value);
        $this->whereClause($clause, $boolean);
    }

    public function whereClause(WhereClause $value, $boolean = 'and')
    {
        return $this->addToClause($value, $boolean);
    }

    public function whereNested(WhereStatement $value, $boolean = 'and')
    {
        return $this->addToClause($value, $boolean);
    }

    protected function addToClause($value, $boolean)
    {
        $this->whereClauses[] = $value;
        $this->booleans[] = $boolean;
    }

    public function getBindings()
    {
        $bindings = array_map(function ($clause) {
            return $clause->getBindings();
        }, $this->whereClauses);

        return call_user_func_array('array_merge', $bindings);
    }

    public function isEmpty()
    {
        return empty($this->whereClauses);
    }
}
