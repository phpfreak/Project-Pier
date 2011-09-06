<?php
    // Added missing strings by Alexander Selifonov, 16.02.2011

  return array(
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------

    'administration tool name test_mail_settings' => 'Проверка настроек почты',
    'administration tool desc test_mail_settings' => 'Здесь Вы можете отправить email для проверки правильности настроек почты',
    'administration tool name mass_mailer' => 'Массовая рассылка',
    'administration tool desc mass_mailer' => 'Здесь можно отправить текстовые email-сообщения любой группе пользователей зарегистрированной в системе',

    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------

    'configuration' => 'Конфигурация',

    'mail transport mail()' => 'Настройки PHP по умолчанию',
    'mail transport smtp' => 'SMTP-сервер',

    'secure smtp connection no'  => 'Нет',
    'secure smtp connection ssl' => 'Да, используя SSL',
    'secure smtp connection tls' => 'Да, используя TLS',

    'file storage file system' => 'Файловая система',
    'file storage mysql' => 'База данных (MySQL)',

    // Categories
    'config category name general' => 'Главная',
    'config category desc general' => 'Основные настройки ProjectPier',
    'config category name mailing' => 'Почта',
    'config category desc mailing' => 'Эта группа настроек для поддержки отправки email-сообщений. Вы можете использовать настройки из php.ini или настроить работу с любым SMTP-сервером',


    // Categories
    'config category name features' => 'Доп-функции',
    'config category desc features' => 'Испльзуется для включения/отключения разных "фич" и выбрать способы отображения данных о проекте',
    'config category name database' => 'База данных',
    'config category desc database' => 'Изменение настроек соединения с БД',

    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------

    // General
    'config option name site_name' => 'Название сайта',
    'config option desc site_name' => 'Это значение будет отбражаться как название сайта на Главной странице',
    'config option name file_storage_adapter' => 'Файловое хранилище',
    'config option desc file_storage_adapter' => 'Укажите, где хранить вложения, аватары, логотипы и другие загружаемые файлы. <strong>Рекомендуется использование базы данных как хранилища</strong>.',
    'config option name default_project_folders' => 'Папки по умолчанию',
    'config option desc default_project_folders' => 'Папки, создаваемые при заведении проекта. Каждое название папки должно быть новой строкой. Пустые названия и дубликаты игнорируются.',
    'config option name theme' => 'Тема',
    'config option desc theme' => 'Темы позволяют менять внешний вид ProjectPier',


    'config option name calendar_first_day_of_week' => 'Первый день недели',
    'config option name check_email_unique' => 'Email адрес должен быть уникальным',
    'config option name remember_login_lifetime' => 'Держать подключение, секунд',
    'config option name installation_root' => 'Путь к web сайту',
    'config option name installation_welcome_logo' => 'Logo или логин-страница',
    'config option name installation_welcome_text' => 'Текст на странице логина (входа в систему)',
    'config option name installation_base_language' => 'Основной язык (в том числе и для логин-страницы)',

    // LDAP authentication support
    'config option name ldap_domain' => 'LDAP домен',
    'config option desc ldap_domain' => 'Имя Вашего AD домена',
    'config option name ldap_host' => 'имя LDAP сервера',
    'config option desc ldap_host' => 'Имя или IP-адрес вашего AD/LDAP сервера',
    'secure ldap connection no' => 'Нет',
    'secure ldap connection tls' => 'Да, TLS',
    'config option name ldap_secure_connection' => 'Использовать безопасное соединение с LDAP',


    // ProjectPier
    'config option name upgrade_check_enabled' => 'Разрешить проверку обновлений',
    'config option desc upgrade_check_enabled' => 'Если да, то система раз в день будет проверять доступность новых версий ProjectPier для скачивания',

    // Mailing
    'config option name exchange_compatible' => 'Режим совместимости с Microsoft Exchange',
    'config option desc exchange_compatible' => 'Если вы используете Microsoft Exchange Server установите "Да" для предотвращения известных проблем с почтой.',
    'config option name mail_transport' => 'Почтовый транспорт',
    'config option desc mail_transport' => 'Вы можете использовать настройки PHP по умолчанию или указать SMTP-сервер',
    'config option name smtp_server' => 'SMTP сервер',
    'config option name smtp_port' => 'SMTP порт',
    'config option name smtp_authenticate' => 'Использовать SMTP аутентификацию',
    'config option name smtp_username' => 'SMTP пользователь',
    'config option name smtp_password' => 'SMTP пароль',
    'config option name smtp_secure_connection' => 'Использовать безопасное SMTP соединение',

    'config option name mail_from' => 'Mail From: адрес',
    'config option name mail_use_reply_to' => 'Использовать Reply-To: для From',

    'config option name per_project_activity_logs' => 'Логи активности в проекте',
    'config option name categories_per_page' => 'Число категорий на страницу',

    'config option name character_set' => 'Используемый Character set',
    'config option name collation' => 'Порядок сортировки символов',

    'config option name session_lifetime' => 'Время жизни сессии',
    'config option name default_controller' => 'Главная страница по умолчанию',
    'config option name default_action' => 'Под-страница',

    'config option name files_show_thumbnails' => 'Показывать мини-картинки когда возможно',
    'config option name logs_show_icons' => 'Показывать иконки в логах приложений',
    'config option name default_private' => 'Значение по умолчанию для опции "личное/private"',
    'config option name files_show_icons' => 'Показывать иконки файлов',
    'config option name logout_redirect_page' => 'Перенаправить при завершении сеанса',
    'config option desc logout_redirect_page' => 'Задает страницы, на которую пользователь перенапрвляется при выходе (завершении сеанса).  Задать default "стандартной" страницы',

    '__end__' =>''
  ); // array
