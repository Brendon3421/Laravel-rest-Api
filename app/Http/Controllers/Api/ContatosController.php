<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatosRequest;
use App\Models\Contatos;
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

    public function index() :JsonResponse
    {
        return $this->contatosServices->listarContatos();
    }

    public function show(Contatos $contatos):JsonResponse
    {
        return $this->contatosServices->listarContatosId($contatos);
    }

    public function store(ContatosRequest $request):JsonResponse
    {
        return $this->contatosServices->criarContatos($request);
    }
}
