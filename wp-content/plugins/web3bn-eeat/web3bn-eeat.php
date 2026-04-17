<?php
/**
 * Plugin Name:  Web3BN — E-E-A-T & Author Profiles
 * Plugin URI:   https://web3businessnews.com
 * Description:  Strengthens Google E-E-A-T signals via structured author profiles, enhanced JSON-LD schema (NewsMediaOrganization, Person, NewsArticle), and author bio boxes on every post.
 * Version:      1.0.0
 * Author:       Web3BusinessNews
 * License:      GPL-2.0-or-later
 * Text Domain:  w3bn-eeat
 */

defined( 'ABSPATH' ) || exit;

define( 'W3BN_EEAT_VERSION', '1.0.0' );
define( 'W3BN_EEAT_DIR',     plugin_dir_path( __FILE__ ) );
define( 'W3BN_EEAT_URL',     plugin_dir_url( __FILE__ ) );

require_once W3BN_EEAT_DIR . 'includes/author-data.php';
require_once W3BN_EEAT_DIR . 'includes/class-user-setup.php';
require_once W3BN_EEAT_DIR . 'includes/class-schema-enhancer.php';
require_once W3BN_EEAT_DIR . 'includes/class-bio-box.php';

// Populate user meta once on activation (or on demand via settings page).
register_activation_hook( __FILE__, [ 'W3BN_User_Setup', 'run' ] );

// Allow admin to re-run setup after adding new authors.
add_action( 'admin_post_w3bn_rerun_setup', function () {
	check_admin_referer( 'w3bn_rerun_setup' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized.' );
	}
	delete_option( 'w3bn_eeat_setup_done' );
	W3BN_User_Setup::run();
	wp_safe_redirect( admin_url( 'options-general.php?page=w3bn-eeat&updated=1' ) );
	exit;
} );

// Enhance Yoast's schema graph (Organization → NewsMediaOrganization, Article → NewsArticle).
add_filter( 'wpseo_schema_graph', [ 'W3BN_Schema_Enhancer', 'enhance_yoast_graph' ], 99 );

// Output supplementary Person schema with E-E-A-T fields Yoast omits.
add_action( 'wp_head', [ 'W3BN_Schema_Enhancer', 'output_person_schema' ], 5 );

// Append author bio box after post content.
add_filter( 'the_content', [ 'W3BN_Bio_Box', 'append' ], 20 );

// Enqueue bio box stylesheet on single posts and author archives.
add_action( 'wp_enqueue_scripts', function () {
	if ( is_singular( 'post' ) || is_author() ) {
		wp_enqueue_style(
			'w3bn-bio-box',
			W3BN_EEAT_URL . 'assets/css/bio-box.css',
			[],
			W3BN_EEAT_VERSION
		);
	}
} );

// Simple settings page.
add_action( 'admin_menu', function () {
	add_options_page( 'E-E-A-T Profiles', 'E-E-A-T Profiles', 'manage_options', 'w3bn-eeat', 'w3bn_eeat_settings_page' );
} );

function w3bn_eeat_settings_page() {
	$done = get_option( 'w3bn_eeat_setup_done' );
	?>
	<div class="wrap">
		<h1>E-E-A-T Author Profiles</h1>
		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><strong>Author profiles updated successfully.</strong></p></div>
		<?php endif; ?>
		<p>This plugin manages author bios, social links, JSON-LD schema, and bio boxes for Google E-E-A-T compliance.</p>
		<table class="form-table">
			<tr>
				<th>Setup status</th>
				<td><?php echo $done ? '<span style="color:#00a32a">&#10003; Profiles populated (v' . esc_html( $done ) . ')</span>' : '<span style="color:#d63638">&#9888; Not yet run — activate or click below</span>'; ?></td>
			</tr>
		</table>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="w3bn_rerun_setup">
			<?php wp_nonce_field( 'w3bn_rerun_setup' ); ?>
			<p class="submit"><input type="submit" class="button button-primary" value="Re-run Profile Setup"></p>
		</form>
		<p><em>Run this any time you add new authors or update profile data in <code>includes/author-data.php</code>.</em></p>
	</div>
	<?php
}
