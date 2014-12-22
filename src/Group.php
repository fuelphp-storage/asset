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

/**
 * Defines a collection of asset files.
 *
 * @package Fuel\Asset
 */
class Group
{

	/**
	 * Contains the group's files
	 *
	 * @var array
	 *
	 * @since 2.0
	 */
	protected $files;

	public function __construct($files = [])
	{
		$this->files = $files;
	}

	/**
	 * @return array
	 *
	 * @since 2.0
	 */
	public function getFiles()
	{
		return $this->files;
	}

	/**
	 * @param array $files
	 *
	 * @since 2.0
	 */
	public function setFiles($files)
	{
		$this->files = $files;
	}

	/**
	 * @param $file
	 *
	 * @since 2.0
	 */
	public function addFile($file)
	{
		$this->files[] = $file;
	}

	/**
	 * @param $files
	 *
	 * @since 2.0
	 */
	public function addFiles($files)
	{
		$this->files = array_merge($this->files, $files);
	}

}
