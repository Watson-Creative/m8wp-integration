<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    M8wp_Integration
 * @subpackage M8wp_Integration/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    M8wp_Integration
 * @subpackage M8wp_Integration/admin
 * @author     Your Name <email@example.com>
 */
class M8wp_Integration_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $m8wp_integration    The ID of this plugin.
	 */
	private $m8wp_integration;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $m8wp_integration       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $m8wp_integration, $version ) {

		$this->m8wp_integration = $m8wp_integration;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in M8wp_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The M8wp_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->m8wp_integration, 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', array(), $this->version, 'all' );
		// add select2 style
		wp_enqueue_style( $this->m8wp_integration, plugin_dir_url( __FILE__ ) . 'css/m8wp-integration-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in M8wp_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The M8wp_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// add select2 script
		wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->m8wp_integration, plugin_dir_url( __FILE__ ) . 'js/m8wp-integration-admin.js', array( 'jquery', 'select2'), $this->version, false );

		

	}

	/**
	 *Create Metabox for Pages/Posts.
	 *
	 * @since    1.0.1
	 */
	public function create_metabox() {
		//replace $screens with recalled setting for post types to use.
		$screens = ['post', 'page'];
	    foreach ($screens as $screen) {
	    	global $wp_meta_boxes;
	        add_meta_box(
	            'm8wp_integration', // Unique ID
	            'Motiv8 Rewards',  // Box title
	            array($this, 'm8wp_metabox_html'), // Content callback, must be of type callable
	            $screen,  // Post type
	            'normal',
	            'high'
	        );
	    }
	}
	public function m8wp_metabox_html($post){
		//retrieve current value for trigger
	    $trigger_value = get_post_meta($post->ID, '_m8wp_trigger_value', true);
	    ?>
<!-- 	    <label for="m8wp_reward">Select Reward</label>
	    <select name="m8wp_reward" id="m8wp_reward" class="postbox js-example-data-ajax">
		</select>
		<br /> -->
		<label for="m8wp_trigger">Select Reward Trigger</label>
	    <select name="m8wp_trigger" id="m8wp_trigger" class="postbox">
	    	<!-- need to make sure to add selected($value, VAL) to ajax sourced options. include necessary identifiers, encoded appropriately -->
	    	<option value='Timer' <?php selected($trigger_value, 'Timer'); ?> >Timer</option>
	    	<option value='Button' <?php selected($trigger_value, 'Button'); ?> >Button</option>
	    	<option value='Anchor' <?php selected($trigger_value, 'Anchor'); ?> >Anchor</option>
		</select>
		<!-- echo shortcode on trigger selection for user to past into content block? -->
	    <?php
	}
	public function m8wp_metabox_save_postdata($post_id)
		{
		    if (array_key_exists('m8wp_trigger', $_POST)) {
		        update_post_meta(
		            $post_id,
		            '_m8wp_trigger_value',
		            $_POST['m8wp_trigger']
		        );
		    }
		}

	/**
	 *Create Admin Options Panel
	 *
	 * @since    1.0.1
	 */
	public function register_m8wp_admin_settings() {
		register_setting( 'm8wp_admin_settings', 'm8wp_admin_options' );
	}
	public function create_m8wp_admin_settings_page() {
		// add_menu_page('Motiv8 Admin Settings', 'Motiv8 Admin Settings', 'editor', __FILE__, 'm8wp_admin_settings_page');
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Motiv8 Admin Settings', 'm8wp_integration_admin' ),
			__( 'Motiv8 Admin', 'm8wp_integration_admin' ),
			'manage_options',
			'm8wp_integration_admin',
			array( $this, 'm8wp_admin_settings_page' )
		);
	}

	
	public function m8wp_admin_settings_page(){
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
	<?php
	}


}
