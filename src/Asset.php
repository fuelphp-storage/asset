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

use Fuel\FileSystem\Finder;
use IndexOutOfBoundsException;

/**
 * Central point for managing assets.
 *
 * @package Fuel\Asset
 */
class Asset
{

	/**
	 * Contains our known groups, indexed by asset type then name.
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

	/**
	 * Contains the path to our web root, this is where all asset files should be placed for serving
	 *
	 * @var string
	 */
	protected $docroot;

	/**
	 * Contains the base URL of the site, this will be automatically detected if not set.
	 */
	protected $baseURL;

	/**
	 * Contains the Finder instance used to locate asset files with.
	 *
	 * @var Finder
	 */
	protected $finder;

	/**
	 * Contains a list of asset type processors
	 * @var AbstractType[]
	 */
	protected $types = [];

	/**
	 * @param string $docroot
	 * @param string $baseURL
	 */
	public function __construct($docroot, $baseURL = null, Finder $finder = null)
	{
		if ($finder === null)
		{
			$finder = new Finder;
		}

		$this->finder = $finder;

		$this->docroot = $docroot;
		$this->groups['css'][$this->defaultGroupName] = new Group([]);
		$this->groups['js'][$this->defaultGroupName] = new Group([]);

		if ($baseURL === null)
		{
			$baseURL = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '' ;
		}

		$this->baseURL = $baseURL;

		$this->types = [
			'js' => 'Fuel\Asset\Type\Js',
			'css' => 'Fuel\Asset\Type\Css',
		];
	}

	/**
	 * Gets an instance of AbstractType for the given type.
	 *
	 * @param string $name
	 *
	 * @return AbstractType
	 *
	 * @since 2.0
	 */
	public function getType($name)
	{
		if ( ! isset($this->types[$name]))
		{
			throw new IndexOutOfBoundsException("ASS-002: [$name] is not a known asset type.");
		}

		$type = $this->types[$name];

		if (is_string($type))
		{
			$this->types[$name] = new $type;
		}

		return $this->types[$name];
	}

	/**
	 * Adds or replaces a type.
	 *
	 * @param string $name  Simple identifier
	 * @param string $class FQCN or instance of AbstractType
	 *
	 * @since 2.0
	 */
	public function setType($name, $class)
	{
		$this->types[$name] = $class;
	}

	/**
	 * Adds a path that contains asset files
	 *
	 * @param string $path
	 */
	public function addPath($path)
	{
		$this->finder->addPath($path);
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
			throw new IndexOutOfBoundsException('ASS-001: Unknown group ['.$group.'] for ['.$type.']');
		}

		return $this->groups[$type][$group];
	}

	/**
	 * @return string
	 */
	public function getDocroot()
	{
		return $this->docroot;
	}

	/**
	 * @param string $docroot
	 */
	public function setDocroot($docroot)
	{
		$this->docroot = $docroot;
	}

	/**
	 * @return mixed
	 */
	public function getBaseURL()
	{
		return $this->baseURL;
	}

	/**
	 * @param mixed $baseURL
	 */
	public function setBaseURL($baseURL)
	{
		$this->baseURL = $baseURL;
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
		$group = $this->getGroup($type, $groupName);

		$typeInstance = $this->getType($type);

		// TODO: move file path fetching into filers so pre-processing can happen
		$tags = '';

		foreach ($group->getFiles() as $file)
		{
			// Get the path of the file
			$filePath = $this->finder->find($type.'/'.$file);

			// Copy that to our output directory if needed
			$outputDir = $this->docroot.'/'.$type;
			if ( ! is_dir($outputDir))
			{
				mkdir($outputDir, 0777, true);
			}

			copy($filePath, $outputDir.'/'.$file);

			// Build the html tag
			$tags .= $typeInstance->wrapFile("//{$this->baseURL}/$type/$file");
		}

		return $tags;
	}

}
