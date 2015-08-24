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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_tlpteam/assets/css/tlpteam.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'setting.cancel') {
            Joomla.submitform(task, document.getElementById('setting-form'));
        }
        else {
            
				
            if (task != 'setting.cancel' && document.formvalidator.isValid(document.id('setting-form'))) {
                
                Joomla.submitform(task, document.getElementById('setting-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_tlpteam&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="setting-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_TLPTEAM_TITLE_SETTINGS', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
            <fieldset class="adminform">
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('imagepath'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('imagepath'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('smallwidth'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('smallwidth'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('smallheight'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('smallheight'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('mediumwidth'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('mediumwidth'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('mediumheight'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('mediumheight'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('largewidth'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('largewidth'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('largeheight'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('largeheight'); ?></div>
			</div>
            
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('display_no'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('display_no'); ?></div>
			</div>
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('enable_bootstrap_css'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('enable_bootstrap_css'); ?></div>
			</div>
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('detailpage_image_grid'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detailpage_image_grid'); ?></div>
			</div>
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('detailpage_content_grid'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detailpage_content_grid'); ?></div>
			</div>
            
			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>
		 </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>