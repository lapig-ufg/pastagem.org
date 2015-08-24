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
 * View class for a list of Tlpteam.
 */
class TlpteamViewSettings extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        TlpteamHelper::addSubmenu('settings');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/tlpteam.php';

        $state = $this->get('State');
        $canDo = TlpteamHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_TLPTEAM_TITLE_SETTINGS'), 'teams.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/setting';
        if (file_exists($formPath)) {


            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('team.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_tlpteam');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_tlpteam&view=settings');

        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		
		'a.state' => JText::_('JSTATUS'),
		'a.created_by' => JText::_('COM_TLPTEAM_TEAMS_CREATED_BY'),
		);
	}

}
