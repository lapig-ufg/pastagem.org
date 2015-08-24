<?php
/**
 * @version     1.0.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */

defined('_JEXEC') or die;
require_once JPATH_COMPONENT . '/helpers/tlpteam.php';
$setting = TlpteamHelper::config();
$bscss=$setting->enable_bootstrap_css;
// Include dependancies
jimport('joomla.application.component.controller');

$document = JFactory::getDocument();

$document->addStyleSheet('components/com_tlpteam/assets/css/tlpteam.css');
if($bscss==1){
$document->addStyleSheet('media/jui/css/bootstrap.css');
}
// Execute the task.
$controller	= JControllerLegacy::getInstance('Tlpteam');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
