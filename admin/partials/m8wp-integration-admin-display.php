<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    M8wp_Integration
 * @subpackage M8wp_Integration/admin/partials
 */
?>


	<div class="wrap">
		<!-- <img id="watson-branding" src="<?php //echo plugins_url('img/WC_Brand_Signature.png', __FILE__ ); ?>" style="max-width:400px;"> -->
		<h1>M8WP</h1>
		<form method="post" action="options.php"> 
			<?php 
			settings_fields( 'm8wp_admin_settings' );
			do_settings_sections( 'm8wp_admin_settings' ); 
			$values = get_option('m8wp_admin_options'); ?>

			<table class="form-table ga-inject-code-options">
				<?php foreach ($values as $key => $value) {
					?>
					<tr valign="top">
				        <th scope="row"><?php echo $key; ?></th>
				        <td><input type="text" name="$key" value="<?php echo esc_attr( $value ); ?>" /></td>
			        </tr>
					<?php
				}
		        ?>
		  
		    </table>

	    <?php
			submit_button('Save Changes');
			?>
		</form>
	</div>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
