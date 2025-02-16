<?php

declare(strict_types=1);

namespace w3lifer\PhpShell;

class PhpShell
{
    private array $argv;

    public string $hostname = '';

    public string $user = '';

    public string $home = '';

    public string $separator = '--------------------------------------------------------------------------------';

    public function __construct(array $config = [])
    {
        global $argv;
        $this->argv = $argv;
        $this->hostname = exec('hostname');
        $this->user = exec('echo -n $USER');
        $this->home = exec('echo -n $HOME');
    }

    /**
     * @see https://ru.stackoverflow.com/q/800670/201026
     */
    public function ask(string $question): string
    {
        fwrite(STDOUT, $question . ' '); // [!] `fwrite` instead of `echo` is required for output when running tests
        // Underscore is necessary for the case, when the ID starts with a digit
        $uniqueId = '_' . uniqid();
        return exec('read ' . $uniqueId . '; echo -n ${' . $uniqueId . '}');
    }

    /**
     * @return array{resultCode: int, output: string[], lastLineOfOutput: string}
     */
    public function exec(string $command, bool $printCommand = false): array
    {
        $printCommand && $this->printLine($command);
        $lastLineOfOutput = exec($command, $output, $resultCode);
        return compact('resultCode', 'output', 'lastLineOfOutput');
    }

    /**
     * @return false|null|string Complete output
     */
    public function shell_exec(string $command, bool $printCommand = false): false|null|string
    {
        $printCommand && $this->printLine($command);
        return shell_exec($command);
    }

    /**
     * @return array{resultCode: string, lastLineOfOutput: string}
     */
    public function system(string $command, bool $printCommand = false): array
    {
        $printCommand && $this->printLine($command);
        $lastLineOfOutput = system($command, $resultCode);
        return compact('resultCode', 'lastLineOfOutput');
    }

    public function printLine(string $line): void
    {
        // [!] `fwrite` instead of `echo` is required for output when running tests
        fwrite(STDOUT, $line . "\n");
    }

    public function printTitle(string $title): void
    {
        $this->printLine($this->separator);
        $this->printLine($title);
        $this->printLine($this->separator);
    }

    public function getArgument(int $sequentialNumber): string
    {
        return $this->argv[$sequentialNumber] ?? '';
    }
}
