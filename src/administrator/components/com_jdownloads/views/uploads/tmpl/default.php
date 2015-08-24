<?php
/**
 * @package jDownloads
 * @version 2.5  
 * @copyright (C) 2007 - 2013 - Arno Betz - www.jdownloads.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
 * 
 * jDownloads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

/*
# This upload script is original from the component com_mediamu and is only modified to use it with jDownloads 
# ------------------------------------------------------------------------
@author Ljubisa - ljufisha.blogspot.com
@copyright Copyright (C) 2012 ljufisha.blogspot.com. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
Technical Support: http://ljufisha.blogspot.com
*/

// no direct access
defined('_JEXEC') or die('Restricted Access');

?>
<div class="jdlists-header-info"><?php echo '<img align="left" src="'.JURI::root().'administrator/components/com_jdownloads/assets/images/info22.png" width="22" height="22" border="0" alt="" />&nbsp;&nbsp;'.JText::_('COM_JDOWNLOADS_UPLOADER_DESC').'<br /><br />'.JText::_('COM_JDOWNLOADS_UPLOADER_DESC2'); ?> </div>
    <div class="clr"> </div> 
<div id="mediamu_wrapper">
    <div id="uploader_content">
        <?php
         echo $this->loadTemplate('uploader'); ?>
    </div>
</div>
