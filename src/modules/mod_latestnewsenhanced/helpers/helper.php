<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('syw.image');
jimport('joomla.filesystem.file');
jimport('joomla.utilities.date');

class modLatestNewsEnhancedHelper
{
	static function getImageSrcFromArticle($introtext, $fulltext) {
		
		preg_match_all('#<img[^>]*>#i', $introtext, $img_result); // finds all images in the introtext
		if (empty($img_result[0][0]) && !empty($fulltext)) {	// maybe there are images in the fulltext...
			preg_match_all('#<img[^>]*>#i', $fulltext, $img_result); // finds all images in the fulltext
		}
		
		// TODO: if image too small (like a dot for empty space in J! 1.5), go to the next one
		
		if (!empty($img_result[0][0])) { // $img_result[0][0] is the first image found			
			preg_match('/(src)=("[^"]*")/i', $img_result[0][0], $src_result); // get the src attribute			
			return trim($src_result[2], '"');
		}
		
		return null;
	}
	
	static function getImageTagForArticle($tmp_path, $alt, $module_id, $article_id, $original_image_src, $clear_cache, $head_width, $head_height, $crop_picture) {
					
		$result = array('', null); // image tag and error
		
		$extensions = get_loaded_extensions();
		if (!in_array('gd', $extensions)) {
			// missing gd library
			$result[0] = '<img alt="'.$alt.'" src="'.$original_image_src.'" />';
			$result[1] = JText::_('MOD_LATESTNEWSENHANCED_GD_NOTLOADED');
		} else {						
			// URL works only if 'allow url fopen' is 'on', which is a security concern
			// retricts images to the ones found on the site, external URLs are not allowed (for security reasons)
			if (substr_count($original_image_src, 'http') <= 0) {
				if (substr($original_image_src, 0, 1) == '/') {	// take the slash off
					$original_image_src = ltrim($original_image_src, '/');
				}
			} else {
				$base = JURI::base(); // JURI::base() is http://www.mysite.com/subpath/
				$original_image_src = str_ireplace($base, '', $original_image_src);
			}
				
			// we end up with all $original_image_src paths as 'images/...'
			// if not, the URL was from an external site
						
			if (substr_count($original_image_src, 'http') > 0) { // we have an external URL
				if (!ini_get('allow_url_fopen')) {
					$result[1] = JText::sprintf('MOD_LATESTNEWSENHANCED_ERROR_EXTERNALURLNOTALLOWED', $original_image_src);
					return $result;
				}
			}
						
			//if (substr_count($original_image_src, 'http') > 0) {
				//$result[1] = JText::sprintf('MOD_LATESTNEWSENHANCED_ERROR_EXTERNALURLNOTALLOWED', $original_image_src);
				//return $result;
			//} else {
				$imageext = explode('.', $original_image_src);
				$imageext = $imageext[count($imageext) - 1];
				$imageext = strtolower($imageext);

				$filename = $tmp_path.'/thumb_'.$module_id.'_'.$article_id.'.'.$imageext;
				$imageheight = 0;
				if (is_file(JPATH_ROOT.'/'.$filename) && !$clear_cache) { // thumbnail already exists
					$imagesize = getimagesize($filename);
					$imageheight = $imagesize[1];
				} else { // create the thumbnail
					
					$image = new SYWImage($original_image_src);
					
					if (is_null($image->getImagePath())) {
						$result[1] = JText::sprintf('MOD_LATESTNEWSENHANCED_ERROR_IMAGEFILEDOESNOTEXIST', $original_image_src);
					} else if (is_null($image->getImageMimeType())) {
						$result[1] = JText::sprintf('MOD_LATESTNEWSENHANCED_ERROR_UNABLETOGETIMAGEPROPERTIES', $original_image_src);
					} else if (is_null($image->getImage()) || $image->getImageWidth() == 0) {
						$result[1] = JText::sprintf('MOD_LATESTNEWSENHANCED_ERROR_UNSUPPORTEDFILETYPE', $original_image_src);
					} else {
						
						switch ($imageext){
							case 'jpg': case 'jpeg': $quality = 100; break; // 0 to 100
							case 'png': $quality = 0; break; // compression: 0 to 9
							default : $quality = -1; break;
						}
						
						$creation_success = $image->createThumbnail($head_width, $head_height, $crop_picture, $quality, null, $filename);
						if (!$creation_success) {
							$result[1] = JText::sprintf('MOD_LATESTNEWSENHANCED_ERROR_THUMBNAILCREATIONFAILED', $original_image_src);
						} else {
							$imageheight = $image->getThumbnailHeight();
						}
					} 
				}
			//}
				
			if (empty($result[1])) {
				$top = ($head_height - $imageheight) / 2;
				$result[0] = '<img alt="'.$alt.'" src="'.JURI::base().$filename.'" style="position:relative;top:'.$top.'px" />';
			}
		}
		
		return $result;
	}
	
