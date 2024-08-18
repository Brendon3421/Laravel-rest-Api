<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatosRequest;
use App\Http\Requests\ContatosUserRequest;
use App\Models\contatos_user;
use App\Models\contatosUser;
use App\Services\ContatosServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContatosController extends Controller
{
    public $contatosServices;

    public function __construct(ContatosServices $contatosServices)
    {
        return $this->contatosServices = $contatosServices;
    }

    public function index(): JsonResponse
    {
        return $this->contatosServices->listarContatos();
    }

    public function show(contatosUser $contatosUser): JsonResponse
    {
        return $this->contatosServices->listarContatosId($contatosUser);
    }

    public function store(ContatosUserRequest $request): JsonResponse
    {
        return $this->contatosServices->criarContatos($request);
    }

    public function update(ContatosUserRequest $request,  contatosUser $contatos): JsonResponse
    {
        return $this->contatosServices->editarContatos($request, $contatos);
    }

    public function destroy(contatosUser $contatos): JsonResponse
    {
        return $this->contatosServices->excluirContatoUser($contatos);
    }
}
