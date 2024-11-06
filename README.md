## Proyecto 4 en ralla - Jose Igual Avila

### Instrucciones monolog
- Si intentamos ejecutar el proyecto y nos dice que no encuentra monolog, verificamos primero si está en la carpeta vendor, psr también, si no están, borramos las carpetas y usamos el comando `composer install`.

- Hay que darle permisos a la carpeta de logs , en este caso ubicada en php/logs/, tendrémos que utilizar el siguiente comando en la raiz del proyecto `chmod -R 775 php/logs/` y `chown -R :www-data php/logs`.