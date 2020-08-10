<?php

namespace Tests\TestCase;

use App\Cidade\Models\Cidade;
use App\Estado\Models\Estado;
use Tests\AppTestTrait;
use PHPUnit\Framework\TestCase;

class CidadeTest extends TestCase
{
    use AppTestTrait;

    public $cidade_id;

    public function testEstadoModelOperations(): void
    {
        $estado = Estado::create([
            'name' => 'Estado Teste',
            'code' => 'ET'
        ]);

        $cidade = Cidade::create([
            'name' => 'Cidade Teste',
            'code' => 'CT',
            'estado_id' => $estado->_id
        ]);

        $this->assertTrue(isset($cidade->_id));

        $cidade_update = Cidade::find($cidade->_id)->update([
            'name' => 'TesteC 222'
        ]);
        $this->assertTrue($cidade_update == 1);

        $cidade_delete = Cidade::destroy($cidade->_id);
        $this->assertTrue($cidade_delete == 1);
    }

}