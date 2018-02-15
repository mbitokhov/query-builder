<?php

namespace QueryBuilder\Logic;

class WhereStatement extends BaseStatement
{

    public function where($column, $op, $value = null, $boolean = 'and')
    {
        if(func_num_args() === 2) {
            list($op, $value) = array('=', $op);
        }

        $clause = new WhereClause($column, $op, $value);
        $this->addClause($clause, $boolean);
    }
}
