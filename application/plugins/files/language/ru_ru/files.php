<?php
  //ProjectPier russian language module
  // Translated by Alexander Selifonov, < alex [at] selifan {dot} ru >
  return array(

    // source: actions.php

    // Files
    'add file' => 'Добавить файл',
    'edit file' => 'Изменить файл',
    'delete file' => 'Удалить файл',

    'add folder' => 'Добавить папку',
    'edit folder' => 'Изменить папку',
    'delete folder' => 'Удалить папку',

    'files add revision' => 'Добавить ревизию',
    'files edit revision' => 'ИзменитьEdit ревизию %s',
    'delete file revision' => 'Удалить ревизию %s',

    'attach file' => 'Приложить файл',
    'attach files' => 'Приложить файлы',
    'attach more files' => 'Приложить еще ',
    'detach file' => 'Удалить файл',
    'detach files' => 'Удалить файлы',

    // source: administration.php

    'config option name files_show_icons' => 'Показывать иконки файлов',
    'config option name files_show_thumbnails' => 'Показывать превью когда возможно',

    // source: errors.php

    // Validate project folder
    'folder name required' => 'Имя папки обязательно',
    'folder name unique' => 'Имя папки должно быть уникальным',

    // Validate add / edit file form
    'folder id required' => 'Выберите папку',
    'filename required' => 'Имя файла обязательно',

    // File revisions (internal)
    'file revision file_id required' => 'Ревизия должна быть связана с файлом',
    'file revision filename required' => 'Имя файлп обязательно',
    'file revision type_string required' => 'Неизвестный тип файла',

    // source: messages.php

    // Empty, dnx etc
    'no files on the page' => 'На странице нет файлов',
    'folder dnx' => 'Выбранная папка отсутствует в базе',
    'define project folders' => 'В проекте нет папок. Чтобы продолжить, определите папки',
    'file dnx' => 'Запрошенного файла нет в базе',
    'file revision dnx' => 'Запрошенной ревизии нет в базе',
    'no file revisions in file' => 'Неверный файл - нет ни одноя связанной с ним ревизии',
    'cant delete only revision' => 'Вы не можете удалить ревизию. У каждого файла должна быть хотя бы одна опубликованная ревизия',

    'no attached files' => 'К объекту не прикреплено ни одного файла',
    'file not attached to object' => 'Выбранный файл не прикреплен к выбранному объекту',
    'no files to attach' => 'Выберите файлы для прикрепления',

    // Success
    'success add folder' => 'Папка \'%s\' была добавлена',
    'success edit folder' => 'Папка \'%s\' была изменена',
    'success delete folder' => 'Папка \'%s\' была удалена',

    'success add file' => 'Файл \'%s\' был добавлен',
    'success edit file' => 'Файл \'%s\' был обновлен',
    'success delete file' => 'Файл \'%s\' был удален',

    'success add revision' => 'Ревизия %s была добавлена',
    'success edit file revision' => 'Ревизия была удалена',
    'success delete file revision' => 'Ревизия файла была удалена',

    'success attach files' => '%s файл(ов) было успешно прикреплено',
    'success detach file' => 'Файл(ы) был успешно откреплен',

    // Failures
    'error upload file' => 'Ошибка при загрузке файла',
    'error file download' => 'Ошибка при скачивании указанного файла',
    'error attach file' => 'Ошибка прикрепления файла',

    'error delete folder' => 'Не удалось удалить выбранную папку',
    'error delete file' => 'Не удалось удалить выбранный файл',
    'error delete file revision' => 'Не удалось удалить выбранную ревизию файла',
    'error attach file' => 'Ошибка прикрепления файла(ов)',
    'error detach file' => 'Ошибка открепления файла(ов)',
    'error attach files max controls' => 'Достигнут лимит в %s прикрепленных файлов, больше нельзя',

    // Confirmation
    'confirm delete folder' => 'Уверены, что хотите удалить эту папку ?',
    'confirm delete file' => 'Уверены, что хотите удалить этот файл ?',
    'confirm delete revision' => 'Уверены, что хотите удалить эту ревизию ?',
    'confirm detach file' => 'Уверены, что хотите открепить этот файл ?',

    // Log
    'log add projectfolders' => '\'%s\' добавлено',
    'log edit projectfolders' => '\'%s\' обновлено',
    'log delete projectfolders' => '\'%s\' удалено',

    'log add projectfiles' => '\'%s\' загружено',
    'log edit projectfiles' => '\'%s\' обновлено',
    'log delete projectfiles' => '\'%s\' удалено',

    'log edit projectfilerevisions' => '%s обновлено',
    'log delete projectfilerevisions' => '%s удалено',

    // source: objects.php

    'file' => 'Файл',
    'files' => 'Файлы',
    'file revision' => 'Ревизия файла',
    'file revisions' => 'Ревизии файла',
    'revision' => 'Ревизия',
    'revisions' => 'Ревизии',
    'folder' => 'Папка',
    'folders' => 'Папки',
    'attached file' => 'Прикрепл.файл',
    'attached files' => 'Прикрепл.файлы',
    'important file'     => 'Важный файл',
    'important files'    => 'Важные файлы',
    'private file' => 'Частный файл',
    'attachment' => 'Вложение',
    'attachments' => 'Вложения',

    // source: project_interface.php

    'attach existing file' => 'Прикрепить существующий файл (из секции Файлы)',
    'upload and attach' => 'Загрузить новый файл и прикрепить к сообщению',

    'new file' => 'Новый файл',
    'existing file' => 'Существующий файл',
    'replace file description' => 'Можно заменить существующий файл, указав новый. Если не хотите замены, оставьте это поле пустым.',
    'download history' => 'История загрузок',
    'download history for' => 'История загрузок для <a href="%s">%s</a>',
    'downloaded by' => 'Загрузил',
    'downloaded on' => 'Загружено',

    'revisions on file' => '%s ревизий',
    'order by filename' => 'по имени файла (a-z)',
    'order by posttime' => 'по дате/времени',
    'all files' => 'Все файлы',
    'upload file desc' => 'Можно загружать файлы любых типов. Максимальный размер загружаемого файла - %s',
    'file revision info short' => 'Ревизия #%s <span>(создана в %s)</span>',
    'file revision info long' => 'Ревизия #%s <span>(автор <a href="%s">%s</a> , %s)</span>',
    'file revision title short' => '<a href="%s">Ревизия #%s</a> <span>(создана %s)</span>',
    'file revision title long' => '<a href="%s">Ревизия #%s</a> <span>(автор <a href="%s">%s</a> , %s)</span>',
    'update file' => 'Обновить файл',
    'version file change' => 'Запомнить изменение (старый файл будет сохранен для ссылок)',
    'last revision' => 'Последняя ревизия',
    'revision comment' => 'Замечания к ревизии',
    'initial versions' => '-- Начальная версия --',
    'file details' => 'Подробно о файле',
    'view file details' => 'Смотреть подробности о файле',

    'add attach file control' => 'Добавить файл',
    'remove attach file control' => 'Удалить',
    'attach files to object desc' => 'Это форма для добавления файлов к объекту <strong><a href="%s">%s</a></strong>. Можно прикрепить один и более файлов. Можно выбрать любые из присутствующих файлов и загрузить новые. <strong>Новые файлы такжу будут доступны после загрузки в секции Файлы</strong>.',
    'select file' => 'Выбрать файл',

    'important file desc' => 'Важные файлы перечислены в боковой панели, блок "Важные файлы"',
    'private file desc' => 'Частные файлы видны только сотрудниками компании владельца. Люди из компаний-клиентов их не видят'

  ); // array

