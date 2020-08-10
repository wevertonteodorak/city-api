<?php
namespace App\Estado\Controllers;

use App\src\HttpResponse as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Estado\Models\Estado;
use App\src\Http\BaseController;
use App\src\Http\Validator;

class EstadoController extends BaseController {

    /**
     * @OA\Get(
     *     tags={"estado"},
     *     summary="Retorna lista de estados",
     *     description="Retorna objetos estados",
     *     path="/api/estado",
     *     @OA\Response(response="200", description="Uma lista com estados"),
     * ),
     * 
    */
    public function index(Request $req, $response, $args){
        $q = $req->getQueryParams();


        $q = $req->getQueryParams();
        $validate = $this->validate($q, [
            'search' => 'nullable|string|min:2',
            'order_by' => 'nullable|string|min:3',
            'order_dir' => 'nullable|string|min:2|max:5',
        ]);
        $order_by = $validate['order_by'] ?? 'name';
        $order_dir = $validate['order_dir'] ?? 'ASC';
        $search = $validate['search'] ?? null;

        $estados = Estado::orderBy($order_by, $order_dir)
            ->when($search, function($query) use ($search){
                $query->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%");
            })
            ->get()->toArray();
        return Response::json($estados);
    }

    /**
     * @OA\Get(
     *     tags={"estado"},
     *     summary="Retorna um estado específico",
     *     description="Retorna um estado",
     *     path="/api/estado/{id}",
     *     @OA\Response(response="200", description="Um estado"),
     * ),
     * 
    */
    public function show(Request $req, $response, $args){
        $estado = Estado::find($args['id']);
        if ($estado) return Response::json($estado->toArray());

        return Response::not_found();
    }


    /**
     * @OA\Post(
     *     tags={"estado"},
     *     summary="Cria um novo objeto estado e o armazena",
     *     description="Cria um objecto estado",
     *     path="/api/estado",
     *     @OA\Response(response="200", description="JSON com Mensagem sobre operação"),
     * 
     *      @OA\Parameter(
     *          name="name",
     *          in="body",
     *          type="string",
     *          description="Nome do estado",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          name="code",
     *          in="body",
     *          type="string",
     *          description="Código/Abreviação do estado",
     *          required=true,
     *      ),
     * ),
    */
    public function store($req, $response, $args){

        $estado = json_decode($req->getBody(), true);
        $validate = $this->validate($estado, [
            'name' => 'required|string|min:3',
            'code' => 'required|string|min:2|max:2',
        ]);

        $estado = Estado::create($estado);
        return Response::json([
            'message' => 'Registro criado com sucesso'
        ]);
    }

    /**
     * @OA\Put(
     *     tags={"estado"},
     *     summary="Atualiza um objeto estado e o armazena",
     *     description="Atualiza um objecto estado",
     *     path="/api/estado/{id}",
     *     @OA\Response(response="200", description="JSON com Mensagem sobre operação"),
     *      @OA\Parameter(
     *          name="name",
     *          in="body",
     *          type="string",
     *          description="Nome do estado",
     *          required=false,
     *      ),
     *      @OA\Parameter(
     *          name="code",
     *          in="body",
     *          type="string",
     *          description="Código/Abreviação do estado",
     *          required=false,
     *      ),
     * 
     * ),
     * 
    */
    public function update($req, $response, $args){

        $estado = json_decode($req->getBody(), true);
        $validate = $this->validate($estado, [
            'name' => 'nullable|string|min:3',
            'code' => 'nullable|string|min:2|max:2',
        ]);

        $estado = Estado::find($args["id"]);
        
        if ($estado) {
            $estado->fill($validate)->update();
            return Response::json([
                'message' => 'Registro atualizado com sucesso'
            ]);
        }

        return Response::not_found();
    }

    /**
     * @OA\Delete(
     *     tags={"estado"},
     *     summary="Deleta um objeto estado",
     *     description="Deleta um objecto estado",
     *     path="/api/estado/{id}",
     *     @OA\Response(response="200", description="JSON com Mensagem sobre operação"),
     * ),
     * 
    */
    public function delete($req, $response, $args){
        $estado = Estado::find($args["id"]);
        
        if ($estado) {
            if ($estado->cidades()->count()) {
                $estado->cidades()->delete();
            }
            
            Estado::destroy($args["id"]);
            return Response::json([
                'message' => 'Registro excluido com sucesso'
            ]);
        }
        
        return Response::json([
            "message" => "Registro não encontrado"
        ])->withStatus(404);
    }
}