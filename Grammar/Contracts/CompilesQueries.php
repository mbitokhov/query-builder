<?php

namespace QueryBuilder\Grammar\Contracts;

use QueryBuilder\Query;

interface CompilesQueries
{
    public function compileQuery(Query $query);

    public function getBindings(Query $query);
}
