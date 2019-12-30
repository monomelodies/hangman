<?php

namespace Monomelodies\Hangman;

/**
 * A simple wrapper for an executed command.
 */
class Command
{
    /** @var string */
    private $command;

    /** @var int */
    private $returnVar;

    public function __construct(string $command, int $returnVar)
    {
        $this->command = $command;
        $this->returnVar = $returnVar;
    }

    public function __toString() : string
    {
        return "{$this->command} ({$this->returnVar})";
    }
}

