<?php
require_once __DIR__
. '/../vendor/autoload.php';

// $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://". $_SERVER['HTTP_HOST'].(isset($_SERVER['SERVER_PORT'])? ':'.$_SERVER['SERVER_PORT'] : '').'/';
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://". $_SERVER['HTTP_HOST'].'/';

$Operaciones = array("envías","recibes");
$PaisesOperaciones = array(
        "Perú" => "PEN",
        "Colombia" => "COP",
        "Brasil" => "BRL"
);
$PaisOrigen = array(
        "Chile" => "CLP"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
                integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
                crossorigin="anonymous">
        <title>Test para CurrencyBird</title>
        <style>
        .text-input-value {
                max-width: 70px;
        }
        </style>
        <script type="text/javascript">
                var $ArrPaisesOperaciones = <?php echo json_encode($PaisesOperaciones); ?>;
                var $ArrPaisOrigen = <?php echo json_encode($PaisOrigen); ?>;
        </script>
</head>

<body>
        <div class="container">
                <div class="row">
                        <div class="col-xs-12 col-md-12">
                                <h1 class="text-center mt-2">Cotizador</h1>
                        </div>
                </div>
                <div class="row">
                        <div class="col-xs-12 col-md-12">
                                <div class="alert alert-danger" role="alert" id="campo-alerta" hidden></div>
                        </div>
                </div>
                <div class="row">
                        <div class="col-xs-12 col-md-12">
                        <?php
                        foreach ($Operaciones as $Operacion){
                                $html = '<div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text label text-input-value">'.ucfirst($Operacion).'</span>
                                                        <div class="input-group-text">
                                                                <input type="radio" name="radio-inputs" data-tipo="'.$Operacion.'">
                                                        </div>
                                                </div>
                                                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" disabled>
                                                <div class="input-group-append">
                                                        <span class="input-group-text codigo-moneda '.$Operacion.'"></span>
                                                </div>
                                        </div>';
                                echo $html;
                        }
                        ?>
                        </div>
                </div>
                <div class="row">
                        <div class="col-xs-12 col-md-4">
                        <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle btn-block mt-2" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Selecciona una moneda
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <?php
                                        foreach ($PaisesOperaciones as $PaisOperacion => $CodigoPais){
                                                $html = '<a class="dropdown-item" href="#">'.$PaisOperacion.'</a>';
                                                echo $html;
                                        }
                                        ?>
                                </div>
                                <input type="hidden" id="pais-seleccionado" value>
                        </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                        <button type="button" class="btn btn-info btn-block mt-2" id="boton-cotizar">Cotizar</button>
                        </div>
                </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
                integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
                crossorigin="anonymous"></script>
                <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
                integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
                crossorigin="anonymous"></script>
        <script type="text/javascript" src="<?php echo $base_url?>js/js_cotizador.js"></script>

</body>

</html>