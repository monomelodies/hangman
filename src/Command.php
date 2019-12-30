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

    /**
     * @param string $command
     * @param int $returnVar
     * @return void
     */
    public function __construct(string $command, int $returnVar)
    {
        $this->command = $command;
        $this->returnVar = $returnVar;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->command;
    }

    /**
     * @return int
     */
    public function getReturnCode() : int
    {
        return $this->returnVar;
    }

    /**
     * Formatted result: COMMAND (RETURNVAR)
     *
     * @return string
     */
    public function __toString() : string
    {
        return "{$this->command} ({$this->returnVar})";
    }
}

