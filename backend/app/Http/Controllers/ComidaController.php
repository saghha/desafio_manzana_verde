<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ComidaRepository;
use App\Http\Requests\Comida\CreateComidaRequest;
use App\Http\Requests\Comida\ShowComidaRequest;
use App\Http\Requests\Comida\DeleteComidaRequest;
use App\Http\Requests\Comida\EditComidaRequest;
use RuntimeException;
use Illuminate\Support\Arr;

class ComidaController extends Controller
{
    /** @var ComidaRepository */
    private $repository;

    public function __construct(ComidaRepository $repository){
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Comida\ShowComidaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(ShowComidaRequest $request)
    {
        return $this->repository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Comida\CreateComidaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateComidaRequest $request)
    {
        $model = $this->repository->create(Arr::only($request->validated(), $this->repository->attributes()));
        return $model;
    }

    /**
     * Display the specified resource.
     *
     * @param App\Http\Requests\Comida\ShowComidaRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowComidaRequest $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Comida\EditComidaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditComidaRequest $request, $id)
    {
        if($this->repository->edit(Arr::only($request->validated(), $this->repository->attributes()), $id)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Comida modificada exitosamente'
            ]);
        } else {
            throw new RuntimeException("No se puedo modificar la Comida");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param App\Http\Requests\Comida\DeleteComidaRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteComidaRequest $request, $id)
    {
        if($this->repository->delete($id)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Comida eliminada exitosamente'
            ]);
        } else {
            throw new RuntimeException("No se puedo eliminar la Comida");
        }
    }
}
