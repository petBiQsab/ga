<?php

namespace App\Http\Interface\FactoryInterface;

interface StorableInterface
{
    public function store($model,$attribute,$id_original,$newValue);
}
