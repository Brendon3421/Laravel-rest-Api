<?php

namespace App\Services;

use App\DTOs\EmpresasDTO;
use App\DTOs\EnderecoDTO;
use App\Http\Requests\EmpresasRequest;
use App\Http\Requests\EnderecoRequest;
use App\Models\Empresas;
use App\Models\Endereco;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

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
                'message' => 'Empresa listada com sucesso',
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
                'Empresa' => $e->getMessage(),
                'error' => 'falha ao listar empresa',
            ], 400);
        }
    }


    public function criarEmpresas(EmpresasRequest $request, EnderecoRequest $enderecoRequest ,$user_id)
    {
        try {
            DB::beginTransaction();
            $user_id = auth()->id();
            // criou a empresa
            $empresasDTO = EmpresasDTO::makefromModel($request ,$user_id);
            $empresasModel = Empresas::fromModel($empresasDTO)->toArray();
            //crio o endereco da empresa
            $endereco = Endereco::create($enderecoRequest->validated());
            $enderecoDTO = EnderecoDTO::makeFromRequest($endereco ,$user_id)->toArray();
            $enderecoDTO = EnderecoDTO::fromModel($endereco ,$user_id)->toArray();
            DB::commit();

            //contato falta fazer
            DB::commit();
            return response()->json([
                'status' => true,
                'Empresas' => $empresasModel,
                'Endereco' => $enderecoDTO,
                'message' => 'Sucesso em criar Empresa',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => true,
                'Exception' => $e->getMessage(),
                'error' => 'Erro ao tentar criar Empresa',
            ], 400);
        }
    }
}
