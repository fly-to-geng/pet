<?php
/**
 * @package    FrameworkOnFramework
 * @copyright  Copyright (C) 2010 - 2012 Akeeba Ltd. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// Protect from unauthorized access
defined('_JEXEC') or die();

if (!class_exists('JFormFieldTel'))
{
	require_once JPATH_LIBRARIES . '/joomla/form/fields/tel.php';
}

/**
 * Form Field class for the FOF framework
 * Supports a URL text field.
 *
 * @since       2.0
 */
class FOFFormFieldTel extends JFormFieldTel implements FOFFormField
{

	protected $static;
	protected $repeatable;

	/**
	 * Method to get certain otherwise inaccessible properties from the form field object.
	 *
	 * @param   string  $name  The property name for which to the the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   2.0
	 */
	public function __get($name)
	{
		switch ($name)
		{
			case 'static':
				if (empty($this->static))
				{
					$this->static = $this->getStatic();
				}

				return $this->static;
				break;

			case 'repeatable':
				if (empty($this->repeatable))
				{
					$this->repeatable = $this->getRepeatable();
				}

				return $this->static;
				break;

			default:
				return parent::__get($name);
		}
	}

	/**
	 * Get the rendering of this field type for static display, e.g. in a single
	 * item view (typically a "read" task).
	 *
	 * @since 2.0
	 */
	public function getStatic()
	{
		$class = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$dolink = $this->element['show_link'] == 'true';
		$empty_replacement = '';
		if ($this->element['empty_replacement'])
		{
			$empty_replacement = (string) $this->element['empty_replacement'];
		}

		if (!empty($empty_replacement) && empty($this->value))
		{
			$this->value = JText::_($empty_replacement);
		}

		$innerHtml = htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8');

		if ($dolink)
		{
			$innerHtml = '<a href="tel:' . $innerHtml . '">' .
				$innerHtml . '</a>';
		}

		return '<span id="' . $this->id . '" ' . $class . '>' .
			$innerHtml .
			'</span>';
	}

	/**
	 * Get the rendering of this field type for a repeatable (grid) display,
	 * e.g. in a view listing many item (typically a "browse" task)
	 *
	 * @since 2.0
	 */
	public function getRepeatable()
	{
		// Initialise
		$class = '';
		$show_link = false;
		$empty_replacement = '';

		$link_url = 'tel:' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8');

		// Get field parameters
		if ($this->element['class'])
		{
			$class = ' class="' . (string) $this->element['class'] . '"';
		}
		if ($this->element['show_link'] == 'true')
		{
			$show_link = true;
		}

		if ($this->element['empty_replacement'])
		{
			$empty_replacement = (string) $this->element['empty_replacement'];
		}

		// Get the (optionally formatted) value
		if (!empty($empty_replacement) && empty($this->value))
		{
			$this->value = JText::_($empty_replacement);
		}
		$value = htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8');

		// Create the HTML
		$html = '<span id="' . $this->id . '" ' . $class . '>';

		if ($show_link)
		{
			$html .= '<a href="' . $link_url . '">';
		}

		$html .= $value;

		if ($show_link)
		{
			$html .= '</a>';
		}

		$html .= '</span>';
		return $html;
	}

}
