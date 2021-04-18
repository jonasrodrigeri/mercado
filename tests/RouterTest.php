<?php
namespace JonasRodrigeri\Source;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    public function testVerificaSeEncontraRota()
    {
        $router = new Router('GET', '/ola-mundo');

        $router->add('GET', '/ola-mundo', function() {
            return true;
        });

        $result = $router->handler();
        $actual = $result();

        $expected = true;

        $this->assertEquals($expected, $actual);
    }

    public function testVerificaNaoSeEncontraRota()
    {
        $router = new Router('GET', '/outra-url');

        $router->add('GET', '/ola-mundo', function() {
            return true;
        });

        $result = $router->handler();

        $actual = $result;
        $expected = false;

        $this->assertNotEquals($expected, $actual);
    }

    public function testVerificaNaoSeEncontraRotaComMetodoErrado()
    {
        //
    }

    public function testVerificaSeEncontraRotaVariavel()
    {
        $router = new Router('GET', '/ola-mundo');

        $router->add('GET', '/ola-{nome}', function() {
            return true;
        });

        $result = $router->handler();

        $actual = $result();
        $expected = true;
        $this->assertEquals($expected, $actual);
    }
}
