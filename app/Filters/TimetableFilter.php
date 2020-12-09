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
        $formatValue = str_replace('/', '-', $value);
        $weekStartDate = Carbon::parse($formatValue)->startOfWeek()->format('Y-m-d');
        $weekEndDate = Carbon::parse($weekStartDate)
            ->addDays(5)
            ->format('Y-m-d');
        $this->builder = $this->builder->whereBetween('date', [$weekStartDate, $weekEndDate]);
    }

}
