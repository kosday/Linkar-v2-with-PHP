# Install PHP Extension for Linux

Linkar extension uses the "libLinkarClientC.so" library.
You need to put "libLinkarClientC.so" in your library directory. Usually this directory is "/usr/lib".

Requirements:

- A *nix based system. LinkarClientPHP has been tested on Debian/Ubuntu and Red Hat

- PHP 7.x.

- GCC, autoconf,.. (your system must have the GCC development environment setup)

- openssl-devel libraries (for Red Hat distributions) or libssl-dev (for Debian and Ubuntu distributions)

- LinkarServer

- You must have root access (or sudo access).

Installation:

The "PHP_Linux" folder contains this files:

- config.m4

- LinkarClientPHP.h

- LinkarClientPHP.c

- LinkarClientC.h

- Readme.txt

You must compile the extension in your system.
First, you must use the "phpize" tool in order to generate compilation files.
After that you must execute: "./configure"
Now you are prepared to compile it using "make install"

You will have obtained a file called "LinkarClientPHP.so".
"install" option in the "make" command will copy this file into the php library folder.
(/usr/lib/php/20170718 in Debian/Ubuntu distributions or /usr/lib64/php/modules in Red Hat distributions)

You must add the PHP extension in the PHP configuration file, Do not forget to do it!
(In Debian/Ubuntu distributions, this file can be found at: /etc/php/7.2/apache2/php.ini and Red Hat distributions at: /etc/php.ini)
                               


With the PHP extension installed, you can test the Demo LinkarClib.php
