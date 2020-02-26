# Linkar with PHP in Linux using libLinkarClientC.so Library

This demo shows how a persistent client works with a PHP document and send the resultant information in HTML.

This demo uses PHP extension for linux. You need  to install the PHP extension in your linux system.

You have to edit "LinkarClib.php" file and adjust the parameters in order to login to Linkar.

With the PHP extension installed, you must put the "LinkarClib.php" file in the public HTML folder of your web server.

You can see the result of "LinkarClib.php" using your web browser.

# Linkar with PHP in Windows using linkaclientCOM.dll Library

You must change login information that is inside the documents "com.php".

After this step several operation will be made and the results will be saved in HTML.

Enumerations:
Since we cannot make use of the PHP enumerators you will have to use the enumerator value instead. The values list of the enumerators is the following:

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


#How to Register COM Library:

To use this COM library it's necessary  to register it. You can do that using RegAsm.exe tool whose location depends on the machine 

where it will run from CMD. You must run CMD as Administrator to avoid mistakes in the register.

For instance:

32-bit OS:
C:\>C:\Windows\Microsoft.NET\Framework\v4.0.30319\regasm "C:\linkar\Clients\NET_Framework\x86\LinkarClientCOM.DLL" /codebase /tlb

64-bit OS:
C:\>C:\Windows\Microsoft.NET\Framework64\v4.0.30319\regasm "C:\linkar\Clients\NET_Framework\x64\LinkarClientCOM.DLL" /codebase /tlb

 NOTICE!
- You must run CMD as Administrator to avoid mistakes in the register
- You must have installed the 4.5 (v4.0.30319) Framework and use Regasm from that FrameWork
- There are two RegAsm versions, 32 and 64 bits (FrameWork or FrameWork64), you will have to use the same as the Linkar one you want to register, otherwise the command will return an error.

 
