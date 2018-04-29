<?php

namespace Senhung\CLI;

require_once 'Service.php';

/**
 * Class Command
 * @package Senhung\CLI
 */
class Command
{
    /** @var string $command */
    private $command;
    /** @var array $arguments */
    private $arguments;
    /** @var array $options */
    private $options;
    /** @var string $signature */
    protected $signature;
    /** @var string $description */
    protected $description;

    /**
     * Command constructor.
     */
    public function __construct()
    {
        $parsedSignature = Service::parseSignature($this->signature);
        $this->command = $parsedSignature[0];
        $this->arguments = $parsedSignature[1];
        $this->options = $parsedSignature[2];
    }

    /**
     * Update Arguments and Options
     *
     * @param array|null $arguments
     * @param array|null $options
     * @return void
     */
    public function update(array $arguments = null, array $options = null): void
    {
        /* Update Arguments */
        if ($arguments) {
            $keys = array_keys($this->arguments);
            for ($index = 0; $index < count($keys); $index++) {
                $this->arguments[$keys[$index]] = $arguments[$index];
            }
        }

        /* Update Options */
        if ($options) {
            foreach ($options as $option => $value) {
                $this->options[$option] = $value;
            }
        }
    }

    /**
     * Handle function when calling command
     *
     * @return void
     */
    public function handle()
    {
        return;
    }

    /**
     * Get command of current class
     *
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * Get description of command
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get specific argument
     *
     * @param string $argument
     * @return mixed|null
     */
    protected function getArgument(string $argument)
    {
        if (isset($this->arguments[':' . $argument])) {
            return $this->arguments[':' . $argument];
        }

        return null;
    }

    /**
     * Get specific argument
     *
     * @param string $option
     * @return mixed|null
     */
    protected function getOption(string $option)
    {
        if (isset($this->options['--' . $option])) {
            return $this->options['--' . $option];
        }

        return null;
    }
}
