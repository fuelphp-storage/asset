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

/**
 * Tests for main asset class
 */
class AssetTest extends Test
{
	private $docroot;

	/**
	 * @var Asset
	 */
	protected $asset;

	protected function _before()
	{
		$this->docroot = __DIR__ . '/../_output/docroot';
		$this->asset = new Asset('');

		$this->asset->setBaseURL('test.com');
		$this->asset->setDocroot($this->docroot);
		$this->asset->addPath(__DIR__.'/../resources');
	}

	protected function _after()
	{
		$rmdir = function($dir) use (&$rmdir)
		{
			foreach (scandir($dir) as $item)
			{
				if ($item == '.' || $item == '..')
				{
					continue;
				}
				$path = $dir . DIRECTORY_SEPARATOR . $item;
				if (is_dir($path))
				{
					$rmdir($path);
					continue;
				}
				unlink($path);
			}
			rmdir($dir);
		};

		if (is_dir($this->docroot))
		{
			$rmdir($this->docroot);
		}
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
		$this->asset->addFile('a.css', 'css');

		$this->assertXmlStringEqualsXmlString(
			'<link rel="stylesheet" type="text/css" href="//test.com/css/a.css" />',
			$this->asset->get('css')
		);
	}

	public function testGetMultipleCss()
	{
		$this->asset->addFile('a.css', 'css');
		$this->asset->addFile('b.css', 'css');

		$this->assertEquals(
			'<link rel="stylesheet" type="text/css" href="//test.com/css/a.css" />'.
			'<link rel="stylesheet" type="text/css" href="//test.com/css/b.css" />',
			$this->asset->get('css')
		);
	}

	public function testGetSingleJS()
	{
		$this->asset->addFile('a.js', 'js');

		$this->assertXmlStringEqualsXmlString(
			'<script type="text/javascript" src="//test.com/js/a.js"></script>',
			$this->asset->get('js')
		);
	}

	public function testGetAndSetType()
	{
		$this->assertInstanceOf(
			'Fuel\Asset\Type\Js',
			$this->asset->getType('js')
		);

		$this->assertInstanceOf(
			'Fuel\Asset\Type\Css',
			$this->asset->getType('css')
		);

		$this->asset->setType('test', 'stdClass');

		$this->assertInstanceOf(
			'stdClass',
			$this->asset->getType('test')
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
