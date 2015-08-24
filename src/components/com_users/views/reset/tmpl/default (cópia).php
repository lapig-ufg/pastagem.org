<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>
<div class="reset<?php echo $this->pageclass_sfx?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>

	<form id="reset-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>" method="post" class="form-validate">

		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
		<p><?php echo JText::_($fieldset->label); ?></p>		<fieldset>
			<dl>
			<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field): ?>
				<div class="row-fluid" style="margin-bottom: 10px;">
					<div class="span3" style="margin-top: 4px;">
						<dt><?php echo $field->label; ?></dt>
					</div>
					<div class="span9">
						<dd><?php echo $field->input; ?></dd>
					</div>
				</div>
			<?php endforeach; ?>
			</dl>
		</fieldset>
		<?php endforeach; ?>
		<div class="row-fluid">
			<div class="span12" style="text-align: center;">
				<button type="submit" class="validate btn"><i class="icon-ok"></i>&nbsp;<?php echo JText::_('JSUBMIT');?></button>
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</div>
	</form>
</div>
