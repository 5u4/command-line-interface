<?php

namespace Senhung\CLI;

use Senhung\CLI\Command;
use Senhung\CLI\CommandEntry;

/**
 * Class Help
 * @package Senhung\CLI
 */
class Help extends Command
{
    /** @var string $signature */
    protected $signature = 'help {:function-name}';
    /** @var string $description */
    protected $description = 'List all functions';

    /**
     * Help command handler
     *
     * @return void
     */
    public function handle(): void
    {
        /* Help Guide Header */
        $help = " -----------------------------------------------------------------\n";
        $help .= " | Command Line Interface\n";
        $help .= " | See more in https://github.com/senhungwong/command-line-interface\n";
        $help .= " -------------------------------------------------------------------\n";

        /* Get All Commands */
        $commands = CommandEntry::getCommands();

        /* See Specific Function's Description */
        if ($command = $this->getArgument('function-name')) {
            $command = new $commands[$command];
            $help .= " - " . $command->getCommand() . ": ";
            $help .= $command->getDescription() . "\n";
        }

        /* List All Commands */
        else {
            foreach ($commands as $command) {
                $command = new $command;
                $help .= " - ";
                $help .= $command->getCommand() . ": ";
                $help .= $command->getDescription() . "\n";
            }
        }

        echo $help;
    }
}
