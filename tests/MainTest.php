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
        // $this->assertEquals(date('Y-m-d'), $phpShell->exec('date "+%Y-%m-%d"', true)->lastLineOfOutput);
    }
}
