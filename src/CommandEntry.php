<?php

namespace Senhung\CLI;

require_once 'Command.php';

class CommandEntry
{
    /** @var array $commands */
    private static $commands;
    /** @var bool $initialized */
    private static $initialized = false;

    private static function initialize()
    {
        if (self::$initialized) {
            return;
        }

        self::$commands = Service::getAllCommands();
    }

    /**
     * @param $argv
     * @return void
     */
    public static function entry($argv): void
    {
        self::initialize();

        /* Check Command Entered */
        if (isset($argv[1])) {
            $command = $argv[1];
        } else {
            return;
        }

        /* Check Command Defined */
        if (!in_array($command, array_keys(self::$commands))) {
            return;
        }

        $arguments = [];
        $options = [];

        for ($index = 2; $index < count($argv); $index++) {
            list($key, $value) = Service::parse($argv[$index]);

            $type = Service::determineTypeOfWord($argv[$index]);

            /* Option */
            if ($type == Service::OPTION_TYPE) {
                if (!$value) {
                    $options[$key] = true;
                } else {
                    $options[$key] = $value;
                }
            }

            /* Argument */
            else {
                $arguments[] = $key;
            }
        }

        /* Run Command Handle */
        Service::runCommand(self::$commands[$command], $arguments, $options);
    }

    /**
     * Load all command classes
     *
     * @param string $dir
     * @return void
     */
    public static function load(string $dir): void
    {
        self::initialize();

        $commandDir = $_SERVER['DOCUMENT_ROOT'] . $dir;

        $files = scandir($commandDir);

        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            require_once $_SERVER['DOCUMENT_ROOT'] . $dir . '/' . $file;
        }
    }
}
