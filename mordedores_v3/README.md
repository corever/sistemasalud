# Animales Mordedores

1.- Requerimientos.
    PHP 5.4+
    Curl
	mb_string
	nuSOAP

2.- Instalación.

2.1.- Renombrar el archivo /sys/Config.php.example a /sys/Config.php

2.2.- Renombrar el archivo /webservice/db_config.php.example a /sys/db_config.php

2.3.- En Configurar ENVIROMENT y Base de Datos en archivo /sys/Config.php y /sys/db_config.php

2.4.- Crear directorios, dar permisos 775 y dueño el usuario apache:
	archivos/
	archivos/documentos
	app/views/templates_c/
	tmp/cache/
	tmp/logs 
	
3.- Base de Datos
3.1.- Instalar la Base de Datos, disponible en /0_Otros/2_Base_Datos/BD_FULL.sql 
3.2.- Ejecutar los Scrit de actualizacion, disponible en /0_Otros/2_Base_Datos/0_CambiosBD/ 
	OBSERVACION: Configurar php.ini
		- max_execution_time = 30000
		- max_input_time = 6000
		- max_input_vars = 1000000
		- memory_limit = 2G
		- post_max_size = 2G
		- upload_max_filesize = 2G
		- max_file_uploads = 200000