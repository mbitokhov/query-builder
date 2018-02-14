<?php

namespace QueryBuilder\Logic;

class WhereClause
{

    protected $column;
    protected $operator;
    protected $value;

    public function __construct($column, $operator, $value)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function getBindings()
    {
        return array($this->value);
    }
}
