<?php

  // Actions
  return array(
  
    // Registration
    'register' => 'Registrarse',
    'login' => 'Iniciar sesión',
    'logout' => 'Cerrar sesión',
    'hide welcome info' => 'Esconder esta información permanentemente',
    
    // Companies
    'add company' => 'Agregar empresa',
    'edit company' => 'Actualizar información de empresa',
    'delete company' => 'Eliminar empresa',
    'edit company logo' => 'Actualizar logo',
    'delete company logo' => 'Eliminar logo',
    'show map' => 'Mostrar mapa',
    
    // Clients
    'add client' => 'Agregar cliente',
    'edit client' => 'Editar cliente',
    'delete client' => 'Eliminar cliente',
    
    // Users
    'add user' => 'Agregar usuario',
    'edit user' => 'Editar usuario',
    'delete user' => 'Eliminar usuario',
    
    // Project
    'add project' => 'Agregar proyecto',
    'copy project' => 'Copiar proyecto',
    'edit project' => 'Editar detalles de proyecto',
    'delete project' => 'Eliminar proyecto',
    'mark project as finished' => 'Etiquetar proyecto como terminado',
    'mark project as active' => 'Etiquetar proyecto como activo',
    'projects logo edit' => 'Actualizar logo',
    'projects logo delete' => 'Eliminar logo',
    'update logo' => 'Actualizar logo',
    'upload logo' => 'Establecer logo',
    'can manage projects' => 'Puede manejar sus propios proyectos',
    'projects shift dates' => 'Shift dates',
    'projects shift dates desc' => 'Las fechas se vuelven "ahora" sumadas a la diferencia entre la fecha original y la fecha de creación del proyecto',
    'add days' => 'Días a agregar a todas las fechas en el proyecto',
    
    // Messages
    'add message' => 'Agregar mensaje',
    'edit message' => 'Editar mensaje',
    'delete message' => 'Eliminar mensaje',
    'view message' => 'Ver mensaje',
    'update message options' => 'Actualizar opciones',
    'subscribe to message' => 'Suscribirse',
    'unsubscribe from message' => 'Darse de bajas',
    'recover last input' => 'recuperar última entrada',
    
    // Comments
    'add comment' => 'Agregar comentario',
    'edit comment' => 'Editar comentario',
    
    // Task list
    'add task list' => 'Agregar lista de tareas',
    'edit task list' => 'Editar lista de tareas',
    'copy task list' => 'Copiar lista de tareas',
    'move task list' => 'Mover lista de tareas',
    'delete task list' => 'Eliminar lista de tareas',
    'download task list' => 'Descargar',
    'reorder tasks' => 'Reordenar tareas',
    'start date' => 'Fecha de inicio',
    
    // Task
    'add task' => 'Agregar tarea',
    'edit task' => 'Editar tarea',
    'delete task' => 'Eliminar tarea',
    'mark task as completed' => 'Etiquetar tarea como completada',
    'mark task as open' => 'Etiquetar tarea como abierta',
    'view task' => 'Ver tarea',
    
    // Milestone
    'add milestone' => 'Agregar milestone',
    'edit milestone' => 'Editar milestone',
    'delete milestone' => 'Eliminar milestone',
    'view calendar' => 'Ver calendario',
    'mark milestone as completed' => 'Etiquetar como completado',
    'mark milestone as open' => 'Reabrir',
    'milestones add days from now' => 'Días a partir de hoy para establecer la fecha de vencimento de los milestone copiados',

    // People
    'update people' => 'Actualizar',
    'remove user from project' => 'Eliminar del proyecto',
    'remove company from project' => 'Eliminar del proyecto',
    'edit user account' => 'Editar cuenta de usuario',
    'delete user account' => 'Eliminar cuenta de usuario',
    'users involved in project' => 'Usuarios involucrados',
    
    // Password
    'update profile' => 'Actualizar perfil',
    'change password' => 'Cambiar contraseña',
    'update avatar' => 'Actualizar avatar',
    'delete current avatar' => 'Eliminar avatar existente',

    // Permissions
    'update permissions' => 'Actualizar permisos',
    'edit permissions' => 'Editar permisos',

    // Notifications
    'send notification' => 'Enviar notificación',
    'attach files' => 'Adjuntar archivos',

    // Download
    'task download header' => "Proyecto\tLista de tareas\tEstado\tDescripción\tId\tEstado\tInfo\tAsignado a\tTarea\r\n",
    '%s items downloaded' => '%s elementos en descarga',
    'nothing to download' => "No hay información disponible en '%s' para descarga",
    'download task lists' => 'Eliminar todas las tareas',
    
    // Contacts
    'contacts' => 'Contactos',
    'add contact' => 'Agregar contacto',
    'edit contact' => 'Título de contacto',
    'show route' => 'Ver ruta',
    

    // Tickets
    'my tickets' => 'Mis tickets',
    'add ticket' => 'Agregar ticket',
    'no my tickets' => 'No existen tickets',
    'most recent' => 'Más recientes',
    'ticket categories' => 'Categoria de tickets',
    'add ticket category' => 'Agregar categoria',
    'add default  ticket categories' => 'Establecer por defecto',
    'filters' => 'Filtros',
    'category' => 'Categoria',
    'assigned to' => 'Asignado a',
    'reported by' => 'Reportado por',
    'opened' => 'Abierto',
    'confirmed' => 'Confirmado',
    'not reproducable' => 'No reproducible',
    'test and confirm' => 'Verificado y confirmado',
    'fixed' => 'Solucionado',
    'closed' => 'Cerrado',
    'critical' => 'Crítico',
    'major' => 'Mayor',
    'minor' => 'Menor',
    'trivial' => 'Trivial',
    'defect' => 'Defecto',
    'enhancement' => 'Mejora',
    'feature request' => 'Solicitud de mejora',
    'no tickets in project' => 'No existen tickets en el proyecto',
    'tickets' => 'Tickets',
    'ticket #' => 'Ticket #',
    'summary' => 'Resumen',
    'private ticket' => 'Ticket privado',
    'private ticket desc' => 'Los tickets privados son visibles sólo para miembros de la compañía. Los miembros de las empresas clientes no serán capaces de    verlos.',
    'email notification ticket desc' => 'Notificar a las personas seleccionadas acerca de este ticket por medio de correo',

    // Time

    'time' => 'Tiempo',
    'add time' => 'Agregar tiempo',
    'no time records in project' => 'No existen tiempos en el proyecto',
    'billable time' => 'Tiempo facturable',
    'report by task' => 'Reporte por tarea',
    'order by date' => 'Reporte por fecha',
    'pdf' => 'pdf',
    'private time desc' => 'Tiempos privados son visibles sólo para miembros de la compañía. Los miembros de las empresas clientes no serán capaces de verlos.',
    'time manager' => 'Administrador de tiempos',
    'unbilled time' => 'Tiempo sin facturar',
    'bill' => 'Facturado',
    'mark as' => 'marcar como',
    'billed' => 'facturado',
    'actions' => 'acciones',
    'view by user' => 'Ver por usuario',
    'view by project' => 'Ver por proyecto',
    'billed time' => 'Tiempo facturado',

    // Files
    'files' => 'Archivos',
    'file' => 'archivo',
    'upload files desc' => 'Seleccione el archivo a subir.',
    'no files on the page' => 'No existen archivos',
    'add file' => 'Agregar archivo',
    'folder' => 'Carpeta',
    'folders' => 'Carpetas',
    'add folder' => 'Agregar carpeta',
    'all files' => 'Todos los archivos',
    'private file' => 'Archivo privado',
    'private file desc' => 'Establecer el archivo como privado',
    'important file' => 'Archivo importante',
    'important files desc' => 'Establecer el archivo como importante',
    'upload file sec' => 'Seleccionar un archivo',
    'parent folder' => 'Carpeta padre',
    'file details' => 'Detalles',
    'success add file' => 'Archivo agregago correctamente',
    'file add description' => 'Descripción de archivo',
    'revisions' => 'Revisión',
    'file revision title long' => 'Revisión de archivo largo',
    'initial versions' => 'Versión inicial',
    'folders' => 'Carpetas',
    'important files' => 'Documentos importantes',
    'revision on file' => 'Revisión de archivo',
    'order by folder' => 'Ordenar por carpeta',
    'order by filename' => 'Ordenar por nombre de archivo',
    'order by posttime' => 'Ordenar por tiempo',


    // Application
    'application log events my projects' => 'Bitácora de eventos',
    'log add users' => 'Agregó usuario',
    'log add companies' => 'Agregó empresa',
    'log add contacts' => 'Agregó contacto',
    'log add projects' => 'Agregó projecto',

    'log edit users' => 'Editó usuario',
    'log edit companies' => 'Editó empresa',
    'lod edit contacts' => 'Editó contacto',
    'log edit projects' => 'Editó proyecto',

    'log delete users' => 'Eliminó usuario',
    'log delte companies' => 'Eliminó empresa',
    'lod delete contacts' => 'Eliminó contacto',
    'log delete projects' => 'Eliminó proyecto',


    // Menu
    'edit logo' => 'Editar logo',
    'memo' => 'Recordatorio',
    'radio' => 'Radio',
  ); // array

?>
