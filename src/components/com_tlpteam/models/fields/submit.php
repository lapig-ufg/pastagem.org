<?php
/**
 * @version     1.0.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldSubmit extends JFormField {

    protected $type = 'submit';
    protected $value;
    protected $for;

    public function getInput() {
        
        $this->value = $this->getAttribute('value');
        
        return '<button id="' . $this->id . '"' 
                . ' name="submit_' . $this->for . '"'
                . ' value="'. $this->value . '"' 
                . ' title="' . JText::_('JSEARCH_FILTER_SUBMIT') . '"'
                . ' class="btn" style="margin-top: -10px;">' 
                . JText::_('JSEARCH_FILTER_SUBMIT') 
                . ' </button>';
    }

}
