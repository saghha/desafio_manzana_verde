<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PedidoRepository;
use App\Repositories\PedidoComidaRepository;
use App\PedidoComida;
use App\Http\Requests\Pedido\CreatePedidoRequest;
use App\Http\Requests\Pedido\ShowPedidoRequest;
use App\Http\Requests\Pedido\DeletePedidoRequest;
use App\Http\Requests\Pedido\EditPedidoRequest;
use RuntimeException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /** @var PedidoRepository */
    private $repository;

    public function __construct(PedidoRepository $repository){
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Pedido\ShowPedidoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(ShowPedidoRequest $request)
    {
        $user = $request->user();
        return $this->repository->all($user->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Pedido\CreatePedidoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePedidoRequest $request)
    {
        $data = $request->validated();
        $repo_pedido_comida = new PedidoComidaRepository(new PedidoComida());
        DB::beginTransaction();
        try {
            $model = $this->repository->create(array_merge($data, ['id_cliente' => $request->user()->id]));
            foreach($data['platos'] as $plato) {
                $data_plato = array_merge($plato, ['id_pedido' => $model->id]);
                $repo_pedido_comida->create($data_plato);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        DB::commit();
        $model->load(['platos']);
        return $model;
    }

    /**
     * Display the specified resource.
     *
     * @param App\Http\Requests\Pedido\ShowPedidoRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowPedidoRequest $request, $id)
    {
        $model = $this->repository->find($id);
        $model->load(['platos', 'platos.comida']);
        return $model;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Pedido\EditPedidoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPedidoRequest $request, $id)
    {
        $data = Arr::only($request->validated(), $this->repository->attributes());
        if($this->repository->edit($data, $id)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pedido modificado exitosamente'
            ]);
        } else {
            throw new RuntimeException("No se puedo modificar el Pedido");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param App\Http\Requests\Pedido\DeletePedidoRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeletePedidoRequest $request, $id)
    {
        if($this->repository->delete($id)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pedido eliminada exitosamente'
            ]);
        } else {
            throw new RuntimeException("No se puedo eliminar el Pedido");
        }
    }

    /**
     * Get all Pedido separated with pagado and entregado
     * @param App\Http\Requests\Pedido\ShowPedidoRequest
     * @return \Illuminate\Http\Response
     */
    public function pedidos(ShowPedidoRequest $request) {
        $user = $request->user();
        $pedidos = $this->repository->all($user->id);
        $data_return = [
            'vigentes' => [],
            'no_vigentes' => []
        ];
        foreach($pedidos as $item) {
            if($item->entregado) {
                array_push($data_return['no_vigentes'], $item);
            } else {
                array_push($data_return['vigentes'], $item);
            }
        }
        return $data_return;
    }
}
