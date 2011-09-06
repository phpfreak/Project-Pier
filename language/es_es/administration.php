<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Probar configuración de correo',
    'administration tool desc test_mail_settings' => 'Utiliza esta herramienta simple para enviar correos de prueba y verificar que el sistema de correo de ProjectPier está configurado correctamente',
    'administration tool name mass_mailer' => 'Correo masico',
    'administration tool desc mass_mailer' => 'Herramienta simple que permite enviar mensajes de texto simple a cualquier grupo de usuarios registrados en el sistema',

    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Configuración',
    
    'mail transport mail()' => 'Configuración default de PHP',
    'mail transport smtp' => 'Servidor SMTP',
    
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
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Nombre del sitio',
    'config option desc site_name' => 'Este valor será mostrado como el nombre del sitio en la página de resúmen',
    'config option name file_storage_adapter' => 'Almacenamiento de archivos',
    'config option desc file_storage_adapter' => 'Selecciona donde quieres que se guarden los adjuntos, avatares, logos y cualquier otro documento. <strong>Se recomienda utilizar el almacenamiento de base de datos</strong>.',
    'config option name default_project_folders' => 'Directorios predeterminados',
    'config option desc default_project_folders' => 'Directorios que serán creados cuando un proyecto es creado. Cada nombre de folder debe estar en una linea nueva. Líneas duplicadas o vacías serán ignoradas',
    'config option name theme' => 'Plantilla',
    'config option desc theme' => 'Utilizando plantillas puedes cambiar el aspecto visual default de ProjectPier',
    'config option name calendar_first_day_of_week' => 'Primer día de la semana',
    'config option name check_email_unique' => 'La dirección de correo electrónico debe ser única',
    'config option name remember_login_lifetime' => 'Duración de sesión en segundos',
    'config option name installation_root' => 'La ruta a la instalación del sitio web',
    'config option name installation_welcome_logo' => 'Logo de página de inicio de sesión',
    'config option name installation_welcome_text' => 'Texto de página de inicio de sesión',
    'config option name installation_base_language' => 'Lenguaje principal (también para página de inicio de sesión)',

    // LDAP authentication support
    'config option name ldap_domain' => 'Dominio LDAP',
    'config option desc ldap_domain' => 'El dominio de "Active Directory"',
    'config option name ldap_host' => 'Servidor LDAP',
    'config option desc ldap_host' => 'El servidor/dirección IP de "Active Directory"',
    'secure ldap connection no' => 'No',
    'secure ldap connection tls' => 'Si, usar TLS',
    'config option name ldap_secure_connection' => 'Utilizar conexión LDAP segura',
    
    // ProjectPier
    'config option name upgrade_check_enabled' => 'Habilitar verificación de actualizaciones',
    'config option desc upgrade_check_enabled' => 'Si seleccionas \'Si\' el sistema verificará una vez al día si existen actualizaciones para descarga de ProjectPier',
    'config option name logout_redirect_page' => 'Página de redirección al cerrar sesión',
    'config option desc logout_redirect_page' => 'Establecer una página para redireccionar a los usuarios después de que han cerrado la sesión. Cambialo a default para utilizar la opción predeterminada',
    
    // Mailing
    'config option name exchange_compatible' => 'Modo de compatibilidad con Microsoft Exchange',
    'config option desc exchange_compatible' => 'Si estás utilizando Microsoft Exchange Server establece esta opción a si para evitar algunos problemas conocidos de correo.',
    'config option name mail_transport' => 'Sistema de correo',
    'config option desc mail_transport' => 'Puedes usar las opciones predeterminadas de PHP para enviar correos o especificar un servidor SMTP',
    'config option name mail_from' => 'Remitente: dirección',
    'config option name mail_use_reply_to' => 'Utilizar Reply-To: para Remitente',
    'config option name smtp_server' => 'Servidor SMTP',
    'config option name smtp_port' => 'Puerto SMTP',
    'config option name smtp_authenticate' => 'Utilizar autenticación SMTP',
    'config option name smtp_username' => 'Usuario SMTP',
    'config option name smtp_password' => 'Contraseña SMTP',
    'config option name smtp_secure_connection' => 'Utilizar conexión SMTP segura',

    'config option name per_project_activity_logs' => 'Bitácoras de actividad por proyecto',
    'config option name categories_per_page' => 'Número de categorías por página',

    'config option name character_set' => 'Set de caracteres a utilizar',
    'config option name collation' => 'Ordenamiento de caracteres',

    'config option name session_lifetime' => 'Duración de sesión',
    'config option name default_controller' => 'Página principal predeterminada',
    'config option name default_action' => 'Subpagina predeterminada',

    'config option name logs_show_icons' => 'Mostrar iconos en la bitácora de la aplicación',
    'config option name default_private' => 'Configuración predeterminada para opción privada',
  ); // array

?>
