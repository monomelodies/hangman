<?php

use Monomelodies\Hangman\{ Executioner, Executable };

/** Tests for the actual executioner. */
return function () : Generator {
    $executioner = new Executioner;

    /** Calling exec on an executioner gives the expected output using all parameters. */
    yield function () use ($executioner) : void {
        $output = [];
        $returnVar = -1;
        $executioner->exec('ls', $output, $returnVar);
        assert(count($output) === 8);
        assert($returnVar === 0);
    };

    /** Calling exec on an executioner w/o returnVar gives the expected output. */
    yield function () use ($executioner) : void {
        $output = [];
        $executioner->exec('ls', $output);
        assert(count($output) === 8);
    };

    /** Calling exec with just a command gives the expected output. */
    yield function () use ($executioner) : void {
        $result = $executioner->exec('ls');
        assert($result instanceof Executioner);
        assert($result instanceof Executable);
    };

    /** Calling passthru on an executioner gives the expected output using all parameters. */
    yield function () use ($executioner) : void {
        $returnVar = -1;
        ob_start();
        $executioner->passthru('ls', $returnVar);
        $output = explode("\n", ob_get_clean());
        assert(count($output) === 9); // Trailing newline
        assert($returnVar === 0);
    };

    /** Calling passthru on an executioner w/o returnVar gives the expected output. */
    yield function () use ($executioner) : void {
        ob_start();
        $executioner->passthru('ls');
        $output = explode("\n", ob_get_clean());
        assert(count($output) === 9); // Trailing newline
    };

    /** Calling shellExec on an executioner places the complete output in $output. */
    yield function () use ($executioner) : void {
        $output = '';
        $executioner->shellExec('ls', $output);
        $output = explode("\n", $output);
        assert(count($output) === 9); // Trailing newline
    };

    /** Calling system on an executioner gives the expected output using all parameters. */
    yield function () use ($executioner) : void {
        $returnVar = -1;
        ob_start();
        $executioner->system('ls', $returnVar);
        $output = explode("\n", ob_get_clean());
        assert(count($output) === 9); // Trailing newline
        assert($returnVar === 0);
    };

    /** Calling system on an executioner w/o returnVar gives the expected output. */
    yield function () use ($executioner) : void {
        ob_start();
        $executioner->system('ls');
        $output = explode("\n", ob_get_clean());
        assert(count($output) === 9); // Trailing newline
    };

    /** Using chdir, we can change _and_ restore the current working directory. */
    yield function () use ($executioner) : void {
        $path = getcwd();
        $executioner->chdir('src');
        assert(getcwd() === "$path/src");
        $executioner->chdir();
        assert(getcwd() === $path);
    };
};

