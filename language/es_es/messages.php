<?php

  /**
  * Array of messages file (error, success message, status...)
  *
  * @http://www.projectpier.org/
  */

  return array(
  
    // Empty, dnx etc
    'project dnx' => 'El proyecto solicitado no existe en la base de datos',
    'message dnx' => 'El mensaje solicitado no existe',
    'no comments in message' => 'No hay comentarios en este mensaje',
    'no comments associated with object' => 'No existen comentarios enviados para este objeto',
    'no status updates associated with object' => 'No existe estado de actualizaciones publicado para este objeto',
    'no messages in project' => 'No existen mensajes para este proyecto',
    'no subscribers' => 'No existen usuarios suscritos a este mensaje',
    'no contacts in company' => 'No existen contactos en esta empresa',

    'no activities in project' => 'No hay actividades registradas para este proyecto',
    'comment dnx' => 'El comentario solicitado no existe',
    'milestone dnx' => 'El hito solicitado no existe',
    'time dnx' => 'El registro de tiempo solicitado no existe',
    'task list dnx' => 'La lista de tareas solicitada no existe',
    'task dnx' => 'La tarea solicitada no existe',
    'no milestones in project' => 'No existen hitos en este proyecto',
    'no active milestones in project' => 'No existen hitos activos en este proyecto',
    'empty milestone' => 'El hito está vacío. Puede agregar un <a href="%s">mensaje</a> o una <a href="%s">lista de tareas</a> cuando desee',
    'no logs for project' => 'No hay entradas de registro relacionadas a este proyecto',
    'no recent activities' => 'No hay registros de actividad reciente en la base de datos',
    'no open task lists in project' => 'No hay listas de tareas abiertas en este proyecto',
    'no completed task lists in project' => 'No hay listas de tareas terminadas en este proyecto',
    'no open task in task list' => 'No hay tareas en esta lista',
    'no projects in db' => 'No hay proyectos definidos',
    'no projects owned by company' => 'No hay proyectos para esta empresa',
    'no projects started' => 'No hay proyectos iniciados',
    'no active projects in db' => 'No hay proyectos activos',
    'no new objects in project since last visit' => 'No existen objetos nuevos en este proyecto desde su última visita',
    'no clients in company' => 'Su empresa no tiene ningún cliente registrado',
    'no contacts in company' => 'No existen contactos en esta empresa',
    'no users in company' => 'No existen usuarios en esta empresa',
    'client dnx' => 'La empresa del cliente seleccionado no existe',
    'company dnx' => 'La empresa seleccionada no existe',
    'contact dnx' => 'El contacto seleccionado no existe',
    'user dnx' => 'El usuario solicitado no existe en la base de datos',
    'avatar dnx' => 'El avatar no existe',
    'no current avatar' => 'No se ha subido ningún avatar',
    'no current logo' => 'No se ha subido ningún logotipo',
    'user not on project' => 'El usuario seleccionado no está involucrado en el proyecto seleccionado',
    'company not on project' => 'La empresa seleccionada no está involucrada en el proyecto seleccionado',
    'user cant be removed from project' => 'El usuario seleccionado no puede ser eliminado del proyecto',
    'tag dnx' => 'La etiqueta solicitada no existe',
    'no tags used on projects' => 'No hay etiquetas utilizadas en este proyecto',
    'no forms in project' => 'No hay formas en este proyecto',
    'project form dnx' => 'La forma del proyecto solicitada no existe en la base de datos',
    'related project form object dnx' => 'El objeto de forma relacionado no existe en la base de datos',
    'no my tasks' => 'No tiene tareas asignadas',
    'no search result for' => 'No existen objetos que concuerden  "<strong>%s</strong>"',
    'config category dnx' => 'La categoría de configuración solicitada no existe',
    'config category is empty' => 'La categoría de configuración seleccionada está vacía',
    'email address not in use' => '%s no esta en uso',
    'no administration tools' => 'No hay herramientas de administración registradas en la base de datos',
    'administration tool dnx' => 'La herramienta de administración "%s" no existe',
    'about to delete' => 'Está a punto de eliminar',
    'about to move' => 'Está a punto de mover',
    'no image functions' => 'No hay funciones de imagen (instalar la biblioteca GD)',
    'no ldap functions' => 'No hay funciones LDAP (instalar la extensión LDAP)',
    
    // Success
    'success add project' => 'El proyecto %s ha sido agregado satisfactoriamente',
    'success copy project' => 'El proyecto %s ha sido copiado a %s',
    'success edit project' => 'El proyecto %s ha sido actualizado',
    'success delete project' => 'El proyecto %s ha sido eliminado',
    'success complete project' => 'El proyecto %s ha sido completado',
    'success open project' => 'El proyecto %s ha sido reabierto',
    'success edit project logo' => 'El logotipo del proyecto ha sido actualizado',
    'success delete project logo' => 'El logotipo del proyecto ha sido eliminado',
    'success edit logo' => 'El logotipo ha sido actualizado',
    'success delete logo' => 'El logotipo ha sido eliminado',
    
    'success add milestone' => 'El milestone \'%s\' ha sido creado satisfactoriamente',
    'success edit milestone' => 'El milestone \'%s\' ha sido actualizado satisfactoriamente',
    'success deleted milestone' => 'El milestone \'%s\' ha sido eliminado satisfactoriamente',

    'success add time' => 'Tiempo \'%s\' ha sido creado satisfactoriamente',
    'success edit time' => 'Tiempo \'%s\' ha sido actualizado satisfactoriamente',
    'success deleted time' => 'Tiempo \'%s\' ha sido eliminado satisfactoriamente',
    
    'success add message' => 'El mensaje %s ha sido agregado satisfactoriamente',
    'success edit message' => 'El mensaje %s ha sido actualizado satisfactoriamente',
    'success move message' => 'El mensaje \'%s\' ha sido movido del proyecto \'%s\' al proyecto \'%s\'',
    'success deleted message' => 'El mensaje \'%s\' y todos sus comentarios han sido eliminados satisfactoriamente',
    
    'success add comment' => 'El comentario ha sido publicado satisfactoriamente',
    'success edit comment' => 'El comentario ha sido actualizado satisfactoriamente',
    'success delete comment' => 'El comentario ha sido eliminado satisfactoriamente',
    
    'success add task list' => 'La lista de tareas \'%s\' se ha agregado',
    'success edit task list' => 'La lista de tareas \'%s\' se ha actualizado',
    'success copy task list' => 'La lista de tareas \'%s\' se ha copiado a \'%s\' con %s tareas',
    'success move task list' => 'La lista de tareas \'%s\' se ha movido del proyecto \'%s\' al proyecto \'%s\'',
    'success delete task list' => 'La lista de tareas \'%s\' ha sido eliminada',
    
    'success add task' => 'La tarea seleccionada ha sido agregada',
    'success edit task' => 'La tarea seleccionada ha sido actualizada',
    'success delete task' => 'La tarea seleccionada ha sido eliminada',
    'success complete task' => 'La tarea seleccionada ha sido completada',
    'success open task' => 'La tarea seleccionada ha sido reabierta',
    'success n tasks updated' => '%s tareas actualizadas',
     
    'success add client' => 'La Empresa cliente %s ha sido agregada',
    'success edit client' => 'La empresa cliente %s ha sido actualizada',
    'success delete client' => 'La empresa cliente %s ha sido eliminada',
    
    'success edit company' => 'Los datos de empresa han sido actualizados',
    'success edit company logo' => 'El logotipo de empresa ha sido actualizado',
    'success delete company logo' => 'El logotipo de empresa ha sido eliminado',
    
    'success add user' => 'El usuario %s ha sido añadido satisfactoriamente',
    'success edit user' => 'El usuario %s ha sido actualizado satisfactoriamente',
    'success delete user' => 'El usuario %s ha sido eliminado satisfactoriamente',
    
    'success add contact' => 'El contacto %s ha sido añadido satisfactoriamente',
    'success edit contact' => 'El contacto %s ha sido actualizado satisfactoriamente',
    'success delete contact' => 'El contacto %s ha sido eliminado satisfactoriamente',
    
    'success update project permissions' => 'Los permisos del proyecto han sido actualizados satisfactoriamente',
    'success remove user from project' => 'El usuario ha sido eliminado del proyecto satisfactoriamente',
    'success remove company from project' => 'La compañía ha sido eliminada del proyecto satisfactoriamente',
    
    'success update profile' => 'El perfil ha sido actualizado',
    'success edit avatar' => 'El avatar ha sido actualizado satisfactoriamente',
    'success delete avatar' => 'El avatar ha sido eliminado satisfactoriamente',
    
    'success hide welcome info' => 'El marco de información de bienvenida se escondió satisfactoriamente',
    
    'success complete milestone' => 'El milestone \'%s\' ha sido completado',
    'success open milestone' => 'El milestone \'%s\' ha sido reabierto',
    
    'success subscribe to message' => 'Has sido suscrito a este mensaje satisfactoriamente',
    'success unsubscribe to message' => 'Has sido dado de baja de este mensaje satisfactoriamente',
   
    'success add project form' => 'Forma \'%s\' ha sido agregada satisfactoriamente',
    'success edit project form' => 'Forma \'%s\' actualizada',
    'success delete project form' => 'Forma \'%s\' eliminada',
    
    'success update config category' => 'Los valores de configuración %s han sido actualizados',
    'success forgot password' => 'Se ha enviado la contraseña a tu correo',
    
    'success test mail settings' => 'Correo de prueba enviado satisfactoriamente',
    'success massmail' => 'El correo ha sido enviado',
    
    'success update company permissions' => 'Los permisos de la compañía han sido actualizados satisfactoriamente. %s Registros actualizados',
    'success user permissions updated' => 'Los permisos de usuario han sido actualizados',
    
    // Failures
    'error form validation' => 'Error al guardar objeto debido a que algunas de sus propiedades son inválidas',
    'error delete owner company' => 'La compañía propietaria no puede ser eliminada',
    'error delete message' => 'Error al eliminar los mensajes seleccionados',
    'error update message options' => 'Error al actualizar opciones de mensaje',
    'error delete comment' => 'Error al eliminar comentarios seleccionados',
    'error delete milestone' => 'Error al eliminar el milestone seleccionado',
    'error delete time' => 'Error al eliminar el tiempo seleccionado',
    'error complete task' => 'Error al completar la tarea seleccionada',
    'error open task' => 'Error al reabrir la tarea seleccionada',
    'error delete project' => 'Error al eliminar el proyecto seleccionado',
    'error complete project' => 'Error al completar el proyecto seleccionado',
    'error open project' => 'Error al reabrir el proyecto seleccionado',
    'error edit project logo' => 'Error el actualizar logotipo de proyecto',
    'error delete project logo' => 'Error al eliminar logotipo de proyecto',
    'error edit logo' => 'Error al actualizar el logotipo %s',
    'error delete logo' => 'Error al eliminar el logotipo %s',
    'error delete client' => 'Error al eliminar la compañía del cliente seleccionado',
    'error delete user' => 'Error al eliminar el usuario seleccionado',
    'error delete contact' => 'Error al eliminar el contacto seleccionado',
    'error update project permissions' => 'Error al actualizar permisos de proyecto',
    'error remove user from project' => 'Error al eliminar al usuario del proyecto',
    'error remove company from project' => 'Error al eliminar la compañía del proyecto',
    'error edit avatar' => 'Error al editar avatar',
    'error delete avatar' => 'Error al eliminar avatar',
    'error hide welcome info' => 'Error al esconder información de bienvenida',
    'error complete milestone' => 'Error al completar el milestone seleccionado',
    'error open milestone' => 'Error al reabrir el milestone seleccionado',
    'error edit company logo' => 'Error al actualizar el logo de la compañía',
    'error delete company logo' => 'Error al eliminar logo de la compañía',
    'error subscribe to message' => 'Error al suscribirse al mensaje seleccionado',
    'error unsubscribe to message' => 'Error al darse de baja del mensaje seleccionado',

    'error move message' => 'Erro al mover el mensaje seleccionado %s',
    'error move task list' => 'Error al mover la lista de tareas seleccionada',
    'error delete task list' => 'Error al eliminar la lista de tareas seleccionada',
    'error delete task' => 'Error al eliminar la tarea seleccionada',
    'error delete category' => 'Error al eliminar la categoría seleccionada',
    'error check for upgrade' => 'Error al verificar las versiones nuevas',
    'error test mail settings' => 'Error al enviar el mensaje de prueba',
    'error massmail' => 'Error al enviar el correo electrónico',
    'error owner company has all permissions' => 'La empresa propietaria posee todos los permisos',
    
    // Access or data errors
    'no access permissions' => 'No tienes permisos para acceder a la página solicitada',
    'invalid request' => 'Solicitud inválida!',
    
    // Confirmation
    'confirm delete message' => '¿Está seguro que deseas eliminar este mensaje?',
    'confirm delete milestone' => '¿Está seguro que deseas eliminar este milestone?',
    'confirm delete task list' => '¿Está seguro que deseas eliminar esta lista de tareas y todas sus tareas?',
    'confirm delete task' => '¿Está seguro que deseas eliminar esta tarea?',
    'confirm delete comment' => '¿Está seguro que deseas eliminar este comentario?',
    'confirm delete category' => '¿Está seguro que deseas eliminar esta categoría?',
    'confirm delete project' => '¿Está seguro que deseas eliminar este proyecto y toda la información relacionada (mensajes, tareas, milestones, archivos...)?',
    'confirm delete project logo' => '¿Está seguro que deseas eliminar este logo?',
    'confirm delete logo' => '¿Está seguro que desea eliminar este logotipo?',
    'confirm complete project' => '¿Está seguro que deseas etiquetar este proyecto como terminado? Todas las acciones dentro del proyecto serán bloqueadas',
    'confirm open project' => '¿Está seguro que deseas etiquetar este proyecto como abierto? Esto desbloqueará todas las acciones dentro del mismo',
    'confirm delete client' => '¿Está seguro que deseas eliminar la compañía del cliente seleccionado y todos sus usuarios?',
    'confirm delete user' => '¿Está seguro que deseas eliminar esta cuenta de usuario?',
    'confirm delete contact' => '¿Está seguro que desea eliminar este contacto?',
    'confirm reset people form' => '¿Está seguro que deseas reestablecer esta forma? Todas las modificaciones hechas se perderan!',
    'confirm remove user from project' => '¿Está seguro que deseas eliminar este usuario del proyecto?',
    'confirm remove company from project' => '¿Está seguro que deseas eliminar esta compañía del proyecto?',
    'confirm logout' => '¿Está seguro que deseas cerrar la sesión?',
    'confirm delete current avatar' => '¿Está seguro que deseas eliminar este avatar?',
    'confirm delete company logo' => '¿Está seguro que deseas eliminar este logo?',
    'confirm subscribe' => '¿Está seguro que deseas suscribirte a este mensaje? Recibiras un correo electrónico cada vez que alguien (excepto tu) publique un comentario en este mensaje.',
    'confirm reset form' => '¿Está seguro que deseas reestablecer esta forma?',
    
    // Errors...
    'system error message' => 'Lo sentimos pero un error fatal evito que ProjectPier ejecutara tu solicitud. Un reporte de error ha sido enviado al administrador.',
    'execute action error message' => 'Lo sentimis pero ProjectPier no puede ejecutar tu solicitud en este momento. Un reporte de error ha sido enviado al administrador.',
    
    // Log
    'log add projectmessages' => '\'%s\' añadido',
    'log edit projectmessages' => '\'%s\' actualizado',
    'log delete projectmessages' => '\'%s\' eliminado',
    
    'log add comments' => '%s añadido',
    'log edit comments' => '%s actualizado',
    'log delete comments' => '%s eliminado',
    
    'log add projectmilestones' => '\'%s\' añadido',
    'log edit projectmilestones' => '\'%s\' actualizado',
    'log delete projectmilestones' => '\'%s\' eliminado',
    'log close projectmilestones' => '\'%s\' completado',
    'log open projectmilestones' => '\'%s\' reabierto',

    'log add projecttimes' => '\'%s\' añadido', 
    'log edit projecttimes' => '\'%s\' actualizado',
    'log delete projecttimes' => '\'%s\' eliminado',
    
    'log add projecttasklists' => '\'%s\' añadido',
    'log edit projecttasklists' => '\'%s\' actualizado',
    'log delete projecttasklists' => '\'%s\' eliminado',
    'log close projecttasklists' => '\'%s\' cerrado',
    'log open projecttasklists' => '\'%s\' abierto',
    
    'log add projecttasks' => '\'%s\' añadido',
    'log edit projecttasks' => '\'%s\' actualizado',
    'log delete projecttasks' => '\'%s\' eliminado',
    'log close projecttasks' => '\'%s\' cerrado',
    'log open projecttasks' => '\'%s\' abierto',
  
    'log add projectforms' => '\'%s\' añadido',
    'log edit projectforms' => '\'%s\' actualizado',
    'log delete projectforms' => '\'%s\' eliminado',

  
    'log add projects' => 'Project \'%s\' añadido',
    'log edit projects' => 'Project \'%s\' actualizado',
    'log open projects' => 'Project \'%s\' abierto',
    'log close projects' => 'Project \'%s\' cerrado',
    'log delete projects' => 'Project \'%s\' eliminado',

    'log add users' => 'User \'%s\' añadido',
    'log edit users' => 'User \'%s\' actualizado',
    'log delete users' => 'User \'%s\' eliminado',

    'log add companies' => 'Company \'%s\' añadido',
    'log edit companies' => 'Company \'%s\' actualizado',
    'log delete companies' => 'Company \'%s\' eliminado',

    'log add contacts' => 'Contact \'%s\' añadido',
    'log edit contacts' => 'Contact \'%s\' actualizado',
    'log delete contacts' => 'Contact \'%s\' eliminado',

    'log add i18nlocales' => 'Locale \'%s\' añadido',
    'log edit i18nlocales' => 'Locale \'%s\' actualizado',
    'log delete i18nlocales' => 'Locale \'%s\' eliminado',

    'log add i18localevalues' => 'Locale value \'%s\' added',
    'log edit i18nlocalevalues' => 'Locale value \'%s\' añadido',
    'log delete i18nlocalevalues' => 'Locale value \'%s\' eliminado',    
  
  ); // array

?>
