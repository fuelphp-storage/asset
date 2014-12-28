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
 * Common functionality for dealing with asset types
 *
 * @package Fuel\Asset
 */
abstract class AbstractType
{

	/**
	 * Wrap the file in html to be able to display/include it.
	 *
	 * @param string $file
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public abstract function wrapFile($file);

}
