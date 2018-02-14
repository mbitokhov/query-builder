<?php

namespace QueryBuilder;

use QueryBuilder\Logic\WhereStatement;
use QueryBuilder\Grammar\Contracts\CompilesQueries;

class Query
{
    protected $grammar;

    protected $whereStatement;

    public function __construct(CompilesQueries $grammar)
    {
        $this->grammar = $grammar;
        $this->whereStatement = new WhereStatement;
    }

    public function newQuery()
    {
        return new self($this->grammar);
    }

    public function getWhereStatement()
    {
        return $this->whereStatement;
    }

    public function where($column, $operator, $value = null, $boolean = 'and')
    {
        return call_user_func_array(array($this->whereStatement, __FUNCTION__), func_get_args());
    }

    public function whereNested(WhereStatement $where, $boolean = 'and')
    {
        return call_user_func_array(array($this->whereStatement, __FUNCTION__), func_get_args());
    }

    public function compile()
    {
        return $this->grammar->compileQuery($this);
    }

    public function getBindings()
    {
        return $this->grammar->getBindings($this);
    }
}
