<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnderecoRequest;
use App\Models\Endereco;
use App\Services\EnderecoServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnderecoController extends Controller
{

    protected $enderecoServices;

    public function __construct(EnderecoServices $enderecoServices)
    {
        $this->enderecoServices = $enderecoServices;
    }
    //funcao de listar dos os endereco em ordem descrescente
    public function index(): JsonResponse
    {
        return $this->enderecoServices->listarEdendereco();
    }
    //funcao de mostrar endereco com ID especifico 
    public function show(Endereco $endereco): JsonResponse
    {
       return $this->enderecoServices->ListarEnderecoId($endereco);
    }
    //criar endereco
    public function store(EnderecoRequest $request): JsonResponse
    {
        return $this->enderecoServices->criarEndereco($request);
    }
    //Editar Endereco
    public function update(EnderecoRequest $request, Endereco $endereco): JsonResponse
    {
        return $this->enderecoServices->editarEndereco($request ,$endereco);
    }
    public function destroy(Endereco $endereco): JsonResponse
    {
        return $this->enderecoServices->excluirEndereco($endereco);
    }
}
