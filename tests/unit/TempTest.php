<?php


namespace Fuel\Asset;

use Codeception\TestCase\Test;

class TempTest extends Test
{

	public function testFake()
	{
		$obj = new Temp;
		$this->assertTrue($obj->returnTrue());
	}

}
