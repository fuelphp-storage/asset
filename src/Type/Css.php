<?php
/**
 * @package Fuel\Asset
 * @version 2.0
 * @author Fuel Development Team
 * @license MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link http://fuelphp.com
 */

namespace Fuel\Asset\Type;

use Fuel\Asset\AbstractType;

/**
 * Deals with css assets
 *
 * @package Fuel\Asset\Type
 */
class Css extends AbstractType
{

	/**
	 * {@inheritdoc}
	 */
	public function wrapFile($file)
	{
		return '<link rel="stylesheet" type="text/css" href="'.$file.'" />';
	}

}
