<?php
/**
 * Schema markup enhancements.
 *
 * 1. enhance_yoast_graph()  — filters Yoast's @graph to:
 *      • Upgrade Organization → NewsMediaOrganization
 *      • Upgrade Article → NewsArticle
 *      • Add masthead, address, foundingDate to the org piece
 *
 * 2. output_person_schema() — outputs a supplementary Person block
 *    on single posts and author archives with E-E-A-T-specific fields
 *    that Yoast does not include: knowsAbout, location, jobTitle via
 *    author-data.php credentials.
 */

defined( 'ABSPATH' ) || exit;

class W3BN_Schema_Enhancer {

	// ── Yoast graph filter ────────────────────────────────────────────────

	public static function enhance_yoast_graph( array $graph ): array {
		foreach ( $graph as &$piece ) {
			if ( empty( $piece['@type'] ) ) {
				continue;
			}

			$types = (array) $piece['@type'];

			// Organization → NewsMediaOrganization
			if ( in_array( 'Organization', $types, true ) ) {
				$piece['@type']        = 'NewsMediaOrganization';
				$piece['masthead']     = home_url( '/about-us/' );
				$piece['foundingDate'] = '2022';
				$piece['address']      = [
					'@type'           => 'PostalAddress',
					'addressLocality' => 'New York',
					'addressRegion'   => 'NY',
					'addressCountry'  => 'US',
				];
			}

			// Article → NewsArticle
			if ( in_array( 'Article', $types, true ) ) {
				$piece['@type'] = 'NewsArticle';
			}
		}
		unset( $piece );

		return $graph;
	}

	// ── Supplementary Person schema ───────────────────────────────────────

	public static function output_person_schema(): void {
		if ( ! is_singular( 'post' ) && ! is_author() ) {
			return;
		}

		$user_id = is_singular( 'post' )
			? (int) get_post_field( 'post_author', get_the_ID() )
			: (int) get_queried_object_id();

		$user = get_user_by( 'id', $user_id );
		if ( ! $user ) {
			return;
		}

		$profiles = w3bn_get_author_profiles();
		$data     = $profiles[ $user->user_email ] ?? [];
		if ( empty( $data ) ) {
			return;
		}

		$title    = get_user_meta( $user_id, 'w3bn_title', true )    ?: ( $data['title']       ?? '' );
		$location = get_user_meta( $user_id, 'w3bn_location', true ) ?: ( $data['location']    ?? '' );
		$twitter  = get_user_meta( $user_id, 'twitter', true )       ?: ( $data['twitter']     ?? '' );
		$linkedin = get_user_meta( $user_id, 'linkedin', true )      ?: ( $data['linkedin']    ?? '' );
		$desc     = get_user_meta( $user_id, 'description', true )   ?: ( $data['description'] ?? '' );

		$same_as = [ get_author_posts_url( $user_id ) ];
		if ( $twitter )  $same_as[] = $twitter;
		if ( $linkedin ) $same_as[] = $linkedin;

		$schema = [
			'@context' => 'https://schema.org',
			'@type'    => 'Person',
			'@id'      => get_author_posts_url( $user_id ) . '#person',
			'name'     => $user->display_name,
			'url'      => get_author_posts_url( $user_id ),
			'sameAs'   => $same_as,
			'worksFor' => [
				'@type' => 'NewsMediaOrganization',
				'name'  => 'Web3BusinessNews',
				'url'   => home_url( '/' ),
			],
		];

		if ( $title ) {
			$schema['jobTitle'] = $title;
		}
		if ( $desc ) {
			$schema['description'] = $desc;
		}
		if ( $location ) {
			$parts                 = array_map( 'trim', explode( ',', $location, 2 ) );
			$schema['address']     = [
				'@type'           => 'PostalAddress',
				'addressLocality' => $parts[0],
				'addressRegion'   => $parts[1] ?? '',
				'addressCountry'  => 'US',
			];
		}
		if ( ! empty( $data['expertise'] ) ) {
			$schema['knowsAbout'] = $data['expertise'];
		}

		echo '<script type="application/ld+json">'
			. wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
			. '</script>' . "\n";
	}
}
