<?php
//if( !class_exists('QuoteRotatorManagement') ) :

class QuoteRotatorManagement
{	
	var $pluginPath;
	var $pluginFile;
	var $tableName;
	
	function QuoteRotatorManagement()
	{
		global $wpdb;
		
		if( !function_exists('get_option') )
		{
			require_once('../../../wp-config.php');
		}
		
		$this->pluginPath = get_settings('siteurl') . '/wp-content/plugins/flexi-quote-rotator/';
		$this->pluginFile = $this->pluginPath . 'flexi-quote-rotator.php';
		$this->tableName = $wpdb->prefix . 'QuoteRotator';
	}
	
	function ajaxDelete()
	{
		global $wpdb;
	
		$id = $_POST['id'];
		
		$sql = "DELETE FROM " . $this->tableName . " WHERE id=" . $id;
		$wpdb->query($sql);
		exit();
	}
	
	function addQuote($quote, $author)
	{
		global $wpdb;
				
		$quote = str_replace(array("\r\n", "\r", "\n"), "<br />", $quote);
		$quote = str_replace("\"", "'", $quote);
		$author = str_replace(array("\r\n", "\r", "\n"), "<br />", $author);
		$author = str_replace("\"", "'", $author);
		
		$sql = "INSERT INTO " . $this->tableName . " (quote, author) VALUES ('" . addslashes($quote) . "', '" . addslashes($author) . "');";
		$wpdb->query($sql);
	}
	
	function editQuote($quote, $author, $id)
	{
		global $wpdb;
				
		$quote = str_replace(array("\r\n", "\r", "\n"), "<br />", $quote);
		$quote = str_replace("\"", "'", $quote);
		$author = str_replace(array("\r\n", "\r", "\n"), "<br />", $author);
		$author = str_replace("\"", "'", $author);
		
		$sql = "UPDATE `" . $this->tableName . "` SET `quote`='" . addslashes($quote) . "', `author`='" . addslashes($author) . "' WHERE `id`=".$id.";";
		$wpdb->query($sql);
	}
	
	function deleteQuote($id)
	{
		global $wpdb;
		
		$sql = "DELETE FROM " . $this->tableName . " WHERE id=" . $id;
		$wpdb->query($sql);
	}
	
	function displayQuotes()
	{
		global $wpdb;
		
		$sql = "SELECT * FROM " . $this->tableName . " ORDER BY id";
		$results = $wpdb->get_results($sql);
		
		echo "<table class=\"widefat\">\n";
		echo "\t<thead>\n";
		echo "\t\t<tr>\n";
		echo "\t\t\t<th scope=\"col\" style=\"text-align:center;\">ID</th>\n";
		echo "\t\t\t<th scope=\"col\">Quote</th>\n";
		echo "\t\t\t<th scope=\"col\">Author</th>\n";
		echo "\t\t\t<th scope=\"col\" colspan=\"2\" style=\"text-align:center;\">Action</th>\n";
		echo "\t\t</tr>\n";
		echo "\t</thead>\n";
		echo "\t<tbody id=\"the-list\">\n";
		
		$i=0;
		foreach($results as $result){
			if($i % 2 == 0)
				$class = "alternate";
			else
				$class = "";
			echo "\t\t<tr id=\"quote-" . $result->id . "\" class=\"" . $class . "\">\n";
			echo "\t\t\t<th scope=\"row\" style=\"text-align:center;\">" . $result->id . "</th>\n";
			echo "\t\t\t<td>" . stripslashes($result->quote) . "</td>\n";
			echo "\t\t\t<td>" . stripslashes($result->author) . "</td>\n";
			echo "\t\t\t<td style=\"text-align:center;\"><a class=\"edit\" href=\"" . get_settings('siteurl') . "/wp-admin/edit.php?page=flexi-quote-rotator.php&amp;action=edit&amp;id=" . $result->id . "\">Edit</a></td>\n";
			echo "\t\t\t<td style=\"text-align:center;\"><a class=\"delete\" onclick=\"return deleteSomething('quote', '" . $result->id . "', 'You are about to delete this quote" . '\n' . "\'" . $result->quote . "\'." . '\n' . "\'OK\' to delete, \'Cancel\' to stop.')\" href=\"" . get_settings('siteurl') . "/wp-admin/edit.php?page=flexi-quote-rotator.php&amp;action=delete-quote&amp;id=" . $result->id . "\">Delete</a></td>\n";
			echo "\t\t</tr>\n";
			$i++;
		}
		
		echo "\t</tbody>\n";
		echo "</table>\n\n";
		echo "<div id=\"ajax-response\"></div>";
	}
	
