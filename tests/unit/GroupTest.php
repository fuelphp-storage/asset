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

class GroupTest extends Test
{

	/**
	 * @var Group
	 */
	protected $group;

	protected function _before()
	{
		$this->group = new Group;
	}

	public function testAddAndGetPath()
	{
		$path = 'foo/bar/baz/bat';

		$this->group->addPath($path);

		$this->assertContains(
			$path,
			$this->group->getPaths()
		);
	}

}
