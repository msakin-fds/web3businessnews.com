<?php
/**
 * Renders an author bio box after single post content.
 *
 * Displays: avatar, name (linked to author archive), job title, location,
 * X/Twitter + LinkedIn social links, article count, bio, and expertise tags.
 *
 * Falls back to author-data.php values when WordPress user meta is empty,
 * so the box works immediately after plugin activation even before the
 * one-time user-setup has run.
 */

defined( 'ABSPATH' ) || exit;

class W3BN_Bio_Box {

	public static function append( string $content ): string {
		if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		$author_id = (int) get_post_field( 'post_author', get_the_ID() );
		$box       = self::render( $author_id );

		return $content . $box;
	}

	public static function render( int $author_id ): string {
		$user = get_user_by( 'id', $author_id );
		if ( ! $user ) {
			return '';
		}

		$profiles = w3bn_get_author_profiles();
		$data     = $profiles[ $user->user_email ] ?? [];

		$name      = $user->display_name;
		$title     = get_user_meta( $author_id, 'w3bn_title', true )    ?: ( $data['title']       ?? '' );
		$bio       = get_user_meta( $author_id, 'description', true )   ?: ( $data['description'] ?? '' );
		$twitter   = get_user_meta( $author_id, 'twitter', true )       ?: ( $data['twitter']     ?? '' );
		$linkedin  = get_user_meta( $author_id, 'linkedin', true )      ?: ( $data['linkedin']    ?? '' );
		$location  = get_user_meta( $author_id, 'w3bn_location', true ) ?: ( $data['location']    ?? '' );
		$expertise = $data['expertise'] ?? [];

		// No bio → no box.
		if ( ! $bio ) {
			return '';
		}

		$author_url = get_author_posts_url( $author_id );
		$post_count = (int) count_user_posts( $author_id, 'post', true );
		$avatar_url = get_avatar_url( $author_id, [ 'size' => 96, 'default' => 'mystery' ] );

		$articles_label = sprintf(
			_n( '%s article', '%s articles', $post_count, 'w3bn-eeat' ),
			number_format_i18n( $post_count )
		);

		ob_start();
		?>
		<div class="w3bn-author-box" itemscope itemtype="https://schema.org/Person">
			<div class="w3bn-author-box__inner">

				<div class="w3bn-author-box__avatar">
					<a href="<?php echo esc_url( $author_url ); ?>" tabindex="-1" aria-hidden="true">
						<img src="<?php echo esc_url( $avatar_url ); ?>"
						     alt="<?php echo esc_attr( $name ); ?>"
						     width="80" height="80"
						     loading="lazy"
						     itemprop="image">
					</a>
				</div>

				<div class="w3bn-author-box__content">

					<div class="w3bn-author-box__header">
						<div class="w3bn-author-box__meta">
							<a href="<?php echo esc_url( $author_url ); ?>"
							   class="w3bn-author-box__name"
							   itemprop="url">
								<span itemprop="name"><?php echo esc_html( $name ); ?></span>
							</a>
							<?php if ( $title ) : ?>
								<span class="w3bn-author-box__title" itemprop="jobTitle">
									<?php echo esc_html( $title ); ?>
								</span>
							<?php endif; ?>
							<?php if ( $location ) : ?>
								<span class="w3bn-author-box__location">
									<svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
										<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
									</svg>
									<?php echo esc_html( $location ); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="w3bn-author-box__social">
							<?php if ( $twitter ) : ?>
								<a href="<?php echo esc_url( $twitter ); ?>"
								   target="_blank"
								   rel="noopener noreferrer nofollow"
								   class="w3bn-author-box__social-link w3bn-author-box__social-link--x"
								   aria-label="<?php echo esc_attr( $name . ' on X (Twitter)' ); ?>"
								   itemprop="sameAs">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
										<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.747l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
									</svg>
								</a>
							<?php endif; ?>
							<?php if ( $linkedin ) : ?>
								<a href="<?php echo esc_url( $linkedin ); ?>"
								   target="_blank"
								   rel="noopener noreferrer nofollow"
								   class="w3bn-author-box__social-link w3bn-author-box__social-link--linkedin"
								   aria-label="<?php echo esc_attr( $name . ' on LinkedIn' ); ?>"
								   itemprop="sameAs">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
										<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
									</svg>
								</a>
							<?php endif; ?>
							<a href="<?php echo esc_url( $author_url ); ?>" class="w3bn-author-box__articles">
								<?php echo esc_html( $articles_label ); ?>
							</a>
						</div>
					</div>

					<p class="w3bn-author-box__bio" itemprop="description">
						<?php echo esc_html( $bio ); ?>
					</p>

					<?php if ( ! empty( $expertise ) ) : ?>
						<ul class="w3bn-author-box__tags" aria-label="Coverage areas">
							<?php foreach ( $expertise as $topic ) : ?>
								<li class="w3bn-author-box__tag"><?php echo esc_html( $topic ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
