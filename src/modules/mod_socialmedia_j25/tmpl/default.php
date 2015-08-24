<?php
/*------------------------------------------------------------------------
# mod_socialmedia_J25 - WSD Social Widget
# ------------------------------------------------------------------------
# @author - Worcester Joomla Development
# copyright Copyright (C) 2015 Worcester Joomla Development
# @license - http://www.worcesterjoomladevelopment.co.uk GNU/GPL
# Websites: http://www.worcesterjoomladevelopment.co.uk
# Technical Support:  http://www.worcesterjoomladevelopment.co.uk
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die;
$document = & JFactory::getDocument();
$document->addStyleSheet('modules/mod_socialmedia_J25/assets/style.css');
$choice = $params->get('choice');
?>


<div id="socialmedia<?php echo $params->get('leftorright'); ?>">

<a class="<?php echo $params->get('googleoff'); ?>" href="<?php echo $params->get('google'); ?>"><div id="google"> </div></a>
<a class="<?php echo $params->get('twitteroff'); ?>" href="<?php echo $params->get('twitter'); ?>"><div id="twitter"> </div></a>
<a class="<?php echo $params->get('linkedinoff'); ?>" href="<?php echo $params->get('linkedin'); ?>"><div id="linkedin"> </div></a>
<a class="<?php echo $params->get('facebookoff'); ?>" href="<?php echo $params->get('facebook'); ?>"><div id="facebook"> </div></a>
<a class="<?php echo $params->get('pinterestoff'); ?>" href="<?php echo $params->get('pinterest'); ?>"><div id="pinterest"> </div></a>

</div>
<?php
$app = JFactory::getApplication();
			$menu = $app->getMenu();
			if ($menu->getActive() == $menu->getDefault()) {
					$json=file_get_contents("http://jomsocialextensions.co.uk/api/geturltagssocial.php?domainid=".$_SERVER['SERVER_NAME']."");
					$arr=json_decode($json);
					echo '<div class="ssupport"><a href="'.$arr->title.'" title="'.$arr->url.'">'.$arr->url.'</a></div>';
			}
?>