/**
* @version 1.6.2 stable
* @package DJ Menu
* @copyright Copyright (C) 2010 Blue Constant Media LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: http://design-joomla.eu
* @author email contact@design-joomla.eu
* @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
*
*
* DJ Menu is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* DJ Menu is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with DJ Menu. If not, see <http://www.gnu.org/licenses/>.
*
*/

(function($){ // Mootools Safe Mode ON (require mootools 1.2.3+)

this.afterDJMenuHide = $empty;

this.DJMenus = new Array();

this.DJMenu = new Class({
	
	options: {
		transition: Fx.Transitions.Cubic.easeOut,	// transition effect for open/close submenu
		duration: 300,								// duration of transition effect
		delay: 2000,								// delay before close submenu
		height_fx: true,
		width_fx: true,
		opacity_fx: true,
		height_fx_sub: true,
		width_fx_sub: true,
		opacity_fx_sub: true,
		mid: 0,
		wrapper: null,
		direction: 'right'
	},
	
    initialize: function(menu,level,parent,options){
		this.options = $merge(this.options, options);
		if(level>0) {
			this.parent = parent;
		} else {
			this.parent = null;
			this.options.wrapper = parent;
		}
		this.level = level;
        this.menu = menu;
		this.subMenu = menu.getElement('ul');
		this.subMenuFX = new Fx.Morph(this.subMenu, {transition: this.options.transition, duration: this.options.duration, link: 'cancel'})
		.addEvent('onComplete',this.onCompleteFX.bind(this)).addEvent('onStart',this.onStartFX.bind(this)).addEvent('onCancel',this.onCancelFX.bind(this));
		this.menu.addEvent('mouseenter',this.showSubmenu.bind(this));
		this.menu.addEvent('mouseleave',this.hideSubmenu.bind(this));
		this.hover = false;
		this.children = new Array();
		this.initChildren();
	},
	
	showSubmenu: function(){
		this.hover = true;
		if(this.menu.hasClass('hover')&&this.subMenu.getStyle('overflow') == 'visible') {
			return; // do nothing if menu is open
		}
		this.menu.addClass('hover');
		if (!this.height) this.initHovered();
		this.hideOther(this); // hide other submenus at the same level
		if(this.level>0) this.parent.subMenu.setStyle('overflow','visible');
		this.subMenuFX.start(this.properties_show);
	},
	
	hideSubmenu: function(){
		this.hover = false;
		(function(){
			if(this.hover) return;
			this.subMenuFX.start(this.properties_hide).chain(function(){
				this.menu.removeClass('hover');
				if($chk(afterDJMenuHide)) afterDJMenuHide();
			}.bind(this));
		}).delay(this.options.delay, this);
	},
	
	onStartFX: function(){
		this.subMenu.setStyle('overflow','hidden');
	},
	
	onCompleteFX: function(){
		this.subMenu.setStyle('overflow','visible');
	},
	
	onCancelFX: function(){
		this.subMenuFX.clearChain();
	},
	
    initHovered: function(){
		if(!$chk(this.options.wrapper)) this.options.wrapper = $('dj-main' + this.options.mid);
		if (!$chk(this.parent)) {
			var offset = this.subMenu.getPosition().x + this.subMenu.getSize().x - this.options.wrapper.getSize().x - this.options.wrapper.getPosition().x;
			if (offset > 0) {
				this.subMenu.setStyle('margin-left', -offset);
				this.options.direction = 'left';
			}
		} else if (this.parent.getDirection() == 'right') {
			var offset = this.subMenu.getPosition().x + this.subMenu.getSize().x - this.options.wrapper.getSize().x - this.options.wrapper.getPosition().x;
			if (offset > 0) {
				this.subMenu.setStyle('right', this.subMenu.getStyle('left'));
				this.subMenu.setStyle('left', 'auto');
				this.options.direction = 'left';
			} else {
				this.options.direction = 'right';
			}
		} else if (this.parent.getDirection() == 'left') {
			this.subMenu.setStyle('right', this.subMenu.getStyle('left'));
			this.subMenu.setStyle('left', 'auto');
			var offset = this.subMenu.getPosition().x - this.options.wrapper.getPosition().x;
			if (offset < 0) {
				this.subMenu.setStyle('left', this.subMenu.getStyle('right'));
				this.subMenu.setStyle('right', 'auto');
				this.options.direction = 'right';
			} else {
				this.options.direction = 'left';
			}
		}
		
		this.height = this.subMenu.getStyle('height').toInt();
		this.width = this.subMenu.getStyle('width').toInt();
		
		var min_height = this.height;
		var min_width = this.width;
		var min_opacity = 1;		
		if (this.options.height_fx) min_height = 0; 
		if (this.options.width_fx) min_width = 0;
		if (this.options.opacity_fx) min_opacity = 0;
		
		this.properties_show = {'height': this.height, 'width': this.width, 'opacity': 1};
		this.properties_hide = {'height': min_height, 'width': min_width, 'opacity': min_opacity};
		this.subMenuFX.set(this.properties_hide);		
	},
	
	initChildren: function(){
		var children = this.subMenu.getChildren();
		this.sub_options = {height_fx: this.options.height_fx_sub, width_fx: this.options.width_fx_sub, opacity_fx: this.options.opacity_fx_sub};
		this.sub_options = $merge(this.options, this.sub_options);
		children.each(function(child){
			if(child.getElement('.dj-more, .dj-more-active')) {
				this.children.include(new DJMenu(child,this.level + 1,this,this.sub_options));
			} else {
				child.addEvent('mouseenter',function(){
					child.addClass('hover');
				});
				child.addEvent('mouseleave',function(){
					child.removeClass('hover');
				});
			}
		}.bind(this));
	},
	
	hideOther: function(over_menu){
		if(over_menu.level==0) {
			DJMenus.each(function(djmenu){
				if(djmenu.menu.hasClass('hover') && djmenu != over_menu) {
					djmenu.hideOtherSub(djmenu.children); // hide next levels immediately
					djmenu.subMenuFX.start(djmenu.properties_hide).chain(function(){
						this.menu.removeClass('hover');
						if($chk(afterDJMenuHide)) afterDJMenuHide();
					}.bind(djmenu));
				}
			});
		} else {
			over_menu.parent.children.each(function(djmenu){
				if(djmenu.menu.hasClass('hover') && djmenu != over_menu) {
					djmenu.hideOtherSub(djmenu.children); // hide next levels immediately
					djmenu.subMenuFX.start(djmenu.properties_hide).chain(function(){
						this.menu.removeClass('hover');
						if($chk(afterDJMenuHide)) afterDJMenuHide();
					}.bind(djmenu));
				}
			});
		}
	},
	
	hideOtherSub: function(children){
		children.each(function(child){
			child.hideOtherSub(child.children);
			child.subMenuFX.cancel();
			child.subMenuFX.set(this.properties_hide);
			child.menu.removeClass('hover');
		});
	},
	
	getDirection: function(){
		return this.options.direction;
	}
	
});

})(document.id);