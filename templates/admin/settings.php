<?php
/**
 * Settings page template.
 *
 * @var array $options The plugin options.
 */
?>

<div class="wrap">
	<h1><?php esc_html_e( 'Pattern Inserter Settings', 'wpcomsp-team51-pattern-inserter' ); ?></h1>

	<form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row"><label for="last_updated"><?php echo esc_html__( 'Last updated:', 'wpcomsp-team51-pattern-inserter' ); ?></label></th>
				<td><span id="last_updated"><?php echo esc_html( $options['last_update'] ); ?></span></td>
			</tr>
			<tr>
				<th scope="row"><label for="num_patterns"><?php echo esc_html__( 'Number of patterns:', 'wpcomsp-team51-pattern-inserter' ); ?></label></th>
				<td><span id="num_patterns"><?php echo esc_html( $options['num_patterns'] ); ?></span></td>
			</tr>
			</tbody>
		</table>

		<?php wp_nonce_field( 'clear_cache', 'clear_cache_nonce' ); ?>
		<p class="submit">
			<input type="submit" name="clear_cache" class="button button-primary" value="<?php esc_html_e( 'Clear cache', 'wpcomsp-team51-pattern-inserter' ); ?>">
		</p>
	</form>
</div>
