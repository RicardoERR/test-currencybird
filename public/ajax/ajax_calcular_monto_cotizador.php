<?php

namespace testcotizador;
require "../../vendor/autoload.php"; 

$monto = $_REQUEST['monto'];
$tipo = $_REQUEST['tipo'];
$pais = $_REQUEST['pais'];

// $montoEnDolar = Util::convertirUsd($monto,$pais);
// $spreadPorConversion = Util::calcularSpread($montoEnDolar,$pais);
// $montoSpread = $montoEnDolar + $spreadPorConversion;
// $montoEnClp = round($montoSpread * Util::$ValorDolar);
// $montoSpreadClp = round($montoEnClp * Util::$spreadDolarPeso);
// $montoEnClpConSpread = $montoEnClp + $montoSpreadClp;
// $montoMargen = round(Util::calcularMargen($montoEnClpConSpread,$pais));
// $montoFinal = $montoEnClpConSpread + $montoMargen;
$util = new Util;
$montoFinal = $util->RealizarCotizacion($monto,$pais,$tipo);

$data = array();
$data['valor_obtenido'] = $montoFinal;

$res['resultado'] = $data;
$res['msg'] = 'OK';

echo json_encode($res);

?>