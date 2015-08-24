<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
 
// no direct access
defined('_JEXEC') or die;

$document = JFactory::getDocument();

$head_align = $params->get('head_align', 'left');

$default_picture = trim($params->get('default_picture', ''));
if (!empty($default_picture)) {
	$default_picture = JURI::base().$default_picture;
}

$link_text = trim($params->get('link', ''));
$cat_link_text = trim($params->get('cat_link', ''));
$head_type = $params->get('head_type', 'none');
$head_width = trim($params->get('head_w', '64'));
$head_height = trim($params->get('head_h', '64'));
$show_weekday = $params->get('show_weekday', 1);
$show_year = $params->get('show_year', 1);
$show_link = $params->get('link_to_article', 1);

$show_author = $params->get('show_author', 1);
$show_date = $params->get('show_date', 'none');
$author_place = $params->get('author_place', 1);

$show_image = false;
$show_calendar = false;
if ($head_type == "image") {
	$show_image = true;
} else if ($head_type == "calendar") {
	$show_calendar = true;
}

$class = htmlspecialchars($params->get('moduleclass_sfx'));
$class_suffix = (empty($class)) ? $module->id : trim($class);

$urlPath = JURI::base()."modules/mod_latestnewsenhanced/";
$document->addStyleSheet($urlPath."style.css.php?suffix=".$class_suffix);

jimport('joomla.environment.browser');
$browser = JBrowser::getInstance();
$name = $browser->getBrowser();
$version = $browser->getVersion();

if ($name == 'msie' && $version == '7.0') {
	$document->addStyleSheet($urlPath."style_msie_7.css.php?suffix=".$class_suffix);
}

$style = ".latestnewsenhanced_".$class_suffix." .newshead .picture, ";
$style .= ".latestnewsenhanced_".$class_suffix." .newshead .nopicture, ";
$style .= ".latestnewsenhanced_".$class_suffix." .newshead .calendar {";
$style .= "width: ".$head_width."px;";
$style .= "height: ".$head_height."px;";
$style .= "min-width: ".$head_width."px;";
$style .= "min-height: ".$head_height."px;";
$style .= "} ";

if ($show_image || $show_calendar) {
	$style .= ".latestnewsenhanced_".$class_suffix." .infoleft {";
	$style .= "margin-left: ".$head_width."px;";
	$style .= "} ";
		
	$style .= ".latestnewsenhanced_".$class_suffix." .inforight {";
	$style .= "margin-right: ".$head_width."px;";
	$style .= "} ";
}

$extraclass = 'noimage';
if ($show_calendar && !empty($default_picture)) {
	$style .= ".latestnewsenhanced_".$class_suffix." .newshead .calendar.image {";
	$style .= "background: transparent url(".$default_picture.") top center no-repeat !important;";
	$style .= "} ";
	
	$extraclass = 'image';
}

$document->addStyleDeclaration($style);

$i = 0;
$oddoreven = "even";

$catlink = '';
$nbr_cat = 0;

foreach ($list as $item) {
	$tmp = $item->catlink;
	if ($catlink != $tmp) {
		$nbr_cat++;
		$catlink = $tmp;
	}
}
?>

