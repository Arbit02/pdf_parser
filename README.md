Парсер PDF файлов
Сделан на основе библиотеки pdfplumber

Суть: мы запихимаем содержимое в json-контейнеры и читаем их на php и заносим в таблицу
Функции:
GetPDF() - парсит страницу и берет ссылку на pdf(она иногда меняется)
StartPythonScript() - запускает скрипт на питоне, который парсит пдф
parsePDF() - заносит данные из json в csv таблицу