	function displayManagementPage()
	{
		global $wpdb;
		
		echo "\t\t<div class=\"wrap\">\n";
		if( $_GET['action']=='edit' )
		{
			$sql = "SELECT * FROM `" . $this->tableName . "` WHERE `id` = " . $_GET['id'];
			$results = $wpdb->get_results($sql);
			$r = $results[0];
			echo "\t\t\t<h2>Edit Quote</h2>\n";
			echo "\t\t\t<form name=\"EditQuotesForm\" method=\"post\" action=\"?page=flexi-quote-rotator.php\">\n";
			echo "\t\t\t\t<p class=\"submit\">\n";
			echo "\t\t\t\t\t<input type=\"submit\" name=\"submit\" value=\"Update Quote &raquo;\" />\n";
			echo "\t\t\t\t</p>\n";
			echo "\t\t\t\t<table class=\"editform\" width=\"100%\" cellspacing=\"2\" cellpadding=\"5\">\n";
			echo "\t\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t\t<th width=\"33%\" scope=\"row\" valign=\"top\"><label for=\"quote\">Quote:</label></th>\n";
			echo "\t\t\t\t\t\t<td width=\"67%\"><textarea name=\"quote\" style=\"width:350px;height:200px;\"/>".stripslashes($r->quote)."</textarea></td>\n";
			echo "\t\t\t\t\t</tr>\n";
			echo "\t\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t\t<th width=\"33%\" scope=\"row\" valign=\"top\"><label for=\"author\">Author:</label></th>\n";
			echo "\t\t\t\t\t\t<td width=\"67%\"><input type=\"text\" name=\"author\" style=\"width:350px;\" value=\"".stripslashes($r->author)."\"/></td>\n";
			echo "\t\t\t\t\t</tr>\n";
			echo "\t\t\t\t</table>\n";
			echo "\t\t\t\t<input type=\"hidden\" name=\"editQuote\" value=\"1\" />\n";
			echo "\t\t\t\t<input type=\"hidden\" name=\"id\" value=\"".$r->id."\" />\n";
			echo "\t\t\t\t<p class=\"submit\">\n";
			echo "\t\t\t\t\t<input type=\"submit\" name=\"submit\" value=\"Update Quote &raquo;\" />\n";
			echo "\t\t\t\t</p>\n";
			echo "\t\t\t</form>\n";
		}
		else
		{
			echo "\t\t\t<h2>Quotes</h2>\n";
			$this->displayQuotes();
			echo "\t\t\t<br /><br />\n";
			echo "\t\t\t<h2>Add Quote</h2>\n";
			echo "\t\t\t<form name=\"QuotesForm\" method=\"post\" action=\"\">\n";
			echo "\t\t\t\t<p class=\"submit\">\n";
			echo "\t\t\t\t\t<input type=\"submit\" name=\"submit\" value=\"Add Quote &raquo;\" />\n";
			echo "\t\t\t\t</p>\n";
			echo "\t\t\t\t<table class=\"editform\" width=\"100%\" cellspacing=\"2\" cellpadding=\"5\">\n";
			echo "\t\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t\t<th width=\"33%\" scope=\"row\" valign=\"top\"><label for=\"quote\">Quote:</label></th>\n";
			echo "\t\t\t\t\t\t<td width=\"67%\"><textarea name=\"quote\" style=\"width:350px;height:100px;\"/></textarea></td>\n";
			echo "\t\t\t\t\t</tr>\n";
			echo "\t\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t\t<th width=\"33%\" scope=\"row\" valign=\"top\"><label for=\"author\">Author:</label></th>\n";
			echo "\t\t\t\t\t\t<td width=\"67%\"><input type=\"text\" name=\"author\" style=\"width:350px;\"/></td>\n";
			echo "\t\t\t\t\t</tr>\n";
			echo "\t\t\t\t</table>\n";
			echo "\t\t\t\t<input type=\"hidden\" name=\"addQuote\" value=\"1\" />\n";
			echo "\t\t\t\t<p class=\"submit\">\n";
			echo "\t\t\t\t\t<input type=\"submit\" name=\"submit\" value=\"Add Quote &raquo;\" />\n";
			echo "\t\t\t\t</p>\n";
			echo "\t\t\t</form>\n";
		}
		echo "\t\t</div>\n";
	}

