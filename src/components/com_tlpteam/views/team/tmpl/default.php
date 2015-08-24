<?php
/**
 * @version     1.0.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// no direct access
defined('_JEXEC') or die;

$setting = TlpteamHelper::config();
$image_storiage_path = $setting->imagepath.'/';
$image_grid=$setting->detailpage_image_grid;
$content_grid=12-$image_grid;
echo TlpteamHelper::contentJDispatchEvents('');
?>
<?php if ($this->item) : ?>

    <div class="team-detail">
         	<div class="row-fluid">
            	<div class="span<?php echo $image_grid;?>">
                <div class="image-area">
            	 <?php
					if (!empty($this->item->profile_image)){ ?>
						<img class = "img-responsive" style="text-align:center" src="<?php echo JUri::base().$image_storiage_path.'l_'.$this->item->profile_image;?>" /></a>
						<?php
					}else{ ?>
					
				<?php }?>
               <!-- <div class="tlp-team-social">
                 <ul>
                   <?php if($this->item->facebook!=''){?><li ><a class="tlp-facebook-icon"  href="<?php echo $this->item->facebook;?>" target="_new">facebook </a></li><?php }?>
                   <?php if($this->item->twitter!=''){?><li ><a  class="tlp-twitter-icon" href="<?php echo $this->item->twitter;?>" target="_new">twitter</a></li><?php }?>
                   <?php if($this->item->googleplus!=''){?><li ><a  class="tlp-googleplus-icon" href="<?php echo $this->item->googleplus;?>" target="_new">googleplus </a></li><?php }?>
                   <?php if($this->item->linkedin!=''){?><li ><a  class="tlp-linkedin-icon" href="<?php echo $this->item->linkedin;?>" target="_new">linkedin</a></li><?php }?>
                 </ul>
            	</div> -->
               </div>	
        	 </div>
                
                <div class="span<?php echo $content_grid;?>">
                	<div class="profile-area">
                        <h3 style="text-align:left"><?php echo $this->item->name; ?></h3>
                        <h4 style="text-align:left;"><?php echo $this->item->position; ?></h4>
                        <br>
                        <?php if($this->item->email!=''){?><div class="tlp-email-icon"><a  href="mailto:<?php echo $this->item->email; ?>"><?php echo $this->item->email; ?></a></div><?php }?>
                        <?php if($this->item->web!=''){?><div class="tlp-web-icon"><a href="<?php echo $this->item->web; ?>" target="_new"><?php echo $this->item->web; ?></a></div><?php }?>
                        <br>
                        <?php if($this->item->phone!=''){?><div class="tlp-tel-icon"><a  href="tell:<?php echo $this->item->phone; ?>"><?php echo $this->item->phone; ?></a></div><?php }?>
                        <?php echo $this->item->detail_bio; ?>
                    </div>
                </div>
            </div>       
    </div>
    
    <?php
else:
    echo JText::_('COM_TLPTEAM_ITEM_NOT_LOADED');
endif;
?>
