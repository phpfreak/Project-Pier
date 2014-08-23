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
    'invalid email address' => 'El formato de la dirección de correo no es válido',
    'id missing' => 'No se encuentra el valor de ID requerido',
   
    // Company validation errors
    'company name required' => 'El nombre de la compañía/organización es requerido',
    'company homepage invalid' => 'El valor de la página de inicio no es una URL válida (http://www.example.com)',

    // Contact validation errors
    'name value required' => 'Name is required',
    'existing contact required' => 'You need to select an existing contact',
    
    // Add user to contact form
    'contact already has user' => 'Este contacto ya tiene una cuenta de usuario adjunta.',    
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
    'invalid upload dimensions' => 'Dimensión de imágen no válida. La dimensión máxima permitida es de %sx%s píxeles',
    'invalid upload size' => 'Tamaño de archivo excedido. El tamaño máximo permitido es de %s',
    'invalid upload failed to move' => 'Ocurrió un fallo al mover el archivo subido',
    
    // Registration form
    'terms of services not accepted' => 'Para poder crear una cuenta debe leer y aceptar los términos y condiciones del servicio',
    
    // Init company website
    'failed to load company website' => 'Error al cargar el sitio web. No se encontró la empresa propietaria',
    'failed to load project' => 'Error al cargar el proyecto activo',
    
    // Login form
    'username value missing' => 'Introduzca su nombre de usuario',
    'password value missing' => 'Introduzca su contraseña',
    'invalid login data' => 'Error al iniciar sesión. Por favor, verifique los datos e inténtelo de nuevo',
    'invalid password' => 'Contraseña incorrecta. Por favor, verifique su clave e inténtelo de nuevo',
    
    // Add project form
    'project name required' => 'Se requiere un nombre para el proyecto',
    'project name unique' => 'El nombre del proyecto debe ser único',
    
    // Add message form
    'message title required' => 'Un título es requerido',
    'message title unique' => 'El título debe ser único para este proyecto',
    'message text required' => 'El valor de texto es requerido',
    
    // Add comment form
    'comment text required' => 'El texto del comentario es requerido',
    
    // Add milestone form
    'milestone name required' => 'Se requiere un nombre para el hito',
    'milestone due date required' => 'Se requiere una fecha de vencimiento del hito',

    // Add task list
    'task list name required' => 'Se requiere un nombre para la lista de tareas',
    'task list name unique' => 'El nombre de la lista de tareas debe ser único para este proyecto',
    
    // Add task
    'task text required' => 'El texto de la tarea es requerido',

    // Test mail settings
    'test mail recipient required' => 'Se requiere una dirección de destinatario',
    'test mail recipient invalid format' => 'El formato de dirección de destinatario no es válido',
    'test mail message required' => 'Se requiere un mensaje para el correo',
    
    // Mass mailer
    'massmailer subject required' => 'El asunto del mensaje es requerido',
    'massmailer message required' => 'El cuerpo del mensaje es requerido',
    'massmailer select recipients' => 'Por favor, selecciona los usuarios que recibirán este correo',
    
  ); // array

?>
