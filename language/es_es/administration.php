<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Probar configuración de correo',
    'administration tool desc test_mail_settings' => 'Utiliza esta sencilla herramienta para enviar correos de prueba y verificar que el sistema de correo de ProjectPier está configurado correctamente',
    'administration tool name mass_mailer' => 'Correo masivo',
    'administration tool desc mass_mailer' => 'Sencilla herramienta que permite enviar mensajes en texto plano a cualquier grupo de usuarios registrados en el sistema',
    'administration tool name system_info' => 'Información del sistema',
    'administration tool desc system_info' => 'Sencilla herramienta que muestra los detalles del sistema',
    'administration tool name browse_log' => 'Navegar por el registro del sistema',
    'administration tool desc browse_log' => 'Utilizar esta herramienta para navegar por el registro del sistema y detectar errores',

    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Configuración',
    
    'mail transport mail()' => 'Ajustes por defecto de PHP',
    'mail transport smtp' => 'Servidor MTP',
    
    'secure smtp connection no'  => 'No',
    'secure smtp connection ssl' => 'Si, usar SSL',
    'secure smtp connection tls' => 'Si, usar TLS',
    
    'file storage file system' => 'Sistema de archivos',
    'file storage mysql' => 'Base de datos (MySQL)',
    
    // Categories
    'config category name general' => 'General',
    'config category desc general' => 'Preferencias generales de ProjectPier',
    'config category name mailing' => 'Envío de correo',
    'config category desc mailing' => 'Utiliza estas preferencias para establecer como debería manejar el envío de correos ProjectPier. Puedes usar las opciones de configuración incluidas en tu archivo php.ini o establecer otro servidor SMTP si así lo deseas.',
    'config category name features' => 'Funciones',
    'config category desc features' => 'Utiliza estas preferencias para habilitar/deshabilitar diferentes funciones y escoger diferentes metodos de mostrar la información del proyecto',
    'config category name database' => 'Base de datos',
    'config category desc database' => 'Utiliza estas preferencias para establecer las opciones de base de datos',
    'config category name authentication' => 'Autentificación',
    'config category desc authentication' => 'Acceso a todos los ajustes de autentificación',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Nombre del sitio',
    'config option desc site_name' => 'Este valor será mostrado como el nombre del sitio en la página de resúmen',
    'config option name file_storage_adapter' => 'Almacenamiento de archivos',
    'config option desc file_storage_adapter' => 'Seleccione donde desea guardar los adjuntos, avatares, logotipos y cualquier otro documento. <strong>Se recomienda utilizar el almacenamiento de base de datos</strong>.',
    'config option name default_project_folders' => 'Directorios predeterminados',
    'config option desc default_project_folders' => 'Directorios que se generarán cuando un proyecto sea creado. Cada nombre de la carpeta debe estar en una línea nueva. Las líneas duplicadas o vacías se ignorarán',
    'config option name theme' => 'Plantilla',
    'config option desc theme' => 'Utilizando plantillas puedes cambiar el aspecto visual por defecto de ProjectPier',
    'config option name calendar_first_day_of_week' => 'Primer día de la semana',
    'config option name check_email_unique' => 'La dirección de correo electrónico debe ser única',
    'config option name remember_login_lifetime' => 'Duración de la sesión en segundos',
    'config option name installation_root' => 'La ruta a la instalación del sitio web',
    'config option name installation_welcome_logo' => 'Logotipo de la página de inicio de sesión',
    'config option name installation_welcome_text' => 'Texto de la página de inicio de sesión',
    'config option name installation_base_language' => 'Idioma principal (también para página de inicio de sesión)',
    'config option name dashboard action index' => 'Información general',
    'config option name dashboard action my_projects' => 'Mis proyectos',
    'config option name dashboard action my_tasks' => 'Mis tareas',
    'config option name dashboard action my_projects_by_name' => 'Mis proyectos - ordenar por nombre',
    'config option name dashboard action my_projects_by_priority' => 'Mis proyectos - ordenar por prioridad',
    'config option name dashboard action my_projects_by_milestone' => 'Mis proyectos - ordenar por hitos',
    'config option name dashboard action my_tasks_by_name' => 'Mis tareas - ordenar por nombre',
    'config option name dashboard action my_tasks_by_priority' => 'Mis tareas - ordenar por prioridad',
    'config option name dashboard action my_tasks_by_milestone' => 'Mis tareas - ordenar por hitos',
    'config option name dashboard action contacts' => 'Contactos',
    'config option name dashboard action search_contacts' => 'Buscar contactos',

    // LDAP authentication support
    'config option name ldap_domain' => 'Dominio LDAP',
    'config option desc ldap_domain' => 'El dominio de directorio activo',
    'config option name ldap_host' => 'Servidor LDAP',
    'config option desc ldap_host' => 'El nombre/IP del servidor de directorio activo',
    'secure ldap connection no' => 'No',
    'secure ldap connection tls' => 'Si, usar TLS',
    'config option name ldap_secure_connection' => 'Utilizar conexión LDAP segura',
    
    // ProjectPier
    'config option name upgrade_check_enabled' => 'Habilitar verificación de actualizaciones',
    'config option desc upgrade_check_enabled' => 'Si seleccionas \'Si\' el sistema verificará una vez al día si existen actualizaciones para descarga de ProjectPier',
    'config option name logout_redirect_page' => 'Página de redirección al cerrar sesión',
    'config option desc logout_redirect_page' => 'Establecer una página para redireccionar a los usuarios después de que han cerrado la sesión. Cambiarlo a por defecto para utilizar la opción predeterminada',
    
    // Mailing
    'config option name exchange_compatible' => 'Modo de compatibilidad con Microsoft Exchange',
    'config option desc exchange_compatible' => 'Si estás utilizando Microsoft Exchange Server establece esta opción a si para evitar algunos problemas conocidos de correo.',
    'config option name mail_transport' => 'Sistema de correo',
    'config option desc mail_transport' => 'Puedes usar las opciones predeterminadas de PHP para enviar correos o especificar un servidor SMTP',
    'config option name mail_from' => 'Remitente: dirección',
    'config option name mail_use_reply_to' => 'Utilizar el campo "Responder a" para Remitente',
    'config option name mail_expose_user_emails' => 'Exponer los correos electrónicos de los usuarios',
    'config option desc mail_expose_user_emails' => 'Activa la exposición a la vista de las direcciones de correo electrónico en los campos "Desde" y "Responder a" o desactiva para siempre el uso de la dirección de correo.',
    'config option name smtp_server' => 'Servidor SMTP',
    'config option name smtp_port' => 'Puerto SMTP',
    'config option name smtp_authenticate' => 'Utilizar autenticación SMTP',
    'config option name smtp_username' => 'Usuario SMTP',
    'config option name smtp_password' => 'Contraseña SMTP',
    'config option name smtp_secure_connection' => 'Utilizar conexión SMTP segura',

    'config option name per_project_activity_logs' => 'Registro de actividad por proyecto',
    'config option name categories_per_page' => 'Número de categorías por página',

    'config option name character_set' => 'Fijar la codificación de caracteres a utilizar',
    'config option name collation' => 'Ordenamiento de caracteres',

    'config option name session_lifetime' => 'Duración de la sesión',
    'config option name default_controller' => 'Página principal predeterminada',
    'config option name default_action' => 'Página a mostrar tras el inicio de sesión del usuario',

    'config option name logs_show_icons' => 'Mostrar iconos en la aplicación de registro de actividad',
    'config option name default_private' => 'Configuración predeterminada para opción de privacidad',
    'config option name send_notification_default' => 'Ajuste predeterminado para "Enviar notificación"',
    'config option name enable_efqm' => 'Activar opciones EFQM',
    'config option name login_show_options' => 'Mostrar opciones en la página de inicio de sesión',
    'config option desc login_show_options' => 'En caso afirmativo se muestran opciones para "Ajustes de idioma y tema".',
    'config option name display_application_logs' => 'Mostrar aplicación de registro de actividad',
    'config option desc display_application_logs' => 'En caso negativo el registro de actividad se sigue produciendo, pero no se muestra más.".',
    'config option name dashboard_logs_count' => 'Máximo número de líneas de la aplicación del registro de actividad a mostrar',
    'config option desc dashboard_logs_count' => 'Limita el número de líneas del registro de actividad a mostrar en el tablero',

    // Authentication
    'config option name authdb server' => 'Servidor de la base de datos',
    'config option desc authdb server' => 'La dirección IP o el nombre DNS del servidor de base de datos para la autenticación. Se debe incluir el número de puerto.',
    'config option name authdb username' => 'Nombre de usuario de la base de datos',
    'config option desc authdb username' => 'La contraseña para acceder a la base de datos',
    'config option name authdb password' => 'Nombre de usuario de la base de datos',
    'config option desc authdb password' => 'La contraseña correspondiente al usuario',
    'config option name authdb database' => 'Nombre de la base de datos',
    'config option desc authdb database' => 'Nombre de la base de datos en el servidor ',
    'config option name authdb sql' => 'Seleccionar SQL',
    'config option desc authdb sql' => 'La SQL para recuperar una única fila de la tabla que contiene los datos del usuario. Al menos un campo deberá ser devuelto con la dirección de correo electrónico. $username/$password es el marcador de posición para el nombre de usuario/contraseña al inicio de sesión.',

    'config option name parking space reservation url' => 'URL de la plaza de aparcamiento',
    'config option desc parking space reservation url' => 'Introduzca la url completa para iniciar la aplicación web de reservas de plaza de aparcamiento',

    'config option name map url' => 'URL de la plaza de aparcamiento',
    'config option desc map url' => 'La URL para visualizar un mapa que muestra la ubicación de un contacto o empresa. $location es el marcador de posición para los detalles de la ubicación.',
    'config option name route url' => 'URL de la ruta a mostrar',
    'config option desc route url' => 'La URL para visualizar una ruta que muestra una dirección desde el usuario actual (de contacto) para la localización de un contacto o empresa. $from/$to es el marcador de posición para la dirección de/desde.',

  ); // array

?>
