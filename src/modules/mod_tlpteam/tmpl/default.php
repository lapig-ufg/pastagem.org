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

$setting = TlpteamHelper::config();
$image_storiage_path = $setting->imagepath.'/';
?>
  <!-- <div id="tlp-team-module" class="owl-carousel owl-theme">
     <?php
    foreach ($rows as $row){
	?>
 
        <div class="item">
              <?php
      		if (!empty($row->profile_image)){ ?>
      			<a href="<?php echo JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $row->id); ?>"><img src="<?php echo JURI::root().$image_storiage_path.'l_'.$row->profile_image;?>" /></a>
      			<?php
      		}else{ ?>
              	<img class="hwllow" src="<?php echo JURI::root().$image_storiage_path?>/noimage.jpg" alt="noimage" />
              <?php }?>
        		<div class="tlp-team-name"><h3><a href="<?php echo JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $row->id); ?>">
      				<?php echo $row->name; ?></a></h3></div>
               <div class="tlp-team-position"><h4><?php echo $row->position; ?></h4></div> 
               <?php if($shortbio=='true'){?>
               <div class="tlp-team-short-bio"><?php echo substr($row->short_bio,0,$shortbiolimit) ?></div> 
               <?php }?>
               <div class="tlp-team-social">
                 <ul>
                   <?php if($row->facebook!=''){?><li ><a class="tlp-facebook-icon"  href="<?php echo $row->facebook;?>" target="_new">facebook </a></li><?php }?>
                   <?php if($row->twitter!=''){?><li ><a  class="tlp-twitter-icon" href="<?php echo $row->twitter;?>" target="_new">twitter</a></li><?php }?>
                   <?php if($row->googleplus!=''){?><li ><a  class="tlp-googleplus-icon" href="<?php echo $row->googleplus;?>" target="_new">googleplus </a></li><?php }?>
                   <?php if($row->linkedin!=''){?><li ><a  class="tlp-linkedin-icon" href="<?php echo $row->linkedin;?>" target="_new">linkedin</a></li><?php }?>
                 </ul>
                 
             
               </div> 
               <div class="tlp-cb"></div>
        </div>
   	
	
     <?php } ?>
    
    </div>     -->
 <script>

$(document).ready(function() {
  $("#tlp-team-module").owlCarousel({
    items : <?php echo $showno;?>,
    itemsCustom : false,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [980,3],
    itemsTablet: [768,2],
    itemsTabletSmall: false,
    itemsMobile : [479,1],
    singleItem : false,
    itemsScaleUp : false,
 
    //Basic Speeds
    slideSpeed : <?php echo $speed;?>,
    paginationSpeed : 800,
    rewindSpeed : 800,
 
    //Autoplay
    autoPlay : <?php echo $autoplay;?>,
    stopOnHover : false,
 
    // Navigation
    navigation : <?php echo $navigation;?>,
    navigationText : ["prev","next"],
    rewindNav : true,
    scrollPerPage : false,
 
    //Pagination
    pagination : <?php echo $pagination;?>,
    paginationNumbers: false,
 
    // Responsive 
    responsive: <?php echo $responsive;?>,
    responsiveRefreshRate : 200,
    responsiveBaseWidth: window,
 
    // CSS Styles
    baseClass : "owl-carousel",
    theme : "owl-theme",
 
    //Lazy load
    lazyLoad : <?php echo $lazyload;?>,
    lazyFollow : true,
    lazyEffect : "fade",
 
    //Auto height
    autoHeight : false,
  });
  
});
$(function() {
    $('.item').matchHeight();
});
  
 </script>