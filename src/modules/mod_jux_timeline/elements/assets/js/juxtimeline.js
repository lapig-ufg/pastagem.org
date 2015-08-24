/**
 * @version		$Id$
 * @author		JoomlaUX
 * @package		Joomla.Site
 *
 * @copyright	Copyright (C) 2013 JoomlaUX. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */
!function ($) {
	"use strict";
	$.fn.juxtimeline = function(options){
		return this.each(function(){
			var $this = $(this),
				container = null,
				btn_add = null;
			container = $('<div class="ntm-container"></div>').insertAfter($this);
			container.append('<div style="margin:0 0 10px 0"><button class="btn btn-small btn-success" id="juxtimeline_add" type="button"><i class="icon-plus icon-white" title="New"></i>New</button></div>');
			container.append('<div class="ntm-items"></div>');
			var main_wap = $(".ntm-items");
			btn_add = $("#juxtimeline_add");
			if($this.val() != ""){
				var items = $.parseJSON(htmlspecialchars_decode($this.val()));
				$.each(items,function(key,item){
					main_wap.append(createTimeline(item.frame,item.title,item.description));
					 $(".ntm-items").sortable();
				});
			}
			btn_add.click(function(){
				main_wap.prepend(createTimeline());
				$(".ntm-items").sortable();
			});
			var form = document.adminForm;
			if(!form){
				return false;
			}
			var onsubmit = form.onsubmit;
			form.onsubmit = function(e){
				juxtimelineUpdate();
				if(jQuery.isFunction(onsubmit)){
					onsubmit();
				}
			};
			
			function htmlspecialchars (string, quote_style, charset, double_encode) {
			  var optTemp = 0,
			    i = 0,
			    noquotes = false;
			  if (typeof quote_style === 'undefined' || quote_style === null) {
			    quote_style = 2;
			  }
			  string = string.toString();
			  if (double_encode !== false) { // Put this first to avoid double-encoding
			    string = string.replace(/&/g, '&amp;');
			  }
			  string = string.replace(/</g, '&lt;').replace(/>/g, '&gt;');

			  var OPTS = {
			    'ENT_NOQUOTES': 0,
			    'ENT_HTML_QUOTE_SINGLE': 1,
			    'ENT_HTML_QUOTE_DOUBLE': 2,
			    'ENT_COMPAT': 2,
			    'ENT_QUOTES': 3,
			    'ENT_IGNORE': 4
			  };
			  if (quote_style === 0) {
			    noquotes = true;
			  }
			  if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
			    quote_style = [].concat(quote_style);
			    for (i = 0; i < quote_style.length; i++) {
			      // Resolve string input to bitwise e.g. 'ENT_IGNORE' becomes 4
			      if (OPTS[quote_style[i]] === 0) {
			        noquotes = true;
			      }
			      else if (OPTS[quote_style[i]]) {
			        optTemp = optTemp | OPTS[quote_style[i]];
			      }
			    }
			    quote_style = optTemp;
			  }
			  if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
			    string = string.replace(/'/g, '&#039;');
			  }
			  if (!noquotes) {
			    string = string.replace(/"/g, '&quot;');
			  }

			  return string;
			}

			
			function htmlspecialchars_decode (string, quote_style) {
			  var optTemp = 0,
			    i = 0,
			    noquotes = false;
			  if (typeof quote_style === 'undefined') {
			    quote_style = 2;
			  }
			  string = string.toString().replace(/&lt;/g, '<').replace(/&gt;/g, '>');
			  var OPTS = {
			    'ENT_NOQUOTES': 0,
			    'ENT_HTML_QUOTE_SINGLE': 1,
			    'ENT_HTML_QUOTE_DOUBLE': 2,
			    'ENT_COMPAT': 2,
			    'ENT_QUOTES': 3,
			    'ENT_IGNORE': 4
			  };
			  if (quote_style === 0) {
			    noquotes = true;
			  }
			  if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
			    quote_style = [].concat(quote_style);
			    for (i = 0; i < quote_style.length; i++) {
			      // Resolve string input to bitwise e.g. 'PATHINFO_EXTENSION' becomes 4
			      if (OPTS[quote_style[i]] === 0) {
			        noquotes = true;
			      } else if (OPTS[quote_style[i]]) {
			        optTemp = optTemp | OPTS[quote_style[i]];
			      }
			    }
			    quote_style = optTemp;
			  }
			  if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
			    string = string.replace(/&#0*39;/g, "'"); // PHP doesn't currently escape if more than one 0, but it should
			    // string = string.replace(/&apos;|&#x0*27;/g, "'"); // This would also be useful here, but not a part of PHP
			  }
			  if (!noquotes) {
			    string = string.replace(/&quot;/g, '"');
			  }
			  // Put this in last place to avoid escape being double-decoded
			  string = string.replace(/&amp;/g, '&');

			  return string;
			}

			
			function juxtimelineUpdate(){
				var items = container.find(".ntm-item"),
					config = {};
				items.each(function(index,element){
					var that = $(this),
						item = {'frame':that.find("#timeline_frame").val(),'title':that.find("#timeline_title").val(),'description':that.find("#timeline_description").val()};
					if (Object.keys(item).length) config[index] = item;
				});
				$this.val(htmlspecialchars(JSON.stringify(config)));
			};
			
			function createTimeline(frame,title,description){
				frame = typeof(frame) == 'undefined' ? '' : frame;
				title = typeof(title) == 'undefined' ? '' : title;
				description = typeof(description) == 'undefined' ? '' : description;
				var html = '<div class="well well-small ntm-item"><button onclick="juxtimelineRemove(this);" class="btn btn-small" id="juxtimeline_remove" type="button"><i class="icon-remove icon-white" title="Remove"></i>Remove</button>'
								+'<div class="control-group">'
									+'<div class="control-label">'
										+'<label for="timeline_frame">Time Frame</label>'
									+'</div>'
									+'<div class="controls">'
										+'<input type="text" id="timeline_frame" name="timeline_frame" value="'+frame+'">'
									+'</div>'
								+'</div>'
								+'<div class="control-group">'
									+'<div class="control-label">'
										+'<label for="timeline_title">Title</label>'
									+'</div>'
									+'<div class="controls">'
										+'<input type="text" id="timeline_title" name="timeline_title" value="'+title+'">'
									+'</div>'
								+'</div>'
								+'<div class="control-group">'
									+'<div class="control-label">'
										+'<label for="timeline_description">Time Description</label>'
									+'</div>'
									+'<div class="controls">'
										+'<textarea id="timeline_description" name="timeline_description" style="height:50px;width:500px;">'+description+'</textarea>'
									+'</div>'
								+'</div>'
							+'</div>';
				return html;
			}
		});
	}
}(window.jQuery);

function juxtimelineRemove(element){
	jQuery(element).closest(".ntm-item").remove();
}