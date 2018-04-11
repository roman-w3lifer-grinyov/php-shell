<?php

namespace w3lifer\phpShell;

class PhpShell
{
    /**
     * @var string
     */
    public $hostname;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $home;

    /**
     * @var string
     */
    private $separator =
        '----------------------------------------' .
        '----------------------------------------' .
        "\n";

    /**
     * @var array
     */
    private $argv;

    /**
     * @param array $config
     */
    public function __construct($config = [])
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
     * @param string $question
     * @return string
     * @see https://ru.stackoverflow.com/q/800670/201026
     */
    public function ask($question)
    {
        echo $question;
        // Underscore is necessary for the case, when the ID starts with a digit
        $uniqueId = '_' . uniqid();
        return exec('read ' . $uniqueId . '; echo -n ${' . $uniqueId . '}');
    }

    /**
     * @param string $command
     * @param bool   $printCommand
     * @return \stdClass Object
     *                   (
     *                     [status] => int
     *                     [completeOutput] => array
     *                     [lastLineOfOutput] => string
     *                   )
     */
    public function exec($command, $printCommand = false)
    {
        if ($printCommand) {
            echo $command . "\n";
        }
        $lastLineOfOutput = exec($command, $completeOutput, $status);
        return (object) compact('status', 'completeOutput', 'lastLineOfOutput');
    }

    /**
     * @param int $sequentialNumber
     * @return string
     */
    public function getArgument($sequentialNumber)
    {
        return
            isset($this->argv[$sequentialNumber])
                ? $this->argv[$sequentialNumber]
                : '';
    }

    /**
     * @param string $command
     * @param bool   $printCommand
     * @return string Complete output.
     */
    public function shell_exec($command, $printCommand = false)
    {
        if ($printCommand) {
            echo $command . "\n";
        }
        return shell_exec($command);
    }

    /**
     * @param string $command
     * @param bool   $printCommand
     * @return \stdClass Object
     *                   (
     *                     [status] => int
     *                     [lastLineOfOutput] => string
     *                   )
     */
    public function system($command, $printCommand = false)
    {
        if ($printCommand) {
            echo $command . "\n";
        }
        $lastLineOfOutput = system($command, $status);
        return (object) compact('status', 'lastLineOfOutput');
    }

    public function printSeparator()
    {
        echo $this->separator;
    }

    /**
     * @param string $title
     */
    public function printTitle($title)
    {
        echo $this->separator;
        echo $title . "\n";
        echo $this->separator;
    }
}
