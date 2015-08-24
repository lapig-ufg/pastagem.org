<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die ;

jimport('joomla.form.formfield');
jimport('joomla.filesystem.folder');
jimport('joomla.version');

/*
 * Checks if the SYW library is installed and has the version needed for the extension to run properly
 */
class JFormFieldSYWlibtest extends JFormField {
		
	public $type = 'SYWlibtest';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getLabel() {
		
		$html = '';
		
		$minversion = $this->element['minversion'];
		
		if (!JFolder::exists(JPATH_ROOT.'/libraries/syw')) {
			$html .= '<div style="clear: both;"></div>';
		} else {
			jimport('syw.version');			
			if (!SYWVersion::isCompatible($minversion)) {	
				$html .= '<div style="clear: both;"></div>';
			}
		}
		
		return $html;		
	}

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput() {
		
		$html = '';
		
		$minversion = $this->element['minversion'];
		$downloadlink = $this->element['downloadlink'];
			
		$version = new JVersion();
		$jversion = explode('.', $version->getShortVersion());
		
		$class = '';
		$style = '';
		
		if (intval($jversion[0]) > 2) {
			$class = 'alert alert-warning';
		} else {
			$style = 'margin: 5px 0; padding: 8px 35px 8px 14px; border-radius: 4px; border: 1px solid #FBEED5; background-color: #FCF8E3; color: #C09853;';
		}
		
		if (!JFolder::exists(JPATH_ROOT.'/libraries/syw')) {
			$html .= '<div class="'.$class.'" style="'.$style.'">';
			$html .= '    <span>'.JText::_('SYW_MISSING_SYWLIBRARY').'</span><br />';
			$html .= '    <a href="'.$downloadlink.'" target="_blank">'.JText::_('SYW_DOWNLOAD_SYWLIBRARY').'</a>';
			$html .= '</div>';
		} else {
			jimport('syw.version');			
			if (!SYWVersion::isCompatible($minversion)) {	
				$html .= '<div class="'.$class.'" style="'.$style.'">';
				$html .= '    <span>'.JText::_('SYW_NONCOMPATIBLE_SYWLIBRARY').'</span><br />';
				$html .= '    <span>'.JText::_('SYW_UPDATE_SYWLIBRARY').JText::_('SYW_OR').'</span>';
				$html .= '    <a href="'.$downloadlink.'" target="_blank">'.strtolower(JText::_('SYW_DOWNLOAD_SYWLIBRARY')).'</a>';
				$html .= '</div>';
			}
		}
		
		return $html;
	}

}
?>