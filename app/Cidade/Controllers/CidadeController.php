<?php
namespace App\Cidade\Controllers;

use App\src\HttpResponse as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Cidade\Models\Cidade;
use App\Estado\Models\Estado;
use App\src\Http\BaseController;

class CidadeController extends BaseController {

    /**
     * @OA\Info(title="Zoox API")
     * @OA\Get(
     *     tags={"cidade"},
     *     summary="Retorna lista de cidades",
     *     description="Retorna objetos cidades",
     *     path="/api/cidade",
     *     @OA\Response(response="200", description="Uma lista com cidades"),
     * ),
     * 
    */
    public function index(Request $req, $response, $args){
        $q = $req->getQueryParams();
        $validate = $this->validate($q, [
            'search' => 'nullable|string|min:2',
            'order_by' => 'nullable|string|min:3',
            'order_dir' => 'nullable|string|min:2|max:5',
        ]);
        $order_by = $validate['order_by'] ?? 'name';
        $order_dir = $validate['order_dir'] ?? 'ASC';
        $search = $validate['search'] ?? null;

        $Cidades = Cidade::orderBy($order_by, $order_dir)
            ->when($search, function($query) use ($search){
                $query->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%");
            })
            ->with('Estado:name')
            ->get()->toArray();
        return Response::json($Cidades);
    }

    /**
     * @OA\Get(
     *     tags={"cidade"},
     *     summary="Retorna uma cidade específico",
     *     description="Retorna uma cidade",
     *     path="/api/cidade/{id}",
     *     @OA\Response(response="200", description="Uma cidade"),
     * ),
     * 
    */
    public function show(Request $req, $response, $args){
        $cidade = Cidade::find($args['id']);
        if ($cidade) return Response::json($cidade->toArray());

        return Response::not_found();
    }


    /**
     * @OA\Post(
     *     tags={"cidade"},
     *     summary="Cria um novo objeto cidade e o armazena",
     *     description="Cria um objecto cidade",
     *     path="/api/cidade",
     *     @OA\Response(response="200", description="JSON com Mensagem sobre operação"),
     *      @OA\Parameter(
     *          name="name",
     *          in="body",
     *          type="string",
     *          description="Nome da cidade",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          name="code",
     *          in="body",
     *          type="string",
     *          description="Código/Abreviação da cidade",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          name="estado_id",
     *          in="body",
     *          type="string",
     *          description="id do estado ao qual a cidade pertence",
     *          required=true,
     *      ),
     * ),
     * 
    */
    public function store($req, $response, $args){

        $request = json_decode($req->getBody(), true);
        $validate = $this->validate($request, [
            'code' => 'required|string|min:2',
            'name' => 'required|string|min:3',
            'estado_id' => 'required|string|min:5',
        ]);

        $estado = Estado::find($validate['estado_id']);
        
        $Cidade = $estado->Cidades()->create($validate);
        return Response::json([
            'message' => 'Registro salvo com sucesso'
        ]);
    }


    /**
     * @OA\Put(
     *     tags={"cidade"},
     *     summary="Atualiza um objeto cidade e o armazena",
     *     description="Atualiza um objecto cidade",
     *     path="/api/cidade/{id}",
     *     @OA\Response(response="200", description="JSON com Mensagem sobre operação"),
     *      @OA\Parameter(
     *          name="name",
     *          in="body",
     *          type="string",
     *          description="Nome da cidade",
     *          required=false,
     *      ),
     *      @OA\Parameter(
     *          name="code",
     *          in="body",
     *          type="string",
     *          description="Código/Abreviação da cidade",
     *          required=false,
     *      ),
     * ),
     * 
    */
    public function update($req, $response, $args){

        $data = json_decode($req->getBody(), true);
        

        $Cidade = Cidade::find($args["id"]);
        
        if ($Cidade) {
            $Cidade->fill($data)->save();
            return Response::json([
                'message' => 'Registro atualizado com sucesso'
            ]);
        }

        return Response::json([
            "message" => "Registro não encontrado"
        ])->withStatus(404);
    }

    /**
     * @OA\Delete(
     *     tags={"cidade"},
     *     summary="Deleta um objeto cidade",
     *     description="Deleta um objecto cidade",
     *     path="/api/cidade/{id}",
     *     @OA\Response(response="200", description="JSON com Mensagem sobre operação"),
     * ),
     * 
    */
    public function delete($req, $response, $args){

        $Cidade = Cidade::destroy($args["id"]);
        
        if ($Cidade) return Response::json([
            'message' => 'Registro escluido com sucesso'
        ]);
        
        return Response::json([
            "message" => "Registro não encontrado"
        ])->withStatus(404);
    }

}