<?php

namespace Senhung\CLI;

class Service
{
    public const COMMAND_TYPE = 'COMMAND_TYPE';
    public const ARGUMENT_TYPE = 'ARGUMENT_TYPE';
    public const OPTION_TYPE = 'OPTION_TYPE';

    public static function getAllCommands()
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

    public static function parseSignature(string $signature)
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

    public static function runCommand(string $command, array $arguments = null, array $options = null)
    {
        $commandObject = new $command($arguments, $options);

        $commandObject->update($arguments, $options);

        $commandObject->handle();
    }

    public static function parse(string $word)
    {
        $word = ltrim(rtrim(trim($word), '}'), '{');

//        /* Cannot Parse Command Type */
//        if (self::determineTypeOfWord($word) == self::COMMAND_TYPE) {
//            return [null, null];
//        }

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
    public static function determineTypeOfWord(string $word)
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
