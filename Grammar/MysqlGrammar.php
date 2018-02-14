<?php

namespace QueryBuilder\Grammar;

use QueryBuilder\Grammar\Contracts\CompilesQueries;
use QueryBuilder\Query;
use QueryBuilder\Logic\WhereClause;
use QueryBuilder\Logic\WhereStatement;

class MysqlGrammar implements CompilesQueries
{
    public function compileQuery(Query $query)
    {
        return $this->compileWhereStatement($query->getWhereStatement());
    }

    public function getBindings(Query $query)
    {
        return $query->getWhereStatement()->getBindings();
    }

    public function compileWhereStatement($wheres)
    {
        $clauses = array_map(function ($clause) {
            $format = $this->{'compile'.class_basename($clause)}($clause);

            if($clause instanceof WhereStatement) {
                $format = "( $format )";
            }

            return $format;
        }, $wheres->getWhereClauses());

        $booleans = $wheres->getBooleans();
        $first = $clauses[0];

        for($i = 1; $i < count($clauses); $i++)
        {
            $bool = $booleans[$i];
            $clause = $clauses[$i];

            $first .= " $bool $clause";
        }

        return $first;
    }

    public function compileWhereClause($where)
    {
        $column = $this->formatColumn($where->getColumn());

        $operator = $where->getOperator();

        return "$column $operator ?";
    }

    protected function formatColumn($column)
    {
        $column = explode('.', $column);
        $column = array_map(function ($str) {
            return '`' . $str . '`';
        }, $column);
        $column = implode('.', $column);
        return $column;
    }
}
