<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PedidoComidaRepository;
use App\Http\Requests\PedidoComida\CreatePedidoComidaRequest;
use App\Http\Requests\PedidoComida\ShowPedidoComidaRequest;
use App\Http\Requests\PedidoComida\DeletePedidoComidaRequest;
use App\Http\Requests\PedidoComida\EditPedidoComidaRequest;
use RuntimeException;
use Illuminate\Support\Arr;

class PedidoComidaComidaController extends Controller
{
    /** @var PedidoComidaRepository */
    private $repository;

    public function __construct(PedidoComidaRepository $repository){
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\PedidoComida\ShowPedidoComidaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(ShowPedidoComidaRequest $request)
    {
        return $this->repository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PedidoComida\CreatePedidoComidaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePedidoComidaRequest $request)
    {
        $model = $this->repository->create(Arr::only($request->validated(), $this->repository->attributes()));
        return $model;
    }

    /**
     * Display the specified resource.
     *
     * @param App\Http\Requests\PedidoComida\ShowPedidoComidaRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowPedidoComidaRequest $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\PedidoComida\EditPedidoComidaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPedidoComidaRequest $request, $id)
    {
        if($this->repository->edit(Arr::only($request->validated(), $this->repository->attributes()), $id)) {
            return response()->json([
                'status' => 'success',
                'message' => 'PedidoComida modificado exitosamente'
            ]);
        } else {
            throw new RuntimeException("No se puedo modificar el PedidoComida");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param App\Http\Requests\PedidoComida\DeletePedidoComidaRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeletePedidoComidaRequest $request, $id)
    {
        if($this->repository->delete($id)) {
            return response()->json([
                'status' => 'success',
                'message' => 'PedidoComida eliminada exitosamente'
            ]);
        } else {
            throw new RuntimeException("No se puedo eliminar el PedidoComida");
        }
    }
}
