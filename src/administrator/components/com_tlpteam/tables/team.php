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
require_once JPATH_COMPONENT . '/helpers/tlpteam.php';
/**
 * team Table class
 */
class TlpteamTableteam extends JTable
{

	/**
	 * Constructor
	 *
	 * @param JDatabase A database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__tlpteam_team', 'id', $db);
	}

	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param    array        Named array
	 *
	 * @return    null|string    null is operation was satisfactory, otherwise returns an error
	 * @see        JTable:bind
	 * @since      1.5
	 */
	public function bind($array, $ignore = '')
	{

		$setting = TlpteamHelper::config();
	
		$image_small_width = $setting->smallwidth;
		$image_small_height = $setting->smallheight;
		$image_medium_width = $setting->mediumwidth;
		$image_medium_height = $setting->mediumheight;
		$image_large_width = $setting->largewidth;
		$image_large_height = $setting->largeheight;
		$image_storiage_path = $setting->imagepath.'/';

				
			//Support for file field: profile_image
			$input = JFactory::getApplication()->input;
			$files = $input->files->get('jform');
		
			
			//exit;
			if(!empty($files['profile_image'])){
				jimport('joomla.filesystem.file');
				$file = $files['profile_image'];
					
			
				//Check if the server found any error.
				$fileError = $file['error'];
				$message = '';
				if($fileError > 0 && $fileError != 4) {
					switch ($fileError) {
						case 1:
							$message = JText::_( 'File size exceeds allowed by the server');
							break;
						case 2:
							$message = JText::_( 'File size exceeds allowed by the html form');
							break;
						case 3:
							$message = JText::_( 'Partial upload error');
							break;
					}
					if($message != '') {
						JError::raiseWarning(500, $message);
						return false;
					}
				}
				else if($fileError == 4){
					if(isset($array['profile_image_hidden'])){
						$array['profile_image'] = $array['profile_image_hidden'];
					}
					}else{
				
				
					$image_storiage_folder = JPATH_ROOT.'/'. $image_storiage_path;

				$folder = $image_storiage_folder;
				if(!file_exists($folder)){
					mkdir($folder, 0777, true);
				}

								
				$image_name = date('YmdHis',time()).".jpg";
				$image_small = 's_'.$image_name;
				$image_medium = 'm_'.$image_name;
				$image_large = 'l_'.$image_name;
			
				TlpteamHelper::createImage($file['tmp_name'],$image_small,$image_medium,$image_large,$image_small_width, $image_small_height, $image_medium_width, $image_medium_height, $image_large_width, $image_large_height, '', $image_storiage_folder, $file['name']);

				//exit;
				//$store->image_s = $image_storiage_path.'/'.$image_small;
				//$row->logo_image = $image_storiage_path.'/'.$image_medium;
				//$store->image_l = $image_storiage_path.'/'.$image_large;
				
				$array['profile_image'] = $image_name;
					
				}
			}
		
		$input = JFactory::getApplication()->input;
		$task = $input->getString('task', '');
		if(($task == 'save' || $task == 'apply') && (!JFactory::getUser()->authorise('core.edit.state','com_tlpteam') && $array['state'] == 1)){
			$array['state'] = 0;
		}
		if($array['id'] == 0){
			$array['created_by'] = JFactory::getUser()->id;
		}

		if (isset($array['params']) && is_array($array['params']))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata']))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}
		if (!JFactory::getUser()->authorise('core.admin', 'com_tlpteam.team.' . $array['id']))
		{
			$actions         = JFactory::getACL()->getActions('com_tlpteam', 'team');
			$default_actions = JFactory::getACL()->getAssetRules('com_tlpteam.team.' . $array['id'])->getData();
			$array_jaccess   = array();
			foreach ($actions as $action)
			{
				$array_jaccess[$action->name] = $default_actions[$action->name];
			}
			$array['rules'] = $this->JAccessRulestoArray($array_jaccess);
		}
		//Bind the rules for ACL where supported.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$this->setRules($array['rules']);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * This function convert an array of JAccessRule objects into an rules array.
	 *
	 * @param type $jaccessrules an arrao of JAccessRule objects.
	 */
	private function JAccessRulestoArray($jaccessrules)
	{
		$rules = array();
		foreach ($jaccessrules as $action => $jaccess)
		{
			$actions = array();
			foreach ($jaccess->getData() as $group => $allow)
			{
				$actions[$group] = ((bool) $allow);
			}
			$rules[$action] = $actions;
		}

		return $rules;
	}

	/**
	 * Overloaded check function
	 */
	public function check()
	{

		//If there is an ordering column and this is a new row then get the next ordering value
		if (property_exists($this, 'ordering') && $this->id == 0)
		{
			$this->ordering = self::getNextOrder();
		}

		return parent::check();
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param    mixed    An optional array of primary key values to update.  If not
	 *                    set the instance property value is used.
	 * @param    integer  The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param    integer  The user id of the user performing the operation.
	 *
	 * @return    boolean    True on success.
	 * @since    1.0.4
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k)
			{
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else
			{
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));

				return false;
			}
		}

		// Build the WHERE clause for the primary keys.
		$where = $k . '=' . implode(' OR ' . $k . '=', $pks);

		// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time'))
		{
			$checkin = '';
		}
		else
		{
			$checkin = ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
		}

		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE `' . $this->_tbl . '`' .
			' SET `state` = ' . (int) $state .
			' WHERE (' . $where . ')' .
			$checkin
		);
		$this->_db->execute();

		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
		{
			// Checkin each row.
			foreach ($pks as $pk)
			{
				$this->checkin($pk);
			}
		}

		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks))
		{
			$this->state = $state;
		}

		$this->setError('');

		return true;
	}

	/**
	 * Define a namespaced asset name for inclusion in the #__assets table
	 * @return string The asset name
	 *
	 * @see JTable::_getAssetName
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return 'com_tlpteam.team.' . (int) $this->$k;
	}

	/**
	 * Returns the parent asset's id. If you have a tree structure, retrieve the parent's id using the external key field
	 *
	 * @see JTable::_getAssetParentId
	 */
	protected function _getAssetParentId(JTable $table = null, $id = null)
	{
		// We will retrieve the parent-asset from the Asset-table
		$assetParent = JTable::getInstance('Asset');
		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();
		// The item has the component as asset-parent
		$assetParent->loadByName('com_tlpteam');
		// Return the found asset-parent-id
		if ($assetParent->id)
		{
			$assetParentId = $assetParent->id;
		}

		return $assetParentId;
	}

	public function delete($pk = null)
	{
		$this->load($pk);
		$result = parent::delete($pk);
		if ($result)
		{

			
	jimport('joomla.filesystem.file');
	$result = JFile::delete(JPATH_ADMINISTRATOR . '/components/com_tlpteam/images/photos/' . $this->profile_image);
		}

		return $result;
	}

}
