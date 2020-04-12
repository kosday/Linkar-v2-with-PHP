# Instalar extensión PHP en Linux


La extensión que se instalará usa la biblioteca "libLinkarClientC.so".
Por lo tanto, debe colocar "libLinkarClientC.so" en su directorio de librerías. Por lo general, este directorio será "/usr/lib".

Requisitos:

- Un sistema *nix. Se ha comprobado el funcionamiento de LinkarClientPHP en Debian/Ubuntu y Red Hat

- PHP 7.x.

- GCC, autoconf, ... (su sistema debe tener instalado y configurado el entorno de desarrollo GCC)

- openssl-devel (para distribuciones Red Hat) o libssl-dev (para distribuciones Debian y Ubuntu)

- LinkarServer

- Debe tener acceso de root (o posibilidad de usar "sudo").

Instalación:

Dentro de la carpeta "PHP_Linux", encontrará los siguientes archivos:

- config.m4

- LinkarClientPHP.h

- LinkarClientPHP.c

- LinkarClientC.h

- Readme.txt

Se debe compilar la extensión en su sistema.
En primer lugar, se debe usar la herramienta "phpize" para generar los archivos de compilación.
A continuación ejecutar: "./configure"
Después de eso, ya se puede compilar usando "make install"

Ahora se obtendrá un archivo llamado "LinkarClientPHP.so"
La opción "install" del comando "make" copiará este archivo dentro de la carpeta de librerías de php.
 (/usr/lib/php/20170718 en distribuciones Debian/Ubuntu o /usr/lib64/php/modules en distribuciones Red Hat)) 

No hay que olvidar agregar la extensión PHP al archivo de configuración de PHP
(En distribuciones Debian/Ubuntu, se puede encontrar este archivo en: /etc/php/7.2/apache2/php.ini Y en las distribuciones Red Hat en: /etc/php.ini)

Una vez que se instala la extensión de PHP, puede probar la Demo LinkarClib.php
