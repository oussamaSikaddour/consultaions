<?php
// app/Traits/SortableTrait.php

namespace App\Traits;



trait SortableTrait
{
    public $sortBy = "created_at";
    public $sortDirection = "ASC";
    public $filters = [];
    public function setSortBy($chosenSortBy)
    {
        if ($this->sortBy === $chosenSortBy) {
            $this->sortDirection = ($this->sortDirection === "ASC") ? "DESC" : "ASC";
            return;
        }
        $this->sortBy = $chosenSortBy;
        $this->sortDirection = "DESC";

    }


    private function initializeFilter($name, $label, $data)
    {
        $this->filters[] = [
            'name' => $name,
            'label' => $label,
            'data' => $data,
        ];
    }
    private function updateFilterData($name, $newData)
    {

        foreach ($this->filters as &$filter) {
            if ($filter['name'] === $name) {
                $filter['data'] = $newData;
                break;
            }
        }
    }




}


