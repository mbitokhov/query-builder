<?php

namespace QueryBuilder\Logic;

class JoinStatement extends BaseStatement
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function on($column, $op, $value = null, $boolean = 'and')
    {
        if(func_num_args() === 2) {
            list($op, $value) = array('=', $op);
        }

        $clause = new JoinClause($column, $op, $value);
        $this->addClause($clause, $boolean);
    }
}
