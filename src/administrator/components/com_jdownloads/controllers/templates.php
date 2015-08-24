<?php
/**
 * @version 2.0 
 * @package Joomla
 * @subpackage jDownloads
 * @copyright (C) 2008 - 2011 - Arno Betz
 * @license GNU/GPL, see LICENSE.php
 * 
 * Jdownloads is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.

 * jDownloads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with jDownloads; if not, visit the Free Software Foundations
 * Website: http://www.gnu.org/copyleft/gpl.html
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controlleradmin'); 

/**
 * Jdownloads list controller class.
 *
 * @package Jdownloads
 */
class jdownloadsControllertemplates extends JControllerAdmin
{
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
        
        // Register Extra task 
        $this->registerTask('activate', 'activate');
	}

                                                
    /**
     * Proxy for getModel.
     */
    public function getModel($name = 'templates', $prefix = 'jdownloadsModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }
    
    /**
     * logic to cancel the edit page
     *
     */
    public function cancel()
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));                
        $app = JFactory::getApplication();
        $this->setRedirect('index.php?option=com_jdownloads&view=layouts');
    }
    
    /**
     * logic to activate a selected layout
     *
     */
    public function activate() 
    {
        // get layout type
        $session        = JFactory::getSession();
        $jd_tmpl_type   = (int) $session->get( 'jd_tmpl_type', '' );
        $error          = '';
        
        // run the model methode
        $model = $this->getModel('templates');
        if(!$model->activate($jd_tmpl_type)) {
            $msg = JText::_( 'COM_JDOWNLOADS_BACKEND_TEMPEDIT_ACTIVE_ERROR' );
            $error = 'error';
        } else {                             
            $msg = JText::_( 'COM_JDOWNLOADS_BACKEND_TEMPEDIT_ACTIVE' );
        }
        $this->setRedirect( 'index.php?option=com_jdownloads&view=templates&types='.$jd_tmpl_type , $msg, $error);
    }    
	
}
?>