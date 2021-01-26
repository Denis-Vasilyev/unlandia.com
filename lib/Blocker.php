<?php

namespace Neti\Utils;

class Blocker
{
    private const MSG_SCRIPT_ALREADY_RUNNING = 'Скрипт уже запущен.';
    private const MSG_SCRIPT_WORK_TOO_LONG = 'Скрипт работает слишком долго.';
    private const MSG_LOCK_FILE_CREATED = 'Создан .lock файл.';
    private const MSG_LOCK_FILE_NOT_CREATED = 'Не удалось создать .lock файл.';
    private const MSG_LOCK_FILE_NOT_LOCKED = 'Не удалось осуществить блокировку .lock файла.';
    private const MSG_LOCK_FILE_LOCKED = 'Осуществлена блокировка .lock файла.';
    private const MSG_LOCK_FILE_UNLOCKED = 'Осуществлена разблокировка .lock файла.';
    private const MSG_LOCK_FILE_NOT_UNLOCKED = 'Не удалось разблокировать .lock файл.';
    private const MSG_LOCK_FILE_DELETED = '.lock файл удален.';
    private const MSG_EMPTY_SCRIPT_FILE_NAME = 'Пустое значение имени файла запускаемого скрипта';

    /**
     * @string PID текущего процесса
     */
    private $pid;

    /**
     * @resource дескриптор файла-блокировщика
     */
    private $lock;

    /**
     * @string директория с процессами на сервере
     */
    private $procDir;

    /**
     * @string полный путь к файлу-блокировщику
     */
    private $lockFile;

    /**
     * @string значение __FILE__ запускаемого скрипта
     */
    private $scriptFileName;

    /**
     * @int величина допустимого времени работы блокируемого скрипта в секундах
     */
    private $longRunningTimeout = 5400; // 1h 30m

    /**
     * Blocker constructor.
     * @param $scriptFileName значение __FILE__ запускаемого скрипта
     */
    public function __construct($scriptFileName)
    {
        $extLockFile = '.lock';
        // в docker $_SERVER['DOCUMENT_ROOT'] имеет пустое значение
        $documentRoot = trim($_SERVER['DOCUMENT_ROOT']) ?? '/var/www/html/boxberry.ru';
        $ds = DIRECTORY_SEPARATOR;

        $this->procDir = $ds . 'proc';
        $this->scriptFileName = trim($scriptFileName);

        if(empty($this->scriptFileName)) {
            self::showMessage(self::MSG_EMPTY_SCRIPT_FILE_NAME);
            die();
        }

        $this->lockFile = $documentRoot . $ds . pathinfo($this->scriptFileName)['dirname'] . $ds
            . pathinfo($this->scriptFileName)['filename'] . $extLockFile;

    }

    /**
     * осуществляет проверку повторного запуска скрипта
     */
    public function lock(): bool
    {
        if (!$this->createLockFile()) {
            return false;
        }

        $this->pid = posix_getpid();
        $pid = $this->getPIDFromLockFile();

        if ( $pid === $this->pid || $this->checkProcessExistenceByPID($pid)
             //|| $this->checkProcessExistenceByScriptName(pathinfo($this->scriptFileName)['basename'])
        ) {
            self::showMessage(self::MSG_SCRIPT_ALREADY_RUNNING);
            return false;
        }

        return $this->lockLockFile();
    }

    /**
     * Осуществляет проверку существования процесса по PID,
     * и проверяет превышение времени работы скрипта
     * @param $pid
     * @return bool
     */
    private function checkProcessExistenceByPID($pid): bool
    {
        $pid = trim($pid);

        //проверяем, передано ли пустое значение $pid или $pid системных процессов
        if (empty($pid) || $pid === '0' || $pid === '1') {
            return false;
        }

        if (file_exists($this->procDir . DIRECTORY_SEPARATOR . $pid)) {
            //необходимо для корректной работы filemtime,
            //т.к. результаты функции filemtime кешируются
            clearstatcache();
            if ((filemtime($this->lockFile) + $this->longRunningTimeout) < time()) {
                self::showMessage(self::MSG_SCRIPT_WORK_TOO_LONG);
            }
            return true;
        }

        return false;
    }

    /**
     * Осуществляет проверку существования процесса по имени запускаемого скрипта,
     * @param $scriptName имя запускаемого скрипта без путей
     * @return bool
     */
    private function checkProcessExistenceByScriptName($scriptName): bool
    {
        //1-й аргумент exec необходимо адаптировать под продуктовый сервер
        //exec("ps aux | grep -v grep | grep $scriptName", $procList);
        exec("ps | grep -v grep | grep $scriptName", $procList);

        foreach ($procList as $plItem) {
            if (    strpos($plItem, ' ' . $this->pid . ' ') === false &&
                    strpos($plItem, ' php ') === true &&
                    strpos($plItem, $scriptName) === true) {
                    return true;
            }
        }

        return false;
    }

    /**
     * Возвращает значение первой строки из соответствующего .lock файла
     * @return string
     */
    private function getPIDFromLockFile(): string
    {
        return trim(fgets($this->lock));
    }

    /**
     * Получает дескриптор .lock файла
     * @return bool
     */
    private function createLockFile(): bool
    {
        if ($this->lock = fopen($this->lockFile, 'w+')) {
            self::showMessage(self::MSG_LOCK_FILE_CREATED);
            return true;
        }

        self::showMessage(self::MSG_LOCK_FILE_NOT_CREATED);

        return false;
    }

    /**
     * Осуществляет попытку блокировки .lock файла
     * в случае успешной блокировки записывает в него pid текущего процесса
     * возвращает результат блокировки
     * @return bool
     */
    private function lockLockFile(): bool
    {
        if (!($this->lock && flock($this->lock, LOCK_EX | LOCK_NB))) {
            //без атрибута LOCK_NB будет осуществлятся ожидание разблокировки файла
            self::showMessage(self::MSG_LOCK_FILE_NOT_LOCKED);
            return false;
        }

        //ftruncate($this->lock,0);
        fwrite($this->lock,$this->pid . PHP_EOL);

        self::showMessage(self::MSG_LOCK_FILE_LOCKED);

        return true;
    }

    /**
     * Осуществляет попытку разблокировки .lock файла
     * возвращает результат разблокировки
     * @return bool
     */
    private function unlockLockFile(): bool
    {
        if (unlink($this->lockFile)) {
            self::showMessage(self::MSG_LOCK_FILE_DELETED);
            return true;
        }

        if ($this->lock && flock($this->lock, LOCK_EX | LOCK_NB)
            && flock($this->lock, LOCK_UN)) {
            //без повторной попытки заблокировать файл не удасться корректно
            //осуществить достоверную разблокировку файла
            self::showMessage(self::MSG_LOCK_FILE_UNLOCKED);
            return true;
        }

        self::showMessage(self::MSG_LOCK_FILE_NOT_UNLOCKED);

        return false;
    }

    /**
     * Функционал вывода сообщений в консоль
     * @param $msg
     */
    public static function showMessage($msg): void
    {
        echo $msg . PHP_EOL;
    }

    /**
     * Blocker destructor.
     */
    public function __destruct()
    {
        $this->unlockLockFile();
    }
}
