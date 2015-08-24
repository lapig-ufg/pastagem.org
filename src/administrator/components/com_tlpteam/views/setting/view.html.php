<?php
/**
 * @version     1.0.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class TlpteamViewSetting extends JViewLegacy {

    protected $state;
    protected $item;
    protected $form;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar() {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $user = JFactory::getUser();
        $isNew = ($this->item->id == 0);
        if (isset($this->item->checked_out)) {
            $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        } else {
            $checkedOut = false;
        }
        $canDo = TlpteamHelper::getActions();

        JToolBarHelper::title(JText::_('COM_TLPTEAM_TITLE_SETTINGS'), 'team.png');

        // If not checked out, can save the item.
        if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create')))) {

            JToolBarHelper::apply('setting.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::save('setting.save', 'JTOOLBAR_SAVE');
        }
       
       
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('setting.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('setting.cancel', 'JTOOLBAR_CLOSE');
        }
    }

}
