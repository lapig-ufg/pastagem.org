<?php

/**
 * @version		$Id$
 * @author		JoomlaUX
 * @package		Joomla.Site
 * @subpackage	mod_jux_timeline
 * @copyright	Copyright (C) 2013 JoomlaUX. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class JFormFieldJUXTimeLine extends JFormField {
	/**
	 * The form field type.
	 *
	 * @var    string
	 */
	public $type = 'juxtimeline';
	
	public function __construct($form = null){
		parent::__construct($form);
		JHtml::_('jquery.ui', array('core','sortable')); 
	}
	
	protected function getInput(){
		$document = JFactory::getDocument();
		$uri = str_replace("\\","/", str_replace(JPATH_SITE, JURI::root(true), dirname(__FILE__) ));
		$document->addScript($uri.'/assets/js/juxtimeline.js');
		$document->addStyleSheet($uri.'/assets/css/juxtimeline.css');
		$document->addScriptDeclaration('
		jQuery(document).ready(function($){
			$("#'.$this->id.'").juxtimeline();
		});
		');
		// Initialize some field attributes.
		$class = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$disabled = ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';

		// Initialize JavaScript field attributes.
		$onchange = $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

		return '<input type="hidden" name="' . $this->name . '" id="' . $this->id . '" value="'
			. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"' . $class . $disabled . $onchange . ' />';
	}
	
	protected function getLabel(){
		return parent::getLabel();
	}
}