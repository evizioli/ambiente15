<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormDelete represents a delete widget for an embedded object form
 *
 * @package    symfony
 * @subpackage widget
 * @author     Francois Zaninotto
 */
class sfWidgetFormDeleteX extends sfWidgetFormInputHidden
{
	public function render($name, $value = null, $attributes = array(), $errors = array())
	{
		return '';
	}
}
