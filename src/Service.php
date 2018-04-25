<?php

namespace CLI;

class Service
{
    public static function getAllCommands()
    {
        /* Get All Commands */
        $commands = [];
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, 'CLI\Command')) {
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

        /* Get Command */
        $command = $signature[0];

        /* Get Arguments */
        $arguments = [];

        /* Get Options */
        $options = [];

        return [$command, $arguments, $options];
    }

    public static function runCommand(string $command)
    {
        $commandObject = new $command;

        $commandObject->handle();
    }
}
