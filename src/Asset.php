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

use IndexOutOfBoundsException;

/**
 * Central point for managing assets.
 *
 * @package Fuel\Asset
 */
class Asset
{

	/**
	 * Contains known asset types.
	 *
	 * @var Type[]
	 */
	protected $types = [];

	/**
	 * Contains our known groups, indexed by asset type.
	 *
	 * @var Group[][]
	 */
	protected $groups = [];

	/**
	 * Name of the default asset groups.
	 *
	 * @var string
	 */
	protected $defaultGroupName = '__default__';

	public function __construct()
	{
		$this->groups['css'][$this->defaultGroupName] = new Group([]);
		$this->groups['js'][$this->defaultGroupName] = new Group([]);
	}

	/**
	 * Adds an asset type.
	 *
	 * @param string $name
	 * @param Type   $type
	 *
	 * @since 2.0
	 */
	public function addType($name, Type $type)
	{
		$this->types[$name] = $type;
	}

	/**
	 * Gets information on an asset type.
	 *
	 * @param string $name
	 *
	 * @return Type
	 *
	 * @since 2.0
	 *
	 * @throws IndexOutOfBoundsException
	 */
	public function getType($name)
	{
		if ( ! isset($this->types[$name]))
		{
			throw new IndexOutOfBoundsException("ASS-001: Unknown asset type: [$name]");
		}

		return $this->types[$name];
	}

	/**
	 * Gets all known asset type definitions.
	 *
	 * @return Type[]
	 *
	 * @since 2.0
	 */
	public function getTypes()
	{
		return $this->types;
	}

	/**
	 * Add a file to the given group.
	 *
	 * @param string $file  Name of the file to add.
	 * @param string $type  Type of file that is being added, css, js, etc.
	 * @param string $group Optional name of the group to add to, if none specified the default group will be used.
	 *
	 * @since 2.0
	 */
	public function addFile($file, $type, $group = null)
	{
		$this->getGroup($type, $group)
			->addFile($file);
	}

	/**
	 * Adds multiple files to the given group.
	 *
	 * @param string $files Names of the files to add.
	 * @param string $type  Type of file that is being added, css, js, etc.
	 * @param string $group Optional name of the group to add to, if none specified the default group will be used.
	 *
	 * @since 2.0
	 */
	public function addFiles($files, $type, $group = null)
	{
		$this->getGroup($type, $group)
			->addFiles($files);
	}

	/**
	 * Gets an asset group.
	 *
	 * @param string $type
	 * @param string $group
	 *
	 * @return Group
	 *
	 * @since 2.0
	 *
	 * @throws IndexOutOfBoundsException
	 */
	public function getGroup($type, $group = null)
	{
		if ($group === null)
		{
			$group = $this->defaultGroupName;
		}

		if ( ! isset($this->groups[$type][$group]))
		{
			throw new IndexOutOfBoundsException('ASS-002: unknown group ['.$group.'] for ['.$type.']');
		}

		return $this->groups[$type][$group];
	}

	/**
	 * Gets the HTML to insert the assets of the given type and groupName.
	 *
	 * @param string $type      Type of asset to fetch
	 * @param string $groupName Optional groupName name to fetch
	 *
	 * @since 2.0
	 */
	public function get($type, $groupName = null)
	{
	}

	// Types of asset
		// Has extension
		// Assign processors to types
			// Caching of processed files

	// Files
	// Folders
	// Remote

	// Groups
		// One type
		// Dependencies

	// Output
		// Group
		// single file


	// Flow

	// Take a list of groups
	// Work out the order to load them in
	// Work out a list of files from the sorted groups
	// Process the files in the groupName
	// save that somewhere
}
