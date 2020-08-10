<?php

namespace Tests\TestCase;

use App\Estado\Models\Estado;
use Tests\AppTestTrait;
use PHPUnit\Framework\TestCase;

class EstadoTest extends TestCase
{
    use AppTestTrait;

    public $estado_id;

    public function testEstadoModelOperations(): void
    {

        $estado = Estado::create([
            'name' => 'Estado Teste',
            'code' => 'ET'
        ]);
        $this->estado_id = $estado->_id;
        $this->assertTrue(isset($estado->_id));

        $estado_update = Estado::find($estado->_id)->update([
            'name' => 'Teste 222'
        ]);
        $this->assertTrue($estado_update == 1);

        $estado_delete = Estado::destroy($estado->_id);
        $this->assertTrue($estado_delete == 1);
    }
}