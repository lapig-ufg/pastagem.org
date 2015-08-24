<?php
/**
 * @version     1.0.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
defined('_JEXEC') or die;

class TlpTeamHelper {
	
	public static function config()
	{
		$db = JFactory::getDBO();
		$sql = 'SELECT * FROM #__tlpteam_settings WHERE id = 1';
		$db->setQuery($sql);
		$config = $db->loadObject(); 

		return $config;
	}

	public static function contentJDispatchEvents($html)
    {
        $article = new stdClass;
        $article->text = $html;
         
        $params = new JObject;
        
        JPluginHelper::importPlugin('content');
        $dispatcher = JDispatcher::getInstance();
        $results = $dispatcher->trigger('onContentPrepare', array('com_tlpteam', &$article, &$params, 0));
        $results = $dispatcher->trigger('onContentAfterTitle', array('com_tlpteam', &$article, &$params, 0));
        $results = $dispatcher->trigger('onContentBeforeDisplay', array('com_tlpteam', &$article, &$params, 0));
        $results = $dispatcher->trigger('onContentAfterDisplay', array('com_tlpteam', &$article, &$params, 0));
        
        return $article->text;
    }
}
