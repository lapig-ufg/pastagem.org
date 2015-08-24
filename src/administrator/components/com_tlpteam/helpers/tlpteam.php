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

/**
 * Tlpteam helper.
 */
class TlpteamHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        JHtmlSidebar::addEntry(
			JText::_('COM_TLPTEAM_TITLE_TEAMS'),
			'index.php?option=com_tlpteam&view=teams',
			$vName == 'teams'
		);
		
		 JHtmlSidebar::addEntry(
			JText::_('COM_TLPTEAM_TITLE_SETTINGS'),
			'index.php?option=com_tlpteam&view=settings',
			$vName == 'settings'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_tlpteam';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

	
	public static function config()
	{
		$db = JFactory::getDBO();
		$sql = 'SELECT * FROM #__tlpteam_settings WHERE id = 1';
		$db->setQuery($sql);
		$config = $db->loadObject(); 

		return $config;
	}
	
	public static function getFileURL() {
		$cparams = JComponentHelper::getParams ('com_tlpteam');
		$psettings = & TlpteamHelper::config();
		$custompath = $psettings->imagepath;
		$url = JURI::root() ;
		$image_url_path = $url.$custompath;
		
		return $image_url_path;
	}
	
	public static function getFilePath(){
	
		 $psettings = & TlpteamHelper::config();
		 $custompath = $psettings->imagepath;
		 $image_path = JPATH_ROOT.DS.$custompath;
	 
	 	return $image_path;
	}
	

	/*
	* Create Thumbnail
	*/
	
	public static function createImage($src_file,$small_name,$medium_name,$large_name,
										$max_width_s,
										$max_height_s,
										$max_width_m,
										$max_height_m,
										$max_width_l,
										$max_height_l,
										$tag,
										$path,
										$orig_name)
			{
				ini_set('memory_limit', '200M');
				
				$src_file = urldecode($src_file);
				
				
					$orig_name = strtolower($orig_name);
					$findme  = '.jpg';
					$pos = strpos($orig_name, $findme);
					if ($pos === false)
					{
						$findme  = '.jpeg';
						$pos = strpos($orig_name, $findme);
						if ($pos === false)
						{
							$findme  = '.gif';
							$pos = strpos($orig_name, $findme);
							if ($pos === false)
							{
								$findme  = '.png';
								$pos = strpos($orig_name, $findme);
								if ($pos === false)
								{
									return;
								}
								else
								{
									$type = "png";
								}
							}
							else
							{
								$type = "gif";
							}
						}
						else
						{
							$type = "jpeg";
						}
					}
					else
					{
						$type = "jpeg";
					}
				//}
				
				$max_small_h = $max_height_s;
				$max_small_w = $max_width_s;
				$max_medium_h = $max_height_m;
				$max_medium_w = $max_width_m;
				$max_large_h = $max_height_l;
				$max_large_w = $max_width_l;
				
				if ( file_exists( "$path/$small_name")) {
					unlink( "$path/$small_name");
				}
				
				if ( file_exists( "$path/$medium_name")) {
					unlink( "$path/$medium_name");
				}
				
				if ( file_exists( "$path/$large_name")) {
					unlink( "$path/$large_name");
				}
				
				$read = 'imagecreatefrom' . $type; 
				$write = 'image' . $type; 
				
				$src_img = $read($src_file);
				
				// height/width
				$imginfo = getimagesize($src_file);
				$src_w = $imginfo[0];
				$src_h = $imginfo[1];
				
				$zoom_h = $max_small_h / $src_h;
				$zoom_w = $max_small_w / $src_w;
				$zoom   = min($zoom_h, $zoom_w);
				$dst_small_h  = $zoom<1 ? round($src_h*$zoom) : $src_h;
				$dst_small_w  = $zoom<1 ? round($src_w*$zoom) : $src_w;
				
				$zoom_h = $max_medium_h / $src_h;
				$zoom_w = $max_medium_w / $src_w;
				$zoom   = min($zoom_h, $zoom_w);
				$dst_medium_h  = $zoom<1 ? round($src_h*$zoom) : $src_h;
				$dst_medium_w  = $zoom<1 ? round($src_w*$zoom) : $src_w;
				
				$zoom_h = $max_large_h / $src_h;
				$zoom_w = $max_large_w / $src_w;
				$zoom   = min($zoom_h, $zoom_w);
				$dst_large_h  = $zoom<1 ? round($src_h*$zoom) : $src_h;
				$dst_large_w  = $zoom<1 ? round($src_w*$zoom) : $src_w;
				
				
				$dst_s_img = imagecreatetruecolor($dst_small_w,$dst_small_h);
				$white = imagecolorallocate($dst_s_img,255,255,255);
				imagefill($dst_s_img,0,0,$white);
				imagecopyresampled($dst_s_img,$src_img, 0,0,0,0, $dst_small_w,$dst_small_h,$src_w,$src_h);
				$textcolor = imagecolorallocate($dst_s_img, 255, 255, 255);
				if (isset($tag))
					imagestring($dst_s_img, 2, 2, 2, "$tag", $textcolor);
				if($type == 'jpeg'){
					$desc_img = $write($dst_s_img,"$path/$small_name", 75);
				}else{
					$desc_img = $write($dst_s_img,"$path/$small_name", 2);
				}
				
				
				$dst_m_img = imagecreatetruecolor($dst_medium_w,$dst_medium_h);
				$white = imagecolorallocate($dst_m_img,255,255,255);
				imagefill($dst_m_img,0,0,$white);
				imagecopyresampled($dst_m_img,$src_img, 0,0,0,0, $dst_medium_w,$dst_medium_h,$src_w,$src_h);
				$textcolor = imagecolorallocate($dst_m_img, 255, 255, 255);
				if (isset($tag))
					imagestring($dst_m_img, 2, 2, 2, "$tag", $textcolor);
				if($type == 'jpeg'){
					$desc_img = $write($dst_m_img,"$path/$medium_name", 75);
				}else{
					$desc_img = $write($dst_m_img,"$path/$medium_name", 2);
				}
				
				$dst_l_img = imagecreatetruecolor($dst_large_w,$dst_large_h);
				$white = imagecolorallocate($dst_l_img,255,255,255);
				imagefill($dst_l_img,0,0,$white);
				imagecopyresampled($dst_l_img,$src_img, 0,0,0,0, $dst_large_w,$dst_large_h,$src_w,$src_h);

				$textcolor = imagecolorallocate($dst_l_img, 255, 255, 255);
				if (isset($tag))
					imagestring($dst_l_img, 2, 2, 2, "$tag", $textcolor);
				if($type == 'jpeg'){
					$desc_img = $write($dst_l_img,"$path/$large_name", 75);
				}else{
					$desc_img = $write($dst_l_img,"$path/$large_name", 2);
				}
				
				
			
			}       
        
}


	