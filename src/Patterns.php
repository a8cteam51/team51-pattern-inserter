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
	 * Constants
	 */
	public const PATTERN_INFO_OPTION = 'wpcomsp_team51_pattern_inserter';

	/**
	 * Hooks and filters
	 *
	 * @return void
	 */
	public function initialize(): void {
		add_action( 'init', array( $this, 'register_patterns_from_github' ) );
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

			if ( isset( $data['patterns'] ) && is_array( $data['patterns'] ) ) {

				// Store update data for Settings page
				update_option(
					self::PATTERN_INFO_OPTION,
					array(
						'last_update'  => time(),
						'num_patterns' => array_reduce(
							$data['patterns'],
							function ( $carry, $category ) {
								return $carry + ( isset( $category['items'] ) ? count( $category['items'] ) : 0 );
							},
							0
						),
					)
				);
			}

			// Cache the data for 12 hours.
			set_transient( $transient_key, $data, 12 * HOUR_IN_SECONDS );
		}

		if ( isset( $data['patterns'] ) && is_array( $data['patterns'] ) ) {
			foreach ( $data['patterns'] as $category_slug => $category_data ) {
				$category       = $data['categories'][ $category_slug ] ?? null;
				$category_title = $category['title'] ?? ucfirst( $category_slug );

				register_block_pattern_category( $category_slug, array( 'label' => $category_title ) );

				if ( isset( $category_data['items'] ) && is_array( $category_data['items'] ) ) {
					foreach ( $category_data['items'] as $key => $pattern ) {
						$pattern_title   = $pattern['title'] ?? ucfirst( $key );
						$pattern_content = $pattern['content'] ?? '';

						register_block_pattern(
							'wpcom_special_projects/' . $category_slug . '/' . sanitize_title_with_dashes( $pattern_title ),
							array(
								'title'       => $pattern_title,
								'content'     => $pattern_content,
								'categories'  => array( $category_slug ),
								'description' => $category_title,
							)
						);
					}
				}
			}
		}
	}
}