<br />
<div class="latestnewsenhanced_<?php echo $class_suffix; ?> newslist">
<?php foreach ($list as $item) :  ?>

	<?php
		// head positioning
		if ($show_image || $show_calendar) {
			if ($params->get('head_align') == "alternate") {			
				$head_align = ($i % 2) ? "right" : "left";			
			}
		} else {
			$head_align = "none";
		}
		
		$oddoreven = ($i % 2) ? "even" : "odd";
		
		if ($show_calendar) {
			$weekday = JText::_(date('D', strtotime($item->date))); // 3 letters / translate from fr-FR.ini for instance
			$day = date('d', strtotime($item->date)); // 01-31				
			$month = JText::_(date('F', strtotime($item->date)).'_SHORT'); // 3 letters				
			$year = date('Y', strtotime($item->date)); // 4 chars
		}	
		
		$div_extra = '';
		if ($show_author || $show_date != 'none') {
			$div_extra .= '<div class="newsextra">';			
			if ($show_author) {
				$div_extra .= '<span class="newsauthor">'.$item->author.'</span>';
			}
			if ($show_author && $show_date != 'none') {
				$div_extra .= '<span class="delimiter">&nbsp;.&nbsp;</span>';
			}
			if ($show_date != 'none') {
				$div_extra .= '<span class="newsdate">';
				if ($show_date == 'date') {
					$div_extra .= JHTML::_('date', $item->date, JText::_('DATE_FORMAT_LC3'));
				} else {
					if ($item->ago == 0) {
						$div_extra .= JText::_('MOD_LATESTNEWSENHANCED_TODAY');
					} elseif ($item->ago == 1) {
						$div_extra .= JText::_('MOD_LATESTNEWSENHANCED_YESTERDAY');
					} else {
						$div_extra .= $item->ago.'&nbsp;'.JText::_('MOD_LATESTNEWSENHANCED_DAYSAGO');
					}
				}
				$div_extra .= '</span>';
			}							
			$div_extra .= '</div>';
		}
		
		$i++;
	?>

	<div class="news">
		<div class="innernews <?php echo $oddoreven; ?>">
	
			<div class="newshead head<?php echo $head_align ?>">
				
				<?php if ($show_image) : ?>				
					
					<?php if (!empty($item->imagetag)) : ?>	
						<div class="picture">
							<?php if ($show_link) : ?>
								<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" >
									<?php echo $item->imagetag; ?>
								</a>
							<?php else : ?>
								<?php echo $item->imagetag; ?>
							<?php endif; ?>							
						</div>
					<?php elseif (!empty($default_picture)) : ?>	
						<div class="picture">
							<?php if ($show_link) : ?>
								<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" >
									<?php echo JHTML::_('image', $default_picture, '', array('class' => 'defaultpicture')); ?>
								</a>
							<?php else : ?>
								<?php echo JHTML::_('image', $default_picture, '', array('class' => 'defaultpicture')); ?>
							<?php endif; ?>							
						</div>
					<?php else : ?>	
						<div class="nopicture">
							<?php if ($show_link) : ?>
								<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" >
									<span>&nbsp;</span>
								</a>
							<?php else : ?>
								<span>&nbsp;</span>
							<?php endif; ?>							
						</div>
					<?php endif; ?>						
				
				<?php elseif ($show_calendar) : ?>
					<div class="calendar <?php echo $extraclass; ?>">
						<?php if ($show_weekday) : ?>
							<div class="weekday"><span><?php echo $weekday; ?></span></div>
						<?php endif; ?>
						<div class="month"><span><?php echo $month; ?></span></div>
						<div class="day"><span><?php echo $day; ?></span></div>					
						<?php if ($show_year) : ?>
							<div class="year"><span><?php echo $year; ?></span></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				
			</div>
	
			<div class="newsinfo info<?php echo $head_align ?>">
			
				<?php if ($div_extra != '' && $author_place == 0) : ?>
					<?php echo $div_extra; ?>
				<?php endif; ?>
			
				<div class="newstitle">
					<?php if ($show_link) : ?>
						<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" >
							<span><?php echo $item->title; ?></span>
						</a>
					<?php else : ?>
						<span><?php echo $item->title; ?></span>
					<?php endif; ?>
				</div>
				
				<?php if ($div_extra != '' && $author_place == 1) : ?>
					<?php echo $div_extra; ?>
				<?php endif; ?>				
				
				<?php if (!empty($item->text)) : ?>
					<div class="newsintro">
						<span><?php echo $item->text; ?></span>
					</div>
				<?php endif; ?>
			
				<?php if ($div_extra != '' && $author_place == 2) : ?>
					<?php echo $div_extra; ?>
				<?php endif; ?>
				
				<?php if (!empty($link_text)) : ?>					
					<div class="link">
						<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" >
							<span><?php echo $link_text; ?></span>
						</a>
					</div>
				<?php endif; ?>
				
				<?php if (!empty($cat_link_text) && $nbr_cat > 1) : ?>					
					<div class="catlink">
						<a href="<?php echo $item->catlink; ?>">
							<span><?php echo $cat_link_text; ?></span>
						</a>
					</div>
				<?php endif; ?>
			</div>	
		</div>
	</div>
<?php endforeach; ?>
				
<?php if (!empty($cat_link_text) && $nbr_cat == 1) : ?>					
	<div class="onecatlink">
		<a href="<?php echo $catlink; ?>">
			<span><?php echo $cat_link_text; ?></span>
		</a>
	</div>
<?php endif; ?>
</div>
