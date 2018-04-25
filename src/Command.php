<?php

namespace CLI;

require_once 'Service.php';

class Command
{
    protected $command;

    protected $arguments;

    protected $options;

    public $signature;

    public $description;

    public function __construct()
    {
        $parsedSignature = Service::parseSignature($this->signature);
        $this->command = $parsedSignature[0];
        $this->arguments = $parsedSignature[1];
        $this->options = $parsedSignature[2];
    }

    public function handle()
    {

    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
