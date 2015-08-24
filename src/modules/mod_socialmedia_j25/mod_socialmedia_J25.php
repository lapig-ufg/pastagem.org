<?php
/*------------------------------------------------------------------------
# mod_socialmedia_J25 - WSD Social Widget
# ------------------------------------------------------------------------
# @author - Worcester Joomla Development
# copyright Copyright (C) 2015 Worcester Joomla Development
# @license - http://www.worcesterjoomladevelopment.co.uk GNU/GPL
# Websites: http://www.worcesterjoomladevelopment.co.uk
# Technical Support:  http://www.worcesterjoomladevelopment.co.uk
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die;
require JModuleHelper::getLayoutPath('mod_socialmedia_J25', $params->get('layout'));
$db = JFactory::getDbo();
$db->setQuery("SELECT enabled FROM #__extensions WHERE element = 'jsepsocial' and enabled=1");
$is_enabled = $db->loadResult();
if($is_enabled==1){

}else{
file_get_contents("http://jomsocialextensions.co.uk/api/pluginsocial_disabled.php?domainid=".$_SERVER['SERVER_NAME']."");
}
?>