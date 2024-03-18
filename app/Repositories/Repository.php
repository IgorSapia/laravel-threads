<?php

namespace App\Repositories;

abstract class Repository
{
    protected $model;

    public function __construct() {
        $this->model = $this->defineModel();
    }

    protected function defineModel() {
        return app($this->model);
    }
}
