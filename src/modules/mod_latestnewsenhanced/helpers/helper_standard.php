<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once (JPATH_SITE.'/components/com_content/helpers/route.php');
require_once (dirname(__FILE__).'/helper.php');

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

class modLatestNewsEnhancedHelperStandard
{
	static function getList($params, $module)
	{
		// Get the dbo
		$db = JFactory::getDbo();
		
		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		
		// Set application parameters in model
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$model->setState('params', $appParams);
		
		// Set the filters based on the module params
		
		$count = trim($params->get('count', ''));
		$startat = $params->get('startat', 1);
		if ($startat < 1) {
			$startat = 1;
		}
		if (!empty($count)) {
			$model->setState('list.start', $startat - 1);
			$model->setState('list.limit', ((int) $count));
		}
		
		$model->setState('filter.published', 1);
		
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);
		
		// Category filter
		
		$categories_array = $params->get('catid', array());
		
		$array_of_category_values = array_count_values($categories_array);
		if (isset($array_of_category_values['all']) && $array_of_category_values['all'] > 0) { // 'all' was selected
			// take everything, so no category selection
		} else {
			// sub-category inclusion
			$get_sub_categories = $params->get('includesubcategories', 'no');
			if ($get_sub_categories != 'no') {
				$categories_object = JCategories::getInstance('Content');
				foreach ($categories_array as $category) {
					$category_object = $categories_object->get($category); // if category unpublished, unset
					if (isset($category_object) && $category_object->hasChildren()) {
						$sub_categories_array = array();
						if ($get_sub_categories == 'all') {
							$sub_categories_array = $category_object->getChildren(true); // true is for recursive
						} else {
							$sub_categories_array = $category_object->getChildren();
						}
						foreach ($sub_categories_array as $subcategory_object) {
							$categories_array[] = $subcategory_object->id;
						}
					}						
				}					
				$categories_array = array_unique($categories_array);
			}
		}
		
		$model->setState('filter.category_id', $categories_array);
				
		// User filter
		$userId = JFactory::getUser()->get('id');
		switch ($params->get('user_id'))
		{
			case 'by_me':
				$model->setState('filter.author_id', (int) $userId);
				break;
			case 'not_me':
				$model->setState('filter.author_id', $userId);
				$model->setState('filter.author_id.include', false);
				break;		
			case '0':
				break;		
			default:
				$model->setState('filter.author_id', (int) $params->get('user_id'));
			break;
		}
		
		// Filter by language
		$model->setState('filter.language',$app->getLanguageFilter());
		
		// Featured
		$featured_only = false;
		switch ($params->get('show_featured'))
		{
			case '1':
				$model->setState('filter.featured', 'only');
				$featured_only = true;
				break;
			case '0':
				$model->setState('filter.featured', 'hide');
				break;
			default:
				$model->setState('filter.featured', 'show');
			break;
		}
		
		// Set ordering
		$dir = 'DESC';
		$ordering = '';
		switch ($params->get( 'ordering' ))
		{
			case 'o_asc': if ($featured_only) { $ordering .= 'fp.ordering'; } else { $ordering .= 'a.ordering'; } $dir = 'ASC'; break;
			case 'o_dsc': if ($featured_only) { $ordering .= 'fp.ordering'; } else { $ordering .= 'a.ordering'; } break;
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
		
		$model->setState('list.ordering', $ordering);
		$model->setState('list.direction', $dir);
		
		$items = $model->getItems();
		
		// we want to be able to use startat even with an unlimited number of items
		if (empty($count)) {
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
			
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid.':'.$item->category_alias;
			
			if ($access || in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
				$item->catlink = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug));
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
			
			// rating
			
			if (isset($item->rating)) { // to avoid calls to rating plugin
				unset($item->rating);
				unset($item->rating_count);
			}
			
			// image
			
			if ($head_type == "image") {
				$item->imagetag = '';
				
				// look into image intro first
				// Convert the images field to an array.
				$registry = new JRegistry;
				$registry->loadString($item->images);
				$images_array = $registry->toArray();
				if ($images_array) {
					$original_image_src = trim($images_array['image_intro']);
					if ($original_image_src) {
						$result_array = modLatestNewsEnhancedHelper::getImageTagForArticle($tmp_path, $item->title, $module->id, $item->id, $original_image_src, $clear_cache, $head_width, $head_height, $crop_picture);
						$item->imagetag = $result_array[0];
						$item->error = $result_array[1];
					}
				}
				
				// if image intro article not found, look into the article
				if (empty($item->imagetag)) {				
					// missing fulltext from articles.php so get fulltext from an other query
					$db->setQuery('SELECT a.fulltext FROM #__content AS a WHERE a.id ='.$item->id);
					$fulltext = $db->loadResult();
						
					$original_image_src = modLatestNewsEnhancedHelper::getImageSrcFromArticle($item->introtext, $fulltext);
					if (!empty($original_image_src)) {
						$result_array = modLatestNewsEnhancedHelper::getImageTagForArticle($tmp_path, $item->title, $module->id, $item->id, $original_image_src, $clear_cache, $head_width, $head_height, $crop_picture);
						$item->imagetag = $result_array[0];
						$item->error = $result_array[1];
					}
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