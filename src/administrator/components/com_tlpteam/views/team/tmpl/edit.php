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
        if (task == 'team.cancel') {
            Joomla.submitform(task, document.getElementById('team-form'));
        }
        else {
            
				js = jQuery.noConflict();
				if(js('#jform_profile_image').val() != ''){
					js('#jform_profile_image_hidden').val(js('#jform_profile_image').val());
				}
            if (task != 'team.cancel' && document.formvalidator.isValid(document.id('team-form'))) {
                
                Joomla.submitform(task, document.getElementById('team-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_tlpteam&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="team-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_TLPTEAM_TITLE_TEAM', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
            <fieldset class="adminform">
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('position'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('position'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('profile_image'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('profile_image'); ?></div>
			</div>

				<?php if (!empty($this->item->profile_image)) : ?>
						
				<?php endif; ?>
				<input type="hidden" name="jform[profile_image]" id="jform_profile_image_hidden" value="<?php echo $this->item->profile_image ?>" />			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('email'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('email'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('phone'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('phone'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('short_bio'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('short_bio'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('detail_bio'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail_bio'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('facebook'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('facebook'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('twitter'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('twitter'); ?></div>
			</div>
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('googleplus'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('googleplus'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('linkedin'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('linkedin'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('web'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('web'); ?></div>
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