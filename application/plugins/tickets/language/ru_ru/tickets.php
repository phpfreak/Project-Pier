<?php

  return array(

    // source: actions.php

    // Bug Trac
    'open tickets' => 'Открытые билеты',
    'closed tickets' => 'Закрытые билеты',
    'add ticket' => 'Новый билет',
    'edit ticket' => 'Редактировать билет',
    'view ticket' => 'Просмотр билета',
    'open ticket' => 'Открыть билет',
    'close ticket' => 'Закрыть билет',
    'delete ticket' => 'Удалить билет',
    'add ticket category' => 'Добавить категорию',
    'add default ticket categories' => 'Добавить стандартные категории',
    'edit ticket category' => 'Редактировать категорию',
    'ticket categories' => 'Категории билетов',
    'update ticket options' => 'Обновить опции',

    // source: administration.php

    'config category name tickets' => 'Билеты',
    'config category desc tickets' => 'Этот набор настроек задает опции по билетам. Пока только стандартные категории.',
    'config option name tickets_types' => 'Разрешенные типы билетов',
    'config option name tickets_default_categories' => 'Стандартные категории билетов в проекте',

    // source: emails.php

    'new ticket' => 'Новый билет',

    'new ticket posted' => 'Новый билет "%s" has been posted in "%s" project',
    'ticket edited' => 'Билет "%s" в проекте "%s" изменен',
    'ticket closed' => 'Билет "%s" в проекте "%s" закрыт',
    'ticket opened' => 'Билет "%s" в проекте "%s" открыт',
    'attached files to ticket' => 'К билету "%s" в проекте "%s" были добавлены файлы',
    'view new ticket' => 'Просмотреть билет',


    // source: errors.php

    // Add category
    'category name required' => 'Имя категории обязательно',

    // Add ticket
    'ticket summary required' => 'Не заполнено поле Общие сведения',
    'ticket description required' => 'Описание билета обязательно',

    // source: messages.php
    // Empty, dnx etc
    'no ticket subscribers' => 'На этот билет никто не подписан',

    'ticket dnx' => 'Запрошенный билет не существует',
    'no tickets in project' => 'В проекте билетов нет',
    'no my tickets' => 'Билетов, назначенных Вам, нет',
    'no changes in ticket' => 'Изменений по билету нет',
    'category dnx' => 'Указанная категория не найдена',
    'no categories in project' => 'В проекте нет категорий',

    // Success
    'success add ticket' => 'Билет \'%s\' был добавлен',
    'success edit ticket' => 'Билет \'%s\' изменен',
    'success deleted ticket' => 'Билет \'%s\' и все примечания были удалены',
    'success close ticket' => 'Выбранный билет закрыт',
    'success open ticket' => 'Выбранный билет был пере-открыт',
    'success add category' => 'Категория \'%s\' добавлена',
    'success edit category' => 'Категория \'%s\' изменена',
    'success deleted category' => 'Категория \'%s\' и все примечания к ней удалены',

    'success subscribe to ticket' => 'Вы были подписаны на этот билет',
    'success unsubscribe to ticket' => 'Вы успешно отписались от билета',

    // Failures
    'error update ticket options' => 'Ошибка при обновлении опций билета',
    'error close ticket' => 'Ошибка to close selected ticket',
    'error open ticket' => 'Ошибка to reopen selected ticket',
    'error subscribe to ticket' => 'Ошибка to subscribe to selected ticket',
    'error unsubscribe to ticket' => 'Ошибка to unsubscribe from selected ticket',
    'error delete ticket' => 'Ошибка to delete selected ticket',

    // Confirmation
    'confirm delete ticket' => 'Вы уверены, что хотите удалить билет ?',
    'confirm unsubscribe' => 'Вы уверены, что хотите отписаться ?',
    'confirm subscribe ticket' => 'Вы уверены, что хотите подписаться на билет ? Вы будете получать email каждый раз, когда кто-либо добавит комментарии по билету',

    // Log
    'log add projectcategories' => '\'%s\' добавлена',
    'log edit projectcategories' => '\'%s\' изменена',
    'log delete projectcategories' => '\'%s\' удалена',
    'log add projecttickets' => '\'%s\' добавлен',
    'log edit projecttickets' => '\'%s\' обновлен',
    'log delete projecttickets' => '\'%s\' удален',
    'log close projecttickets' => '\'%s\' закрыт',
    'log open projecttickets' => '\'%s\' открыт',

    // source: general.php

    'ticket' => 'Билет',
    'tickets' => 'Билеты',
    'private ticket' => 'Частный билет',

    // source: project_interface.php

    'email notification ticket desc' => 'Уведомить об этом билете выбранных по email',
    'subscribers ticket desc' => 'Подписчики получают email-уведомления при каждом добавлении комментариев по билету',

    // Tickets
    'summary' => 'Общие сведения',
    'category' => 'Категория',
    'priority' => 'Приоритет',
    'state' => 'Статус',
    'assigned to' => 'Назначено',
    'reported by' => 'Сообщил',
    'closed' => 'Закрыт',
    'open' => 'Открыт',
    'critical' => 'Критический',
    'major' => 'Существенный',
    'minor' => 'Несущественный',
    'trivial' => 'Мелкий',
    'opened' => 'Открыт',
    'confirmed' => 'Подтвержден',
    'not reproducable' => 'Не воспроизводимо',
    'test and confirm' => 'Тестировать/подтвердить',
    'fixed' => 'Исправлен',
    'defect' => 'Дефект',
    'enhancement' => 'Усовершенствование',
    'feature request' => 'Запрос нового функционала',
    'legend' => 'Легенда',
    'ticket #' => 'Билет #%s',
    'updated on by' => '%s | <a href="%s">%s</a> | %s',
    'history' => 'История изменений',
    'field' => 'Поле',
    'old value' => 'Старое значение',
    'new value' => 'Новое значение',
    'change date' => 'Изменить дату',

    'private ticket desc' => 'Частные билеты дотсупны только сотрудникам компании-владельца. В компаниях-клиентах их никто не увидит.',

    // source: site_interface.php

    // Tickets
    'my tickets' => 'Мои билеты',

  ); // array

