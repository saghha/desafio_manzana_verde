<?php

namespace App\Repositories;

use App\Pedido;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Repositories\Traits\BasicCrudOperations;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PedidoRepository {
    use BasicCrudOperations;

    /**
     * The constructor of the Repository
     * @param Pedido $repo
     */
    public function __construct(Pedido $repo){
        $this->model = $repo;
    }
    
    /**
     * get all model
     * @return \Illuminate\Support\Collection
     */
    public function all($id_user){
        return $this->model->with(['platos', 'platos.comida'])->where('id_cliente', $id_user)->get();
    }

    /**
     * get a single model
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id){
        $model = $this->model->find($id);
        if ($model) return $model;
        else throw new ModelNotFoundException(class_basename($this->model)." not found");
    }
}