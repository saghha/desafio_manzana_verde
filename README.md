# Desafio Manzana Verde

Proyecto realizado para revolver desafío planteado por la empresa Manzana Verde

## Instalación

Clonar el repositorio que consta de 2 directorios. El directorio `Backend` contiene un servicio desarrollado en Laravel versión 7, mientras que el directorio `frontend` contiene el cliente web desarrollado en VueJs V2.

## Configuración Backend
Hay 2 formas de hacer correr el backend, las cuales son con una servicio LAMP/XAMP/WAMP dependiendo del sistema operativo que se utilice. Requiere tener instalado `PHP7` y `composer` como gestor de paquetes de PHP.

### Configuración Docker
Si se tiene docker instalado en el computador se debe verificar que los puertos de MySQL estén libres el cuales `PORT 3306`, lu
ego entrar a la carpeta raíz del proyecto donde se encuentra el archivo `docker-compose.yml`. Ya en esta carpeta se debe correr el siguiente comando

```bash
docker-compose build --no-cache
```
Luego que termine la instalación de los contenedores se debe ejecutar el comando
```bash
docker-compose exec app bash
```
con el que tendemos acceso al contenedor donde está el proyecto en Laravel. Primero se debe configurar el archivo `.env` que contiene las directivas para conexiones.
Se necesita configurar los siguientes campos: 
```
DB_CONNECTION=mysql
DB_HOST=dbmanzanav
DB_PORT=3306
DB_DATABASE=manzanav
DB_USERNAME=root
DB_PASSWORD=secret
``` 
Estos campos dan acceso a la base de datos que está corriendo en un contenedor de Docker, luego se debe instalar las dependencias y configuraciones del proyecto con los siguientes comandos
```bash
composer install
php artisan migrate
```
Con todo esto listo ya se podrá utilizar el servicio de backend.

### Configuración OnPremise
Se debe entrar a la carpeta `backend/` que se encuentra en el proyecto, configurar el archivo `.env` según las conexiones a base de datos que se maneje de forma local y luego correr los comandos 
```bash
composer install
php artisan migrate
```
Luego para tener acceso se debe configurar la ruta host para que apunte según la "url" que se designe a la carpeta `public/` del proyecto.

## Configuración Frontend
Requiere tener instalado NodeJs en el entorno donde se trabajará para acceder al gestor de paquetes `NPM`.

Se debe ingresar a la carpeta `frontend/` que se encuentra en la carpeta raíz del proyecto y correr el siguiente comando:
```bash
npm install
```

Con este comando se instalarán las dependencias del proyecto. Luego se debe configurar la URL que apunta hacia el servicio backend en el archivo `.env.local` y ya teniendo todas las configuraciones se usa el comando para levantar el servicio de l cliente frontend
```bash
npm run serve
```
Este comando utiliza el puerto 8080.

## License
[MIT](https://choosealicense.com/licenses/mit/)
