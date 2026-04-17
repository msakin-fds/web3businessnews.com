<?php
/**
 * Populates WordPress user meta from author profile data.
 * Runs once on plugin activation; can be re-triggered from the settings page.
 *
 * Fields written per user:
 *   display_name, first_name, last_name  — via wp_update_user()
 *   description, w3bn_title, w3bn_location,
 *   twitter, linkedin,
 *   wpseo_twitter, wpseo_linkedin        — via update_user_meta()
 */

defined( 'ABSPATH' ) || exit;

class W3BN_User_Setup {

	public static function run(): void {
		if ( get_option( 'w3bn_eeat_setup_done' ) === W3BN_EEAT_VERSION ) {
			return;
		}

		foreach ( w3bn_get_author_profiles() as $email => $data ) {
			$user = get_user_by( 'email', $email );
			if ( ! $user ) {
				continue;
			}

			// ── Core user fields ──────────────────────────────────────────
			$update = [ 'ID' => $user->ID ];

			foreach ( [ 'display_name', 'first_name', 'last_name' ] as $field ) {
				if ( ! empty( $data[ $field ] ) ) {
					$update[ $field ] = $data[ $field ];
				}
			}

			if ( count( $update ) > 1 ) {
				wp_update_user( $update );
			}

			// ── User meta ─────────────────────────────────────────────────
			$meta_map = [
				'description'    => $data['description'] ?? '',
				'w3bn_title'     => $data['title']       ?? '',
				'w3bn_location'  => $data['location']    ?? '',
				'twitter'        => $data['twitter']     ?? '',
				'linkedin'       => $data['linkedin']    ?? '',
				// Yoast SEO social fields
				'wpseo_twitter'  => $data['twitter']     ?? '',
				'wpseo_linkedin' => $data['linkedin']    ?? '',
			];

			foreach ( $meta_map as $key => $value ) {
				if ( $value !== '' ) {
					update_user_meta( $user->ID, $key, $value );
				}
			}
		}

		update_option( 'w3bn_eeat_setup_done', W3BN_EEAT_VERSION );
	}
}
