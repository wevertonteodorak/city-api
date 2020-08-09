<?php
namespace App\Cidade\Models;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Estado\Models\Estado;

Class Cidade extends Model {
    protected $connection = 'mongodb';
    protected $collection = 'cidades';

    protected $fillable = ['name', 'code'];

    public function Estado()
    {
        return $this->belongsTo(Estado::class);
    }

}