<?php
/**
 * @package    FrameworkOnFramework
 * @copyright  Copyright (C) 2010 - 2012 Akeeba Ltd. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// Protect from unauthorized access
defined('_JEXEC') or die();

if (!class_exists('JFormFieldLanguage'))
{
	require_once JPATH_LIBRARIES . '/joomla/form/fields/language.php';
}

/**
 * Form Field class for FOF
 * Available site languages
 *
 * @since       2.0
 */
class FOFFormFieldLanguage extends JFormFieldLanguage implements FOFFormField
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

	protected function getOptions()
	{
		$options = parent::getOptions();

		$noneoption = $this->element['none'] ? $this->element['none'] : null;
		if ($noneoption)
		{
			array_unshift($options, JHtml::_('select.option', '*', JText::_($noneoption)));
		}

		return $options;
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

		return '<span id="' . $this->id . '" ' . $class . '>' .
			htmlspecialchars(FOFFormFieldList::getOptionName($this->getOptions(), $this->value), ENT_COMPAT, 'UTF-8') .
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
		return $this->getStatic();
	}

}
