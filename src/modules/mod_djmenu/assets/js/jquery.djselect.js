/**
 * @version $Id: jquery.djselect.js 5 2014-08-21 13:00:29Z szymon $
 * @package DJ-Menu
 * @copyright Copyright (C) 2012 DJ-Extensions.com, All rights reserved.
 * @license DJ-Extensions.com Proprietary Use License
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
 */
(function($){function addOptionsFromDJMenu(g,h,j){var k='';for(var i=0;i<j;i++){k+='- '}g.each(function(){var a=$(this);var b=a.find('> a').first();var c=a.find('> ul').first();if(b.length){var d=k+b.text();var e=b.find('img').first();if(e.length){d=k+e.attr('alt')}var f=$('<option value="'+b.prop('href')+'">'+d+'</option>').appendTo(h);if(!b.prop('href')){f.prop('disabled',true)}if(a.hasClass('active')){h.val(f.val())}}if(c.length)addOptionsFromDJMenu(c.find('> li'),h,j+1)})}$(window).load(function(){$('.dj-main').each(function(){var a=$(this);var b=$('<select id="'+a.attr('id')+'select" class="inputbox dj-select" />').on('change',function(){if($(this).val)window.location=$(this).val()});var c=a.find('li.dj-up');addOptionsFromDJMenu(c,b,0);b.insertAfter(a)})})})(jQuery);