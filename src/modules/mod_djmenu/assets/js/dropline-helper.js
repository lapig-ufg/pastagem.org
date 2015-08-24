(function($){ // Mootools Safe Mode ON
	
	window.addEvent('domready',function(){
		$$('.dj-main').each(function(djmenu){
			djmenu.addEvent('mouseenter',function(){
				var djsub = djmenu.getElement('li.dj-up.active ul.dj-submenu');
				if($chk(djsub)) {
					djsub.addClass('hide');
				}
			});
			djmenu.addEvent('mouseleave',function(){
				var djsub = djmenu.getElement('li.dj-up.active ul.dj-submenu');
				if($chk(djsub)) {
					djsub.removeClass('hide');
				}
			});
		});	
	});
	
})(document.id);