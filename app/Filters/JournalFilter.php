<?php

namespace App\Filters;


use Carbon\Carbon;

class JournalFilter extends QueryFilter
{

    protected function student($value)
    {
        $this->builder = $this->builder->where('student_id', $value);
    }

    protected function teacher($value)
    {
        $this->builder = $this->builder->where('teacher_id', $value);
    }

    protected function subject($value)
    {
        $this->builder = $this->builder->where('subject_id', $value);
    }

    protected function date($value)
    {
        $value = Carbon::createFromTimestamp($value/1000)->floorDays();
        $this->builder = $this->builder->where('updated_at', $value);
    }

    protected function last($value)
    {
        $date = Carbon::now()->subDays($value);
        $this->builder = $this->builder->where('updated_at', '>=', $date);
    }

}
