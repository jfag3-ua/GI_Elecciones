<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Instrucciones proyecto Gestión de la Información

-	ACCESO MÁQUINA VIRTUAL
-	Nuestro proyecto/programa vamos a alojarlo en una máquina virtual. Esta máquina virtual la hemos creado en Azure. ¿Cómo trabajar con ella? 
o	Ejecutar el siguiente comando en la terminal:
	ssh taxfraud@20.56.154.249
	Contraseña: Contrasena1234

-	ACCESO BASE DE DATOS LOCAL
-	Nuestro proyecto trabajará con 2 bases de datos: una BD la crearemos dentro de la máquina virtual, a esa la llamaremos BD local (es local porque el programa, que está en la misma máquina virtual, accede a esa BD, que también está en la máquina virtual)
-	Para acceder a la BD local hay que ejecutar el siguiente comando en la terminal de la máquina virtual:
"mysql". Si no funciona, escribir:
	mysql –u Alberto –p
	Contraseña: Contrasena1234
	use elecciones;
-	También se puede acceder a la BD local que está en la máquina virtual mediante comando desde otro ordenador:
	mysql -u Alberto -h 20.56.154.249 -p

-	ACCESO BASE DE DATOS REMOTA
-	Para acceder a la BD remota hay que descargarse el programa Mysql Workbench y añadir una dirección, poniendo: 
	Connection: taxfraud.mysql.database.azure.com
	Hostname: taxfraud.mysql.database.azure.com
	Puerto: 3306
	Usuario: Alberto
	Contraseña: Contrasena1234

-	POBLAR TABLAS CON 1 MILLÓN Y 2 MILLONES DE DATOS FAKE
-	Para poblar las 2 tablas (direcciones y censo) de la base de datos remota con nuestros datos fake-generados, hemos utilizado los siguientes comandos:
o	mysql --host=taxfraud.mysql.database.azure.com --user=Alberto --password=Contrasena1234 --local-infile=1
o	use elecciones;
LOAD DATA LOCAL INFILE '/home/taxfraud/script/direcciones.csv'
INTO TABLE elecciones.direcciones
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
o	La ruta se puede modificar según dónde hayamos guardado el .csv
o	Es importante ignorar la primera línea de direcciones.csv dado que contiene un encabezado con los nombres de cada columna.

o	Para poblar censo de forma remota hemos usado:
o	php -d mysqli.allow_local_infile=1 /home/taxfraud/script/insertarDatosCensoRemoto.php

-	PARA TRABAJAR CON EL PROYECTO LARAVEL
-	Modificar el .env, que está como ignore:
o	DB_CONNECTION=mysql
o	DB_HOST=20.56.154.249
o	DB_PORT=3306
o	DB_DATABASE=elecciones
o	DB_USERNAME=Alberto
o	DB_PASSWORD=Contrasena1234

INSTALAR PHP:
sudo apt update
sudo apt install php8.3 php8.3-bcmath php8.3-mbstring \
php8.3-xml php8.3-mysql php8.3-curl

INSTALAR COMPOSER
sudo apt install curl
curl https://getcomposer.org/download/2.8.4/composer.phar \
--output composer
sudo mv composer /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

INSTALAR MYSQL
sudo apt install mysql-server

CLONAR REPOSITORIO
git clone https://github.com/jfag3-ua/GI_Elecciones.git
cd GI_Elecciones/elecciones

INSTALAR DEPENDENCIAS
composer install

CONFIGURAR .ENV
cp .env.example .env
nano .env
(de momento cambiáis la línea 30 SESSION_DRIVER=database a SESSION_DRIVER=file)

GENERAR LA CLAVE DE LA APLICACIÓN
php artisan key:generate
(si os da problemas de permisos lo hacéis con sudo)

ARRANCAR SERVIDOR
php artisan serve
(Laravel se ejecutará en el puerto 8000)

ABRIR NAVEGADOR Y PONER DIRECCIÓN
localhost:8000
