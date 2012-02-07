//Cookie
jQuery.cookie = function(name, value, options) {
if (typeof value != 'undefined') {
options = options || {};
if (value === null) {
value = '';
options.expires = -1;
}
var expires = '';
if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
var date;
if (typeof options.expires == 'number') {
date = new Date();
date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
} else {
date = options.expires;
}
expires = '; expires=' + date.toUTCString();
}
var path = options.path ? '; path=' + (options.path) : '';
var domain = options.domain ? '; domain=' + (options.domain) : '';
var secure = options.secure ? '; secure' : '';
document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
} else {
var cookieValue = null;
if (document.cookie && document.cookie != '') {
var cookies = document.cookie.split(';');
for (var i = 0; i < cookies.length; i++) {
var cookie = jQuery.trim(cookies[i]);
if (cookie.substring(0, name.length + 1) == (name + '=')) {
cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
break;
}
}
}
return cookieValue;
}
};
//Box Height, Shake
(function(jQuery) {
jQuery.fn.equalHeights = function(minHeight, maxHeight) {
tallest = (minHeight) ? minHeight : 0;
this.each(function() {
if(jQuery(this).height() > tallest) {
tallest = jQuery(this).height();
}
});
if((maxHeight) && tallest > maxHeight) tallest = maxHeight;
return this.each(function() {
jQuery(this).height(tallest).css("overflow","hidden");
});
}
})(jQuery);
jQuery.fn.shake = function(intShakes , intDistance , intDuration ) {
this.each(function() {
jQuery(this).css({position:'relative'});
for (var x=1; x<=intShakes; x++) {
jQuery(this).animate({left:(intDistance*-1)}, (((intDuration/intShakes)/4)))
.animate({left:intDistance}, ((intDuration/intShakes)/2))
.animate({left:0}, (((intDuration/intShakes)/4)));
}
});
return this;
};
//Fileupload
(function(){
var d = document, w = window;
function get(element){
if (typeof element == "string")
element = d.getElementById(element);
return element;
}
function addEvent(el, type, fn){
if (w.addEventListener){
el.addEventListener(type, fn, false);
} else if (w.attachEvent){
var f = function(){
fn.call(el, w.event);
};	el.attachEvent('on' + type, f)
}
}
var toElement = function(){
var div = d.createElement('div');
return function(html){
div.innerHTML = html;
var el = div.childNodes[0];
div.removeChild(el);
return el;
}
}();
function hasClass(ele,cls){
return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}
function addClass(ele,cls) {
if (!hasClass(ele,cls)) ele.className += " "+cls;
}
function removeClass(ele,cls) {
var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
ele.className=ele.className.replace(reg,' ');
}
if (document.documentElement["getBoundingClientRect"]){
var getOffset = function(el){
var box = el.getBoundingClientRect(),
doc = el.ownerDocument,
body = doc.body,
docElem = doc.documentElement,
clientTop = docElem.clientTop || body.clientTop || 0,
clientLeft = docElem.clientLeft || body.clientLeft || 0,
zoom = 1;
if (body.getBoundingClientRect) {
var bound = body.getBoundingClientRect();
zoom = (bound.right - bound.left)/body.clientWidth;
}
if (zoom > 1){
clientTop = 0;
clientLeft = 0;
}
var top = box.top/zoom + (window.pageYOffset || docElem && docElem.scrollTop/zoom || body.scrollTop/zoom) - clientTop,
left = box.left/zoom + (window.pageXOffset|| docElem && docElem.scrollLeft/zoom || body.scrollLeft/zoom) - clientLeft;
return {
top: top,
left: left
};
}
} else {
var getOffset = function(el){
if (w.jQuery){
return jQuery(el).offset();
}	var top = 0, left = 0;
do {
top += el.offsetTop || 0;
left += el.offsetLeft || 0;
}
while (el = el.offsetParent);
return {
left: left,
top: top
};
}
}
function getBox(el){
var left, right, top, bottom;	var offset = getOffset(el);
left = offset.left;
top = offset.top;
right = left + el.offsetWidth;
bottom = top + el.offsetHeight;	return {
left: left,
right: right,
top: top,
bottom: bottom
};
}
function getMouseCoords(e){	if (!e.pageX && e.clientX){
var zoom = 1;	var body = document.body;
if (body.getBoundingClientRect) {
var bound = body.getBoundingClientRect();
zoom = (bound.right - bound.left)/body.clientWidth;
}
return {
x: e.clientX / zoom + d.body.scrollLeft + d.documentElement.scrollLeft,
y: e.clientY / zoom + d.body.scrollTop + d.documentElement.scrollTop
};
}
return {
x: e.pageX,
y: e.pageY
};	}
var getUID = function(){
var id = 0;
return function(){
return 'ValumsAjaxUpload' + id++;
}
}();
function fileFromPath(file){
return file.replace(/.*(\/|\\)/, "");	}
function getExt(file){
return (/[.]/.exec(file)) ? /[^.]+$/.exec(file.toLowerCase()) : '';
}	Ajax_upload = AjaxUpload = function(button, options){
if (button.jquery){
button = button[0];
} else if (typeof button == "string" && /^#.*/.test(button)){	button = button.slice(1);	}
button = get(button);	this._input = null;
this._button = button;
this._disabled = false;
this._submitting = false;
this._justClicked = false;
this._parentDialog = d.body;
if (window.jQuery && jQuery.ui && jQuery.ui.dialog){
var parentDialog = jQuery(this._button).parents('.ui-dialog');
if (parentDialog.length){
this._parentDialog = parentDialog[0];
}
}	this._settings = {
action: 'upload.php',	name: 'userfile',
data: {},
autoSubmit: true,
responseType: false,
onChange: function(file, extension){},	onSubmit: function(file, extension){},
onComplete: function(file, response) {}
};
for (var i in options) {
this._settings[i] = options[i];
}
this._createInput();
this._rerouteClicks();
}
AjaxUpload.prototype = {
setData : function(data){
this._settings.data = data;
},
disable : function(){
this._disabled = true;
},
enable : function(){
this._disabled = false;
},
destroy : function(){
if(this._input){
if(this._input.parentNode){
this._input.parentNode.removeChild(this._input);
}
this._input = null;
}
},	_createInput : function(){
var self = this;
var input = d.createElement("input");
input.setAttribute('type', 'file');
input.setAttribute('name', this._settings.name);
var styles = {
'position' : 'absolute'
,'margin': '-5px 0 0 -175px'
,'padding': 0
,'width': '220px'
,'height': '30px'
,'fontSize': '14px'	,'opacity': 0
,'cursor': 'hand'
,'display' : 'none'
,'zIndex' :  2147483583
};
for (var i in styles){
input.style[i] = styles[i];
}
if ( ! (input.style.opacity === "0")){
input.style.filter = "alpha(opacity=0)";
}
this._parentDialog.appendChild(input);
addEvent(input, 'change', function(){
var file = fileFromPath(this.value);	if(self._settings.onChange.call(self, file, getExt(file)) == false ){
return;	}	if (self._settings.autoSubmit){
self.submit();	}	});
addEvent(input, 'click', function(){
self.justClicked = true;
setTimeout(function(){
self.justClicked = false;
}, 2500);	});	this._input = input;
},
_rerouteClicks : function (){
var self = this;
var box, dialogOffset = {top:0, left:0}, over = false;
addEvent(self._button, 'mouseover', function(e){
if (!self._input || over) return;
over = true;
box = getBox(self._button);
if (self._parentDialog != d.body){
dialogOffset = getOffset(self._parentDialog);
}	});
addEvent(document, 'mousemove', function(e){
var input = self._input;	if (!input || !over) return;
if (self._disabled){
removeClass(self._button, 'hover');
input.style.display = 'none';
return;
}	var c = getMouseCoords(e);
if ((c.x >= box.left) && (c.x <= box.right) &&
(c.y >= box.top) && (c.y <= box.bottom)){
input.style.top = c.y - dialogOffset.top + 'px';
input.style.left = c.x - dialogOffset.left + 'px';
input.style.display = 'block';
addClass(self._button, 'hover');
} else {	over = false;
var check = setInterval(function(){
if (self.justClicked){
return;
}
if ( !over ){
input.style.display = 'none';	}	clearInterval(check);
}, 25);
removeClass(self._button, 'hover');
}	});	},
_createIframe : function(){
var id = getUID();
var iframe = toElement('<iframe src="javascript:false;" name="' + id + '" />');
iframe.id = id;
iframe.style.display = 'none';
d.body.appendChild(iframe);	return iframe;	},
submit : function(){
var self = this, settings = this._settings;	if (this._input.value === ''){
return;
}
var file = fileFromPath(this._input.value);	if (! (settings.onSubmit.call(this, file, getExt(file)) == false)) {
var iframe = this._createIframe();
var form = this._createForm(iframe);
form.appendChild(this._input);
form.submit();
d.body.removeChild(form);	form = null;
this._input = null;
this._createInput();
var toDeleteFlag = false;
addEvent(iframe, 'load', function(e){
if (// For Safari
iframe.src == "javascript:'%3Chtml%3E%3C/html%3E';" ||
iframe.src == "javascript:'<html></html>';"){	if( toDeleteFlag ){
setTimeout( function() {
d.body.removeChild(iframe);
}, 0);
}
return;
}	var doc = iframe.contentDocument ? iframe.contentDocument : frames[iframe.id].document;
if (doc.readyState && doc.readyState != 'complete'){
return;
}
if (doc.body && doc.body.innerHTML == "false"){
return;	}
var response;
if (doc.XMLDocument){
response = doc.XMLDocument;
} else if (doc.body){
response = doc.body.innerHTML;
if (settings.responseType && settings.responseType.toLowerCase() == 'json'){
if (doc.body.firstChild && doc.body.firstChild.nodeName.toUpperCase() == 'PRE'){
response = doc.body.firstChild.firstChild.nodeValue;
}
if (response) {
response = window["eval"]("(" + response + ")");
} else {
response = {};
}
}
} else {
var response = doc;
}
settings.onComplete.call(self, file, response);
toDeleteFlag = true;
iframe.src = "javascript:'<html></html>';";	});
} else {
d.body.removeChild(this._input);	this._input = null;
this._createInput();	}
},	_createForm : function(iframe){
var settings = this._settings;
var form = toElement('<form method="post" enctype="multipart/form-data"></form>');
form.style.display = 'none';
form.action = settings.action;
form.target = iframe.name;
d.body.appendChild(form);
for (var prop in settings.data){
var el = d.createElement("input");
el.type = 'hidden';
el.name = prop;
el.value = settings.data[prop];
form.appendChild(el);
}	return form;
}	};
})();
//Clipboard
var ZeroClipboard = {
version: "1.0.7",
clients: {},
moviePath: WPtouchCustom.wptouch_url + '/admin/js/ZeroClipboard.swf',
nextId: 1,
$: function(thingy) {
if (typeof(thingy) == 'string') thingy = document.getElementById(thingy);
if (!thingy.addClass) {
thingy.hide = function() { this.style.display = 'none'; };
thingy.show = function() { this.style.display = ''; };
thingy.addClass = function(name) { this.removeClass(name); this.className += ' ' + name; };
thingy.removeClass = function(name) {
var classes = this.className.split(/\s+/);
var idx = -1;
for (var k = 0; k < classes.length; k++) {
if (classes[k] == name) { idx = k; k = classes.length; }
}
if (idx > -1) {
classes.splice( idx, 1 );
this.className = classes.join(' ');
}
return this;
};
thingy.hasClass = function(name) {
return !!this.className.match( new RegExp("\\s*" + name + "\\s*") );
};
}
return thingy;
},
setMoviePath: function(path) {
this.moviePath = path;
},
dispatch: function(id, eventName, args) {
var client = this.clients[id];
if (client) {
client.receiveEvent(eventName, args);
}
},
register: function(id, client) {
this.clients[id] = client;
},
getDOMObjectPosition: function(obj, stopObj) {
var info = {
left: 0,
top: 0,
width: obj.width ? obj.width : obj.offsetWidth,
height: obj.height ? obj.height : obj.offsetHeight
};
while (obj && (obj != stopObj)) {
info.left += obj.offsetLeft;
info.top += obj.offsetTop;
obj = obj.offsetParent;
}
return info;
},
Client: function(elem) {
this.handlers = {};
this.id = ZeroClipboard.nextId++;
this.movieId = 'ZeroClipboardMovie_' + this.id;
ZeroClipboard.register(this.id, this);
if (elem) this.glue(elem);
}
};
ZeroClipboard.Client.prototype = {
id: 0,
ready: false,
movie: null,
clipText: '',
handCursorEnabled: true,
cssEffects: true,
handlers: null,
glue: function(elem, appendElem, stylesToAdd) {
this.domElement = ZeroClipboard.$(elem);
var zIndex = 99;
if (this.domElement.style.zIndex) {
zIndex = parseInt(this.domElement.style.zIndex, 10) + 1;
}
if (typeof(appendElem) == 'string') {
appendElem = ZeroClipboard.$(appendElem);
}
else if (typeof(appendElem) == 'undefined') {
appendElem = document.getElementsByTagName('body')[0];
}
var box = ZeroClipboard.getDOMObjectPosition(this.domElement, appendElem);
this.div = document.createElement('div');
var style = this.div.style;
style.position = 'absolute';
style.left = '' + box.left + 'px';
style.top = '' + box.top + 'px';
style.width = '' + box.width + 'px';
style.height = '' + box.height + 'px';
style.zIndex = zIndex;
if (typeof(stylesToAdd) == 'object') {
for (addedStyle in stylesToAdd) {
style[addedStyle] = stylesToAdd[addedStyle];
}
}
appendElem.appendChild(this.div);
this.div.innerHTML = this.getHTML( box.width, box.height );
},
getHTML: function(width, height) {
var html = '';
var flashvars = 'id=' + this.id +
'&width=' + width +
'&height=' + height;
if (navigator.userAgent.match(/MSIE/)) {
var protocol = location.href.match(/^https/i) ? 'https://' : 'http://';
html += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="'+protocol+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="'+width+'" height="'+height+'" id="'+this.movieId+'" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+ZeroClipboard.moviePath+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+flashvars+'"/><param name="wmode" value="transparent"/></object>';
}
else {
html += '<embed id="'+this.movieId+'" src="'+ZeroClipboard.moviePath+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+width+'" height="'+height+'" name="'+this.movieId+'" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+flashvars+'" wmode="transparent" />';
}
return html;
},
hide: function() {
if (this.div) {
this.div.style.left = '-2000px';
}
},
show: function() {
this.reposition();
},
destroy: function() {
if (this.domElement && this.div) {
this.hide();
this.div.innerHTML = '';
var body = document.getElementsByTagName('body')[0];
try { body.removeChild( this.div ); } catch(e) {;}
this.domElement = null;
this.div = null;
}
},
reposition: function(elem) {
if (elem) {
this.domElement = ZeroClipboard.$(elem);
if (!this.domElement) this.hide();
}
if (this.domElement && this.div) {
var box = ZeroClipboard.getDOMObjectPosition(this.domElement);
var style = this.div.style;
style.left = '' + box.left + 'px';
style.top = '' + box.top + 'px';
}
},
setText: function(newText) {
this.clipText = newText;
if (this.ready) this.movie.setText(newText);
},
addEventListener: function(eventName, func) {
eventName = eventName.toString().toLowerCase().replace(/^on/, '');
if (!this.handlers[eventName]) this.handlers[eventName] = [];
this.handlers[eventName].push(func);
},
setHandCursor: function(enabled) {
this.handCursorEnabled = enabled;
if (this.ready) this.movie.setHandCursor(enabled);
},
setCSSEffects: function(enabled) {
this.cssEffects = !!enabled;
},
receiveEvent: function(eventName, args) {
eventName = eventName.toString().toLowerCase().replace(/^on/, '');
switch (eventName) {
case 'load':
this.movie = document.getElementById(this.movieId);
if (!this.movie) {
var self = this;
setTimeout( function() { self.receiveEvent('load', null); }, 1 );
return;
}
if (!this.ready && navigator.userAgent.match(/Firefox/) && navigator.userAgent.match(/Windows/)) {
var self = this;
setTimeout( function() { self.receiveEvent('load', null); }, 100 );
this.ready = true;
return;
}
this.ready = true;
this.movie.setText( this.clipText );
this.movie.setHandCursor( this.handCursorEnabled );
break;
case 'mouseover':
if (this.domElement && this.cssEffects) {
this.domElement.addClass('hover');
if (this.recoverActive) this.domElement.addClass('active');
}
break;
case 'mouseout':
if (this.domElement && this.cssEffects) {
this.recoverActive = false;
if (this.domElement.hasClass('active')) {
this.domElement.removeClass('active');
this.recoverActive = true;
}
this.domElement.removeClass('hover');
}
break;
case 'mousedown':
if (this.domElement && this.cssEffects) {
this.domElement.addClass('active');
}
break;
case 'mouseup':
if (this.domElement && this.cssEffects) {
this.domElement.removeClass('active');
this.recoverActive = false;
}
break;
}
if (this.handlers[eventName]) {
for (var idx = 0, len = this.handlers[eventName].length; idx < len; idx++) {
var func = this.handlers[eventName][idx];
if (typeof(func) == 'function') {
func(this, args);
}
else if ((typeof(func) == 'object') && (func.length == 2)) {
func[0][ func[1] ](this, args);
}
else if (typeof(func) == 'string') {
window[func](this, args);
}
}
}
}
};
//Tools
(function(c){var d=[];c.tools=c.tools||{};c.tools.tooltip={version:"1.1.3",conf:{effect:"toggle",fadeOutSpeed:"fast",tip:null,predelay:0,delay:30,opacity:1,lazy:undefined,position:["top","center"],offset:[0,0],cancelDefault:true,relative:false,oneInstance:true,events:{def:"mouseover,mouseout",input:"focus,blur",widget:"focus mouseover,blur mouseout",tooltip:"mouseover,mouseout"},api:false},addEffect:function(e,g,f){b[e]=[g,f]}};var b={toggle:[function(e){var f=this.getConf(),g=this.getTip(),h=f.opacity;if(h<1){g.css({opacity:h})}g.show();e.call()},function(e){this.getTip().hide();e.call()}],fade:[function(e){this.getTip().fadeIn(this.getConf().fadeInSpeed,e)},function(e){this.getTip().fadeOut(this.getConf().fadeOutSpeed,e)}]};function a(f,g){var p=this,k=c(this);f.data("tooltip",p);var l=f.next();if(g.tip){l=c(g.tip);if(l.length>1){l=f.nextAll(g.tip).eq(0);if(!l.length){l=f.parent().nextAll(g.tip).eq(0)}}}function o(u){var t=g.relative?f.position().top:f.offset().top,s=g.relative?f.position().left:f.offset().left,v=g.position[0];t-=l.outerHeight()-g.offset[0];s+=f.outerWidth()+g.offset[1];var q=l.outerHeight()+f.outerHeight();if(v=="center"){t+=q/2}if(v=="bottom"){t+=q}v=g.position[1];var r=l.outerWidth()+f.outerWidth();if(v=="center"){s-=r/2}if(v=="left"){s-=r}return{top:t,left:s}}var i=f.is(":input"),e=i&&f.is(":checkbox, :radio, select, :button"),h=f.attr("type"),n=g.events[h]||g.events[i?(e?"widget":"input"):"def"];n=n.split(/,\s*/);if(n.length!=2){throw"Tooltip: bad events configuration for "+h}f.bind(n[0],function(r){if(g.oneInstance){c.each(d,function(){this.hide()})}var q=l.data("trigger");if(q&&q[0]!=this){l.hide().stop(true,true)}r.target=this;p.show(r);n=g.events.tooltip.split(/,\s*/);l.bind(n[0],function(){p.show(r)});if(n[1]){l.bind(n[1],function(){p.hide(r)})}});f.bind(n[1],function(q){p.hide(q)});if(!c.browser.msie&&!i&&!g.predelay){f.mousemove(function(){if(!p.isShown()){f.triggerHandler("mouseover")}})}if(g.opacity<1){l.css("opacity",g.opacity)}var m=0,j=f.attr("title");if(j&&g.cancelDefault){f.removeAttr("title");f.data("title",j)}c.extend(p,{show:function(r){if(r){f=c(r.target)}clearTimeout(l.data("timer"));if(l.is(":animated")||l.is(":visible")){return p}function q(){l.data("trigger",f);var t=o(r);if(g.tip&&j){l.html(f.data("title"))}r=r||c.Event();r.type="onBeforeShow";k.trigger(r,[t]);if(r.isDefaultPrevented()){return p}t=o(r);l.css({position:"absolute",top:t.top,left:t.left});var s=b[g.effect];if(!s){throw'Nonexistent effect "'+g.effect+'"'}s[0].call(p,function(){r.type="onShow";k.trigger(r)})}if(g.predelay){clearTimeout(m);m=setTimeout(q,g.predelay)}else{q()}return p},hide:function(r){clearTimeout(l.data("timer"));clearTimeout(m);if(!l.is(":visible")){return}function q(){r=r||c.Event();r.type="onBeforeHide";k.trigger(r);if(r.isDefaultPrevented()){return}b[g.effect][1].call(p,function(){r.type="onHide";k.trigger(r)})}if(g.delay&&r){l.data("timer",setTimeout(q,g.delay))}else{q()}return p},isShown:function(){return l.is(":visible, :animated")},getConf:function(){return g},getTip:function(){return l},getTrigger:function(){return f},bind:function(q,r){k.bind(q,r);return p},onHide:function(q){return this.bind("onHide",q)},onBeforeShow:function(q){return this.bind("onBeforeShow",q)},onShow:function(q){return this.bind("onShow",q)},onBeforeHide:function(q){return this.bind("onBeforeHide",q)},unbind:function(q){k.unbind(q);return p}});c.each(g,function(q,r){if(c.isFunction(r)){p.bind(q,r)}})}c.prototype.tooltip=function(e){var f=this.eq(typeof e=="number"?e:0).data("tooltip");if(f){return f}var g=c.extend(true,{},c.tools.tooltip.conf);if(c.isFunction(e)){e={onBeforeShow:e}}else{if(typeof e=="string"){e={tip:e}}}e=c.extend(true,g,e);if(typeof e.position=="string"){e.position=e.position.split(/,?\s/)}if(e.lazy!==false&&(e.lazy===true||this.length>20)){this.one("mouseover",function(h){f=new a(c(this),e);f.show(h);d.push(f)})}else{this.each(function(){f=new a(c(this),e);d.push(f)})}return e.api?f:this}})(jQuery);
(function(b){b.tools=b.tools||{};b.tools.expose={version:"1.0.5",conf:{maskId:null,loadSpeed:"slow",closeSpeed:"fast",closeOnClick:true,closeOnEsc:true,zIndex:9998,opacity:0.8,color:"#456",api:false}};function a(){if(b.browser.msie){var f=b(document).height(),e=b(window).height();return[window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth,f-e<20?e:f]}return[b(window).width(),b(document).height()]}function c(h,g){var e=this,j=b(this),d=null,f=false,i=0;b.each(g,function(k,l){if(b.isFunction(l)){j.bind(k,l)}});b(window).resize(function(){e.fit()});b.extend(this,{getMask:function(){return d},getExposed:function(){return h},getConf:function(){return g},isLoaded:function(){return f},load:function(n){if(f){return e}i=h.eq(0).css("zIndex");if(g.maskId){d=b("#"+g.maskId)}if(!d||!d.length){var l=a();d=b("<div/>").css({position:"absolute",top:0,left:0,width:l[0],height:l[1],display:"none",opacity:0,zIndex:g.zIndex});if(g.maskId){d.attr("id",g.maskId)}b("body").append(d);var k=d.css("backgroundColor");if(!k||k=="transparent"||k=="rgba(0, 0, 0, 0)"){d.css("backgroundColor",g.color)}if(g.closeOnEsc){b(document).bind("keydown.unexpose",function(o){if(o.keyCode==27){e.close()}})}if(g.closeOnClick){d.bind("click.unexpose",function(o){e.close(o)})}}n=n||b.Event();n.type="onBeforeLoad";j.trigger(n);if(n.isDefaultPrevented()){return e}b.each(h,function(){var o=b(this);if(!/relative|absolute|fixed/i.test(o.css("position"))){o.css("position","relative")}});h.css({zIndex:Math.max(g.zIndex+1,i=="auto"?0:i)});var m=d.height();if(!this.isLoaded()){d.css({opacity:0,display:"block"}).fadeTo(g.loadSpeed,g.opacity,function(){if(d.height()!=m){d.css("height",m)}n.type="onLoad";j.trigger(n)})}f=true;return e},close:function(k){if(!f){return e}k=k||b.Event();k.type="onBeforeClose";j.trigger(k);if(k.isDefaultPrevented()){return e}d.fadeOut(g.closeSpeed,function(){k.type="onClose";j.trigger(k);h.css({zIndex:b.browser.msie?i:null})});f=false;return e},fit:function(){if(d){var k=a();d.css({width:k[0],height:k[1]})}},bind:function(k,l){j.bind(k,l);return e},unbind:function(k){j.unbind(k);return e}});b.each("onBeforeLoad,onLoad,onBeforeClose,onClose".split(","),function(k,l){e[l]=function(m){return e.bind(l,m)}})}b.fn.expose=function(d){var e=this.eq(typeof d=="number"?d:0).data("expose");if(e){return e}if(typeof d=="string"){d={color:d}}var f=b.extend({},b.tools.expose.conf);d=b.extend(f,d);this.each(function(){e=new c(b(this),d);b(this).data("expose",e)});return d.api?e:this}})(jQuery);