<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnderecoRequest;
use App\Models\Empresas;
use App\Models\Endereco;
use App\Services\EnderecoServices;
use Illuminate\Http\JsonResponse;

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
        return $this->enderecoServices->listarEndereco();
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
    public function update(EnderecoRequest $request, Endereco $endereco, Empresas $empresas_id,): JsonResponse
    {
        return $this->enderecoServices->editarEndereco($request ,$endereco, $empresas_id);
    }
    public function destroy(Endereco $endereco): JsonResponse
    {
        return $this->enderecoServices->excluirEndereco($endereco);
    }
}
