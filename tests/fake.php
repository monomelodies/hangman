<?php

use Monomelodies\Hangman\{ FakeExecutioner, Executable };

/** Tests for the actual executioner. */
return function () : Generator {
    $executioner = new FakeExecutioner;

    /** Calling exec on a fake executioner gives the expected output using all parameters. */
    yield function () use ($executioner) : void {
        $output = [];
        $returnVar = -1;
        $executioner->exec('ls', $output, $returnVar);
        assert($returnVar === 0);
        assert(count($output) === 1);
        assert($output[0] === 'ls');
    };

    /** Calling exec on a fake executioner w/o returnVar gives the expected output. */
    yield function () use ($executioner) : void {
        $output = [];
        $executioner->exec('ls', $output);
        assert(count($output) === 1);
        assert($output[0] === 'ls');
    };

    /** Calling exec with just a command gives the expected output. */
    yield function () use ($executioner) : void {
        $result = $executioner->exec('ls');
        assert($result instanceof FakeExecutioner);
        assert($result instanceof Executable);
    };

    /** Calling passthru on a fake executioner gives the expected output using all parameters. */
    yield function () use ($executioner) : void {
        $returnVar = -1;
        ob_start();
        $executioner->passthru('ls', $returnVar);
        $output = ob_get_clean();
        assert($output === 'ls');
        assert($returnVar === 0);
    };

    /** Calling passthru on a fake executioner w/o returnVar gives the expected output. */
    yield function () use ($executioner) : void {
        ob_start();
        $executioner->passthru('ls');
        $output = ob_get_clean();
        assert($output === 'ls');
    };

    /** Calling shellExec on a fake executioner places the complete output in $output. */
    yield function () use ($executioner) : void {
        $output = '';
        $executioner->shellExec('ls', $output);
        assert($output === 'ls');
    };

    /** Calling system on a fake executioner gives the expected output using all parameters. */
    yield function () use ($executioner) : void {
        $returnVar = -1;
        ob_start();
        $executioner->system('ls', $returnVar);
        $output = ob_get_clean();
        assert($output === 'ls');
        assert($returnVar === 0);
    };

    /** Calling system on a fake executioner w/o returnVar gives the expected output. */
    yield function () use ($executioner) : void {
        ob_start();
        $executioner->system('ls');
        $output = ob_get_clean();
        assert($output === 'ls');
    };

    /** Using chdir, our actual path is unchanged but commands are added. */
    yield function () use ($executioner) : void {
        $executioner->flush();
        $path = getcwd();
        $executioner->chdir('src');
        assert(getcwd() === $path);
        $executioner->chdir();
        assert(getcwd() === $path);
        assert(count($executioner->getCommands()) === 2);
    };

    /** Using fails we can set a custom return var. */
    yield function () use ($executioner) : void {
        $returnVar = -1;
        $output = [];
        $executioner->fails(2)->exec('ls', $output, $returnVar);
        assert($returnVar === 2);
        $commands = $executioner->getCommands();
        $command = end($commands);
        assert("$command" === 'ls (2)');
    };
};

