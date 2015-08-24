
function ieHover(){

	if($$('.dj-main')){		
		$$('.dj-main').each(function(e){
			var li_s = e.getElements('li');
			li_s.each(function(element){
				element.addEvent('mouseenter', function(){					
					element.addClass('hover');
				});
				element.addEvent('mouseleave', function(){
					element.removeClass('hover');
				});
			});
		});
	}
}
window.addEvent('domready',function(){
	ieHover();
});

