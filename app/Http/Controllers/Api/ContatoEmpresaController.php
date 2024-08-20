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

    public function show(ContatoEmpresa $contatoEmpresa)
    {
       echo "chamoi";
    }

    public function store(ContatoEmpresaRequest $request): JsonResponse
    {
        return $this->contatoEmpresaServices->criarContatos($request);
    }
}