	function displayOptionsPage()
	{
		/* 2010-03-25 added by colin@brainbits.ca to fix broken options saving in wordpress 2.9.2 */
		if($_POST['action'] == 'update'){
                	update_option('fqr_title', $_POST['fqr_title'] );
                	update_option('fqr_delay', $_POST['fqr_delay'] );
                	update_option('fqr_fade', $_POST['fqr_fade'] );
                	update_option('fqr_fadeout', $_POST['fqr_fadeout'] );
                	update_option('fqr_height', $_POST['fqr_height'] );
                	update_option('fqr_width', $_POST['fqr_width'] );
                	update_option('fqr_random', $_POST['fqr_random'] );
                	update_option('fqr_stylesheet', $_POST['fqr_stylesheet'] );

                	?><div class="updated"><p><strong><?php _e('Options saved.', 'eg_trans_domain' ); ?></strong></p></div><?php
		}
		/* end of added by colin@brainbits.ca */

      ?>
      <div class="wrap">
      <h2>Flexi Quote Rotator Options</h2>
      
      <form method="post">
      <?php wp_nonce_field('update-options'); ?>
     
      <table class="form-table">
      <tr valign="top">
      <th scope="row">Title</th>
      <td><input type="text" name="fqr_title" value="<?php echo get_option('fqr_title'); ?>" /><br/>(adds a header above quote area, leave blank if no header desired)</td>
      </tr>
       
      <tr valign="top">
      <th scope="row">Delay (in seconds)</th>
      <td><input type="text" name="fqr_delay" value="<?php echo get_option('fqr_delay'); ?>" /></td>
      </tr>
      
      <tr valign="top">
      <th scope="row">Fade in duration (in seconds)</th>
      <td><input type="text" name="fqr_fade" value="<?php echo get_option('fqr_fade'); ?>" /></td>
      </tr>

      <tr valign="top">
      <th scope="row">Fade out duration (in seconds)</th>
      <td><input type="text" name="fqr_fadeout" value="<?php echo get_option('fqr_fadeout'); ?>" /></td>
      </tr>
            
      <tr valign="top">
      <th scope="row">Height override (overrides CSS)</th>
      <td><input type="text" name="fqr_height" value="<?php echo get_option('fqr_height'); ?>" />px</td>
      </tr>
      
      <tr valign="top">
      <th scope="row">Width override (overrides CSS)</th>
      <td><input type="text" name="fqr_width" value="<?php echo get_option('fqr_width'); ?>" />px</td>
      </tr>
            
      <tr valign="top">
      <th scope="row">Random?</th>
      <td>
         Yes <input type="radio" name="fqr_random" value="1"<?php if(get_option('fqr_random')==1) echo ' checked="checked"';?> />&nbsp;&nbsp;&nbsp;
         No <input type="radio" name="fqr_random" value="0"<?php if(get_option('fqr_random')!=1) echo ' checked="checked"';?> />
      </td>
      </tr>

      <tr valign="top">
      <th scope="row">Stylesheet</th>
      <td>
         <select name="fqr_stylesheet">
            <option>none</option>
         <?php
            $style = get_option('fqr_stylesheet'); 
            $stylesdir	= ABSPATH . 'wp-content/plugins/flexi-quote-rotator/styles/';
            $allCSS = array();
            $dir = opendir($stylesdir);
            while ( $dir && ($f = readdir($dir)) ) {
            	if( eregi("\.css$",$f) && !eregi("calendar\.css$",$f) ){
            		array_push($allCSS, $f);
            	}
            }
            sort($allCSS);
            foreach ( $allCSS as $f ) {
            	if( $f==$style )
            	    	echo '<option style="background:#fbd0d3" selected="selected" value="'.$f.'">'.$f.'</option>'."\n";
            	else
            			echo '<option value="'.$f.'">'.$f.'</option>';																		
            }
         ?>
         </select><br/>
         (you can add your own stylesheet to the directory /wp-content/plugins/flexi-quote-rotator/styles/ for full control over styling)
      </td>
      </tr>
      </table>
      
      <input type="hidden" name="action" value="update" />
      <input type="hidden" name="page_options" value="fqr_title,fqr_delay,fqr_fade,fqr_fadeout,fqr_height,fqr_width,fqr_random,fqr_stylesheet" />
      
      <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
      </p>
      
      </form>
      </div>
      <?php
   }
   	
