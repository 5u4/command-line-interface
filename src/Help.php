<?php

namespace Senhung\CLI;

use Senhung\CLI\Command;
use Senhung\CLI\CommandEntry;

class Help extends Command
{
    public $signature = 'help {:function-name}';

    public $description = 'List all functions';

    public function handle()
    {
        $help = " -----------------------------------------------------------------\n";
        $help .= " | Command Line Interface\n";
        $help .= " | See more in https://github.com/senhungwong/command-line-interface\n";
        $help .= " -------------------------------------------------------------------\n";
        $commands = CommandEntry::getCommands();

        /* See Specific Function Description */
        if ($command = $this->getArgument('function-name')) {
            $command = new $commands[$command];
            $help .= " - " . $command->getCommand() . ": ";
            $help .= $command->description . "\n";
        }

        /* List All Commands */
        else {
            foreach ($commands as $command) {
                $command = new $command;
                $help .= " - ";
                $help .= $command->getCommand() . ": ";
                $help .= $command->description . "\n";
            }
        }

        echo $help;
    }
}
