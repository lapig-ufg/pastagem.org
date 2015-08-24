<?php

class JA_Tools {
	var $_tpl = null;
	var $template = '';
	
	var $config;
	var $app;
	var $menu;
	var $lang;

	function JA_Tools ($template) {
		$this->_tpl = $template;
		$this->template = $template->template;
		$this->config = new JConfig();
		
		$this->app = JFactory::getApplication();
		$this->menu = $this->app->getMenu();
		$this->lang = JFactory::getLanguage();
	}

	function baseurl(){
		return JURI::base();
	}

	function templateurl(){
		return JURI::base()."templates/".$this->template;
	}

	function getRandomImage ($img_folder) {
		$imglist=array();

		mt_srand((double)microtime()*1000);

		$imgs = dir($img_folder);

		while ($file = $imgs->read()) {
			if (eregi("gif", $file) || eregi("jpg", $file) || eregi("png", $file))
				$imglist[] = $file;
		}
		closedir($imgs->handle);

		if(!count($imglist)) return '';

		$random = mt_rand(0, count($imglist)-1);
		$image = $imglist[$random];

		return $image;
	}

	function isFrontPage(){
		return ($this->menu->getActive() == $this->menu->getDefault($this->lang->getTag()));
		
	}

	function sitename() {
		return $this->config->sitename;
	}

	function pagepath() {
	    $path = &JFactory::getURI()->getPath();
	    return $path;
	}

	function pagealias() {
	    $path = &JFactory::getURI()->getPath();
	    $length = strlen($path);
	   
	    for ($i = $length; $i >= 0 ; $i--)
	      if ($path[$i] == '/')
	         return substr($path, $i + 1, $length - $i - 1);

	    return $path;
	}

  function pagetitle() {
        $mydoc =& JFactory::getDocument();
		$pagetitle = $mydoc->getTitle();
		
		if(strpos($pagetitle, ' - ') !== false) {
			return $this->split_title($pagetitle,'-',2);
		} else if(strpos($pagetitle, ':') !== false) {
			return $this->split_title($pagetitle,':',1);
		} else {
			return $pagetitle;
						
		}
	}

	function split_title($text, $delimiter, $index) {
		$array = explode($delimiter,$text);
		
		$result = '';
		for($i = 0; $i < $index; $i++) {
			$result .= $array[$i] . $delimiter;
		}
		
		$lastIndex= (strlen($result) - strlen($delimiter));
		
		return substr($result,0,$lastIndex);
	}

	function pegaImage() {
		 $textoTopo= $tmpTools->templateurl() . '/images/texts/' . $tmpTools->imagePagetitle() . '.png';
                       
                       $id = @fopen($textoTopo,"r");
                       
                       if(!$id)
                            $textoTopo= $tmpTools->templateurl() . '/images/texts/noticias.png';

                       @fclose($id);
		
	}

     function removeacentos ($var) {
       $ACENTOS   = array("À","Á","Â","Ã","à","á","â","ã");
       $SEMACENTOS= array("A","A","A","A","a","a","a","a");
       $var=str_replace($ACENTOS,$SEMACENTOS, $var);
      
       $ACENTOS   = array("È","É","Ê","Ë","è","é","ê","ë");
       $SEMACENTOS= array("E","E","E","E","e","e","e","e");
       $var=str_replace($ACENTOS,$SEMACENTOS, $var);
       $ACENTOS   = array("Ì","Í","Î","Ï","ì","í","î","ï");
       $SEMACENTOS= array("I","I","I","I","i","i","i","i");
       $var=str_replace($ACENTOS,$SEMACENTOS, $var);
      
       $ACENTOS   = array("Ò","Ó","Ô","Ö","Õ","ò","ó","ô","ö","õ");
       $SEMACENTOS= array("O","O","O","O","O","o","o","o","o","o");
       $var=str_replace($ACENTOS,$SEMACENTOS, $var);
     
       $ACENTOS   = array("Ù","Ú","Û","Ü","ú","ù","ü","û");
       $SEMACENTOS= array("U","U","U","U","u","u","u","u");
       $var=str_replace($ACENTOS,$SEMACENTOS, $var);

       $ACENTOS   = array("Ç","ç","ª","º","°");
       $SEMACENTOS= array("C","c","a.","o.","o.");
       $var=str_replace($ACENTOS,$SEMACENTOS, $var);      

       $ESPACO    = array(" ","/");
       $SEMESPACO = array("_","_");
       $var=str_replace($ESPACO,$SEMESPACO, $var);      

       return $var;
}

    function imagePagetitle() {
        return strtolower($this->removeacentos($this->pagetitle()));
    }

	function getRandomInteger($n1, $n2) {
		return mt_rand($n1, $n2);
	}	
	
}
?>