	function displayWidgetControl()
	{
		$options = get_option('widgetQuoteRotator');
		if ( !is_array($options) ){
			$options = array();
			$options['title'] = 'Quotes';
			$options['delay'] = 5;
			$options['fade'] = 2;
			$options['fontsize'] = 14;
			$options['fontunit'] = 'px';
			$options['random'] = 0;
			$options['height'] = 100;
			$options['color'] = 'black';
		}
		if ( $_POST['quoterotator-submit'] ) {
			$options['title'] = strip_tags(stripslashes($_POST['quoterotator-title']));
			$options['delay'] = strip_tags(stripslashes($_POST['quoterotator-delay']));
			$options['fade'] = strip_tags(stripslashes($_POST['quoterotator-fade']));
			$options['fontsize'] = strip_tags(stripslashes($_POST['quoterotator-fontsize']));
			$options['fontunit'] = strip_tags(stripslashes($_POST['quoterotator-fontunit']));
			$options['random'] = strip_tags(stripslashes($_POST['quoterotator-random']));
			$options['height'] = strip_tags(stripslashes($_POST['quoterotator-height']));
			$options['color'] = strip_tags(stripslashes($_POST['quoterotator-color']));
			update_option('widgetQuoteRotator', $options);
		}

		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$delay = htmlspecialchars($options['delay'], ENT_QUOTES);
		$fade = htmlspecialchars($options['fade'], ENT_QUOTES);
		$fontsize = htmlspecialchars($options['fontsize'], ENT_QUOTES);
		$fontunit = htmlspecialchars($options['fontunit'], ENT_QUOTES);
		$random = htmlspecialchars($options['random'], ENT_QUOTES);
		$height = htmlspecialchars($options['height'], ENT_QUOTES);
		$color = htmlspecialchars($options['color'], ENT_QUOTES);
		
		echo '<p><label for="quoterotator-title">Title: </label><input style="width: 200px;" id="quoterotator-title" name="quoterotator-title" type="text" value="'.$title.'" /></p>';
		echo '<p><label for="quoterotator-delay">Delay(seconds): </label><input style="width: 200px;" id="quoterotator-delay" name="quoterotator-delay" type="text" value="'.$delay.'" /></p>';
		echo '<p><label for="quoterotator-fade">Fade Time(seconds): </label><input style="width: 200px;" id="quoterotator-fade" name="quoterotator-fade" type="text" value="'.$fade.'" /></p>';
		echo '<p><label for="quoterotator-fontsize">Font Size: </label><input style="width: 50px;" id="quoterotator-fontsize" name="quoterotator-fontsize" type="text" value="'.$fontsize.'" />';
		echo '<select id="quoterotator-fontunit" name="quoterotator-fontunit">';
		echo '<label for="quoterotator-fontunit"><option value="px">px</option>';
		echo '<option value="em"';
		if ( isset($options['fontunit']) && 'em' == $options['fontunit'] ) echo ' selected="selected"';
		echo ' >em</option>';
		echo '<option value="%"';
		if ( isset($options['fontunit']) && '%' == $options['fontunit'] ) echo ' selected="selected"';
		echo ' >%</option>';
		echo '</select>';
		echo '</label></p>';

		echo '<p><label for="quoterotator-height">Height(pixels): </label><input style="width: 200px;" id="quoterotator-height" name="quoterotator-height" type="text" value="'.$height.'" /></p>';
		echo '<p><label for="quoterotator-color">Text Color: </label><input style="width: 200px;" id="quoterotator-color" name="quoterotator-color" type="text" value="'.$color.'" /></p>';

		echo '<p><label for="quoterotator-random">Random?: </label><input id="quoterotator-random1" name="quoterotator-random" type="radio" ';
		if($random==1)
			echo 'checked="yes" ';
		echo 'value="1" /> Yes';
		echo '<input id="quoterotator-random2" name="quoterotator-random" type="radio" ';
		if($random==0)
			echo 'checked="no" ';
		echo 'value="0" /> No </label></p>';
		echo '<input type="hidden" id="quoterotator-submit" name="quoterotator-submit" value="1" />';
	}
}

//endif;
