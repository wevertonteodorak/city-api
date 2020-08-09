<?php
namespace App\Estado\Models;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Cidade\Models\Cidade;

Class Estado extends Model {
    protected $connection = 'mongodb';
    protected $collection = 'estados';

    protected $fillable = ['name', 'code'];


    public function Cidades()
    {
        return $this->hasMany(Cidade::class);
    }
}