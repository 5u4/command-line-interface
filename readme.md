# Command Line Interface

## Description

A package imitating [Aritsan Console](https://laravel.com/docs/5.6/artisan) for writing command easier.

## Example

An example is included in `Commands/Greet.php` and `example`.

### Example Entry

```php
<?php

/* file: example */

require_once $_SERVER['DOCUMENT_ROOT'] . 'src/CommandEntry.php';

use CLI\CommandEntry;

CommandEntry::load('Commands');

CommandEntry::entry($argv);

```

### Example Command

```php
<?php

/* file: Commands/Greet.php */

namespace Example;

require_once $_SERVER['DOCUMENT_ROOT'] . 'src/Command.php';

use CLI\Command;

class Greet extends Command
{
    /* How this command would be called */
    public $signature = 'greet';

    /* The description of the command */
    public $description = 'Test command for greeting people';

    /* Actions when this command is been called */
    public function handle()
    {
        print "Hello \n";
    }
}

```

### Use Command

```bash
$ php example greet
```

Output:

```bash
Hello

```
