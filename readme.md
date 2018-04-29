# Command Line Interface

## Description

A package imitating [Aritsan Console](https://laravel.com/docs/5.6/artisan) for writing command easier.

## Setup

1. Add Dependency

```bash
$ composer require senhung/command-line-interface
```

2. Add a Entry for Command

Create a file in root directory and name it the command you want to call

For example create a file named `example`; calling the command line will be

```php
$ php example <command>
```

3. Edit Command Entry

Open the command entry file just created and add the following

```php
<?php

require_once 'vendor/autoload.php';

use Senhung\CLI\CommandEntry;

/* Read through all commands in <change-folder-to-your-command-folder> */
CommandEntry::load('<change-folder-to-your-command-folder>');

/* When calling the script, execute the target command */
CommandEntry::entry($argv);

```

## Usage

### Create Command

Open the command folder and create a php script

```php
<?php

namespace Some\Name\Space;

use Senhung\CLI\Command;

class YourClassName extends Command
{
    /**
     * @var string $signature
     *
     * Set the signature of your command
     *
     * <command> how you call the command
     * {:arguments} arguments will be filled in in order when call
     * {--options} options are like flags or parameters
     */
    public $signature = '<command> {:arguments} {--options}';

    /**
     * @var string $description
     *
     * Description of your command
     *
     * Will be used in help command
     */
    public $description = 'Description for <command>';

    /**
     * The executing function when calling the command
     */
    public function handle()
    {
        /**
         * Write your handling function here
         *
         * You can get argument by: $this->getArgument('<argument-key>')
         * You can get option by: $this->getOption('<option-key>')
         */
    }
}

```

### Default Values

You can set default value for argument and option by setting the signature like:

```php
public $signature = '<command> {:arguments=some-default-value} {--options=some-default-value}';
```

### Calling Command

You can call your command by:

```bash
$ php <entry-file-name> <command> <argument> <--opiton-as-a-flag> <--option-as-a-param=some-value>
```

**You can mix up arguments and options, the package will recognize argument/options**

**Note: The order of arguments is important, but the order of options is not**

### Help

Call the following to get all commands:

```bash
$ php <entry-file-name> help
```

You can add one more argument for getting specific function's description

```bash
$ php <entry-file-name> help <command>
```

## Example

### Example Entry

```php
<?php

/* file: example */

require_once 'vendor/autoload.php';

use Senhung\CLI\CommandEntry;

CommandEntry::load('Commands');

CommandEntry::entry($argv);

```

### Example Command

```php
<?php

/* file: Commands/Greet.php */

namespace Example;

use Senhung\CLI\Command;

class Greet extends Command
{
    protected $signature = 'greet {:name} {--with-exclamation} {--number-of-times=1}';

    protected $description = 'Greet people';

    public function handle()
    {
        /* Repeat Greeting Times */
        $numberOfTimes = $this->getOption('number-of-times');

        /* Get Greeting Person's Name */
        $name = $this->getArgument('name');

        /* Check If Using Exclamation Point */
        $withExclamation = $this->getOption('with-exclamation');

        /* Repeat $numberOfTimes Times */
        for ($index = 0; $index < $numberOfTimes; $index++) {
            $greet = "Hello " . $name;

            if ($withExclamation) {
                $greet .= "!";
            }

            $greet .= "\n";

            echo $greet;
        }
    }
}

```

### Using Command

#### With Argument

```bash
$ php example greet Senhung
```

Output:

```
Hello Senhung
```

**Note: If no argument is passed in, {:name} will be null**

#### With Option (Flag)

```bash
$ php example greet Senhung --with-exclamation
```

Output:

```
Hello Senhung!
```

#### With Option (Parameter)

```bash
$ php example greet Senhung --with-exclamation --number-of-times=3
```

Output:

```
Hello Senhung!
Hello Senhung!
Hello Senhung!
```
