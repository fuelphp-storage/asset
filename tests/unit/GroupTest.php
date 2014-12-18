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
		$this->group = new Group([]);
	}

	public function testAddFiles()
	{
		$files = ['a.css', 'b.css'];

		$this->group->setFiles($files);

		$this->assertEquals(
			$files,
			$this->group->getFiles()
		);
	}

	public function testAddFile()
	{
		$file = 'a.css';

		$this->group->addFile($file);

		$this->assertEquals(
			[$file],
			$this->group->getFiles()
		);
	}

	public function testMergeFileList()
	{
		$files1 = ['a.css'];
		$files2 = ['b.css'];

		$this->group->addFiles($files1);

		$this->assertEquals(
			$files1,
			$this->group->getFiles()
		);

		$this->group->addFiles($files2);

		$this->assertEquals(
			['a.css', 'b.css'],
			$this->group->getFiles()
		);
	}

}
