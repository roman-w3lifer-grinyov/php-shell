# [php-shell](https://packagist.org/packages/w3lifer/php-shell)

- [Installation](#installation)
- [Usage](#usage)
  - [Methods](#methods)
- [Tests](#tests)

## Installation

``` sh
composer require w3lifer/php-shell
```

## Usage

### Methods

- `public function ask(string $question): string`
- `public function exec(string $command, bool $printCommand = false): array`
- `public function shell_exec(string $command, bool $printCommand = false): false|null|string`
- `public function system(string $command, bool $printCommand = false): array`
- `public function printLine(string $line): void`
- `public function printTitle(string $title): void`
- `public function getArgument(int $sequentialNumber): string`

## Tests

``` sh
make tests
```
