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
 * Deals with js assets
 *
 * @package Fuel\Asset\Type
 */
class Js extends AbstractType
{

	/**
	 * {@inheritdoc}
	 */
	public function wrapFile($file)
	{
		return '<script type="text/javascript" src="'.$file.'"></script>';
	}

}
