<?php

/**
 * Test: Nette\DI\ContainerBuilder and rich syntax.
 */

use Nette\DI;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


class Factory
{
	/** @return Obj */
	function create()
	{
		return new Obj;
	}

	function mark(Obj $obj)
	{
		$obj->mark = TRUE;
	}
}

class Obj
{
	/** @return Obj */
	function foo($arg)
	{
		$this->args[] = $arg;
		return $this;
	}
}


$builder = new DI\ContainerBuilder;
$one = $builder->addDefinition('one')
	->setFactory([new DI\Statement('Factory'), 'create'])
	->addSetup([new DI\Statement('Factory'), 'mark'], ['@self']);

$two = $builder->addDefinition('two')
	->setFactory([new DI\Statement([$one, 'foo'], [1]), 'foo'], [2]);


$container = createContainer($builder);

Assert::same('Obj', $one->getClass());
Assert::type('Obj', $container->getService('one'));
Assert::true($container->getService('one')->mark);

Assert::same('Obj', $two->getClass());
Assert::type('Obj', $container->getService('two'));
Assert::true($container->getService('two')->mark);
Assert::same([1, 2], $container->getService('two')->args);
