<?php

declare(strict_types=1);

namespace w3lifer\PhpShell;

use stdClass;

class PhpShell
{
    public string $hostname = '';

    public string $user = '';

    public string $home = '';

    private string $separator = '--------------------------------------------------------------------------------' . "\n";

    private array $argv = [];

    public function __construct(array $config = [])
    {
        global $argv;
        $this->argv = $argv;
        $this->hostname = exec('hostname');
        $this->user = exec('echo -n $USER');
        $this->home = exec('echo -n $HOME');
        if (isset($config['separator'])) {
            $this->separator = $config['separator'];
        }
    }

    /**
     * @see https://ru.stackoverflow.com/q/800670/201026
     */
    public function ask(string $question): string
    {
        fwrite(STDOUT, $question . ' ');
        // Underscore is necessary for the case, when the ID starts with a digit
        $uniqueId = '_' . uniqid();
        return exec('read ' . $uniqueId . '; echo -n ${' . $uniqueId . '}');
    }

    /**
     * @return stdClass Object
     * (
     *   [status] => int
     *   [completeOutput] => array
     *   [lastLineOfOutput] => string
     * )
     */
    public function exec(string $command, bool $printCommand = false): stdClass
    {
        if ($printCommand) {
            fwrite(STDOUT, $command);
        }
        $lastLineOfOutput = exec($command, $completeOutput, $status);
        return (object) compact('status', 'completeOutput', 'lastLineOfOutput');
    }

    public function getArgument(int $sequentialNumber): string
    {
        return $this->argv[$sequentialNumber] ?? '';
    }

    /**
     * @return string Complete output
     */
    public function shell_exec(string $command, bool $printCommand = false): string
    {
        if ($printCommand) {
            echo $command . "\n";
        }
        return shell_exec($command);
    }

    /**
     *
     * @return stdClass Object
     * (
     *   [status] => int
     *   [lastLineOfOutput] => string
     * )
     */
    public function system(string $command, bool $printCommand = false): stdClass
    {
        if ($printCommand) {
            echo $command . "\n";
        }
        $lastLineOfOutput = system($command, $status);
        return (object) compact('status', 'lastLineOfOutput');
    }

    public function printSeparator(): void
    {
        echo $this->separator;
    }

    public function printTitle(string $title): void
    {
        echo $this->separator;
        echo $title . "\n";
        echo $this->separator;
    }
}
