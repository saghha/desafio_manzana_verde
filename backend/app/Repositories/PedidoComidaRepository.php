<?php

namespace App\Repositories;

use App\PedidoComida;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Repositories\Traits\BasicCrudOperations;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PedidoComidaRepository {
    use BasicCrudOperations;

    /**
     * The constructor of the Repository
     * @param PedidoComida $repo
     */
    public function __construct(PedidoComida $repo){
        $this->model = $repo;
    }
}