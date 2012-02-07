(function(){

	// Creates a new plugin class and a custom listbox
	tinymce.create('tinymce.plugins.csshortcodes', {
	
		createControl: function(n, cm) {
			switch (n) {
				case 'shortcodesbutton':
					var c = cm.createMenuButton('shortcodesbutton', {
						title : 'Shortcodes Menu',
						image : '',
						icons : false
					});
	
					c.onRenderMenu.add(function(c, m) {
						var sub;
						var selection = '';
						
						/* Content Functions
						tinyMCE.activeEditor.getContent();//to get content in editor
						tinyMCE.activeEditor.selection.getContent();//to get selected content in editor
						tinyMCE.activeEditor.setContent('some value') //to set content in editor
						tinyMCE.activeEditor.selection.setContent('some value') //to replace selected content in editor
						*/
						
						// Layout Shortcodes
						sub = m.addMenu({title : 'Layout Columns'});
						
						sub.add({title : '1/2 Column', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('<div class="one-half">'+selection+'</div>');
						}});
	
						sub.add({title : '1/2 Column Last', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('<div class="one-half last">'+selection+'</div>');
						}});
						
						sub.add({title : '1/3 Column', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('<div class="one-third">'+selection+'</div>');
						}});
	
						sub.add({title : '1/3 Column Last', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('<div class="one-third last">'+selection+'</div>');
						}});
						
						sub.add({title : '2/3 Column', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('<div class="two-third">'+selection+'</div>');
						}});
	
						sub.add({title : '2/3 Column Last', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('<div class="two-third last">'+selection+'</div>');
						}});
						
						sub.add({title : '1/4 Column', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('<div class="one-fourth">'+selection+'</div>');
						}});
	
						sub.add({title : '1/4 Column Last', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('<div class="one-fourth last">'+selection+'</div>');
						}});
						
						sub.add({title : '3/4 Column', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('<div class="three-fourth">'+selection+'</div>');
						}});
	
						sub.add({title : '3/4 Column Last', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('<div class="three-fourth last">'+selection+'</div>');
						}});
						
						
						// Media Shortcodes
						sub = m.addMenu({title : 'Media Embed'});
	
						sub.add({title : 'Media Embed Small', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('[embed width="550" height="400"]'+selection+'[/embed]');
						}});
						
						sub.add({title : 'Media Embed Large', onclick : function() {
							selection = tinyMCE.activeEditor.selection.getContent();
							tinyMCE.activeEditor.selection.setContent('[embed width="840" height="473"]'+selection+'[/embed]');
						}});
						
					});
	
					// Return the new menu button instance
					return c;
			}
	
			//return null;
		}
	});
	
	// Register plugin with a short name
	tinymce.PluginManager.add( 'c7s_shortcodes', tinymce.plugins.csshortcodes );
	
	// Initialize TinyMCE with the new plugin and menu button
	tinyMCE.init({
		plugins : '-c7s_shortcodes' // - tells TinyMCE to skip the loading of the plugin
	});
	
})()