<?php

namespace CLI;

require_once $_SERVER['DOCUMENT_ROOT'] . 'src/Command.php';

class CommandEntry
{
    /**
     * @param $argv
     * @return void
     */
    public static function entry($argv): void
    {
        $commands = Service::getAllCommands();

        $command = $argv[1];

        if (!isset($command) || !in_array($command, array_keys($commands))) {
            return;
        }

        Service::runCommand($commands[$command]);
    }

    /**
     * Load all command classes
     *
     * @param string $dir
     * @return void
     */
    public static function load(string $dir): void
    {
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
