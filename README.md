# Test para CurrencyBird
#### Por Ricardo Riveros Rivera.

###### Este desafío fue realizado en PHP y Javascript, utilizando Composer como sistema para manejar dependencias, NGINX como servidor y PHPUnit para realizar test unitarios, dentro del repositorio git se puede observar:

```
1. conf/nginx 
    - site.conf
        -
- public
    - ajax
        - ajax_calcular_monto_cotizador.php
    - comun
        - Util.php
    - js
        - js_cotizador.js
    - index.php    
- test
    - UtilTest.php
- composer.json
- composer.lock
- docker-compose.yml
- phpunit.xml
```

#### Lógica de la aplicación

La aplicación desde el punto de vista del Usuario utiliza 3 archivos básicamente:
1. js_cotizador.js: Está encargado de entregar un formato dinámico a la aplicación y realizar las peticiones ajax para el cotizador.
2. ajax_calcular_monto_cotizador.php: Función que recibe la petición ajax desde el js_cotizador y llama a la función Util que contiene la lógica a utilizar
3. Util.php: Archivo que contiene la clase Util con los métodos necesarios para realizar la lógica solicitada en este desafío

Por otra parte, los archivos site.conf, composer.json, composer.lock, docker-compose.yml y phpunit.xml entregan las instrucciones a los contenedores para ejecutar la aplicación de la forma deseada.

Separada de esta forma, resulta más sencillo saber dónde modificar en caso de:
    - Manejar la lógica aritmética del cotizador (Util.php)
    - Manejar la petición realizada por el js y controlar los input y output de la función (ajax)
    - Manejar el comportamiento dinámico de la aplicación y cómo este interactua con las funciones (js_cotizador)
    - Realizar test unitarios de forma sencilla al estar separado toda la lógica aritmética del resto. (Util.php y UtilTest.php)

Para realizar el desarrollo y pruebas unitarias con PHPUnit de este desafío se utilizó los siguientes comandos de Docker:
```
1. docker-compose run composer require --dev phpunit/phpunit
2. docker-compose up -d
```

#### Muchas gracias por brindarme la oportunidad de rendir el test!
