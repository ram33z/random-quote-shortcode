<?php
/**
 * Plugin Name:     Custom Quote
 * Plugin URI:      https://twitter.com/rameezjoya
 * Description:     This plugin will add support for 'custom_quote' shortcode, that can be use to display a random quote on every page load.
 * Author:          Rameez Joya
 * Author URI:      https://twitter.com/rameezjoya
 * Text Domain:     custom-quote
 * Version:         0.1.0
 *
 * @package         Custom_Quote
 */




function custom_quote_shortcode( $atts, $content = null ) {

	// $quotes_list = array(
	// '{"_id":"JIP8Z3unkKLi","tags":["famous-quotes"],"content":"If you must tell me your opinions, tell me what you believe in. I have plenty of doubts of my own.","author":"Johann Wolfgang von Goethe","authorSlug":"johann-wolfgang-von-goethe","length":98,"dateAdded":"2020-04-14","dateModified":"2021-06-17"}',
	// '{"_id":"JIP8Z3unkKLi","tags":["famous-quotes"],"content":"If you must tell me your opinions, tell me what you believe in. I have plenty of doubts of my own.","author":"Johann Wolfgang von Goethe","authorSlug":"johann-wolfgang-von-goethe","length":98,"dateAdded":"2020-04-14","dateModified":"2021-06-17"}',
	// '{"_id":"KsFj1hU_I3","tags":["friendship"],"content":"True friendship is a plant of slow growth, and must undergo and withstand the shocks of adversity, before it is entitled to the appellation.","author":"George Washington","authorSlug":"george-washington","length":140,"dateAdded":"2021-03-28","dateModified":"2021-03-28"}',
	// );

	$attributes = shortcode_atts( array( 'length' => -1 ), $atts );

	var_dump( $attributes );

	// This is where you run the code and display the output
	$curl = curl_init();
	$url  = 'https://api.quotable.io/random';

	curl_setopt_array(
		$curl,
		array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'GET',
		)
	);

	$response = curl_exec( $curl );
	$err      = curl_error( $curl );

	curl_close( $curl );
	// $random_index = wp_rand( 0, count( $quotes_list ) - 1 );
	// $random_quote = json_decode( $quotes_list[ $random_index ] );
	$random_quote = json_decode( $response );
	$print_quote  = $random_quote->content;

	if ( isset( $attributes['length'] ) && is_numeric( $attributes['length'] ) && $attributes['length'] > 0 ) {
		$print_quote = substr( $print_quote, 0, $attributes['length'] ) . '...';
	}

	ob_start();
	?>

	<div class="blockquote">
		<?php
			echo $print_quote;
		?>
	</div>
	
	<?php
	return ob_get_clean();

}

add_shortcode( 'custom_quote', 'custom_quote_shortcode' );

// By default, shortcodes are not allowed to be executed in a custom HTML widget. To change this, you will need to add the following code
// add_filter( 'widget_text', 'do_shortcode' );
// OR
add_filter( 'widget_custom_html_content', 'do_shortcode' );
