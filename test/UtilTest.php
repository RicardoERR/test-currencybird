<?php

use PHPUnit\Framework\TestCase;
use testcotizador\Util;

/**
 * Prueba unitaria para verificar que el método RealizarCotizacion de nuestra clase Util retorne el resultado esperado
 */

class UtilTest extends TestCase
{
        // Para realizar pruebas y verificar que funcione (o falle a propósito), separamos en variables privadas para tener mayor acceso a ellas
        // y poder modificarlas de forma más sencilla.

        // Haremos una prueba enviando 100000 a Brasil, deberían ser 665 reales
        private $valorIngresadoEnvías = '100000';
        private $valorEsperadoEnvías = '665';
        private $paisEnvías = 'Brasil';

        // Haremos la prueba que nos indica el desafío
        private $valorIngresadoRecibes = '4600';
        private $valorEsperadoRecibes = '1023408';
        private $paísRecibes = 'Perú';
        
        /**
         * @covers \testcotizador\Util::RealizarCotizacion
         * */ 
        public function testCotizadorRecibes(){
                $util = new Util;
                $this->assertEquals($this->valorEsperadoRecibes,$util->RealizarCotizacion($this->valorIngresadoRecibes,$this->paísRecibes,'recibes'));
        }
        /**
         * @covers \testcotizador\Util::RealizarCotizacion
         * */ 
        public function testCotizadorEnvias(){
                $util = new Util;
                $this->assertEquals($this->valorEsperadoEnvías,$util->RealizarCotizacion($this->valorIngresadoEnvías,$this->paisEnvías,'envías'));
        }
}