	static function cropText($text, $letter_count) {
		
		$temp = $text;
		
		if (strlen($text) > $letter_count) {
			$temp = mb_substr($text, 0, $letter_count);
			if (strcmp($temp, $text) != 0) {
				$temp .= '...';
			}
		}
		
		return $temp;
	}	
	
	static function date_to_counter($date, $date_in_future = false) {
		
		$date_origin = new JDate($date);
		$now = new JDate(); // now
		
		if ($date_in_future) {
			$difference = $date_origin->toUnix() - $now->toUnix();
		} else {
			$difference = $now->toUnix() - $date_origin->toUnix();
		}
		
		//$difference = $date_origin->diff($now); // object PHP 5.3 [y] => 0 [m] => 0 [d] => 26 [h] => 23 [i] => 11 [s] => 32 [invert] => 0 [days] => 26
		
		$nbr_days = 0;
		$nbr_hours = 0;
		$nbr_mins = 0;
		$nbr_secs = 0;
		
		if ($difference < 60) { // less than 1 minute
			$nbr_secs = $difference;
		} else if ($difference < 3600) { // less than 1 hour
			$nbr_mins = $difference / 60;
			$nbr_secs = $difference % 60;
		} else if ($difference < 86400) { // less than 1 day
			$nbr_hours = $difference / 3600;
			$nbr_mins = ($difference % 3600) / 60;
			$nbr_secs = $difference % 60;
		} else { // 1 day or more
			$nbr_days = $difference / 86400;
			$nbr_hours = ($difference % 86400) / 3600;
			$nbr_mins = ($difference % 3600) / 60;
			$nbr_secs = $difference % 60;
		}
		
		return array('days' => $nbr_days, 'hours' => $nbr_hours, 'mins' => $nbr_mins, 'secs' => $nbr_secs);		
	}
	
	static function getText($text, $type, $letter_count, $strip_tags, $tags_to_keep) {
		
		$temp = '';
		
		if ($letter_count == 0) {
			return $temp;
		}
			
		if ($letter_count > 0) {
			if ($type == 'html') {
				$temp = strip_tags($text);
				$temp = self::stripPluginTags($temp);
			} else { // 'txt'
				$temp = $text;
			}
				
			$lenTemp = strlen($temp);
			if ($lenTemp > $letter_count) {
				$temp = mb_substr($temp, 0, $letter_count);
				$temp .= '...';
			}
		} else { // take everything
			if ($type == 'html') {
				if ($strip_tags) {
					$temp = strip_tags($text);
					$temp = self::stripPluginTags($temp);
				} else {
					if ($tags_to_keep == '') {
						$temp = $text;
						$temp = self::stripPluginTags($temp);
					} else {
						$temp = strip_tags($text, $tags_to_keep);
						$temp = self::stripPluginTags($temp);
					}
				}
			} else { // 'txt'
				$temp = $text;
			}
		}
		
		return $temp;
	}
	
	static function stripPluginTags($output) {
			
		$plugins = array();
		
		preg_match_all('/\{\w*/', $output, $matches);
		foreach ($matches[0] as $match) {
			$match = str_replace('{', '', $match);
			if (strlen($match)) {
				$plugins[$match] = $match;
			}
		}
			
		$find = array();
		foreach ($plugins as $plugin) {
			$find[] = '\{'.$plugin.'\s?.*?\}.*?\{/'.$plugin.'\}';
			$find[] = '\{'.$plugin.'\s?.*?\}';
		}
		if(!empty($find)) {
			foreach($find as $key=>$f) {
				$f = '/'.str_replace('/','\/',$f).'/';
				$find[$key] = $f;
			}
			$output = preg_replace($find ,'', $output);
		}
		
		return $output;
	}
	
	/**
	 * Pagination initialization
	 */
	static function getPaginationJavascript($target, $step, $num_links, $show_first_last, $prevlabel, $nextlabel, $firstlabel, $lastlabel, $jqueryvar)
	{
		$html = $jqueryvar.'(document).ready(function($) {';
	
		$html .= '$("'.$target.'").pajinate({';
		$html .= '    item_container_id : ".newsitems",';
		$html .= '    nav_panel_id : ".pagination",';
		$html .= '    items_per_page: '.$step.',';
		$html .= '    num_page_links_to_display: '.$num_links.',';
		$html .= '    wrap_around: true,';
		if ($show_first_last) {
			$html .= '    show_first_last: true,';
			$html .= '    nav_label_first: "'.$firstlabel.'",';
			$html .= '    nav_label_last: "'.$lastlabel.'",';
		}
		$html .= '    nav_label_prev: "'.$prevlabel.'",';
		$html .= '    nav_label_next: "'.$nextlabel.'"';
		$html .= '});';
		
		$html .= '});';
	
		return $html;
	}
}
?>