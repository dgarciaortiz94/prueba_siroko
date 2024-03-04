
# PRUEBA TÉCNICA MO2O
  
#### Prueba técnica de aplicación en **PHP/Symfony** construida en **arquitectura de puertos y adaptadores y Domain Driven Design**.  


## Tecnologías y versiones utilizadas


* **PHP:** 8.3
* **Symfony:** 7.0
* **MySql:** 8.0
* **Redis:** 7.2
* **Composer:** 2.7

## Pasos necesarios

* [Instalar Docker](https://www.docker.com/get-started/)
* Clonar el repositorio: `git clone https://github.com/dgarciaortiz94/prueba_siroko.git`
* Posicionarte en el directorio prueba_siroko: `cd prueba_siroko`
* Ejecutar `make build` y esperar a que se levanten los contenedores
* Ejecutar `make install` y esperar a que se descarguen todas las dependencias
* Ejecutar `make generate-kwt-keypair` para generar las claves pública y privada de jwt
* Adicionalmente puedes ejecutar los test mediante `make test`

## Comandos de despliegue

El proyecto contiene un archivo Makfile que contiene los comandos con las instrucciones necesarias 
para levantar los contenedores e instalar las dependencias:

* **`make build`**  Descarga las imágenes de docker, levanta los contenedores e instala las dependencias con composer.
* **`make start`**  Levanta los contenedores si no están ya levantados
* **`make stop`**   Para y elimina los contenedores
* **`make ssh`**    Accede al contenedor de la API en modo interactivo
* **`make delete`** Fuerza a eliminar los contenedores
* **`make test`**   Ejecuta los tests con PHPUnit
* **`make help`**   Visualiza la toda la lista de comandos

## Características de la aplicación

Ésta aplicación ha sido construida en ***PHP 8/Symfony 7*** atendiendo a los requerimientos de la prueba técnica para backend developer de Techpump.

La aplicación está construida mediante arquitectura hexagonal (puertos y adaptadores) y Domain Driven Design, utilizando Vertical Slicing 
para la estructura de directorios.

Éste proyecto contiene las siguientes características y funcionalidades.

* Arquitectura Hexagonal y DDD
* Funcionalidad de carrito de E-Commerce en el que se pueden realizar las siguientes acciones:
    - Crear un carrito con un producto.
    - Añadir un producto al carro.
    - Eliminar un producto del carro.
    - Confirmar el pedido con los productos del carro.
* Los endpoints siguen el formato de API REST aceptando y devolviendo un json.
* Código formateado con los estándares de PSR-1 y PSR-2.
* La aplicación contiene una pila de test unitarios que testean la funcionalidad mencionada.
* Se ha utilizado Docker para el despliegue de la aplicación centralizando los comandos en un Makefile.

## Documentación

La aplicacíon implementa la funcionalidad de manejo de un carrito de E-Commerce. Está realizada en formato API-REST. Esté es el análisis de negocio de la funcionalidad:

    * El carrito es creado por un usuario que navega por la web cuando añade un producto sin tener un carrito en guardado sesión o una cookie.
    * El carrito puede vincularse a la cuenta de usuario del usuario si ha iniciado sesión, o no si está navegando como un usuario anónimo.
    * Los productos están divididos en models (W1 SKYWALK LF), productos (W1 SKYWALK LF / Talla M) e items (Todos los artículos físicos en stock de W1 SKYWALK LF / Talla M).
    * Los items pueden tener 3 estados:
        1 - Available / Disponible
        2 - Reserved / Reservado
        3 - Sold / Vendido
    * Cuando se añade un nuevo producto al carrito o cuando se crea un carrito con un producto se comprueba que haya stock de ese item con estado disponible y se selecciona el primer item de ese producto pasándolo a estado reservado en una operación atómica.
    * Al eliminar un item del carrito se comprueba que esté esté en él y se le cambia el estado de nuevo a disponible en una operación atómica.
    * Al confirmar el pedido ocurren las siguientes operaciones de manera atómica:
        - Se crea un pedido.
        - Se crea un snapshot de cada item del carrito para guardar el estado en el que estaba en el momento del pedido.
        - El pedido se asocia o no al usuario dependiendo de si está logueado o si navega en modo anónimo.
        - Se guarda la dirección de envío.
        - Se guardan los datos de pago.

Se detalla el flujo de peticiones a continuación:

1. Cómo primer paso el usuario creará un carrito que se asociará a su entidad de usuario si ha iniciado sesión, o no se asociará si está utilizando la aplicación cómo un usuario anónimo. El endpoint de creación del carrito es el siguiente:

    * `http://127.0.0.1/prueba_siroko/public/cart`

	    Cómo cuerpo de la petición aceptará los siguientes parámetros

	    * "productId": `id de la tabla product`.

    Ejemplo: 

    *  `http://127.0.0.1/prueba_siroko/public/cart`

		    {
		        "productId": `018df9df-8640-7dc1-bd2f-e7a56f0bb87e`
		    }

2. En segundo lugar se puede añadir un producto al carrito:

    * `http://127.0.0.1/prueba_siroko/public/cart/{id-del-carrito}/add-product`

	    Cómo cuerpo de la petición aceptará los siguientes parámetros

	    * "productId": `id de la tabla product`.

    Ejemplo: 

    *  `http://127.0.0.1/prueba_siroko/public/cart/733b6c66-f32a-41f7-99f1-00307ef0a586/add-product`

		    {
		        "productId": `018df9e1-99ee-73aa-b48c-ca2445d67d7a`
		    }

3. En segundo lugar se puede añadir un producto al carrito:

    * `http://127.0.0.1/prueba_siroko/public/cart/{id-del-carrito}/remove-product`

	    Cómo cuerpo de la petición aceptará los siguientes parámetros

	    * "itemId": `id de la tabla product`.

    Ejemplo: 

    *  `http://127.0.0.1/prueba_siroko/public/cart/733b6c66-f32a-41f7-99f1-00307ef0a586/remove-product`

		    {
		        "itemId": `018df9e3-4311-7540-9a2b-2ad88d39ad20`
		    }

4. En segundo lugar se puede añadir un producto al carrito:

	* `http://127.0.0.1/prueba_siroko/public/cart/{id-del-carrito}/confirm-order`

		Cómo cuerpo de la petición aceptará los siguientes parámetros

		* "paymentCard": "5787-5646-3423-7898",
		* "shipmentAddress": "Calle Falsa 123",
		* "shipmentLocation": "Alcorcón",
		* "shipmentComunity": "Madrid",
		* "shipmentZipCode": "28015".

		Ejemplo: 

		`http://localhost/prueba_siroko/public/cart/733b6c66-f32a-41f7-99f1-00307ef0a586/confirm-order`.

		    {
			        "paymentCard": "4970-1100-0000-0062",
			        "shipmentAddress": "Calle Falsa 123",
			        "shipmentLocation": "Alcorcón",
			        "shipmentComunity": "Madrid",
			        "shipmentZipCode": "28015"
		    }

La respuesta devulta por las peticiones de creación del carrito, añadir producto o eliminar producto será el carrito actualizado:

    {
        "cartId": "8952b589-6ef0-4fc9-87a6-7f246a73a2a8",
        "items": [
            {
            "id": "018df9e3-0313-709c-96da-26db8af79acf",
            "productTracingCode": "32001",
            "modelName": "W3 NEUQUÉN LF",
            "productVariant": "S",
            "modelDescription": "Chaqueta lifestyle para hombre",
            "productDescription": "Talla S",
            "itemTid": "GF54787FGD5487F4GFD54",
            "price": 79.99
            }
        ],
        "total": 79.99
    }

La respuesta devuelta por la petición de la confirmación del pedido será la siguiente:

    {
        "shipmentAddress": {
            "address": "Calle Falsa 123",
            "location": "Alcorcón",
            "comunity": "Madrid",
            "zipCode": "28015"
        },
        "items": [
            {
            "id": "de481c3e-95fc-4260-85a1-5edbc12b2f08",
            "itemId": "018df9e3-0313-709c-96da-26db8af79acf",
            "price": 79.99
            },
            {
            "id": "78be1054-3e76-4d78-8e82-89812b960053",
            "itemId": "018df9e3-4311-7540-9a2b-2ad88d39ad20",
            "price": 79.99
            }
        ]
    }