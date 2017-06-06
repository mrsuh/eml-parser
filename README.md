# EML Parser

## Установка

```sh
sh bin/deploy
```

В директории bin должен лежать bin файл tomita
```
https://tech.yandex.ru/tomita/
```

Установить параметры в файлах

/bin/run.php
```
//путь до файла с конфигурацией Tomita
$config = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'tomita' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR . 'config.proto';

//путь до файла с исполняемым файлом tomita
$bin_tomita = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'tomita';

//директория в которой лежат все файлы для парсинга
$files_dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'test';
```

/tomita/contact/config.proto
```
//Путь в файлу газеттира
 Dictionary = "path/to/tomita/contact/dict.gzt";
```

## Использование
```
php bin/run.php
```

после этого в файле person.txt буду данные по контактам