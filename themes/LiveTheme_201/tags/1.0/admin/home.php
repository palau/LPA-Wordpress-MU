<?php if ( is_user_logged_in() ):?>

	<?php $standardframework =  get_bloginfo('stylesheet_directory').'/admin/';?>

	<?php get_scripts_styles(); ?>
	
	<script type="text/javascript">
	    var standardframework = "<?php bloginfo('template_directory'); ?>";
	</script>

	<div id="standard_framework">
	    
		<div id="standard_header" class="polish">
		
			<h1 id="standard_logo"><a href="<?php bloginfo('wpurl');?>/wp-admin/admin.php?page=standardframework">Standard Theme</a></h1>
		
			<div class="clear"></div>
		
		</div><!-- /#standard_header -->
		
		<?php
		
		/* ----------------------- Form Security Check -------------------------- */
		if(isset($_POST['_wpnonce'])):
		    //Check if submitted from this domain
		    check_admin_referer();
		    //Verify Form Nonce
		    if (! wp_verify_nonce($_POST['_wpnonce'], md5('standard_framework'.date('D'))) ) die('Security Exception');
		endif;
		
		
		/* ------------------Import/Export Functions ----------------------- */
		//Restore Previous Options
		global $export_message;
		if(isset($_POST['standard_restore'])):
		    $current = get_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME);
		    $backup = get_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME.'_backup');
		    update_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME.'_backup', $current);
		    update_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME, $backup);
		    $export_message = "<p class='import'>Everything's back to normal now!</p>";
		endif;
		
		//Restore Defaults
		
		if(isset($_POST['standard_defaults'])):
		    $current = get_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME);
		    update_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME.'_backup', $current);
		    delete_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME);
		    $export_message = "<p class='import'>Default options restored!<span><form method='post' action=''><input class='standard_restore' type='submit' name='standard_restore' value='Click Here to Undo'></form></span></p>";
		endif;
		
		
		/* ------------------------- Import Options Code ------------------------------- */
		
		if(isset($_POST['standard_import']) && isset($_POST['standard_import_code'])):
		    $import = $_POST['standard_import_code'];
		    $import = base64_decode($import);
		    $import = explode('~~', $import);
		    
		    //Check if code is legitimate
		    if(count($import) == 2):
			$option_name = $import[0];
			$options = explode('||', $import[1]);
		
			foreach ($options as $option):
			    $option = explode('|', $option);
			    global $new_options;
			    $new_options[$option[0]] = preg_replace('/"/', '\'', stripslashes($option[1]));
			endforeach;
			$current_option = get_option($option_name);
			update_option($option_name.'_backup', $current_option);
			update_option($option_name, $new_options);
			$export_message = "<p class='import'>Options Code Import Successful!<span><form method='post' action=''><input class='standard_restore' type='submit' name='standard_restore' value='Click Here to Undo'></form></span></p>";
		    else:
			$export_message = "<p class='import'>Oops! Something went wrong. <span>Try pasting your import code again.</span></p>";
		    endif;

		endif;
	    
		/* ------------------------- Save Theme Options ------------------------------- */
		if(isset($_POST['standard_save'])):
			$posts = $_POST;
			foreach($posts as $k => $v):
			    //Check if option is array (mulitple selects)
			    if(is_array($v)):
					//Check if array is empty
					$check = 0;
					foreach($v as $key => $value):    
						if($value != ''):
							$check++;
						endif;
					endforeach;
					//If array is not empty
					if($check > 0  ):
						//Remove empty array elements
						$post[$k] = array_filter($v);
					else:
						$post[$k] = '';
					endif;
					$check = 0;
			    else:
					//Remove slashes
					$post[$k] = preg_replace('/"/', '\'', stripslashes($v));
			    endif;
			endforeach;
			//Add options array to wp_options table
			update_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME, $post);
		    endif;
		
		/* ---------------------- Default Options Functions  ----------------- */
		global $default_check;
		global $default_options;
		
		$option_check = get_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME);	
		if($option_check):
		    $default_check = true;
		else:
		    $default_check = false;
		endif;
		

		//Get all options from the database
		$standard_options_db = get_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME);
		global $standard_options;
		//Check if options are stored properly
		if(is_array($standard_options_db)):
		    //Check array to an object
		    foreach ($standard_options_db as $k => $v) {
				$standard_options -> {$k} = $v;
		    }
		endif;
		?>
    
		<form method="post" enctype="multipart/form-data" action="" id="theme-options" name="theme-options">
		    <?php //Security Nonce For Cross Site Hacking
		    $nonce= wp_create_nonce(md5('standard_framework'.date('D')));?>
		    <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?=$nonce?>" />
		    
		<div class="button-zone-wrapper">
		    <div id="button-zone" class="polish">
			<span class="top">
			    <!--<span class="formState">Theme options have changed. Make sure to save.</span>-->
				<span class="formState">Options updated. Remember to save your changes!</span>
			    <button class="save" id="standard_save" name="standard_save" type="submit">Save Changes</button>
			</span>
		    </div><!-- #button-zone -->
		</div><!-- /.button-zone-wrapper -->
		
		<div id="standard_main">

				<div id="standard_sidebar">
				
					<div id="standard_nav" class="box">
						
						<ul>
							<?php //Create dynamic tab links from array
							global $standard_tabs;
							    foreach ($standard_tabs as $tab):
								foreach($tab as $title => $shortname):?>
								    <li class="<?=$shortname?>"><a href="#<?=$shortname?>"><?=$title?></a></li>
								<?php endforeach;
							    endforeach;?>
							<li class="import-and-export"><a href="#import-and-export">Import And Export</a></li>
						</ul>
									
					</div>
				
				</div>
				
				<div id="standard_content">
					<div id="tabber">
					    <?php //Create dynamic tabs from array
					    foreach ($standard_tabs as $order => $tab):
						foreach($tab as $title => $shortname):?>
						    <div id="<?=$shortname?>">
							<h2><?=$title?></h2>
							<ul class="feature-set">
							    <?php require_once (STYLESHEETPATH . '/theme-options/'.$shortname.'_'.$order.'.php'); ?>
							</ul>										
						    </div><!-- /#<?=$shortname?> -->
						<?php endforeach;
					    endforeach;?>
					    </form>
					    <div id="import-and-export">
						<h2>Import And Export</h2>
						<ul class="feature-set">
						    <?php require_once (STYLESHEETPATH . '/admin/import-export.php'); ?>
						</ul>										
					    </div><!-- /#import-export -->
				
					</div><!-- /#tabber -->

				</div><!-- /#standard_content -->
			
				<div class="clear"></div>

			
		
		</div>
		
		<div id="standard_footer">
		
			<ul>
				<li><a href="#"><?=STANDARD_FRAMEWORK_NAME?> Version <?=STANDARD_THEME_VER?></a></li>
				<li><a href="#">Standard Framework <?=STANDARD_FRAMEWORK_VER?></a></li>
			</ul>
		
		</div><!-- /#standard_footer -->
	
	</div><!-- /#standard_framework -->

<?php else: echo "You must be logged in to view this page"; endif;?>