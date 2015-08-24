<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once (JPATH_SITE.'/components/com_k2/helpers/route.php');
require_once (JPATH_SITE.'/components/com_k2/models/itemlist.php');
require_once (dirname(__FILE__).'/helper.php');

class modLatestNewsEnhancedHelperK2
{
	static function getList($params, $module)
	{
		// Get the dbo
		$db = JFactory::getDbo();
		$app = JFactory::getApplication();
		
		$query = $db->getQuery(true);
		
		$subquery1 = ' CASE WHEN ';
		$subquery1 .= $query->charLength('a.alias');
		$subquery1 .= ' THEN ';
		$a_id = $query->castAsChar('a.id');
		$subquery1 .= $query->concatenate(array($a_id, 'a.alias'), ':');
		$subquery1 .= ' ELSE ';
		$subquery1 .= $a_id.' END AS slug';
		
		$subquery2 = ' CASE WHEN ';
		$subquery2 .= $query->charLength('cc.alias');
		$subquery2 .= ' THEN ';
		$cc_id = $query->castAsChar('cc.id');
		$subquery2 .= $query->concatenate(array($cc_id, 'cc.alias'), ':');
		$subquery2 .= ' ELSE ';
		$subquery2 .= $cc_id.' END AS cat_slug';
		
		$query->select('a.*, cc.id AS cat_id, cc.name AS category_title, cc.alias AS cat_alias');
		$query->select($subquery1);
		$query->select($subquery2);
		$query->from('#__k2_items AS a');		
		$query->join('INNER', '#__k2_categories AS cc ON cc.id = a.catid');
		
		$nullDate = $db->Quote($db->getNullDate());
		$nowDate = $db->Quote(JFactory::getDate()->toSql());
		
		$query->where('a.published = 1 AND a.trash = 0');
		$query->where('(a.publish_up = ' . $nullDate . ' OR a.publish_up <= ' . $nowDate . ')');
		$query->where('(a.publish_down = ' . $nullDate . ' OR a.publish_down >= ' . $nowDate . ')');
		
		// Access filter
		
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		
		if ($access) {
			$user = JFactory::getUser();
			$groups	= implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN ('.$groups.')');
			$query->where('cc.access IN ('.$groups.')');
		}
		
		// Category filter
		
		$categories = '';
		$categories_array = $params->get('k2catid', array());
		
		$array_of_category_values = array_count_values($categories_array);
		if (isset($array_of_category_values['all']) && $array_of_category_values['all'] > 0) { // 'all' was selected
			// take everything, so no category selection
		} else {
			// sub-category inclusion
			$get_sub_categories = $params->get('includesubcategories', 'no');
			if ($get_sub_categories != 'no') {			
				$itemListModel = K2Model::getInstance('Itemlist', 'K2Model');
				$sub_categories_array = array();
				if ($get_sub_categories == 'all') {
					$sub_categories_array = $itemListModel->getCategoryTree($categories_array);
				} else {				
					foreach ($categories_array as $category) {						
						$sub_categories_rows = $itemListModel->getCategoryFirstChildren($category);
						foreach ($sub_categories_rows as $sub_categories_row) {
							$sub_categories_array[] = $sub_categories_row->id;
						}
					}
				}
				foreach ($sub_categories_array as $subcategory) {
					$categories_array[] = $subcategory;
				}
				$categories_array = array_unique($categories_array);
			}
			
			if (!empty($categories_array)) {
				$categories = implode(',', $categories_array);
				$query->where('cc.id IN ('.$categories.')');
			}
		}
		
		$query->where('cc.published = 1');
		
		// User filter
		
		$userId = JFactory::getUser()->get('id');
		switch ($params->get('user_id'))
		{
			case 'by_me':
				$query->where('a.created_by IN ('.$userId.')');
				break;
			case 'not_me':
				$query->where('a.created_by NOT IN ('.$userId.')');
				break;
			case '0':
				break;
			default:
				$query->where('a.created_by IN ('.$params->get('user_id').')');
				break;
		}		
		
		// Filter by language
		// TODO correct ?
		$query->where('a.language IN ('.$db->quote(JFactory::getLanguage()->getTag()).','.$db->quote('*').')');
		
		// Featured
		
		switch ($params->get('show_featured'))
		{
			case '1': // only
				$query->where('a.featured = 1');
				break;
			case '0': // hide
				$query->where('a.featured = 0');
				break;
			default: // show
				break;
		}
		
		// Set ordering
		
		$dir = 'DESC';
		$ordering = '';
		switch ($params->get( 'ordering' ))
		{
			case 'o_asc': $ordering .= 'a.ordering'; $dir = 'ASC'; break;
			case 'o_dsc': $ordering .= 'a.ordering'; break;
			case 'p_asc': $ordering .= 'a.publish_up'; $dir = 'ASC'; break;
			case 'p_dsc': $ordering .= 'a.publish_up'; break;
			case 'f_asc': $ordering .= 'CASE WHEN (a.publish_down = '.$db->quote($db->getNullDate()).') THEN a.publish_up ELSE a.publish_down END'; $dir = 'ASC'; break;
			case 'f_dsc': $ordering .= 'CASE WHEN (a.publish_down = '.$db->quote($db->getNullDate()).') THEN a.publish_up ELSE a.publish_down END'; break;			
			case 'm_asc': $ordering .= 'a.modified ASC, a.created'; $dir = 'ASC'; break;
			case 'm_dsc': $ordering .= 'a.modified DESC, a.created'; break;
			case 'c_asc': $ordering .= 'a.created'; $dir = 'ASC'; break;
			case 'c_dsc': $ordering .= 'a.created'; break;
			case 'mc_asc': $ordering .= 'a.created'; $dir = 'ASC'; break;
			case 'mc_dsc': $ordering .= 'CASE WHEN (a.modified = '.$db->quote($db->getNullDate()).') THEN a.created ELSE a.modified END'; break;
			case 'random': $ordering .= 'rand()'; $dir = ''; break;
			case 'hit': $ordering .= 'a.hits'; break;
			case 'title_asc': $ordering .= 'a.title'; $dir = 'ASC'; break;
			case 'title_dsc': $ordering .= 'a.title'; break;
			default: $ordering .= 'a.publish_up'; break;
		}
		
		$query->order($ordering.' '.$dir);		
		
		$db->setQuery($query);
		
		$items = $db->loadObjectList();
		
		if ($error = $db->getErrorMsg()) {
			throw new Exception($error);
		}
		
		$count = trim($params->get('count', ''));
		$startat = $params->get('startat', 1);
		if ($startat < 1) {
			$startat = 1;
		}
		if (!empty($count)) {
			$items = array_slice($items, $startat - 1, $count);
		} else {
			$items = array_slice($items, $startat - 1);
		}
		
		$head_type = $params->get('head_type', 'none');
		$postdate = $params->get('post_date', 'published');
		$when_no_date = $params->get('when_no_date', 0);
		$text_type = $params->get('text', 'intro');
		$letter_count = trim($params->get('letter_count'));
		$keep_tags = $params->get('keep_tags');
		
		$show_author = $params->get('show_author', 1);
		$author_name = $params->get('author_name', 'full');
		$show_date = $params->get('show_date', 'none');
		
		$strip_tags = $params->get('strip_tags', 1);
		$crop_picture = $params->get('crop_picture', 0);
		$head_width = trim($params->get('head_w', '64'));
		$head_height = trim($params->get('head_h', '64'));
		$clear_cache = $params->get('clear_cache', 0);
		
		$tmp_path = $params->get('thumb_path', 'tmp');
		
		foreach ($items as &$item) {
			
			// links
			
			if ($access || in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->slug, $item->cat_slug)));
				$item->catlink = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($item->cat_slug)));
			} else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
				$item->catlink = $item->link;
			}			
			
			// title
			
			//$item->title = htmlspecialchars( $row->title );
			$force_one_line = $params->get('force_one_line', false);
			if (!$force_one_line) {
				$title_letter_count = trim($params->get('letter_count_title', ''));
				if (strlen($title_letter_count) > 0) {
					$item->title = modLatestNewsEnhancedHelper::cropText($item->title, (int)$title_letter_count);
				}
			}
			
			// author
			
			if ($show_author) {
				$user = JFactory::getUser($item->created_by);
				switch ($author_name) {
					case 'full':
						$item->author = htmlspecialchars($user->name);
						break;
					case 'alias':
						$item->author = htmlspecialchars($item->created_by_alias);
						break;
					default:
						$item->author = htmlspecialchars($user->username);
						break;
				}
			}
			
			// image
			
			if ($head_type == "image") {
				$item->imagetag = '';
					
				$original_image_src = 'media/k2/items/cache/'.md5("Image".$item->id).'_Generic.jpg'; // k2 image
				if (!is_file(JPATH_ROOT.'/'.$original_image_src)) { // if no k2 image, use the first article image found
					$original_image_src = modLatestNewsEnhancedHelper::getImageSrcFromArticle($item->introtext, $item->fulltext);
				}
				
				if (!empty($original_image_src)) {
					$result_array = modLatestNewsEnhancedHelper::getImageTagForArticle($tmp_path, $item->title, $module->id, $item->id, $original_image_src, $clear_cache, $head_width, $head_height, $crop_picture);
					$item->imagetag = $result_array[0];
					$item->error = $result_array[1];
				}
			}
			
			// date
			
			$item->date = $item->publish_up;
			if ($postdate == 'created') {
				$item->date = $item->created;
			} else if ($postdate == 'modified') {
				$item->date = $item->modified;
			} else if ($postdate == 'finished') {
				$item->date = $item->publish_down;
			}
			
			if ($show_date == 'ago' || $show_date == 'agohm') {
				if ($item->date != $db->getNullDate()) {
					$details = modLatestNewsEnhancedHelper::date_to_counter($item->date, ($postdate == 'finished') ? true : false);
										
					$item->nbr_seconds  = intval($details['secs']);
					$item->nbr_minutes  = intval($details['mins']);
					$item->nbr_hours = intval($details['hours']);
					$item->nbr_days = intval($details['days']);
				}
			}
			
			// text
			
			$item->text = '';
			
			if ($text_type == 'intro') {
				$item->text = $item->introtext;
				
				// will trigger events from plugins
				$app->triggerEvent('onContentPrepare', array('com_content.article', &$item, &$params, 0));
			}
			
			$number_of_letters = -1;
			if ($letter_count != '') {
				$number_of_letters = (int)($letter_count);
			}
			
			if ($text_type == 'intro') {
				$item->text = modLatestNewsEnhancedHelper::getText($item->text, 'html', $number_of_letters, $strip_tags, trim($keep_tags));
			} else {
				$item->text = modLatestNewsEnhancedHelper::getText($item->metadesc, 'txt', $number_of_letters, false, '');
			}
		}
		
		$items_with_no_date = array();
		foreach ($items as $key => &$item) {
			if ($item->date == $db->getNullDate()) {
				$item->date = null;
				$items_with_no_date[] = $item;
				unset($items[$key]);
			}
		}
		
		if ($when_no_date == 1) {
			$items = array_merge($items_with_no_date, $items);
		} else if ($when_no_date == 2) {
			$items = array_merge($items, $items_with_no_date);
		}
		
		return $items;
	}
}
?>
