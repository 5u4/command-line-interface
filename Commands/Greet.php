<?php

namespace Example;

require_once $_SERVER['DOCUMENT_ROOT'] . 'src/Command.php';

use CLI\Command;

class Greet extends Command
{
    public $signature = 'greet';

    public $description = 'Test command for greeting people';

    public function handle()
    {
        print "Hello \n";
    }
}
