<?php

namespace QueryBuilder\Logic;

class WhereClause extends BaseClause
{

    public function getBindings()
    {
        return array($this->value);
    }
}
