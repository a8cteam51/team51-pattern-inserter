<?php
/**
 * @var array $options The plugin options.
 */
?>

<div class="wrap">
	<h1><?php esc_html_e( 'Pattern Inserter Settings', 'wpcomsp-team51-pattern-inserter' ); ?></h1>

	<form method="post">

		<p><?php echo esc_html__( 'Last updated: ', 'wpcomsp-team51-pattern-inserter' ) . esc_html( $options['last_update'] ) ?></p>
		<p><?php echo esc_html__( 'Number of patterns: ', 'wpcomsp-team51-pattern-inserter' ) . esc_html( $options['num_patterns'] ) ?></p>

		<?php wp_nonce_field( 'clear_cache', 'clear_cache_nonce' ); ?>
		<button type="submit" name="clear_cache">Clear cache</button>
	</form>
</div>
