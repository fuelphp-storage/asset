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
 * Defines a group of assets.
 *
 * @package Fuel\Asset
 * @since   2.0
 */
class Group
{

	/**
	 * Contains our file paths.
	 * Can be individual files or globs.
	 *
	 * @var array
	 */
	protected $paths = [];

	/**
	 * Adds a new path to the group.
	 *
	 * @param string $path
	 *
	 * @since 2.0
	 */
	public function addPath($path)
	{
		$this->paths[] = $path;
	}

	/**
	 * Gets the group's registered paths.
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function getPaths()
	{
		return $this->paths;
	}

}
