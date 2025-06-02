<?php

namespace App\Http\Controllers\Auth;

class AuthCollection
{
    private $data;

    public function __construct($data)
    {
        $this->data=$data;
    }

    public function getAll()
    {
        return $this->data;
    }

    public function getByKey($key)
    {
        return $this->data[$key];
    }

    public function getByKeyAndType($key,$type)
    {
        return $this->data[$key][$type];
    }
}
