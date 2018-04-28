<?php

namespace CLI;

require_once 'Service.php';

class Command
{
    private $command;

    private $arguments;

    private $options;

    public $signature;

    public $description;

    public function __construct()
    {
        $parsedSignature = Service::parseSignature($this->signature);
        $this->command = $parsedSignature[0];
        $this->arguments = $parsedSignature[1];
        $this->options = $parsedSignature[2];
    }

    public function update(array $arguments = null, array $options = null)
    {
        /* Update Arguments */
        if ($arguments) {
            foreach ($arguments as $argument => $value) {
                $this->arguments[$argument] = $value;
            }
        }

        /* Update Options */
        if ($options) {
            foreach ($options as $option => $value) {
                $this->options[$option] = $value;
            }
        }
    }

    public function handle()
    {

    }

    public function getCommand()
    {
        return $this->command;
    }

    protected function getArgument(string $argument)
    {
        if (isset($this->arguments[':' . $argument])) {
            return $this->arguments[':' . $argument];
        }

        return null;
    }

    protected function getOption(string $option)
    {
        if (isset($this->options['--' . $option])) {
            return $this->options['--' . $option];
        }

        return null;
    }
}
