<?php

namespace src;

define('TOMITA_DEBUG', false);

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Tomita.php';
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Person.php';
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Formatter.php';

//путь до файла с конфигурацией Tomita
$config = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'tomita' . DIRECTORY_SEPARATOR . 'contact' . DIRECTORY_SEPARATOR . 'config.proto';

//путь до файла с исполняемым файлом tomita
$bin_tomita = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'tomita';

//директория в которой лежат все файлы для парсинга
$files_dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'test';

$tomita  = new \src\Tomita($bin_tomita, $config);
$persons = [];

/**
 * @param Tomita $tomita
 * @param string $raw_text
 * @return Person
 */
function handle(Tomita $tomita, string $raw_text)
{
    $result = $tomita->run(Formatter::common($raw_text));
    $person = $tomita->handleResult($result);

    if (empty($person->getPhone())) {
        $result       = $tomita->run(Formatter::phone($raw_text));
        $person_phone = $tomita->handleResult($result);
        $person->setPhone($person_phone->getPhone());
    }

    return $person;
}

/**
 * @param array $persons
 * @return array
 */
function unique(array $persons)
{
    $unique = [];
    foreach ($persons as $person) {

        if (array_key_exists($person->getEmail(), $unique)) {
            continue;
        }

        if (empty($person->getEmail())) {
            continue;
        }

        if ($person->getEmail() && $person->getName() && $person->getPhone()) {
            $unique[$person->getEmail()] = $person;
            continue;
        }

        foreach ($persons as $p) {
            if ($p->getEmail() !== $person->getEmail()) {
                continue;
            }

            if ($p->getName()) {
                $person->setName($p->getName());
            }

            if ($p->getPhone()) {
                $person->setPhone($p->getPhone());
            }

            if ($person->getEmail() && $person->getName() && $person->getPhone()) {
                break;
            }
        }

        $unique[$person->getEmail()] = $person;
    }

    return $unique;
}

foreach (scandir($files_dir) as $file) {

    if (0 === preg_match('/\.eml$/', $file)) {
        continue;
    }

    echo $file . PHP_EOL;

    $person = handle($tomita, file_get_contents($files_dir . DIRECTORY_SEPARATOR . $file));

    $str = '';
    $str .= 'Name:  ' . $person->getName() . PHP_EOL;
    $str .= 'Email: ' . $person->getEmail() . PHP_EOL;
    $str .= 'Phone: ' . $person->getPhone() . PHP_EOL;
    $str .= '======================================' . PHP_EOL;
    echo $str;

    $persons[] = $person;
}

file_put_contents('persons.yml', '');
foreach (unique($persons) as $person) {
    $str = '';
    $str .= 'Name:  ' . $person->getName() . PHP_EOL;
    $str .= 'Email: ' . $person->getEmail() . PHP_EOL;
    $str .= 'Phone: ' . $person->getPhone() . PHP_EOL;
    $str .= '======================================' . PHP_EOL;
    file_put_contents('persons.txt', $str, FILE_APPEND);
}
