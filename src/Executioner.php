<?php

namespace Monomelodies\Hangman;

/**
 * The Executioner - this will actually run commands.
 */
class Executioner implements Executable
{
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
     * @param string $command
     * @param array|null &$output
     * @param int|null &$returnVar
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.exec.php
     */
    public function exec(string $command, array &$output = null, int &$returnVar = null) : Executable
    {
        exec($command, $output, $returnVar);
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
        passthru($command, $returnVar);
        return $this;
    }

    /**
     * @param string $command
     * @param string|null &$output
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.shell-exec.php
     */
    public function shellExec(string $command, string &$output = null) : Executable
    {
        if (isset($output)) {
            $output = shell_exec($command);
        } else {
            shell_exec($command);
        }
        return $this;
    }

    /**
     * @param string $command
     * @param int|null &$returnVar
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.system.php
     */
    public function system(string $command, int &$returnVar = null) : Executable
    {
        system($command, $returnVar);
        return $this;
    }

    public function chdir(string $dir = null) : Executable
    {
        chdir($dir ?? $this->originalPath);
        return $this;
    }
}

