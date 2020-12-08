(function($) {

    //$ArrPaisesOperaciones y $ArrPaisOrigen llegan desde el PHP
    var $paisOrigen = "Chile"; //Ponemos el país de origen en duro, de ser dinámico debe considerarse también en el arreglo $ArrPaisOrigen
    $(document).ready(function() {

        function ActualizaSpansMoneda() {
            //Función que cambia el texto del span con el tipo de moneda en la pantalla, según el país de origen y el país seleccionado para la moneda de cambio
            $('span.codigo-moneda').each(function() {
                if ($(this).hasClass('envías')) {
                    $(this).html($ArrPaisOrigen[$paisOrigen]);
                } else if ($(this).hasClass('recibes')) {
                    selText = $('#pais-seleccionado').val();
                    if (selText != undefined && selText != '') {
                        $(this).html($ArrPaisesOperaciones[selText]);
                    } else {
                        $(this).html($ArrPaisOrigen[$paisOrigen]);
                    }
                }
            });
        }

        function mostrarAlerta(msg) {
            $('#campo-alerta').html(msg);
            $('#campo-alerta').attr('hidden', false);
            setTimeout(function() {
                $('#campo-alerta').attr('hidden', true);
                $('#campo-alerta').html('');
            }, 4000);
        }

        function sendFormAjax() {

            var inputMontoIngresado = $('input[type=radio]:checked').closest('.input-group').find('.form-control');
            var MontoIngresado = inputMontoIngresado.val();
            var tipoMontoIngresado = $('input[type=radio]:checked').data('tipo');
            var PaisOperacion = $('#pais-seleccionado').val();
            if (PaisOperacion == undefined || PaisOperacion == '') {
                mostrarAlerta('Debe seleccionar una moneda de cambio');
            }

            console.log('Monto ingresado: ', MontoIngresado);

            var MontoParseado = parseFloat(MontoIngresado);
            if (!$.isNumeric(MontoIngresado) || isNaN(MontoParseado) || MontoParseado <= 0) {
                inputMontoIngresado.val('');
                mostrarAlerta('Monto ingresado inválido')
                return;
            }

            var url = '/ajax/ajax_calcular_monto_cotizador.php';

            var data = {
                monto: MontoParseado,
                tipo: tipoMontoIngresado,
                pais: PaisOperacion
            };

            var $inputModificar = $('input[type=radio]:not(:checked)').closest('.input-group').find('.form-control');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url, //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                    console.log(data);
                    console.log('valor obtenido: ', data.resultado.valor_obtenido);
                    $inputModificar.val(data.resultado.valor_obtenido);
                },
                error: function(err) {
                    console.log(err);
                },
                complete: function() {
                    // Hide loading overlay
                }
            });
        }

        $('#boton-cotizar').on('click', sendFormAjax);

        $('.dropdown-item').on('click', function() {
            var selText = $(this).text();
            $('#pais-seleccionado').val(selText);
            $(this).parents('.dropdown').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
            ActualizaSpansMoneda();
        });


        $('input[type=radio]').on('change', function() {
            ActualizaSpansMoneda();
            var $this, $thisDiv, $othersDiv, $thisDivsText, $OthersDivsText;

            $this = $(this);
            $thisDiv = $this.closest('.input-group'); //Vemos cual es el div más "padre" más cercano al radio seleccionado
            $othersDiv = $thisDiv.siblings('.input-group'); //Vemos cuales son los otros divs "padre".

            //deshabilitamos los otros campos de texto distintos al seleccionado en el radio
            $OthersDivsText = $othersDiv.find('input[type=text]');
            $OthersDivsText.prop('disabled', true);
            $OthersDivsText.val(""); //Limpiamos el o los campo deshabilitado ya que el ajax se encarga de llenar el valor

            //habilitamos el campo de texto seleccionado en el radio //Limpiamos el campo deshabilitado ya que el ajax se encarga de llenar el valor
            $thisDivsText = $thisDiv.find('input[type=text]');
            $thisDivsText.prop('disabled', false);
            $thisDivsText.focus(); //Hacemos un focus para que el usuario ingrese el monto indicado
        });

        ActualizaSpansMoneda();
    });
})(jQuery);