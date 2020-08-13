<?php
namespace App\Cidade\Models;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Estado\Models\Estado;
use Carbon\Carbon;

Class Cidade extends Model {
    protected $connection = 'mongodb';
    protected $collection = 'cidades';

    protected $fillable = ['name', 'code', 'estado_id'];
    protected $appends = ['created_at_GMT_3', 'updated_at_GMT_3'];

    public function Estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function getCreatedAtGmt3Attribute($value)
    {
        if (!isset($this->created_at)) return '';
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at, 'UTC');
        $date->setTimezone('America/Sao_Paulo');
        return $date->toDateTimeString();
    }

    public function getUpdatedAtGmt3Attribute($value)
    {

        if (!isset($this->updated_at)) return '';
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at, 'UTC');
        $date->setTimezone('America/Sao_Paulo');
        return $date->toDateTimeString();
    }

}