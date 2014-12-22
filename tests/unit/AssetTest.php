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
		$this->asset = new Asset('');
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

	public function testBaseURL()
	{
		$name = 'foobar';
		$_SERVER['SERVER_NAME'] = $name;
		$asset = new Asset('', null);

		$this->assertEquals(
			$name,
			$asset->getBaseURL()
		);

		$asset = new Asset('', $name);
		$this->assertEquals(
			$name,
			$asset->getBaseURL()
		);

		$asset = new Asset('');
		$asset->setBaseURL($name);
		$this->assertEquals(
			$name,
			$asset->getBaseURL()
		);
	}

	public function testDocroot()
	{
		$name = 'foobar';
		$asset = new Asset($name);

		$this->assertEquals(
			$name,
			$asset->getDocroot()
		);

		$newName = 'bazbat';
		$asset->setDocroot($newName);

		$this->assertEquals(
			$newName,
			$asset->getDocroot()
		);
	}

	public function testGetSingleCss()
	{
		$this->asset->setBaseURL('test.com');
		$this->asset->setDocroot(__DIR__.'/../_output/docroot');
		$this->asset->addPath(__DIR__.'/../resources');

		$this->asset->addFile('a.css', 'css');

		$this->assertXmlStringEqualsXmlString(
			'<link rel="stylesheet" type="text/css" href="//test.com/css/a.css" />',
			$this->asset->get('css')
		);
	}

}
