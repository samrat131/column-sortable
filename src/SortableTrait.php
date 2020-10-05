<?php

namespace Samrat131\ColumnSortable;

/**
* Trait for sort column wise eloquent model
*/
trait SortableTrait{

	public function scopeSortable($query, array $default = [])
    {
        if (! is_array($this->columnToSort) || empty($this->columnToSort)) {
            return $query;
        }

        $sortCol = app()->make('sortcolumn');
        $sortCol->sortColumn($this->columnToSort);

        if (request()->has('sort') && request()->has('order')) {
            return $query->orderBy(request('sort'), request('order'));
        }

        if (isset($default[0]) && isset($default[1])) {
        	return $query->orderBy($default[0], $default[1]);
        }

        return $query;
    }
}