<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatoEmpresaRequest;
use App\Http\Requests\EmpresasRequest;
use App\Http\Requests\EnderecoRequest;
use App\Models\Empresas;
use App\Services\EmpresasServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    public $empresasServices;

    public function __construct(EmpresasServices $empresasServices)
    {
        return $this->empresasServices = $empresasServices;
    }

    public function index(): JsonResponse
    {
        return $this->empresasServices->listarEmpresas();
    }

    public function  show(Empresas $empresas): JsonResponse
    {
        return $this->empresasServices->listarEmpresasId($empresas);
    }

    public function store(EmpresasRequest $request, EnderecoRequest $enderecoRequest, ContatoEmpresaRequest $contatoEmpresaRequest): JsonResponse
    {
        // dd($request->all());
        return $this->empresasServices->criarEmpresas($request, $enderecoRequest, $contatoEmpresaRequest);
    }
}
