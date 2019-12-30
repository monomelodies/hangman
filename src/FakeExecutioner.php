<?php

namespace Monomelodies\Hangman;

use DomainException;

/**
 * The fake executioner. This can be used e.g. in unit tests when all you want
 * to do is see _if_ a command is run, not actually run it.
 */
class FakeExecutioner implements Executable
{
    /**
     * Array of commands run so far.
     *
     * @var array
     */
    private $commands = [];

    /**
     * The intended returnVar.
     *
     * @var int
     */
    private $returnVar = 0;

    /** @var string */
    private $originalPath;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->originalPath = getcwd();
    }

    /**
     * Since we cannot return the last line of output, we simply place the
     * command run in $output.
     *
     * @param string $command
     * @param array|null &$output
     * @param int|null &$returnVar
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.exec.php
     */
    public function exec(string $command, array &$output = null, int &$returnVar = null) : Executable
    {
        $this->commands[] = new Command($command, $this->returnVar);
        if (isset($output)) {
            $output[] = $command;
        }
        if (isset($returnVar)) {
            $returnVar = $this->returnVar;
        }
        return $this;
    }

    /**
     * @param string $command
     * @param int|null &$returnVar
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.passthru.php
     */
    public function passthru(string $command, int &$returnVar = null) : Executable
    {
        $this->commands[] = new Command($command, $this->returnVar);
        if (isset($returnVar)) {
            $returnVar = $this->returnVar;
        }
        echo $command;
        return $this;
    }

    /**
     * Since we cannot return the output, we simply place the command run in
     *  $output.
     *
     * @param string $command
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.shell-exec.php
     */
    public function shellExec(string $command, string &$output = null) : Executable
    {
        $this->commands[] = new Command($command, $this->returnVar);
        if (isset($output)) {
            $output = $command;
        }
        return $this;
    }

    /**
     * Since we cannot return the last line of output, we simply return the
     * command run.
     *
     * @param string $command
     * @param int|null &$returnVar
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.system.php
     */
    public function system(string $command, int &$returnVar = null) : Executable
    {
        $this->commands[] = new Command($command, $this->returnVar);
        if (isset($returnVar)) {
            $returnVar = $this->returnVar;
        }
        echo $command;
        return $this;
    }

    /**
     * This won't _actually_ change the current working directory, but instead
     * append `cd $dir` calls to the commands array.
     *
     * @param string|null $dir
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     */
    public function chdir(string $dir = null) : Executable
    {
        if (isset($dir)) {
            $this->commands[] = "cd $dir";
        } else {
            $this->commands[] = "cd {$this->originalPath}";
        }
        return $this;
    }

    /**
     * Get all commands run.
     *
     * @return array
     */
    public function getCommands() : array
    {
        return $this->commands;
    }

    /**
     * Flush the command buffer.
     *
     * @return array The commands run so far, resetting to an empty array
     *  afterwards.
     */
    public function flush() : array
    {
        $commands = $this->commands;
        $this->commands = [];
        return $commands;
    }

    /**
     * Set the returnVar to success.
     *
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     */
    public function succeeds() : Executable
    {
        $this->returnVar = 0;
        return $this;
    }

    /**
     * Set the returnVar to an error. The default error is 1, but a custom one
     * may be supplied.
     *
     * @param int $returnVar Optional; defaults to 1.
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @throws DomainException for an invalid error code.
     */
    public function fails(int $returnVar = 1) : Executable
    {
        if ($returnVar < 1) {
            throw new DomainException("\$returnVar must be a positive integer");
        }
        $this->returnVar = $returnVar;
        return $this;
    }
}

