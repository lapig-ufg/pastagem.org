<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
 
// no direct access
defined('_JEXEC') or die;

$i = 0;
$oddoreven = "even";

$catlink = '';
$cat_label = '';
$nbr_cat = 0;

foreach ($list as $item) {
	$tmp = $item->catlink;
	if ($catlink != $tmp) {
		$nbr_cat++;
		$catlink = $tmp;
		$cat_label = $item->category_title;
	}
}
if (!empty($cat_link_text)) {
	$cat_label = $cat_link_text;
}
?>

<div class="latestnewsenhanced_<?php echo $class_suffix; ?> newslist">
	<ul class="newsitems">
		<?php foreach ($list as $item) :  ?>		
			<?php				
				// check if the link is the same of the article activaly shown 
				$css_extra = '';
				$current_url = JURI::current();				
				if (stripos($current_url, $item->link) !== false) { // the URL contains $item->link
					$css_extra = ' active';
				}	
			?>
			<li class="newsitem<?php echo $css_extra; ?>">
				<?php if ($show_errors && !empty($item->error)) : ?>
					<div class="error-message">
						<dl>
							<dt><?php echo JText::_('ERROR'); ?></dt>
							<dd><?php echo $item->error; ?></dd>
						</dl>
					</div>
				<?php endif; ?>
			
				<?php
					// head positioning
					if ($show_image || $show_calendar) {
						if ($params->get('head_align') == "alternate") {			
							$head_align = ($i % 2) ? "right" : "left";			
						}
					} 
					
					$oddoreven = ($i % 2) ? "even" : "odd";
					
					if ($show_category && $nbr_cat > 1) {
						$cat_label = $cat_link_text;
						if (empty($cat_label)) {
							$cat_label = $item->category_title;
						}
					}
					
					if ($show_calendar && !empty($item->date)) {
						jimport('joomla.utilities.date');
						$article_date = new JDate($item->date);
						
						$weekday = $article_date->format('D');
						$day = $article_date->format('d'); 			
						$month = $article_date->format('M');
						$year = $article_date->format('Y');						
						
						$time_format = $params->get('t_format', 'H:i');	
						$time = JHTML::_('date', $item->date, $time_format); // $time = date_format(new DateTime($item->date), $time_format);
					}	
					
					$div_extra = '';
					if ($show_hits || $show_author || $show_date != 'none') {
						$div_extra .= '<div class="newsextra">';	

						if ($show_hits) {
							$div_extra .= '<span class="hits">'.$item->hits.' '.strtolower(JText::_('JGLOBAL_HITS')).'</span>';
							
							if ($show_author || $show_date != 'none') {
								$div_extra .= '<span class="delimiter"></span>';
							}
						}
						
						if ($show_author) {
							$div_extra .= '<span class="newsauthor">'.$item->author.'</span>';
							
							if ($show_date != 'none') {
								$div_extra .= '<span class="delimiter"></span>';
							}
						}
						
						if ($show_date != 'none') {
							if (empty($item->date)) {
								$div_extra .= '<span class="nodate"></span>';
							} else {
								$postdate = $params->get('post_date', 'published');
								$div_extra .= '<span class="newsdate">';
								if ($show_date == 'date') {
									$div_extra .= JHTML::_('date', $item->date, $date_format);
								} else if ($show_date == 'ago') {
									if ($item->nbr_days == 0) {
										$div_extra .= JText::_('MOD_LATESTNEWSENHANCED_TODAY');
									} else if ($item->nbr_days == 1) {
										if ($postdate == 'finished') {
											$div_extra .= JText::_('MOD_LATESTNEWSENHANCED_TOMORROW');
										} else {
											$div_extra .= JText::_('MOD_LATESTNEWSENHANCED_YESTERDAY');
										}
									} else {
										if ($postdate == 'finished') {
											$div_extra .= JText::sprintf('MOD_LATESTNEWSENHANCED_INDAYSONLY', $item->nbr_days);
										} else {
											$div_extra .= JText::sprintf('MOD_LATESTNEWSENHANCED_DAYSAGO', $item->nbr_days);
										}
									}
								} else {
									if ($item->nbr_days > 0) {
										if ($postdate == 'finished') {
											$div_extra .= JText::sprintf('MOD_LATESTNEWSENHANCED_INDAYS', $item->nbr_days, $item->nbr_hours, $item->nbr_minutes);
										} else {
											$div_extra .= JText::sprintf('MOD_LATESTNEWSENHANCED_DAYS', $item->nbr_days, $item->nbr_hours, $item->nbr_minutes);
										}
									} else if ($item->nbr_hours > 0) {
										if ($postdate == 'finished') {
											$div_extra .= JText::sprintf('MOD_LATESTNEWSENHANCED_INHOURS', $item->nbr_hours, $item->nbr_minutes);
										} else {
											$div_extra .= JText::sprintf('MOD_LATESTNEWSENHANCED_HOURS', $item->nbr_hours, $item->nbr_minutes);
										}
									} else {										
										if ($postdate == 'finished') {
											$div_extra .= JText::sprintf('MOD_LATESTNEWSENHANCED_INMINUTES', $item->nbr_minutes);
										} else {
											$div_extra .= JText::sprintf('MOD_LATESTNEWSENHANCED_MINUTES', $item->nbr_minutes);
										}
									}
								}
								$div_extra .= '</span>';
							}
						}							
						$div_extra .= '</div>';
					}
					
					$i++;
				?>		
			
				<div class="news <?php echo $oddoreven; ?>">	
						
					<?php if ($show_image) : ?>
					
						<?php if (!empty($item->imagetag) || !empty($default_picture) || $keep_space) : ?>		
							<div class="newshead head<?php echo $head_align ?>">
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
								<?php elseif ($keep_space) : ?>	
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
							</div>		
						<?php endif; ?>	
								
					<?php elseif ($show_calendar) : ?>
						<?php if (!empty($item->date) || $keep_space) : ?>						
							<div class="newshead head<?php echo $head_align ?>">	
								<?php if (!empty($item->date)) : ?>					
									<div class="calendar<?php echo $extraclass; ?>">
										<?php if ($show_weekday) : ?>
											<div class="weekday"><span><?php echo $weekday; ?></span></div>
										<?php endif; ?>
										<div class="month"><span><?php echo $month; ?></span></div>
										<div class="day"><span><?php echo $day; ?></span></div>					
										<?php if ($show_year) : ?>
											<div class="year"><span><?php echo $year; ?></span></div>
										<?php endif; ?>
										<?php if ($show_time) : ?>
											<div class="time"><span><?php echo $time; ?></span></div>
										<?php endif; ?>
									</div>
								<?php elseif ($keep_space) : ?>	
									<div class="nodate"></div>
								<?php endif; ?>	
							</div>
						<?php endif; ?>		
					<?php endif; ?>
			
					<?php if ($show_image && empty($item->imagetag) && empty($default_picture) && !$keep_space) : ?>
						<div class="newsinfo infonoimage<?php echo $head_align ?>">
					<?php else : ?>
						<div class="newsinfo info<?php echo $head_align ?>">
					<?php endif; ?>			
					
						<?php if ($div_extra != '' && $author_place == 0) : ?>
							<?php echo $div_extra; ?>
						<?php endif; ?>
					
						<?php if ($show_title) : ?>
							<h<?php echo $title_html_tag; ?> class="newstitle">
								<?php if ($show_link) : ?>
									<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" >
										<span><?php echo $item->title; ?></span>
									</a>
								<?php else : ?>
									<span><?php echo $item->title; ?></span>
								<?php endif; ?>
							</h<?php echo $title_html_tag; ?>>
						<?php endif; ?>
						
						<?php if ($div_extra != '' && $author_place == 1) : ?>
							<?php echo $div_extra; ?>
						<?php endif; ?>				
						
						<?php if (!empty($item->text)) : ?>
							<div class="newsintro">
								<?php echo $item->text; ?>
								<?php if (!empty($link_text) && $append_link) : ?>
									<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" class="inlinelink">
										<span><?php echo $link_text; ?></span>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					
						<?php if ($div_extra != '' && $author_place == 2) : ?>
							<?php echo $div_extra; ?>
						<?php endif; ?>
						
						<?php if (!empty($link_text) && !$append_link) : ?>					
							<div class="link">
								<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" >
									<span><?php echo $link_text; ?></span>
								</a>
							</div>
						<?php endif; ?>
						
						<?php if ($show_category && $nbr_cat > 1) : ?>					
							<div class="catlink">
								<?php if ($link_category) : ?>
									<a href="<?php echo $item->catlink; ?>" title="<?php echo $cat_label; ?>">
										<span><?php echo $cat_label; ?></span>
									</a>
								<?php else : ?>
									<span><?php echo $cat_label; ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>	
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<div class="pagination"></div>
				
<?php if ($show_category && $nbr_cat == 1) : ?>					
	<div class="onecatlink">
		<?php if ($link_category) : ?>
			<a href="<?php echo $catlink; ?>" title="<?php echo $cat_label; ?>">
				<span><?php echo $cat_label; ?></span>
			</a>
		<?php else : ?>
			<span><?php echo $cat_label; ?></span>
		<?php endif; ?>
	</div>
<?php endif; ?>

</div>
