<?php
if( !class_exists('QuoteRotator') ) :

class QuoteRotator
{
	var $tableName;
	var $pluginPath;
	var $currentVersion;
	
	function QuoteRotator()
	{
		global $wpdb;
		
		if( !function_exists('get_option') )
		{
			require_once('../../../wp-config.php');
		}
		
		$this->currentVersion = '0.1';
		$this->tableName = $wpdb->prefix . 'QuoteRotator';
		$this->pluginPath = get_settings('siteurl') . '/wp-content/plugins/flexi-quote-rotator/';
		
		$options = get_option('widgetQuoteRotator');
		$options['version'] = $this->currentVersion;
		update_option('widgetQuoteRotator', $options);
	}
	
	function createDatabaseTable()
	{
		global $wpdb;
		
		if( !function_exists('get_option') )
		{
			require_once('../../../wp-config.php');
		}
		
		$options = array();
		$options['title'] = 'Quote Rotator';
		$options['delay'] = 5;
		$options['fade'] = 2;
		$options['fontsize'] = 12;
		$options['fontunit'] = 'px';
		
		if( !get_option('widgetQuoteRotator') )
		{
			add_option('widgetQuoteRotator', $options);
		}
		
		if( $wpdb->get_var("SHOW TABLES LIKE `" . $this->tableName . "`") != $this->tableName)
		{
			$sql = "CREATE TABLE `" . $wpdb->prefix . "QuoteRotator` (`id` MEDIUMINT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY, `quote` TEXT NULL);";
			//$sql = "CREATE TABLE `" . $this->tableName . "` (`id` MEDIUMINT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY, `quote` TEXT NULL);";
			require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
			dbDelta($sql);
			$options['version'] = $this->currentVersion;
		}
		$sql = "ALTER TABLE `" . $this->tableName . "` ADD `author` VARCHAR(255) NOT NULL AFTER `quote`;";
		$wpdb->query($sql);
		$sql = "RENAME TABLE `wp_QuoteRotator` TO `$this->tableName`;";
		$wpdb->query($sql);
		$sql = "ALTER TABLE `" . $this->tableName . "` CHANGE `quote` `quote` TEXT NULL;";
		$wpdb->query($sql);
		update_option('widgetQuoteRotator', $options);
		delete_option('widgetizeQuoteRotator');		
	}
	
	function deleteDatabaseTable()
	{
		if( !function_exists('get_option') )
		{
			require_once('../../../wp-config.php');
		}
		delete_option('widgetQuoteRotator');
		//global $wpdb;
		
		//$sql = "DROP TABLE IF EXISTS " . $this->tableName . ";";	
		//$wpdb->query($sql);
	}
	
	function addHeaderContent()
	{
		global $wpdb;
		
		if( !function_exists('get_option') )
		{
			require_once('../../../wp-config.php');
		}
      
		$delay = get_option('fqr_delay');
		if (!isset($delay) || $delay == "") $delay = 5;
		$fade = get_option('fqr_fade');
		if (!isset($fade) || $fade == "") $fade = 2;
		$fadeout = get_option('fqr_fadeout');
		if (!isset($fadeout) || $fadeout == "") $fadeout = 0;
		$random = get_option('fqr_random');
		if (!isset($random) || $random == "") $random = 0;
		
		if($random)
			$sql = "SELECT * FROM " . $this->tableName . " ORDER BY RAND(".time().")";
		else
			$sql = "SELECT * FROM " . $this->tableName . " ORDER BY id";
		$results = $wpdb->get_results($sql);
		
		$stylesdir = 'wp-content/plugins/flexi-quote-rotator/styles/';
		$cssfile = get_option('fqr_stylesheet');
      if (file_exists(ABSPATH . $stylesdir . $cssfile))
		echo "
			<link rel=\"stylesheet\" href=\"" . get_settings('siteurl') . '/' . $stylesdir . $cssfile ."\" type=\"text/css\" media=\"screen\" />";
		/* 2010-03-25 replacing Scriptaculous animation code with jQuery - Thanks to colin@brainbits.ca for supplying the code */
		echo "	<script type='text/javascript'>
				quoteRotator = {
					i: 1,
					quotes: [";

               	$i=0;
               	foreach($results as $result){
                       	echo "\"$result->quote";
                       	if($result->author != '')
				echo " <span id='quoteauthor'>$result->author</span>";
			echo "\",\n";
			$i++;
		}
		echo "
					],
					numQuotes: ".$i.",
					fadeDuration: ".$fade.",
					fadeoutDuration: ".$fadeout.",
					delay: ".$delay.",
					quotesInit: function(){
						if (this.numQuotes < 1){
							document.getElementById('quoterotator').innerHTML=\"No Quotes Found\";
						} else {
							this.quoteRotate();
							setInterval('quoteRotator.quoteRotate()', (this.fadeDuration + this.fadeoutDuration + this.delay) * 1000);
						}
					},
					quoteRotate: function(){
						jQuery('#quoterotator').hide().html(this.quotes[this.i - 1]).fadeIn(this.fadeDuration * 1000).css('filter','').delay(this.delay * 1000).fadeOut(this.fadeoutDuration * 1000);
						this.i = this.i % (this.numQuotes) + 1;
					}
	
				}
			</script>";
	}
		
	function displayWidget($args)
	{
		extract($args);
		
		$options = get_option('widgetQuoteRotator');
		$title = $options['title'];

      $color = $options['color'];
      
      $style = "";
      if ($options['fontsize'] != "") $style .= "font-size:".$options['fontsize'].$options['fontunit'].";";
      if ($options['height'] != "") $style .= "height:".$options['height']."px;";
      if ($options['color'] != "") $style .= "color:".$options['color'].";";
      if ($style != "") $style = " style='".$style."'";

		echo $before_widget . $before_title . $title . $after_title;
		
		echo "<div id=\"quotearea\"$style><div id=\"quoterotator\">\n";
		echo "Loading Quotes...\n";
		echo "</div></div>\n";
		echo "<script type=\"text/javascript\">setTimeout(\"quoteRotator.quotesInit()\", 2000)</script>\n";
		
		echo $after_widget;
	}

	function getQuoteCode($title=null, $delay=null, $fadeDuration=null, $fadeoutDuration=null)
	{
		$output =  "";
           
      if (isset($title) && $title != "") {
   		$output .=  "<h2>" . $title . "</h2>";
		} else {
         $title_from_settings = get_option('fqr_title');
         if (isset($title_from_settings) && $title_from_settings != "") {
      		$output .=  "<h2>" . $title_from_settings . "</h2>";
   		}
      }
      $style = "";
      if (get_option('fqr_height') != "") $style .= "height:".get_option('fqr_height')."px;";
      if (get_option('fqr_width') != "") $style .= "width:".get_option('fqr_width')."px;";
      if ($style != "") $style = " style='".$style."'";
		$output .= "<div id=\"quotearea\"$style><div id=\"quoterotator\">\n";
		$output .= "Loading Quotes...\n";
		$output .= "</div></div>\n";
		$output .= "<script type=\"text/javascript\">";
      if (isset($delay) && $delay != "") {
   		$output .=  "quoteRotator.delay=".$delay.";";
		}
      if (isset($fadeDuration) && $fadeDuration != "") {
   		$output .=  "quoteRotator.fadeDuration=".$fadeDuration.";";
		}
      if (isset($fadeoutDuration) && $fadeoutDuration != "") {
   		$output .=  "quoteRotator.fadeoutDuration=".$fadeoutDuration.";";
		}
      $output .= "quoteRotator.quotesInit();</script>\n";
		return $output;
	}
}

endif;
?>
