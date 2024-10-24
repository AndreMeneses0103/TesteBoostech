<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PessoaController extends Controller
{
    public function allUsers()
    {
        $pessoas = Pessoa::all();
        return response()->json($pessoas);
    }

    public function createPessoa(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:100',
                'email' => 'required|email|string|max:255|unique:pessoas,email',
                'senha' => 'required|string|min:8|max:100',
                'cargo' => 'string|required|in:user,admin'
            ]);

            $pessoa = Pessoa::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'senha' => bcrypt($request->senha),
                'cargo' => $request->cargo
            ]);

            return response()->json([
                "message" => 'Pessoa cadastrada com sucesso!',
                "data" => $pessoa->makeHidden('senha')
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                "message" => "Erro de validação",
                "errors" => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                "message" => 'Erro ao cadastrar pessoa',
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function loginPessoa(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'senha' => 'required|string',
        ]);
        try {
            $pessoa = Pessoa::where('email', $request->input('email'))->first();
            if ($pessoa && Hash::check($request->input('senha'), $pessoa->senha)) {
                return response()->json([
                    'message' => 'Login realizado com sucesso',
                    'user' => $pessoa->makeHidden('senha')
                ], 200);
            } else {
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no processo de login', 'error' => $e->getMessage()], 500);
        }
    }

    public function deletePessoa($id)
    {
        $pessoa = Pessoa::find($id);
        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa nao encontrada'], 404);
        }
        $pessoa->delete();
        return response()->json(['message' => 'Pessoa deletada com sucesso', 200]);
    }

    public function getPessoa($id)
    {
        $pessoa = Pessoa::find($id);
        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa nao encontrada'], 404);
        }
        return response()->json(['pessoa' => $pessoa], 200);
    }

    public function updatePessoa(Request $request, $id)
    {
        $pessoa = Pessoa::find($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        $request->validate([
            'nome' => 'nullable|string',
            'email' => 'nullable|string|email',
            'senha' => 'nullable|string',
        ]);

        if ($request->has('nome')) {
            $pessoa->nome = $request->input('nome');
        }
        if ($request->has('email')) {
            $pessoa->email = $request->input('email');
        }
        if ($request->has('senha')) {
            $pessoa->senha = Hash::make($request->input('senha'));
        }
        $pessoa->save();
        return response()->json(['message' => 'Pessoa atualizada com sucesso', 'user' => $pessoa], 200);
    }

    public function sorteio()
    {
        $pessoas = Pessoa::where('cargo', '!=', 'admin')->get();

        if ($pessoas->count() < 2) {
            return response()->json(['message' => 'É necessário ter pelo menos duas pessoas para realizar o sorteio.'], 400);
        }

        if ($pessoas->count() % 2 != 0) {
            return response()->json(['message' => 'É necessário que o número de pessoas que irão participar do sorteio seja par.'], 400);
        }

        $pessoasArray = $pessoas->toArray();
        shuffle($pessoasArray);

        for ($i = 0; $i < count($pessoasArray); $i++) {
            $referenciaPessoaId = $pessoasArray[($i + 1) % count($pessoasArray)]['id'];

            Pessoa::where('id', $pessoasArray[$i]['id'])->update(['referencia_pessoa_id' => $referenciaPessoaId]);
        }

        return response()->json(['message' => 'Sorteio realizado com sucesso!'], 200);
    }

    public function getSorteioResultados()
    {
        $pessoas = Pessoa::whereNotNull('referencia_pessoa_id')->get();

        $resultados = $pessoas->map(function ($pessoa) {
            return [
                'pessoa' => $pessoa->nome,
                'quem_sorteou' => Pessoa::find($pessoa->referencia_pessoa_id)->nome ?? 'Desconhecido'
            ];
        });

        return response()->json($resultados);
    }

    public function getSorteioResultadoPorId($id)
    {
        $pessoa = Pessoa::find($id);

        if (!$pessoa) {
            return response()->json(['error' => 'Pessoa não encontrada.'], 404);
        }

        $resultado = [
            'pessoa' => $pessoa->nome,
            'quem_sorteou' => Pessoa::find($pessoa->referencia_pessoa_id)->nome ?? 'Desconhecido'
        ];

        return response()->json($resultado);
    }
}
