<?php

namespace Senhung\CLI;

require_once 'Command.php';
require_once 'Help.php';

/**
 * Class CommandEntry
 * @package Senhung\CLI
 */
class CommandEntry
{
    /** @var array $commands */
    private static $commands;
    /** @var bool $initialized */
    private static $initialized = false;

    /**
     * Initialize the class if haven't been initialized
     *
     * @return void
     */
    private static function initialize(): void
    {
        /* If Not Initialized, Initialize */
        if (!self::$initialized) {
            self::$commands = Service::getAllCommands();
        }
    }

    /**
     * Command entry for running the desire command
     *
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

        /* Parse Arguments and Options */
        for ($index = 2; $index < count($argv); $index++) {
            /* Get Argument/Option Key and Value */
            list($key, $value) = Service::parse($argv[$index]);

            /* Is Option */
            if (Service::determineTypeOfWord($argv[$index]) == Service::OPTION_TYPE) {
                /* Flag */
                if (!$value) {
                    $options[$key] = true;
                }

                /* Parameter */
                else {
                    $options[$key] = $value;
                }
            }

            /* Is Argument */
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

        /* Make Directory */
        $commandDir = $_SERVER['DOCUMENT_ROOT'] . $dir;

        /* Get All Files In Directory */
        $files = scandir($commandDir);

        /* Require Files */
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            require_once $_SERVER['DOCUMENT_ROOT'] . $dir . '/' . $file;
        }
    }

    /**
     * Get all commands
     *
     * @return array
     */
    public static function getCommands(): array
    {
        return self::$commands;
    }
}
