<?php

namespace Senhung\CLI;

/**
 * Class Service
 * @package Senhung\CLI
 *
 * Helper class for Senhung\CLI\Command and Senhung\CLI\CommandEntry
 */
class Service
{
    /** Command Types */
    public const COMMAND_TYPE = 'COMMAND_TYPE';
    public const ARGUMENT_TYPE = 'ARGUMENT_TYPE';
    public const OPTION_TYPE = 'OPTION_TYPE';

    /**
     * Get all registered commands
     *
     * @return array
     */
    public static function getAllCommands(): array
    {
        /* Get All Commands */
        $commands = [];
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, 'Senhung\CLI\Command')) {
                $commandObject = new $class;
                $command = $commandObject->getCommand();
                $commands[$command] = $class;
            }
        }

        return $commands;
    }

    /**
     * Parse command signature to command, arguments and options
     *
     * @param string $signature
     * @return array
     */
    public static function parseSignature(string $signature): array
    {
        /* Parse Signature to Array */
        $signature = explode(' ', trim($signature));

        /* Initialize */
        $command = trim($signature[0]);
        $arguments = [];
        $options = [];

        /* Check Each Word */
        foreach ($signature as $word) {
            $type = self::determineTypeOfWord($word);

            /* Option */
            if ($type == self::OPTION_TYPE) {
                list($key, $defaultValue) = self::parse($word);
                $options[$key] = $defaultValue;
            }

            /* Argument */
            elseif ($type == self::ARGUMENT_TYPE) {
                list($key, $defaultValue) = self::parse($word);
                $arguments[$key] = $defaultValue;
            }
        }

        return [$command, $arguments, $options];
    }

    /**
     * Run command handle
     *
     * @param string $command
     * @param array|null $arguments
     * @param array|null $options
     * @return void
     */
    public static function runCommand(string $command, array $arguments = null, array $options = null): void
    {
        $commandObject = new $command($arguments, $options);

        $commandObject->update($arguments, $options);

        $commandObject->handle();
    }

    /**
     * Parse an argument or option to its key and value
     *
     * @param string $word
     * @return array
     */
    public static function parse(string $word): array
    {
        $word = ltrim(rtrim(trim($word), '}'), '{');

        /* Having Default Value */
        if ($separatorPosition = strpos($word, '=')) {
            $key = substr($word, 0, $separatorPosition);
            $defaultValue = substr($word, $separatorPosition + 1);
            return [$key, $defaultValue];
        }

        return [$word, null];
    }

    /**
     * Determine the type of a string
     * Option: --option
     * Argument: :argument
     * Command: command
     *
     * @param string $word
     * @return string
     */
    public static function determineTypeOfWord(string $word): string
    {
        $word = ltrim(rtrim(trim($word), '}'), '{');

        /* Is Option Type */
        if (substr($word, 0, 2) == '--') {
            return self::OPTION_TYPE;
        }

        /* Is Argument Type */
        elseif (substr($word, 0, 1) == ':') {
            return self::ARGUMENT_TYPE;
        }

        /* Is Command Type */
        return self::COMMAND_TYPE;
    }
}
