<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once (dirname(__FILE__).'/helpers/helper.php');

jimport('joomla.filesystem.folder');

$list = null;

$layout = $params->get('layout', 'default'); // returns _:default by default
$layout_path = explode(':', $layout);
$layout_filename = $layout_path[1];

$k2_exists = false;
$folder = JPATH_ROOT.'/components/com_k2';
if (JFolder::exists($folder)) {
	$k2_exists = true;
}

switch ($layout_filename) {
	case 'k2':
		if ($k2_exists) {
			require_once (dirname(__FILE__).'/helpers/helper_k2.php');
			$list = modLatestNewsEnhancedHelperK2::getList($params, $module);
		}
		break;
	default:
		require_once (dirname(__FILE__).'/helpers/helper_standard.php');
		$list = modLatestNewsEnhancedHelperStandard::getList($params, $module);
		break;
}

if (empty($list)) {
	return;
}

jimport('syw.libraries');
jimport('syw.utilities');

$isjoomla3plus = SYWUtilities::isJoomla3();

// parameters

$doc = JFactory::getDocument();

$show_errors = $params->get('show_errors', 0);

$head_align = $params->get('head_align', 'left');

$default_picture = trim($params->get('default_picture', ''));
if (!empty($default_picture)) {
	$default_picture = JURI::base().$default_picture;
}

$link_text = trim($params->get('link', ''));

$show_category = false;
$link_category = true;
switch ($params->get('show_cat', 0)) {
	case 1: $show_category = true; break; // show and link
	case 2: $show_category = true; $link_category = false; break; // show
	default: break; // hide
}

$cat_link_text = trim($params->get('cat_link', ''));

$head_type = $params->get('head_type', 'none');
$head_width = trim($params->get('head_w', 64));
$head_height = trim($params->get('head_h', 64));
$show_weekday = $params->get('show_weekday', 1);
$show_year = $params->get('show_year', 1);
$show_time = $params->get('show_time', 0);
$show_link = $params->get('link_to_article', 1);
$append_link = $params->get('append_link', 0);

$show_hits = $params->get('show_hits', 1);
$show_author = $params->get('show_author', 1);
$show_date = $params->get('show_date', 'none');
$date_format = $params->get('d_format', 'd F Y');
$author_place = $params->get('author_place', 1);

$show_image = false;
$show_calendar = false;
if ($head_type == "image") {
	$show_image = true;
} else if ($head_type == "calendar") {
	$show_calendar = true;
}

$keep_space = $params->get('keep_image_space', 1);

$title_html_tag = $params->get('t_tag', '4');

$show_title = true;
if (trim($params->get('letter_count_title', '')) == '0') {
	$show_title = false;
}

//$class = htmlspecialchars($params->get('moduleclass_sfx'));
//$class_suffix = (empty($class)) ? $module->id : trim($class);

// leave moduleclass_sfx for the template
$class_suffix = $module->id;

jimport('joomla.environment.browser');
$browser = JBrowser::getInstance();
$browser_name = $browser->getBrowser();
$browser_version = $browser->getVersion();

$news_width = $params->get('news_width', 100);
if ($news_width <= 0 || $news_width > 100) {
	$news_width = 100;
}

$extra_path = '';
if ($show_image || $show_calendar) {
	$extra_path .= "&amp;head_w=".$head_width."&amp;head_h=".$head_height;

	$wrap_text = $params->get('wrap', 0);
	if ($wrap_text == 1) {
		$extra_path .= "&amp;wrap=".$wrap_text;
	}
}

if ($params->get('force_one_line', false)) {
	$extra_path .= "&amp;title_fl=1";
}

$font_ref = $params->get('f_r', 14);
if ($font_ref > 0) {
	$extra_path .= "&amp;font_s=".$font_ref;
}

$urlPath = JURI::base()."modules/mod_latestnewsenhanced/";
if ($params->get('simple_style', 0)) {
	$doc->addStyleSheet($urlPath."simplifiedstyle.css.php?security=".defined('_JEXEC')."&amp;suffix=".$class_suffix."&amp;item_w=".$news_width.$extra_path);
} else {
	$doc->addStyleSheet($urlPath."style.css.php?security=".defined('_JEXEC')."&amp;suffix=".$class_suffix."&amp;item_w=".$news_width.$extra_path);
}

// add user styles
	
$styles = trim($params->get('styles', ''));

$extraclass = ' noimage';
if ($show_calendar && !empty($default_picture)) {
	$styles .= ".latestnewsenhanced_".$class_suffix." .newshead .calendar.image {";
	$styles .= "background: transparent url(".$default_picture.") top center no-repeat !important;";
	$styles .= "} ";

	$extraclass = ' image';
}

if (!empty($styles)) {
	$styles = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $styles); // minify the CSS code
	$doc->addStyleDeclaration($styles);
}

if ($params->get('paginate', 0)) {
	$jquery_var = 'syw';
	if ($isjoomla3plus) {
		JHtml::_('jquery.framework');
		$jquery_var = 'jQuery';
	} else {
		$load_jquery = $params->get('load_jquery', 0);
		if ($load_jquery > 0) {
			$jquery_version = $params->get('jquery_version', '1.8.3');
			SYWLibraries::loadJQuery($load_jquery == 1 ? false : true, $jquery_version);
		}
		SYWLibraries::loadJQueryNoConflict();
	}
	
	SYWLibraries::loadPagination();
	
	$steps = $params->get('steps', 3);
	$num_links = $params->get('num_links', 5);
	$show_first_last = $params->get('show_first_last', false);
	$label_first = trim($params->get('label_first', '')) == '' ? JText::_('JFIRST') : trim($params->get('label_first', ''));
	$label_next = trim($params->get('label_next', '')) == '' ? JText::_('JNEXT') : trim($params->get('label_next', ''));
	$label_prev = trim($params->get('label_prev', '')) == '' ? JText::_('JPREV') : trim($params->get('label_prev', ''));
	$label_last = trim($params->get('label_last', '')) == '' ? JText::_('JLAST') : trim($params->get('label_last', ''));
	
	$doc->addScriptDeclaration(modLatestNewsEnhancedHelper::getPaginationJavascript('.latestnewsenhanced_'.$class_suffix.'.newslist', $steps, $num_links, $show_first_last, $label_prev, $label_next, $label_first, $label_last, $jquery_var));
}

require JModuleHelper::getLayoutPath('mod_latestnewsenhanced', $layout);
?>
