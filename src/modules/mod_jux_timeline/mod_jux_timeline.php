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
require_once __DIR__ . '/helper.php';
$document = JFactory::getDocument();
//include css

$document->addStyleSheet('modules/' . $module->module . '/assets/css/style.css');
//Include js
$document->addScript('modules/' . $module->module . '/assets/js/script.js');
$document->addScriptDeclaration('
	jQuery(document).ready(function($){
		$("#jux_tl'.$module->id.'").juxtimeline();
	});
');

$lists = modJUXTimeLineHelper::getTimeLine($params);

require (JModuleHelper::getLayoutPath('mod_jux_timeline',$params->get('layout', 'default')));