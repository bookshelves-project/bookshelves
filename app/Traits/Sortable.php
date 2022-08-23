<?php

namespace App\Traits;

trait Sortable
{
    protected $default_sort_column = 'sort';

    public function initializeSortable()
    {
        $this->fillable[] = $this->getSortColumn();

        $this->casts[$this->getSortColumn()] = 'integer';
    }

    public function getSortColumn(): string
    {
        return $this->sort_column ?? $this->default_sort_column;
    }
}
