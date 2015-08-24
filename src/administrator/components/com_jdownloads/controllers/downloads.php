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

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controlleradmin'); 

/**
 * jDownloads list downloads controller class.
 *
 */
class jdownloadsControllerdownloads extends JControllerAdmin
{
	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		parent::__construct();
        
        // Register Extra task
        $this->registerTask('delete',    'delete');
	}

                                                
    /**
     * Proxy for getModel.
     */
    public function getModel($name = 'download', $prefix = 'jdownloadsModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    } 
	
    
   /**
    * Removes an download item in db table.
    *
    * @return  void
    *
    */    
    public function delete()
    {
        $jinput = JFactory::getApplication()->input;
		$cid = $jinput->get('cid', 0, 'array');
		$error          = '';
        $message        = '';
        
        // run the model methode
        $model = $this->getModel();
        
        if(!$model->delete($cid))
        {
            $msg = JText::_( 'COM_JDOWNLOADS_ERROR_RESULT_MSG' );
            $error = 'error';
        } else {                             
            $this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DELETED', count($cid)));
        }
        $this->setRedirect( 'index.php?option=com_jdownloads&view=downloads', $msg, $error);       
    }
    
   /**
    * Method to publish a list of items
    *
    * @return  void
    *
    */    
    public function publish()
    {
        global $jlistConfig;
        
        require_once JPATH_COMPONENT_SITE.'/helpers/jdownloadshelper.php';
        
        // Check for request forgeries
        JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
                
        // Get items to publish from the request.
        $cid = JFactory::getApplication()->input->get('cid', array(), 'array');
        $data = array('publish' => 1, 'unpublish' => 0);
        $task = $this->getTask();
        $state = JArrayHelper::getValue($data, $task, 0, 'int');        
        
        if (empty($cid)){
            JLog::add(JText::_('JGLOBAL_NO_ITEM_SELECTED'), JLog::WARNING, 'jerror');
            $this->setRedirect(JRoute::_('index.php?option=com_jdownloads&view=downloads', false));
        } else {
            if ($state == 1 && $jlistConfig['use.alphauserpoints']){
                // load the model
                $model = $this->getModel();
                foreach ($cid as $id){
                    // load the items data
                    $item = $model->getItem($id);
                    // add the AUP points
                    JDHelper::setAUPPointsUploads($item->submitted_by, $item->file_title);
                }
            }
            parent::publish();
        }        
    }    
    	
}
?>