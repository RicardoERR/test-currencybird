<?php
/**
 * Clase Util para Cotizador, en ella se declararán todas las funciones relacionadas con la lógica del cotizador,
 * es utilizada para calcular el spread, margen y costo del cotizador.
 * @author Ricardo Riveros Rivera
 * @date 03/12/2020
 */

namespace testcotizador;

Class Util {

        //Creamos un arreglo de dos dimensiones para representar la tabla de valores de conversión
        //Estructura del arreglo: [País,Valor USD, Spread, Margen]
        //Todos los porcentajes serán expresados de esa forma y en las operaciones matemáticas se representarán como porcentaje/100
        private static $ValoresMoneda = array(
                "Perú" => array(0.28,1.5,3),
                "Colombia" => array(0.00027,1.8,3.5),
                "Brasil" => array(0.19,1.2,2.9)
        );
        private static $diccionarioArr = array(
                0 => "USD",
                1 => "Spread",
                2 => "Margen"
        );

        public static $ValorDolar = 757;
        public static $spreadDolarPeso = 0.4;

        // Función que nos permite obtener los valores según el país de moneda de cambio seleccionado
        // Genera un nuevo arreglo con las llaves modificadas según el arreglo $diccionarioArr para luego manejarlos de forma más sencilla
        private static function getValueFromValoresMoneda($pais){
                try{
                        $lists = self::$ValoresMoneda[$pais];
                        $arr = array();
                        foreach ($lists as $key => $val){
                            $arr[self::$diccionarioArr[$key]] = $val;
                        }
                        return $arr;
                    }catch (Exception $e) {
                            return false;
                    }
        }
        // Función que calcula las operaciones con los porcentajes, verifica si la operación es envías o recibe
        // y realiza las operaciones correspondientes, las operaciones son inversas entre sí.
        private static function calculaOperacionPorcentaje($monto,$divisa,$indice,$tipo){
                $arr =  self::getValueFromValoresMoneda($divisa);
                $porcentajeOperacion = $arr[$indice];
                $valorRetornado = ($tipo === 'envías')? $monto/(1+($porcentajeOperacion/100)): $monto * (1+($porcentajeOperacion/100));
                return round($valorRetornado,2);
        }
        // Función similar a la de calculaOperacionPorcentaje, al no trabajarse con porcentajes sino con montos decimales
        // Debe tratarse de forma distinta las operaciones a la función calculaOperacionPorcentaje
        private static function convertirUsd($monto,$divisa,$tipo){
                $arr =  self::getValueFromValoresMoneda($divisa);
                $razonDolar = $arr["USD"];
                $valorRetornado = ($tipo === 'envías')? $monto/$razonDolar: $monto * $razonDolar;
                return round($valorRetornado,2);
        }
        // Funciones que llaman a calculaOperación según la operación, divisa y tipo
        private static function calcularSpread($monto, $divisa,$tipo){
                return self::calculaOperacionPorcentaje($monto, $divisa, "Spread",$tipo);
        }
        private static function calcularMargen($monto, $divisa,$tipo){
                return self::calculaOperacionPorcentaje($monto, $divisa, "Margen",$tipo);
        }
        // Función que realiza la cotización y es llamada desde el ajax, sólo esta función será pública
        public static function RealizarCotizacion($monto,$pais,$tipo){
                // La lógica es la misma pero realizada de forma inversa para las dos operaciones "envías" y "recibes".
                if ($tipo === 'recibes'){
                        $montoEnDolar = self::convertirUsd($monto,$pais,$tipo);
                        $montoSpread = self::calcularSpread($montoEnDolar,$pais,$tipo);
                        $montoEnClp = round($montoSpread * self::$ValorDolar);
                        $montoSpreadClp = round($montoEnClp * (self::$spreadDolarPeso/100));
                        $montoEnClpConSpread = $montoEnClp + $montoSpreadClp;
                        $montoFinal = round(self::calcularMargen($montoEnClpConSpread,$pais,$tipo));
                        return $montoFinal;
                } elseif ($tipo === 'envías'){
                        $margenMonto = round(self::calcularMargen($monto,$pais,$tipo));
                        $montoSpread = round($margenMonto /(1+(self::$spreadDolarPeso/100)));
                        $montoEnDolar = round($montoSpread / self::$ValorDolar,2);
                        $montoSinSpread = self::calcularSpread($montoEnDolar,$pais,$tipo);
                        $montoEnDivisa = self::convertirUsd($montoSinSpread,$pais,$tipo);
                        return $montoEnDivisa;
                }
                return false;
        }

}

?>