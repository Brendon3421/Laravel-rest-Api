<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatoEmpresaRequest;
use App\Models\ContatoEmpresa;
use App\Services\ContatoEmpresaServices;
use Illuminate\Http\JsonResponse;

class ContatoEmpresaController extends Controller
{
    public $contatoEmpresaServices;

    public function __construct(ContatoEmpresaServices $contatoEmpresaServices)
    {
        return $this->contatoEmpresaServices = $contatoEmpresaServices;
    }

    public function index(): JsonResponse
    {
        return $this->contatoEmpresaServices->listarContatos();
    }

    public function show(contatoEmpresa $contatoEmpresa)
    {
        return $this->contatoEmpresaServices->listarContatosId($contatoEmpresa);
    }
    public function store(ContatoEmpresaRequest $request): JsonResponse
    {
        return $this->contatoEmpresaServices->criarContatos($request);
    }
    public function update(ContatoEmpresaRequest $request, ContatoEmpresa $contatoEmpresa)
    {
        return $this->contatoEmpresaServices->editarContatos($request, $contatoEmpresa);
    }
    public function delete(ContatoEmpresa $contatoEmpresa): JsonResponse
    {
        return $this->contatoEmpresaServices->excluirContatoUser($contatoEmpresa);
    }
}
