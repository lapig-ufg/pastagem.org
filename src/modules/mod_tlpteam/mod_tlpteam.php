<?php
/**
 * @version     1.0.0
 * @package     mod_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// no direct access
defined('_JEXEC') or die;
 
//This is the parameter we get from the XML file 
 
$membercount= $params->get('membercount');
$showno= $params->get('showno');
$speed= $params->get('speed');
$autoplay= $params->get('autoplay');
$navigation= $params->get('navigation');
$pagination= $params->get('pagination');
$responsive= $params->get('responsive');
$lazyload= $params->get('lazyload');
$shortbio= $params->get('shortbio');
$shortbiolimit= $params->get('shortbiolimit');
$enablejquery= $params->get('enablejquery');

$document = JFactory::getDocument();

$document->addStyleSheet('components/com_tlpteam/assets/css/tlpteam.css');

$document->addStyleSheet('components/com_tlpteam/assets/owl-carousel/owl.carousel.css');
$document->addStyleSheet('components/com_tlpteam/assets/owl-carousel/owl.theme.css');
if($enablejquery=='true'){
$document->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js');
}
$document->addScript('components/com_tlpteam/assets/owl-carousel/owl.carousel.min.js');
$document->addScript('components/com_tlpteam/assets/js/jquery.matchHeight-min.js');

//Include syndicate function only once

require_once dirname(__FILE__).'/helper.php';

//Require the path of the layout file

require JModuleHelper::getLayoutPath('mod_tlpteam', $params->get('layout','default'));