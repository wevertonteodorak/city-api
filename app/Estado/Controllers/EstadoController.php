<?php
namespace App\Estado\Controllers;

use App\src\HttpResponse as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Estado\Models\Estado;
use App\src\Http\BaseController;
use App\src\Http\Validator;

class EstadoController extends BaseController {

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

    public function update($req, $response, $args){

        $estado = json_decode($req->getBody(), true);
        $validate = $this->validate($estado, [
            'name' => 'required|string|min:3',
            'code' => 'required|string|min:2|max:2',
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

    public function delete($req, $response, $args){
        $estado = Estado::find($args["id"]);
        $estado->cidades()->delete();
        Estado::destroy($args["id"]);
        
        if ($estado) return Response::json([
            'message' => 'Registro excluido com sucesso'
        ]);
        
        return Response::not_found();
    }
}