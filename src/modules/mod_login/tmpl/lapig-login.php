<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
?>
<?php if ($type == 'logout') : ?>
	<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" >
	<?php if ($params->get('greeting')) : ?>
		
		<label style="font-size: 15px">
		<?php if($params->get('name') == 0) : {
			echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name')));
		} else : {
			echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username')));
		} endif; ?>
		</label>
	<?php endif; ?>
		
			<button type="submit" class="btn btn-micro"><i class="icon-share-alt"></i>&nbsp;<?php echo JText::_('JLOGOUT'); ?></button>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.logout" />
			<input type="hidden" name="return" value="<?php echo $return; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		
	</form>
<?php else : ?>
	<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" >
		<div class="form-inline">
					<input type="text" class="input" name="username" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>">
					<button type="submit" class="btn"><i class="icon-ok"></i></button>
					<a class="btn" style="margin-left: 15px;" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
						<i class="icon-question-sign"></i>
					</a>
				</div>
				<div class="form-inline" style="margin-top: 16px;">
					<input type="password" class="input" name="password" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>">
					<?php
					$usersConfig = JComponentHelper::getParams('com_users');
					if ($usersConfig->get('allowUserRegistration')) : ?>
						<a class="btn" href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
							<i class="icon-user"></i><?php echo JText::_('MOD_LOGIN_REGISTER'); ?>
						</a>
					<?php endif; ?>
					
				</div>
				<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
				<div class="form-inline" style="margin-top: 8px;">
					<label class="checkbox">
						<?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?><input type="checkbox">
					</label>
				</div>
				<?php endif; ?>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="user.login" />
				<input type="hidden" name="return" value="<?php echo $return; ?>" />
				<?php echo JHtml::_('form.token'); ?>
	</div>
<?php endif; ?>
