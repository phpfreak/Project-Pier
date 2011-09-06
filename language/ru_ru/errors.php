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
    'invalid email address' => 'Неправильный формат email адреса',

    // Company validation errors
    'company name required' => 'Укажите название компании/организации',
    'company homepage invalid' => 'Неправильный URL для домашней страницы',

    // User validation errors
    'username value required' => 'Введите имя пользователя',
    'username must be unique' => 'Извините, но выбранное имя пользователя уже занято',
    'email value is required' => 'Требуется адрес Email',
    'email address must be unique' => 'Извините, выбранный email уже занят',
    'company value required' => 'Пользователь должен принадлежать какой-либо компании/организации',
    'password value required' => 'Требуется ввести пароль',
    'passwords dont match' => 'Пароли не совпадают',
    'old password required' => 'Требуется старый пароль',
    'invalid old password' => 'Старый пароль введён неверно',

    // Avatar
    'invalid upload type' => 'Неправильный тип файла. Разрешённые типы %s',
    'invalid upload dimensions' => 'Неправильные размеры изображения. Максимальный размер %sx%s точек',
    'invalid upload size' => 'Неправильный размер изображения. Максимальный размер %s',
    'invalid upload failed to move' => 'Перемещение загруженного файла не удалось',

    // Registration form
    'terms of services not accepted' => 'Для создания учётной записи вам нужно согласиться с условиями обслуживания',

    // Init company website
    'failed to load company website' => 'Не удалось закрузить вебсайт. Компания-влавделец не найдена',
    'failed to load project' => 'Не удалось загрузить активный проект',

    // Login form
    'username value missing' => 'Пожалуйста, введите ваше имя пользователя',
    'password value missing' => 'Пожалуйста, введите ваш пароль',
    'invalid login data' => 'Вход не удался. Пожалуйста, проверьте ваши регистрационные данные и попытайтесь войти снова',

    // Add project form
    'project name required' => 'Требуется ввести название проекта',
    'project name unique' => 'Имя проекта должно быть уникальным',

    // Add message form
    'message title required' => 'Требуется наличие заголовка',
    'message title unique' => 'Заголовок сообщения должен быть уникальным',
    'message text required' => 'Требуется ввести текст сообщения',

    // Add comment form
    'comment text required' => 'Требуется ввести текст комментария',

    // Add milestone form
    'milestone name required' => 'Название этапа обязательно',
    'milestone due date required' => 'Требуется дата завершения этапа',

    // Add task list
    'task list name required' => 'Название списка заданий обязательно',
    'task list name unique' => 'Название списка заданий должно быть уникальным в проекте',

    // Add task
    'task text required' => 'Требуется ввести текст задания',

    // Add project form
    'form name required' => 'Требуется название формы',
    'form name unique' => 'Имя формы должно быт уникалным',
    'form success message required' => 'Текст сообщения об успешной отправке формы обязателен',
    'form action required' => 'Назначьте действие формы',
    'project form select message' => 'Пожалуйста, выберите сообщение',
    'project form select task lists' => 'Пожалуйста, выберите список заданий',

    // Submit project form
    'form content required' => 'Пожалуйста, введите содержимое в текстовое поле',

    // Validate project folder
    'folder name required' => 'Имя папки обязательно',
    'folder name unique' => 'Имя папки должно быть уникальным в этом проекте',

    // Validate add / edit file form
    'folder id required' => 'Пожалуйста, выберите имя папки',
    'filename required' => 'Имя файла обязательно',

    // File revisions (internal)
    'file revision file_id required' => 'Версия должна относится к конкретному файлу',
    'file revision filename required' => 'Требуется имя файла',
    'file revision type_string required' => 'Неизвестный тип файла',

    // Test mail settings
    'test mail recipient required' => 'Требуется адрес получателя',
    'test mail recipient invalid format' => 'Неправильный формат адреса получателя',
    'test mail message required' => 'Требуется сообщение для отсылки',

    // Mass mailer
    'massmailer subject required' => 'Необходимо указать тему для сообщения',
    'massmailer message required' => 'Требуется текст сообщения',
    'massmailer select recipients' => 'Пожалуйста, выберите пользователей, которые получат это сообщение',
    'id missing' => 'Уазанный ID не найден',
    'user homepage invalid' => 'URL заданной страницы неверен (Пример: http://www.example.com)',

  ); // array
