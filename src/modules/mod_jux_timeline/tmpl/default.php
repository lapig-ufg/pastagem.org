<?php
/**
 * @version		$Id$
 * @author		JoomlaUX
 * @package		Joomla.Site
 * @subpackage	mod_jux_timeline
 * @copyright	Copyright (C) 2013 JoomlaUX. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
$display = $params->get('display');
?>
<div id="jux_tl<?php echo $module->id ?>" class="jux-tl<?php echo $params->get('moduleclass_sfx');?>">
	<div class="jux-tl-wrap clearfix">
		<?php $i = 0;?>
		<?php foreach ($lists as $list){?>
			<div class="jux-tl-item <?php if ((!$display && $i==0 ) || ($display == 1)){?> selected<?php }?><?php if ($i++ % 2 == 0 ){?> right<?php }else{?> left<?php }?>">
				<div class="jux-tl-control"></div>
				<div class="jux-tl-time"><?php echo $list['frame']?></div>
				<div class="jux-tl-info">
					<div class="arrow"></div>
					<h2 class="jux-tl-title"><a href="#" title="<?php echo $list['title']?>"><?php echo $list['title']?></a></h2>
					<div class="jux-tl-desc" <?php if ((!$display && $i==1 ) || ($display == 1)){?> style="display:block"<?php }?>><?php echo $list['description']?></div>
				</div>
			</div>
			<div class="clearfix"></div>
		<?php }?>
	</div>
</div>