<?php

namespace Monomelodies\Hangman;

/**
 * The executable interface, for use in type hinting.
 */
interface Executable
{
    /**
     * @param string $command
     * @param array|null &$output
     * @param int|null &$returnVar
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.exec.php
     */
    public function exec(string $command, array &$output = null, int &$returnVar = null) : Executable;

    /**
     * @param string $command
     * @param int|null &$returnVar
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.passthru.php
     */
    public function passthru(string $command, int &$returnVar = null) : Executable;

    /**
     * @param string $command
     * @param string|null &$output
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.shell-exec.php
     */
    public function shellExec(string $command, string &$output = null) : Executable;

    /**
     * @param string $command
     * @param int|null &$returnVar
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     * @see https://www.php.net/manual/en/function.system.php
     */
    public function system(string $command, int &$returnVar = null) : Executable;

    /**
     * Change current working directory. When called without arguments, the
     * original working directory is restored.
     *
     * @param string|null $dir
     * @return Monomelodies\Hangman\Executable Itself, for chaining
     */
    public function chdir(string $dir = null) : Executable;
}

