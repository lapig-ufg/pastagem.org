<?php
/**
 * @version $Id: helper.php 4 2014-05-07 18:42:25Z szymon $
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

class modDJMenuHelper {

	var $name = null;
	
	var $params = null;
	
	var $path = null;

	
	function render(&$paramsa) {

	
		$this->params = $paramsa;

		
		if (is_null($this->name)) {
		
			$this->name = $this->params->get('menu');
			
		}
		
		echo '<ul id="dj-main'.$this->params->get('module_id').'" class="nav nav-pills menu-pastagem">';
		
		$this->ShowMenu();
		
		echo '</ul>';
		
	}
	
	function ShowMenu() {
		
		//$user 	= JFactory::getUser();
		$app 	= JFactory::getApplication();
		$menu 	= $app->getMenu();		
		
		$end = $this->params->get('endLevel',0);
		
		//get menu items		
		$rows 	= $menu->getItems('menutype', $this->name);
		
		$children = array();
		
		foreach ($rows as $v) {
			if($end && $v->level > $end){
				continue;
			}
			$pt = $v->parent_id;
			$list = @$children[$pt] ? $children[$pt] : array();			
			array_push($list, $v);			
			$children[$pt] = $list;			
		}
		
		$this->path = $this->getActive();
		
		$this->mosRecurseListMenu(1, 0, $children);
		
		return true;
	}

	function getActive() {
	
		$app	= JFactory::getApplication();
		$menu	= $app->getMenu();
		$active	= $menu->getActive();
		$active_id = isset($active) ? $active->id : $menu->getDefault()->id;
		$path	= isset($active) ? $active->tree : array();
		
		return $path;
	}
	
	/**
	 
	 * Utility function for writing a menu link
	 
	 */
	 
	function mosGetMenuLink($item, $level = 0, &$params, $havechild = null) {
	
		$app 	= JFactory::getApplication();
		$menu 	= $app->getMenu();
		
		if(!isset($item->flink)) {
		
			$item->flink = $item->link;
		
			switch ($item->type) {
				
						case 'separator':
							$item->browserNav = 3;
							break;
	
						case 'url':
							if ((strpos($item->link, 'index.php?') === 0) && (strpos($item->link, 'Itemid=') === false)) {
								// If this is an internal Joomla link, ensure the Itemid is set.
								$item->flink = $item->link.'&Itemid='.$item->id;
							}
							break;
	
						case 'alias':
							// If this is an alias use the item id stored in the parameters to make the link.
							$item->flink = 'index.php?Itemid='.$item->params->get('aliasoptions');
							break;
	
						default:
							$router = JSite::getRouter();
							if ($router->getMode() == JROUTER_MODE_SEF) {
								$item->flink = 'index.php?Itemid='.$item->id;
							}
							else {
								$item->flink .= '&Itemid='.$item->id;
							}
							break;
			}
			
			if (strcasecmp(substr($item->flink, 0, 4), 'http') && (strpos($item->flink, 'index.php?') !== false)) {
				$item->flink = JRoute::_($item->flink, true, $item->params->get('secure'));
			} else {
				$item->flink = JRoute::_($item->flink);
			}
	
			// get image if selected
			$item->title = htmlspecialchars($item->title);
			$item->anchor_css = htmlspecialchars($item->params->get('menu-anchor_css', ''));
			$item->anchor_title = htmlspecialchars($item->params->get('menu-anchor_title', ''));
			$item->menu_image = $item->params->get('menu_image', '') ? htmlspecialchars($item->params->get('menu_image', '')) : '';
		
		}
		
		// Note. It is important to remove spaces between elements.
		$anchor_title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
		if ($item->menu_image) {
				$item->params->get('menu_text', 1 ) ? 
				$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
				$linktype = '&nbsp;<img src="'.$item->menu_image.'" alt="'.$item->title.'" />&nbsp;';
		} 
		else { 
			$linktype = $item->title;
		}
		
		// Add classes
		$classplus = '';		
		if ($item->type == 'alias' && in_array($item->params->get('aliasoptions'),$this->path) || in_array($item->id, $this->path)) {
			$classplus = 'active ';
		}
		$classplus .= $item->anchor_css;
		$class = 'class="'.$classplus.'"';;
		if ($level == 0) $class = 'class="dj-up_a'.(trim($classplus) ? ' '.trim($classplus) : '').'"';			
		if ($havechild && $level != 0) {		
			if ( empty($classplus))
				$class = 'class="dj-more"';				
			else
				$class = 'class="dj-more-'.$classplus.'"';				
		}
		
		$spanclass = '';
		if ($havechild && $level == 0) {		
			$spanclass = 'class="dj-drop" ';			
		}
		if ($level == 0) {
			$linktype = '<span '.$spanclass.'>'.$linktype.'</span>';
		}
		
		$link = '';
		switch ($item->browserNav) {
		
			// cases are slightly different
			default:
			case 0:			
				// same window
				$link = '<a href="'.$item->flink.'" '.$class.' '.$anchor_title.'>'.$linktype.'</a>';
				break;
				
			case 1:
				// _blank
				$link = '<a href="'.$item->flink.'" '.$class.' '.$anchor_title.' target="_blank">'.$linktype.'</a>';
				break;
				
			case 2:
				// open in a popup window
				$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550';
				$link = '<a href="'.$item->flink.'" onclick="window.open(this.href,\'targetWindow\',\''.$attribs.'\');return false;" '.$class.' '.$anchor_title.'>'.$linktype.'</a>';
				break;
				
			case 3:
				// don't link it
				$link = '<a '.$class.' '.$anchor_title.'>'.$linktype.'</a>';
				break;
		}

		return $link;
		
	}
	 
	function mosRecurseListMenu($id, $level, &$children) {
	
		$app 	= JFactory::getApplication();
		$menu 	= $app->getMenu();
		
		if (@$children[$id]) {
		
			$elements = count($children[$id]);			
			$counter = 0;
			
			foreach ($children[$id] as $row) {
			
				$counter++;				
				$separator = ($row->type == 'separator' ? true : false);
				@$havechild = is_array($children[$row->id]);
				
				$classname = "";				
				if ($level == 0) {
					$classname .= "dj-up ";
				}				
				$classname .= "itemid".$row->id." ";				
				if ($counter == 1) {				
					$classname .= "first ";					
				} else if ($counter == $elements) {				
					$classname .= "last ";					
				}				
				if ($row->type == 'alias' && in_array($row->params->get('aliasoptions'),$this->path) || in_array($row->id, $this->path)) {
					$classname .= "active ";
				}				
				if ($separator) {
					$classname .= "separator";
				}
				
				$class = "";
				
				if (!empty($classname)) {				
					$class = " class=\"".trim($classname)."\"";
				}

				if ($havechild) {
				
					echo "<li".$class.">".$this->mosGetMenuLink($row, $level, $this->params, 1)."\n";
					
					if ($level == 0) {
						
						echo "<ul class=\"dj-submenu\">\n";
						echo "<li class=\"submenu_top\" style=\"display: none\"> </li>\n";
						
						$this->mosRecurseListMenu($row->id, $level + 1, $children);
						
						echo "<li class=\"submenu_bot\" style=\"display: none\"> </li>\n";
						echo "</ul>\n";
						
					} else {
					
						echo "<ul>\n";
						echo "<li class=\"submenu_top\" style=\"display: none\"> </li>\n";
						
						$this->mosRecurseListMenu($row->id, $level + 1, $children);
						
						echo "<li class=\"submenu_bot\" style=\"display: none\"> </li>\n";
						echo "</ul>\n";

					}
					
					echo "</li>\n";
					
				} else {
				
					echo "<li".$class.">".$this->mosGetMenuLink($row, $level, $this->params)."</li>\n";
					
				}
				
			}
			
		}
		
	}
}
?>