;(function($){
	/**
	 * Superfish
	 *
	 * @link http://users.tpg.com.au/j_birch/plugins/superfish/
	 */
	$.fn.superfish=function(op){var sf=$.fn.superfish,c=sf.c,$arrow=$(['<span class="',c.arrowClass,'"> &#187;</span>'].join('')),over=function(){var $$=$(this),menu=getMenu($$);clearTimeout(menu.sfTimer);$$.showSuperfishUl().siblings().hideSuperfishUl();},out=function(){var $$=$(this),menu=getMenu($$),o=sf.op;clearTimeout(menu.sfTimer);menu.sfTimer=setTimeout(function(){o.retainPath=($.inArray($$[0],o.$path)>-1);$$.hideSuperfishUl();if(o.$path.length&&$$.parents(['li.',o.hoverClass].join('')).length<1){over.call(o.$path);}},o.delay);},getMenu=function($menu){var menu=$menu.parents(['ul.',c.menuClass,':first'].join(''))[0];sf.op=sf.o[menu.serial];return menu;},addArrow=function($a){$a.addClass(c.anchorClass).append($arrow.clone());};return this.each(function(){var s=this.serial=sf.o.length;var o=$.extend({},sf.defaults,op);o.$path=$('li.'+o.pathClass,this).slice(0,o.pathLevels).each(function(){$(this).addClass([o.hoverClass,c.bcClass].join(' ')).filter('li:has(ul)').removeClass(o.pathClass);});sf.o[s]=sf.op=o;$('li:has(ul)',this)[($.fn.hoverIntent&&!o.disableHI)?'hoverIntent':'hover'](over,out).each(function(){if(o.autoArrows)addArrow($('>a:first-child',this));}).not('.'+c.bcClass).hideSuperfishUl();var $a=$('a',this);$a.each(function(i){var $li=$a.eq(i).parents('li');$a.eq(i).focus(function(){over.call($li);}).blur(function(){out.call($li);});});o.onInit.call(this);}).each(function(){var menuClasses=[c.menuClass];if(sf.op.dropShadows&&!($.browser.msie&&$.browser.version<7))menuClasses.push(c.shadowClass);$(this).addClass(menuClasses.join(' '));});};var sf=$.fn.superfish;sf.o=[];sf.op={};sf.IE7fix=function(){var o=sf.op;if($.browser.msie&&$.browser.version>6&&o.dropShadows&&o.animation.opacity!=undefined)
	this.toggleClass(sf.c.shadowClass+'-off');};sf.c={bcClass:'sf-breadcrumb',menuClass:'sf-js-enabled',anchorClass:'sf-with-ul',arrowClass:'sf-sub-indicator',shadowClass:'sf-shadow'};sf.defaults={hoverClass:'sfHover',pathClass:'overideThisToUse',pathLevels:1,delay:800,animation:{opacity:'show'},speed:'normal',autoArrows:true,dropShadows:true,disableHI:false,onInit:function(){},onBeforeShow:function(){},onShow:function(){},onHide:function(){}};$.fn.extend({hideSuperfishUl:function(){var o=sf.op,not=(o.retainPath===true)?o.$path:'';o.retainPath=false;var $ul=$(['li.',o.hoverClass].join(''),this).add(this).not(not).removeClass(o.hoverClass).find('>ul').hide().css('visibility','hidden');o.onHide.call($ul);return this;},showSuperfishUl:function(){var o=sf.op,sh=sf.c.shadowClass+'-off',$ul=this.addClass(o.hoverClass).find('>ul:hidden').css('visibility','visible');sf.IE7fix.call($ul);o.onBeforeShow.call($ul);$ul.animate(o.animation,o.speed,function(){sf.IE7fix.call($ul);o.onShow.call($ul);});return this;}});
	



	/**
	 * MobilMenu
	 *
	 * @link https://github.com/mattkersley/Responsive-Menu
	 */
	var menuCount=0;$.fn.mobileMenu=function(options){var settings={switchWidth:768,topOptionText:'Select a page',indentString:'&nbsp;&nbsp;&nbsp;'};function isList($this){return $this.is('ul, ol');}
	function isMobile(){return($(window).width()<settings.switchWidth);}
	function menuExists($this){if($this.attr('id')){return($('#mobileMenu_'+$this.attr('id')).length>0);}
	else{menuCount++;$this.attr('id','mm'+menuCount);return($('#mobileMenu_mm'+menuCount).length>0);}}
	function goToPage($this){if($this.val()!==null){document.location.href=$this.val()}}
	function showMenu($this){$this.hide('display','none');$('#mobileMenu_'+$this.attr('id')).show();}
	function hideMenu($this){$this.css('display','');$('#mobileMenu_'+$this.attr('id')).hide();}
	function createMenu($this){if(isList($this)){var selectString='<select id="mobileMenu_'+$this.attr('id')+'" class="mobileMenu">';selectString+='<option value="">'+settings.topOptionText+'</option>';$this.find('li').each(function(){var levelStr='';var len=$(this).parents('ul, ol').length;for(i=1;i<len;i++){levelStr+=settings.indentString;}
	var link=$(this).find('a:first-child').attr('href');var text=levelStr+$(this).clone().children('ul, ol').remove().end().text();selectString+='<option value="'+link+'">'+text+'</option>';});selectString+='</select>';$this.parent().append(selectString);$('#mobileMenu_'+$this.attr('id')).change(function(){goToPage($(this));});showMenu($this);}else{alert('mobileMenu will only work with UL or OL elements!');}}
	function run($this){if(isMobile()&&!menuExists($this)){createMenu($this);}
	else if(isMobile()&&menuExists($this)){showMenu($this);}
	else if(!isMobile()&&menuExists($this)){hideMenu($this);}}
	return this.each(function(){if(options){$.extend(settings,options);}
	var $this=$(this);$(window).resize(function(){run($this);});run($this);});};
	



})(window.jQuery);



jQuery(document).ready(function($) {
	/**
	 * Navigation Init
	 */
	$('#primary-nav .sf-menu').superfish().mobileMenu({
		switchWidth: 767,                   //width (in px to switch at)
		topOptionText: 'Select a page',     //first option text
		indentString: '&nbsp;&nbsp;&nbsp;'  //string for indenting nested items
	})
});
