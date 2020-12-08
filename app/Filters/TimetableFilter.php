<?php

namespace App\Filters;


use Carbon\Carbon;

class TimetableFilter extends QueryFilter
{

    protected function class($value)
    {
        $this->builder = $this->builder->where('class_id', $value);
    }

    protected function teacher($value)
    {
        $this->builder = $this->builder->where('teacher_id', $value);
    }

    protected function subject($value)
    {
        $this->builder = $this->builder->where('subject_id', $value);
    }

    protected function classroom($value)
    {
        $this->builder = $this->builder->where('classroom', $value);
    }

    protected function date($value)
    {
        $start_date = str_replace('/', '-', $value);
        $end_date = Carbon::parse($start_date)
            ->addDays(5)
            ->format('Y-m-d');
        $this->builder = $this->builder->whereBetween('date', [$start_date, $end_date]);
    }

}
