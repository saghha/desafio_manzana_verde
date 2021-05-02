<?php

namespace App\Repositories;

use App\Comida;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Repositories\Traits\BasicCrudOperations;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ComidaRepository {
    use BasicCrudOperations;

    /**
     * The constructor of the Repository
     * @param Comida $repo
     */
    public function __construct(Comida $repo){
        $this->model = $repo;
    }
}