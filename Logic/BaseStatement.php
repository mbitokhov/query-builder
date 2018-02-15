<?php

namespace QueryBuilder\Logic;

class BaseStatement
{
    protected $clauses = array();

    protected $booleans = array();

    public function getClauses()
    {
        return $this->clauses;
    }

    public function getBooleans()
    {
        return $this->booleans;
    }

    public function addClause(BaseClause $clause, $boolean = 'and')
    {
        $this->addToClauses($clause, $boolean);
    }

    public function addStatement(BaseStatement $clause, $boolean = 'and')
    {
        $this->addToClauses($clause, $boolean);
    }

    protected function addToClauses($value, $boolean)
    {
        $this->clauses[] = $value;
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
        return empty($this->getClauses());
    }
}
