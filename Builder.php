<?php

namespace QueryBuilder;

class Builder
{
    protected $query;

    protected $model = null;

    protected $localMacros = array();

    protected static $globalMacros = array();

    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    public function macro($key, $closure)
    {
        $model[$key] = $closure;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function newBuilder()
    {
        $builder = new Builder($this->query->newQuery());
        $builder->setModel($this->model);
        return $builder;
    }

    public function where($column, $op = null, $value = null, $boolean = 'and')
    {
        if(is_callable($column))
        {
            $builder = $this->newBuilder();
            if(!is_null($ans = $column($builder))) {
                $builder = $ans;
            }
            if(is_null($op)) {
                $op = 'and';
            }
            $this->whereNested($builder->query->getWhereStatement(), $op);
            return $this;
        }

        call_user_func_array(array($this->query, 'where'), func_get_args());
        return $this;
    }

    protected function callScope(callable $scope, $parameters = [])
    {
        array_unshift($parameters, $this->newBuilder());

        $result = call_user_func_array($scope, array_values($parameters));
        $result = is_null($result) ? $this : $result;

        if($result instanceof self)
        {
            $this->mergeBuilder($result);
        }

        return $result;
    }

    public function __call($method, $parameters)
    {
        if(isset($this->localMacros[$method])) {
            return call_user_func_array($this->localMacros[$method], $parameters);
        }

        if(isset(self::$globalMacros[$method])) {
            return call_user_func_array(self::$globalMacros[$method], $parameters);
        }

        if(method_exists($this->model, $scope = 'scope' . ucfirst($method))) {
            return $this->callScope(array($this->model, $scope), $parameters);
        }

        return call_user_func_array(array($this->query, $method), $parameters);
    }
}
