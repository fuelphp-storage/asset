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

	/**
	 * @expectedException IndexOutOfBoundsException
	 */
	public function testGetInvalidGroup()
	{
		$this->asset->getGroup('css', 'not here');
	}

	/**
	 * @expectedException IndexOutOfBoundsException
	 */
	public function testGetInvalidGroupWithInvalidType()
	{
		$this->asset->getGroup('not a valid type', 'not here');
	}

	public function testAddFileToDefaultGroup()
	{
		$file = 'test.css';

		$this->asset->addFile($file, 'css');

		$this->assertEquals(
			[$file],
			$this->asset->getGroup('css')->getFiles()
		);
	}

	public function testAddMultipleFilesToDefaultGroup()
	{
		$files = ['test.css', 'a.css'];

		$this->asset->addFiles($files, 'css');

		$this->assertEquals(
			$files,
			$this->asset->getGroup('css')->getFiles()
		);
	}

}
