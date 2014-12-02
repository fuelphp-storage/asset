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
	 * Contains groups of assets.
	 *
	 * @var Group[]
	 */
	protected $groups = [];

	/**
	 * Name of our default group.
	 *
	 * @var string
	 */
	protected $defaultGroupName = '__default__';

	public function __construct()
	{
		$this->types[$this->defaultGroupName] = new Group;
	}

	/**
	 * Adds a new group of assets.
	 *
	 * @param Group  $group
	 * @param string $name
	 *
	 * @since 2.0
	 */
	public function addGroup(Group $group, $name)
	{
		$this->groups[$name] = $group;
	}

	/**
	 * Gets a group by name.
	 *
	 * @param string $name
	 *
	 * @return Group
	 *
	 * @since  2.0
	 *
	 * @throws IndexOutOfBoundsException
	 */
	public function getGroup($name)
	{
		if ( ! isset($this->groups[$name]))
		{
			throw new IndexOutOfBoundsException("ASS-001: Unknown group name: [$name]");
		}

		return $this->groups[$name];
	}

	/**
	 * Gets all groups.
	 *
	 * @return Group[]
	 *
	 * @since 2.0
	 */
	public function getGroups()
	{
		return $this->groups;
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
			throw new IndexOutOfBoundsException("ASS-002: Unknown asset type: [$name]");
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
	 * Gets the HTML to insert the assets of the given type and group.
	 *
	 * @param string $type  Type of asset to fetch
	 * @param string $group Optional group name to fetch
	 *
	 * @since 2.0
	 */
	public function get($type, $group = null)
	{
		// Work out our group list

		// get the list of files from the groups

		// Pass the groups through any of the filters defined in the type

		// Write out to the cache if enabled

			// IF cache enabled
				// Output single asset
			// ELSE
				// Output for each file needed
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
	// Process the files in the group
	// save that somewhere
}
