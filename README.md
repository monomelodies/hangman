# monomelodies/hangman
Wrapper for executing commands, including support for dry runs (e.g. during unit
tests).

## Installation
Composer (recommended):

```sh
$ composer require monomelodies/hangman
```

## Usage
Hangman provides two "executioners": the actual `Executioner` and a
`FakeExecutioner` which will simply collect commands for further inspection:

```php
<?php

use Monomelodies\Hangman\{ Executioner, FakeExecutioner, Executable };

function setExecutioner() : Executable
{
    if (shouldActuallyRunCommands()) {
        $executioner = new Executioner;
    } else {
        $executioner = new FakeExecutioner;
    }
    return $executioner;
}

$executioner = setExecutioner();
$executioner->exec('some/command');
```

As you can see, the `Executable` interface can be used for type hinting.

## Methods
Both the real as well as the fake executioner support 5 methods:

- `exec`
- `passthru`
- `shellExec`
- `system`
- `chdir`

These work (almost) identical to their PHP counterparts, except they can be
_chained_:

```php
<?php

$executioner
    ->exec('ls')
    ->passthru('ls')
    ->chdir('some/path')
    ->system('ls')
    ->chdir();
```

## Fake executioner
The fake executioner (meant to be used during testing) supports some additional
methods:

- `succeeds` - force a command to succeed (the default)
- `fails([int $error = 1])` - force a command to fail
- `getCommands` - return the list of "executed" commands
- `flush` - like `getCommands`, but also resets the list to an empty array

Commands "executed" by the fake executioner are wrapped in the `Command` class.

