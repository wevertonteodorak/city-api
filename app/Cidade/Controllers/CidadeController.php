<?php
namespace App\Cidade\Controllers;

use App\src\HttpResponse as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Cidade\Models\Cidade;
use App\Estado\Models\Estado;
use App\src\Http\BaseController;

class CidadeController extends BaseController {

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