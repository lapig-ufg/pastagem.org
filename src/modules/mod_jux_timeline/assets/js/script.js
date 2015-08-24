/**
 * @version		$Id$
 * @author		JoomlaUX
 * @package		Joomla.Site
 * @subpackage	mod_jux_timeline
 * @copyright	Copyright (C) 2013 JoomlaUX. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */
!function($){
	"use strict";
	$.fn.juxtimeline = function(options){
		return this.each(function(){
			var $this = $(this),
				controls = $this.find(".jux-tl-control,.jux-tl-time,.jux-tl-title");
			controls.click(function(){
				var that = $(this),
					parent = that.closest(".jux-tl-item");
				if(parent.hasClass("selected")){
					parent.removeClass("selected").find(".jux-tl-desc").hide(400);
				}else{
					var selected = $this.find(".selected");
					if(selected){
						selected.removeClass("selected").find(".jux-tl-desc").hide(400);
					}
					parent.addClass("selected").find(".jux-tl-desc").show(400);
				}
				return false;
			});
		});
	}
}(window.jQuery);