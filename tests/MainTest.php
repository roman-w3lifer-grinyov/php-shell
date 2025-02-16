<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use w3lifer\PhpShell\PhpShell;

final class MainTest extends TestCase
{
    public function testAsk(): void
    {
        $phpShell = new PhpShell();
        $this->assertEquals(4, $phpShell->ask('2 + 2 ='));
    }

    public function testExec(): void
    {
        $phpShell = new PhpShell();
        $command = 'date "+%Y-%m-%d"';
        $date = date('Y-m-d');
        $this->assertEquals(
            ['resultCode' => 0, 'output' => [$date], 'lastLineOfOutput' => $date],
            $phpShell->exec($command)
        );
    }

    public function testShell_exec(): void
    {
        $phpShell = new PhpShell();
        $this->assertEquals(
            date('Y-m-d') . "\n",
            $phpShell->shell_exec('date "+%Y-%m-%d"')
        );
    }

    public function testSystem(): void
    {
        $phpShell = new PhpShell();
        $this->assertEquals(
            ['resultCode' => 0, 'lastLineOfOutput' => date('Y-m-d') . "\n"],
            $phpShell->system('date "+%Y-%m-%d"')
        );
    }

    public function testGetArgument(): void
    {
        $phpShell = new PhpShell();
        $this->assertEquals('vendor/bin/phpunit', $phpShell->getArgument(0));
        $this->assertEquals('--color=always', $phpShell->getArgument(1));
        $this->assertEquals('tests/MainTest.php', $phpShell->getArgument(2));
    }
}
