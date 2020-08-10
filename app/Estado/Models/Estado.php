<?php
namespace App\Estado\Models;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Cidade\Models\Cidade;
use Carbon\Carbon;

Class Estado extends Model {
    protected $connection = 'mongodb';
    protected $collection = 'estados';

    protected $fillable = ['name', 'code'];
    protected $appends = ['created_at_GMT_3', 'updated_at_GMT_3'];


    public function Cidades()
    {
        return $this->hasMany(Cidade::class);
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