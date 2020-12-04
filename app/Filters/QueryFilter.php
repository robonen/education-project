<?php

namespace App\Filters;


class QueryFilter
{
    protected $builder;
    protected $request;

    public function __construct($builder, $request)
    {
        $this->builder = $builder;
        $this->request = $request;
    }

    public function apply()
    {
        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                if (!$value) {
                    continue;
                }
                $this->$filter($value);
            }
        }
        return $this->builder;
    }

    protected function filters()
    {
        return $this->request->all();
    }
}
