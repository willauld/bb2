<?php
if ( isset( $_GET['pb_backupbuddy_alt_cron'] ) ) {
	echo __('Alternate Cron Should Run Now', 'it-l10n-backupbuddy');
} else {

	$this->admin_scripts();
	
	// Needed for fancy boxes...
	wp_enqueue_style('dashboard');
	wp_print_styles('dashboard');
	wp_enqueue_script('dashboard');
	wp_print_scripts('dashboard');

	// If they clicked the button to reset plugin defaults...
	if (!empty($_POST['reset_defaults'])) {
		$this->_options = $this->_parent->_defaults;
		$this->_parent->activate();
		$this->_parent->save();
		$this->_parent->alert( __('Plugin settings have been reset to defaults.', 'it-l10n-backupbuddy') );
	}
	if (!empty($_POST['reset_log'])) {
		if ( file_exists ( ABSPATH . '/wp-content/uploads/bb2' . '-' . $this->_options['log_serial'] . '.txt' ) ) {
			unlink( ABSPATH . '/wp-content/uploads/bb2' . '-' . $this->_options['log_serial'] . '.txt' );
		}
		$this->_parent->alert( __('Plugin log has been cleared.', 'it-l10n-backupbuddy') );
	}
	if (!empty($_POST['file_cleanup'])) {
		$this->_parent->periodic_cleanup( 0 );
		$this->alert( __( 'Manually forced file cleanup complete.', 'it-l10n-backupbuddy' ) );
	}
	?>

	<div class="wrap">
		<div class="postbox-container" style="width:70%;">
			<?php
			$this->title( _x('Getting Started with BackupBuddy v', 'v for version', 'it-l10n-backupbuddy') . $this->_parent->_version );
			
			
			echo '<br />';
			
			echo __("BackupBuddy is the all-in-one solution for backups, restoration, and migration.  The single backup ZIP file created can be used with the import & migration script to quickly and easily restore your site on the same server or even migrate to a new host with different settings.  Whether you're an end user or a developer, this plugin will bring you peace of mind and added safety in the event of data loss.  Our goal is keeping the backup, restoration, and migration processes easy, fast, and reliable.", 'it-l10n-backupbuddy');
			
			echo sprintf( __('Throughout the plugin you may hover your mouse over question marks %1$s for tips or click play icons %2$s for video tutorials.', 'it-l10n-backupbuddy'), 
						  $this->tip( __('This tip provides additional help.', 'it-l10n-backupbuddy'), '', false ), //the flag false returns a string
						  $this->video( 'x', __('This video would provide detailed information.', 'it-l10n-backupbuddy'), false )
						  );
			
			echo '<br /><br />';
			?>
			<p>
				<h3><?php _e('Backup', 'it-l10n-backupbuddy');?></h3>
				<ol>
					<li type="disc">
					<?php
						echo sprintf( __('Perform a <b>Full Backup</b> by clicking `Full Backup` button on the <a href="%s">Backup</a> page. This backs up all files in your WordPress directory (and subdirectories) as well as the database. This will capture everything from the Database Only Backup and also all files in the WordPress directory and subdirectories. This includes files such as media, plugins, themes, images, and any other files found.', 'it-l10n-backupbuddy'), admin_url( "admin.php?page={$this->_var}-backup" ) );
					?>
					</li>
					<li type="disc">
						<?php
							echo sprintf( __('Perform a <b>Database Backup</b> regularly by clicking `Database Backup` button on the <a href="%s">Backup</a>. The database contains posts, pages, comments widget content, media titles & descriptions (but not media files), and other WordPress settings. It may be backed up more often without impacting your available storage space or server performance as much as a Full Backup.', 'it-l10n-backupbuddy'), admin_url( "admin.php?page={$this->_var}-backup" ) );
						?>	
					</li>
					<li type="disc"><?php _e('Local backup storage directory', 'it-l10n-backupbuddy');?>: <span style="background-color: #EEEEEE; padding: 4px;"><i><?php echo str_replace( '\\', '/', $this->_options['backup_directory'] ); ?></i></span> <?php $this->tip(' ' . __('This is the local directory that backups are stored in. Backup files include random characters in their name for increased security. BackupBuddy must be able to create this directory & write to it.', 'it-l10n-backupbuddy') ); ?></li>
				</ol>
				
			</p>
			<br />
			<p>
				<h3><?php _e('Restoring, Migrating', 'it-l10n-backupbuddy');?></h3>
				<ol>
					<?php
						echo '<li type="disc">', 
							 sprintf( __('Upload the backup file and <a href="%s">importbuddy.php</a> to the root web directory of the destination server. <b>Do not install WordPress</b> on the destination server. The importbuddy.php script will restore all files, including WordPress.', 'it-l10n-backupbuddy'), $this->importbuddy_link()),
							 '</li>',
							 '<li type="disc">',
							 __('Create a mySQL database on the destination server.', 'it-l10n-backupbuddy'), 
							 '( <a href="http://pluginbuddy.com/tutorial-create-database-in-cpanel/" target="_new">',
							 __('Tutorial Video & Instructions Here', 'it-l10n-backupbuddy'),
							 '</a> )</li>',
							'<li type="disc">',
							sprintf( __('Navigate to <a href="%s">importbuddy.php</a> in your web browser on the destination server. If you provided an import password you will be prompted for this password before you may continue.', 'it-l10n-backupbuddy'), $this->importbuddy_link() ),
							'</li>',
							'<li type="disc">',
							__('Follow the importing instructions on screen. You will be asked whether you are restoring or migrating.', 'it-l10n-backupbuddy'),
							'</li>';
					?>
				</ol>
			</p>
			
			<?php 
				if ( stristr( PHP_OS, 'WIN' ) ) {
					echo '<br />',
						 '<h3>',
						 __('Windows Server Performance Boost', 'it-l10n-backupbuddy'),
						 '</h3>',
						 __('Windows servers may be able to significantly boost performance, if the server allows executing .exe files, by adding native Zip compatibility executable files.
				Instructions are provided within the readme.txt in the package.  This package prevents Windows from falling back to Zip compatiblity mode and works for both BackupBuddy and importbuddy.php. This is particularly useful for <a href="http://ithemes.com/codex/page/BackupBuddy:_Local_Development">local development on a Windows machine using a system like XAMPP</a>.', 'it-l10n-backupbuddy');
			 } ?>
			
			<br /><br />
			
			<br />
			
			<center>
				<div style="background: #D4E4EE; -webkit-border-radius: 8px; -moz-border-radius: 8px; border-radius: 8px; padding: 15px; text-align: center; width: 395px; line-height: 1.6em;">
					<a title="<?php _e('Click to visit the PluginBuddy Knowledge Base', 'it-l10n-backupbuddy');?>" href="http://ithemes.com/codex/page/BackupBuddy" style="text-decoration: none; color: #000000;">
						<img src="<?php echo $this->_pluginURL , '/images/kb.png';?>" alt="" width="70" height="70" style="float: right;" /><?php _e('For documentation &#038; help visit our', 'it-l10n-backupbuddy');?><br />
						<span style="font-size: 2.8em;"><?php _e('Knowledge Base', 'it-l10n-backupbuddy');?></span>
						<br /><?php _e('Walkthroughs &middot; Tutorials &middot;  Technical Details', 'it-l10n-backupbuddy');?>
					</a>
				</div>
			</center>
			
			<br style="clear: both;" />
			
			
			
			<br /><br />
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#pluginbuddy_debugtoggle").click(function() {
						jQuery("#pluginbuddy_debugtoggle_div").slideToggle();
					});
				});
			</script>
			
			<table>
				<tr>
				<td>
					<a id="pluginbuddy_debugtoggle" class="button secondary-button"><?php _e('Debugging Information', 'it-l10n-backupbuddy');?></a>
				</td><td>&nbsp;&nbsp;</td><td>
					<form method="post" action="<?php echo $this->_selfLink; ?>">
						<input type="hidden" name="file_cleanup" value="true" />
						<input type="submit" name="submit" value="<?php _e('Manual File Cleanup', 'it-l10n-backupbuddy');?>" class="button secondary-button" />
					</form>
					</td>
				</tr>
			</table>
			
			<div id="pluginbuddy_debugtoggle_div" style="display: none;">
				<h3><?php _e('Debugging Information', 'it-l10n-backupbuddy');?></h3>
				<?php
				$temp_options = $this->_options;
				$temp_options['import_password'] = '*hidden*';
				echo '<textarea rows="7" cols="65">';
				echo 'Plugin Version = '.$this->_name.' '.$this->_parent->_version.' ('.$this->_parent->_var.')'."\n";
				echo 'WordPress Version = '.get_bloginfo("version")."\n";
				echo 'PHP Version = '.phpversion()."\n";
				global $wpdb;
				echo 'DB Version = '.$wpdb->db_version()."\n";
				echo "\n".print_r($temp_options);
				echo '</textarea>';
				?>
				<p>
				<form method="post" action="<?php echo $this->_selfLink; ?>">
					<input type="hidden" name="reset_defaults" value="true" />
					<input type="submit" name="submit" value="<?php _e('Reset Plugin Settings & Defaults', 'it-l10n-backupbuddy');?>" id="reset_defaults" class="button secondary-button" onclick="if ( !confirm('<?php _e('WARNING: This will reset all settings associated with this plugin to their defaults. Are you sure you want to do this?', 'it-l10n-backupbuddy');?>') ) { return false; }" />
				</form>
				</p>
				
				<h3><?php _e('Log File', 'it-l10n-backupbuddy');?></h3>
				<?php
				echo '<textarea rows="7" cols="65">';
				if ( file_exists( ABSPATH . '/wp-content/uploads/pluginbuddy_backupbuddy' . '-' . $this->_options['log_serial'] . '.txt' ) ) {
					readfile( ABSPATH . '/wp-content/uploads/pluginbuddy_backupbuddy' . '-' . $this->_options['log_serial'] . '.txt' );
				} else {
					echo __('Nothing has been logged.', 'it-l10n-backupbuddy');
				}
				echo '</textarea>';
				?>
				<p>
				<form method="post" action="<?php echo $this->_selfLink; ?>">
					<input type="hidden" name="reset_log" value="true" />
					<input type="submit" name="submit" value="<?php _e('Clear Log File', 'it-l10n-backupbuddy');?>" id="reset_log" class="button secondary-button" />
				</form>
				</p>
				
			</div>
		</div>
	</div>
<?php } ?>
