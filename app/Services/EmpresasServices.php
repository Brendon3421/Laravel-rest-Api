<?php

namespace App\Services;

use App\DTOs\ContatoEmpresaDTO;
use App\DTOs\EmpresasDTO;
use App\DTOs\EnderecoDTO;
use App\Http\Requests\ContatoEmpresaRequest;
use App\Http\Requests\EmpresasRequest;
use App\Http\Requests\EnderecoRequest;
use App\Models\ContatoEmpresa;
use App\Models\Empresas;
use App\Models\Endereco;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Dotenv\Exception\ValidationException;

class EmpresasServices
{


    public function listarEmpresas(): JsonResponse
    {
        try {
            $empresas = Empresas::with(['situacao', 'endereco'])->orderBy('id', 'DESC')->paginate(3);
            $empresasDTO = $empresas->map(function ($empresa) {
                return EmpresasDTO::fromModel($empresa)->toArray();
            });
            return response()->json([
                'status' => true,
                'Empresas' => $empresasDTO,
                'message' => 'Empresas listadas com sucesso',
                'pagination' => [
                    'total' => $empresas->total(),
                    'count' => $empresas->count(),
                    'per_page' => $empresas->perPage(),
                    'current_page' => $empresas->currentPage(),
                    'total_pages' => $empresas->lastPage()
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'exception' => $e->getMessage(),
                'error' => 'Falha ao listar empresas',
            ], 400);
        }
    }
    public function listarEmpresasId(Empresas $empresas): JsonResponse
    {
        try {
            $empresas->load(['situacao', 'endereco']);
            $empresasDTO = EmpresasDTO::fromModel($empresas)->toArray();
            return response()->json([
                'status' => true,
                'Empresa' => $empresasDTO,
                'message' => 'Empresa listada com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Empresa' => $e->getMessage(),
                'error' => 'falha ao listar empresa',
            ], 400);
        }
    }


    public function criarEmpresas(
        EmpresasRequest $request,
        EnderecoRequest $enderecoRequest, 
        ContatoEmpresaRequest $contatoEmpresaRequest
    ) {
        try {
            DB::beginTransaction();
            $userId = auth()->id();

            // Criar a empresa
            $empresasDTO = EmpresasDTO::makefromModel($request, $userId)->toArray();
            $empresaModel = Empresas::create($empresasDTO);
            $empresasModel = EmpresasDTO::fromModel($empresaModel)->toArray();
            $empresa_id = $empresaModel->id;
            // Criar o endereço da empresa
            $enderecoDTO = EnderecoDTO::makeFromRequestEmpresa($enderecoRequest, $empresa_id)->toArray();
            $enderecoModel = Endereco::create($enderecoDTO);
            $enderecoDTO = EnderecoDTO::fromModel($enderecoModel, $userId)->toArray();
            
            // // Criar o contato da empresa
            $sub_empresa = null; // Fica como null pois não há sub-empresa neste contexto
            $contatoEmpresaDTO = ContatoEmpresaDTO::makeFromModel($contatoEmpresaRequest, $empresa_id, $sub_empresa);
            $contatoModel = ContatoEmpresa::create($contatoEmpresaDTO->toArray());
            $contatoEmpresaDTO = ContatoEmpresaDTO::fromModel($contatoModel)->toArray();
            DB::commit();
            return response()->json([
                'status' => true,
                'Empresas' => $empresasModel,
                'Endereco' => $enderecoDTO,
                'ContatoEmpresa' => $contatoEmpresaDTO,
                'message' => 'Sucesso em criar Empresa',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => true,
                'message' => "erro na validacao",
                'error' => $e->getMessage(),
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Exception' => $e->getMessage(),
                'error' => 'Erro ao tentar criar Empresa',
            ], 400);
        }
    }
}
