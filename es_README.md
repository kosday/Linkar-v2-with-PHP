# Linkar con PHP en Linux usando la libreria libLinkarClientC.so

Esta demo muestra el funcionamiento de un cliente persistente trabajando con un documento PHP y mostrando la información resultante en HTML.

Esta demo usa extensiones PHP para linux. Es necesario instalar la extensión PHP en su sistema linux.

Tiene que editar el archivo "LinkarClib.php" para ajustar los parámetros de login a LinkarServer

Una vez que ya está instalada la extensión PHP, se debe poner el archivo "LinkarClib.php" en la carpeta publica HTML de su servidor web.

Ahora, usando un navegador web, puede ver los resultados de "LinkarClib.php".

# Linkar con PHP en Windows usando la librería COM linkaclientCOM.dll

Esta demo muestra el funcionamiento de un cliente persistente trabajando con un documento PHP y mostrando la información resultante en HTML.


Se usará la información del login que hay dentro del documento para loguear el LinkarClient. Tras este paso se realizarán en secuencia una batería de operaciones y se presentarán los resultados en código HTML.

Enumerados

Al no poder hacer uso de los enumerados en PHP deberá usarse el valor del enumerado en su lugar. La lista de los valores de los enumerados es la siguiente:

CONVERSION_TYPE
INPUT = 0
OUTPUT = 1

ENVELOPE_FORMAT
XML = 0
JSON = 1

TYPE
MV = 0x01
XML = 0x02
JSON = 0x03 

Registrar Libreria COM

Para usar la libreria COM es necesario que este registrada en el equipo que desea hacer uso de ella.

El registro de la librería se hace mediante la herramienta RegAsm.exe cuya ubicación dependerá de la máquina donde se vaya a ejecutar.

Un ejemplo de como registrar LinkarClientCOM de 32 bits desde la consola de comandos de Windows (cmd) es el siguiente:

C:\>C:\Windows\Microsoft.NET\Framework\v4.0.30319\regasm "C:\linkar\Clients\NET_Framework\x86\LinkarClientCOM.DLL" /codebase /tlb

Un ejemplo de como registrar LinkarClientCOM de 64 bits desde la consola de comandos de Windows (cmd) es el siguiente:

C:\>C:\Windows\Microsoft.NET\Framework64\v4.0.30319\regasm "C:\linkar\Clients\NET_Framework\x64\LinkarClientCOM.DLL" /codebase /tlb

¡¡Muy importante!!

- Es recomendable abrir la consola en modo administrador para evitar fallos en el registro.

- Debe tener instalada la Framework 4.5 (v4.0.30319) y usar el RegAsm de dicha Framework.

- Existen dos versiones de RegAsm, para 32 y 64 bits (Framework o Framework64), debe usar la misma que la de la librería a registrar o el comando devolverá un error.
