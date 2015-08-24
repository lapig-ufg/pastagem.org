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

require_once JPATH_SITE . '/components/com_tlpteam/helpers/tlpteam.php';
 
 //Add database instance
 
$db= JFactory::getDBO();
  
//Pass query Limit by usercount parameter (Check XML)
$query="SELECT * FROM #__tlpteam_team  WHERE state=1 ORDER BY ordering LIMIT $membercount";
 
//Run The query
$db->setQuery($query);

//Load it as an Object into the variable "$rows
$rows = $db->loadObjectList();