<?php

  /**
  * Error messages
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */

  // Return langs
  return array(
  
    // General
    'invalid email address' => 'El formato de la dirección de correo es inválido',
    'id missing' => 'El valor de ID requerido no se encuentra',
   
    // Company validation errors
    'company name required' => 'El nombre de compañía / organización es requerido',
    'company homepage invalid' => 'El valor de Página de inicio no es un URL válido (http://www.example.com)',
    
    // User validation errors
    'username value required' => 'El usuario es requerido',
    'username must be unique' => 'Lo sentimos pero el nombre de usuario ingresado ya existe',
    'email value is required' => 'La dirección de correo es requerida',
    'email address must be unique' => 'Lo sentimos pero la dirección de correo ingresada ya existe',
    'company value required' => 'El usuario debe ser parte de una compañía / organización',
    'password value required' => 'La contraseña es requerida',
    'passwords dont match' => 'Las contraseñas no coinciden',
    'old password required' => 'La contraseña anterior es requerida',
    'invalid old password' => 'La contraseña anterior no es válida',
    'user homepage invalid' => 'El valor de Página de inicio no es un URL válido (http://www.example.com)',
    
    // Avatar
    'invalid upload type' => 'Tipo de archivo inválido. Solo se permiten archivos %s',
    'invalid upload dimensions' => 'Dimensión de imágen inválida. La dimensión máxima permitida es de %sx%s pixeles',
    'invalid upload size' => 'Tamaño de archivo excedido. El tamaño máximo permitido es de %s',
    'invalid upload failed to move' => 'Ocurrio un fallo al mover el archivo subido',
    
    // Registration form
    'terms of services not accepted' => 'Para poder crear una cuenta debes leer y aceptar los términos y condiciones de servicio',
    
    // Init company website
    'failed to load company website' => 'Error al cargar sitio web. No se encontró la compañía propietaria',
    'failed to load project' => 'Error al cargar proyecto acitovo',
    
    // Login form
    'username value missing' => 'Ingresa tu nombre de usuario',
    'password value missing' => 'Ingresa tu contraseña',
    'invalid login data' => 'Error al iniciar sesión. Por favor verifica los datos e intenta nuevamente',
    
    // Add project form
    'project name required' => 'El nombre del proecto es requerio',
    'project name unique' => 'El nombre del proyecto debe ser único',
    
    // Add message form
    'message title required' => 'El título es requerido',
    'message title unique' => 'El título debe ser único para este proyecto',
    'message text required' => 'El valor de texto es requerido',
    
    // Add comment form
    'comment text required' => 'El texto del comentario es requerido',
    
    // Add milestone form
    'milestone name required' => 'El nombre del milestone es requerido',
    'milestone due date required' => 'La fecha de vencimiento del milestone es requerida',

    // Add task list
    'task list name required' => 'El nombre de la lista de tareas es requerido',
    'task list name unique' => 'El nombre de la lista de tareas debe ser único para este proyecto',
    
    // Add task
    'task text required' => 'El texto de la tarea es requerido',

    // Test mail settings
    'test mail recipient required' => 'La dirección del destinatario es requerida',
    'test mail recipient invalid format' => 'El formato de dirección de destinatario es inválido',
    'test mail message required' => 'El mensaje del correo es requerido',
    
    // Mass mailer
    'massmailer subject required' => 'El asunto del mensaje es requerido',
    'massmailer message required' => 'El cuerpo del mensaje es requerido',
    'massmailer select recipients' => 'Por favor selecciona los usuarios que recibirán este correo',
    
  ); // array

?>
