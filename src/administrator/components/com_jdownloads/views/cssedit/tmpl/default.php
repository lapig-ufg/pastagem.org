<?php
/**
 * @package jDownloads
 * @version 2.0  
 * @copyright (C) 2007 - 2012 - Arno Betz - www.jdownloads.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
 * 
 * jDownloads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */
 
defined('_JEXEC') or die('Restricted access');

global $jlistConfig; 

JHtml::_('behavior.tooltip');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jdownloads');?>" method="post" name="adminForm" id="adminForm">
    
    <div>
        <fieldset style="background-color: #ffffff;" class="uploadform">
            <legend><?php echo JText::_(''); ?></legend>
                       
             <label id="csstext-lbl" class="hasTip" title="" for="csstext">
             <strong>
             <?php echo JText::_('COM_JDOWNLOADS_BACKEND_EDIT_CSS_WRITE_STATUS_TEXT')." ";
                if ($this->cssfile_writable) {
                    echo JText::_('COM_JDOWNLOADS_BACKEND_EDIT_LANG_CSS_FILE_WRITABLE_YES');
                } else {
                    echo JText::_('COM_JDOWNLOADS_BACKEND_EDIT_LANG_CSS_FILE_WRITABLE_NO'); ?>
                    </strong>
                    <br />
                    <?php echo JText::_('COM_JDOWNLOADS_BACKEND_EDIT_LANG_CSS_FILE_WRITABLE_INFO'); ?><br />
            <?php } ?>
            <br /><br /><strong><?php echo JText::_('COM_JDOWNLOADS_BACKEND_EDIT_CSS_FIELD_TITLE').': </strong>'.$this->cssfile; ?><br />
            </label>
            
            <div class="clr"></div>
            <textarea class="input_box" name="cssfile" cols="120" rows="30"><?php echo $this->csstext; ?></textarea>
        </fieldset>
    </div>
    
    <div>
        <fieldset style="background-color: #ffffff;" class="uploadform">
            <legend><?php echo JText::_(''); ?></legend>
                       
             <label id="csstext-lbl" class="hasTip" title="" for="csstext2">
             <strong>
             <?php echo JText::_('COM_JDOWNLOADS_BACKEND_EDIT_CSS_WRITE_STATUS_TEXT')." ";
                if ($this->cssfile_writable2) {
                    echo JText::_('COM_JDOWNLOADS_BACKEND_EDIT_LANG_CSS_FILE_WRITABLE_YES');
                } else {
                    echo JText::_('COM_JDOWNLOADS_BACKEND_EDIT_LANG_CSS_FILE_WRITABLE_NO'); ?>
                    </strong>
                    <br />
                    <?php echo JText::_('COM_JDOWNLOADS_BACKEND_EDIT_LANG_CSS_FILE_WRITABLE_INFO'); ?><br />
            <?php } ?>
            <br /><br /><strong><?php echo JText::_('COM_JDOWNLOADS_BACKEND_EDIT_CSS_FIELD_TITLE').': </strong>'.$this->cssfile2; ?><br />
            </label>
            
            <div class="clr"></div>
            <textarea class="input_box" name="cssfile2" cols="120" rows="30"><?php echo $this->csstext2; ?></textarea>
        </fieldset>
    </div>    
  
    <input type="hidden" name="option" value="com_jdownloads" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="view" value="cssedit" />
    <input type="hidden" name="hidemainmenu" value="0" />
    
    <?php echo JHtml::_('form.token'); ?>
   </form>
