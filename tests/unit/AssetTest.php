<?php
/**
 * @package Fuel\Asset
 * @version 2.0
 * @author Fuel Development Team
 * @license MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link http://fuelphp.com
 */

namespace Fuel\Asset;

use Codeception\TestCase\Test;
use IndexOutOfBoundsException;

class AssetTest extends Test
{

	/**
	 * @var Asset
	 */
	protected $asset;

	protected function _before()
	{
		$this->asset = new Asset;
	}

	public function testGroupAddAndGet()
	{
		$name = 'test';
		$group = new Group;

		$this->asset->addGroup($group, $name);

		$this->assertEquals(
			$group,
			$this->asset->getGroup($name)
		);

		$this->assertContains(
			$group,
			$this->asset->getGroups()
		);
	}

	/**
	 * @expectedException IndexOutOfBoundsException
	 */
	public function testGetInvalidGroup()
	{
		$this->asset->getGroup('not here');
	}

	public function testTypeAddAndGet()
	{
		$name = 'css';
		$type = new Type;

		$this->asset->addType($name, $type);

		$this->assertEquals(
			$type,
			$this->asset->getType($name)
		);

		$this->assertContains(
			$type,
			$this->asset->getTypes()
		);
	}

	/**
	 * @expectedException IndexOutOfBoundsException
	 */
	public function testGetInvalidType()
	{
		$this->asset->getType('not here');
	}

}
