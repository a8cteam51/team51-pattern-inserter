<?php

namespace WPCOMSpecialProjects\Team51PatternInserter;

defined( 'ABSPATH' ) || exit;

/**
 * Main plugin class.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Patterns {

	/**
	 * Hooks and filters
	 *
	 * @return void
	 */
	public function initialize(): void {
		add_action( 'init', [ $this, 'register_patterns_from_github' ] );
	}

	/**
	 * Register block patterns from the GitHub JSON file.
	 *
	 * @return void
	 */
	public function register_patterns_from_github(): void {
		$transient_key = 'wpcom_special_projects_patterns';
		$data          = get_transient( $transient_key );

		if ( false === $data ) {
			$response = wp_remote_get( 'https://github.com/a8cteam51/special-projects-patterns/releases/latest/download/special-projects-patterns.json' );

			if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
				return;
			}

			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );

			if ( json_last_error() !== JSON_ERROR_NONE ) {
				return;
			}

			// Cache the data for 12 hours.
			set_transient( $transient_key, $data, 12 * HOUR_IN_SECONDS );
		}

		if ( isset( $data['patterns'] ) && is_array( $data['patterns'] ) ) {
			foreach ( $data['patterns'] as $categorySlug => $categoryData ) {
				$category      = $data['categories'][ $categorySlug ] ?? null;
				$categoryTitle = $category['title'] ?? 'Uncategorized';

				register_block_pattern_category( $categorySlug, [ 'label' => $categoryTitle ] );

				if ( isset( $categoryData['items'] ) && is_array( $categoryData['items'] ) ) {
					foreach ( $categoryData['items'] as $patternKey => $pattern ) {
						$patternTitle   = $pattern['title'] ?? 'Untitled';
						$patternContent = $pattern['content'] ?? '';

						error_log( 'Pattern: ' . $patternTitle . ' (' . $patternKey . ')' );

						register_block_pattern(
							'wpcom_special_projects/' . $categorySlug . '/' . sanitize_title_with_dashes( $patternTitle ),
							[
								'title'       => $patternTitle,
								'content'     => $patternContent,
								'categories'  => [ $categorySlug ],
								'description' => $categoryTitle,
							]
						);
					}
				}
			}
		}
	}
}
