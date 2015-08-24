<?php 
/**
 * @version $Id: mod_djmenu.php 4 2014-05-07 18:42:25Z szymon $
 * @package DJ-Menu
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
 *
 * DJ Menu is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ Menu is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ Menu. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// joomla3.0 compability
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$app = JFactory::getApplication();
$doc = JFactory::getDocument();

$version = new JVersion;
$jquery = version_compare($version->getShortVersion(), '3.0.0', '>=');

if ($jquery) {
	JHTML::_('jquery.framework');
} else {
	JHTML::_('behavior.framework');
}

if($params->get('select',1)) {
	$doc->addScript(JURI::root(true).'/modules/mod_djmenu/assets/js/'.($jquery ? 'jquery.':'').'djselect.js');
	if ($jquery) {
		$doc->addScriptDeclaration("jQuery(document).ready(function(){jQuery('#dj-main$module->id').addClass('allowHide')});");
	} else {
		$doc->addScriptDeclaration("window.addEvent('domready',function(){document.id('dj-main$module->id').addClass('allowHide')});");
	}
	
	$doc->addStyleDeclaration("
		.dj-select {display: none;margin:10px;padding:5px;font-size:1.5em;max-width:95%;height:auto;}
		@media (max-width: ".$params->get('width',800)."px) {
  			#dj-main$module->id.allowHide { display: none; }
  			#dj-main$module->id"."select { display: inline-block; }
		}
	");
}

if($params->get('css')=='1') $params->set('css', 'default'); // backward compatibility

if($params->get('css')!='0') {
	$css_fx = 'modules/mod_djmenu/themes/'.$params->get('css','default').'/css/djmenu_fx.css';
	$css = 'modules/mod_djmenu/themes/'.$params->get('css','default').'/css/djmenu.css';
} else {
	$css_fx = 'templates/'.$app->getTemplate().'/css/djmenu_fx.css';
	$css = 'templates/'.$app->getTemplate().'/css/djmenu.css';
}

$doc->addStyleSheet(JURI::root(true).'/'.$css);

if($params->get('moo',1)) {
	
	$doc->addStyleSheet(JURI::root(true).'/media/djextensions/css/animate.min.css');
	$doc->addStyleSheet(JURI::root(true).'/modules/mod_djmenu/assets/css/animations.css');
	$doc->addScript(JURI::root(true).'/modules/mod_djmenu/assets/js/'.($jquery ? 'jquery.':'').'djmenu.js');
	
	$doc->addStyleSheet(JURI::root(true).'/'.$css_fx);
	
	if(!is_numeric($delay = $params->get('delay'))) $delay = 500;
	$wrapper_id = $params->get('wrapper');
	$animIn = $params->get('animation_in');
	$animOut = $params->get('animation_out');
	$animSpeed = $params->get('animation_speed');
	
	$options = "{wrap: '$wrapper_id', animIn: '$animIn', animOut: '$animOut', animSpeed: '$animSpeed', delay: $delay }";
	
	$js = $jquery ?	"jQuery(document).ready( function(){ new DJMenu(jQuery('#dj-main$module->id'), $options); } );"
				:	"window.addEvent('domready',function(){ new DJMenu(document.id('dj-main$module->id'), $options); });";
	
	$doc->addScriptDeclaration($js);
}

$params->def('module_id',$module->id);
$djmenu = new modDJMenuHelper();

require(JModuleHelper::getLayoutPath('mod_djmenu'));

?>