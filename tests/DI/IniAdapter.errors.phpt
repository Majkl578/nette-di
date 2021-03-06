<?php

/**
 * Test: Nette\DI\Config\Adapters\IniAdapter errors.
 */

use Nette\DI\Config;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


Assert::exception(function () {
	$config = new Config\Loader;
	$config->load('files/iniAdapter.scalar1.ini');
}, 'Nette\InvalidStateException', "Invalid section [scalar.set] in file '%a%'.");


Assert::exception(function () {
	$config = new Config\Loader;
	$config->load('files/iniAdapter.scalar2.ini');
}, 'Nette\InvalidStateException', "Invalid key 'date.timezone' in section [set] in file '%a%'.");


Assert::exception(function () {
	$config = new Config\Loader;
	$config->load('files/iniAdapter.malformed.ini');
}, 'Nette\InvalidStateException', "%a?%syntax error, unexpected \$end, expecting ']' in %a% on line 1");
