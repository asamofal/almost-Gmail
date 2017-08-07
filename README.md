# almost-Gmail
Небольшой почтовый клиент.

## Фукнциональные возможности
* Получение писем из подключенного почтового ящика _(последние 10 писем из папки "Inbox")_
* Отправка писем
* Сохранение в базу данных полученных и отправленных сообщений
* Вывод архива сообщений из базы данных
* Удаление писем из архива _(в случае отправленных писем)_ и удаление на стороне сервера _(перемещение в папку 'IMAP/Deleted')__
* Сортировка списка писем _(по получателю/отправителю, теме письма, дате отправки/получения)_

## Используемые технологии/библиотеки
* HTML/CSS фреймворк Bootstrap 3
* PHP,  php-imap-client ([GitHub link](https://github.com/SSilence/php-imap-client))
* База данных MySQL
* JS билиотеки: jQuery, jQuery blockUI ([GitHub link](https://github.com/malsup/blockui)), Sortable ([GitHub link](https://github.com/HubSpot/sortable))
* AJAX

## Подключение
Необходимые настройки вносятся в **config.php**. _После подключения к MySQL серверу база данных создается автоматически._

Для отправки писем требуется настроеннй локальный SMTP сервер либо поддержка отправки писем на стороне хостера.
