<?php
/**
 * Plugin Name:     Custom Quote (Random Quotes)
 * Plugin URI:      https://twitter.com/rameezjoya
 * Description:     This plugin will add support for 'custom_quote' shortcode, that can be use to display a random quote on every page load.
 * Author:          Rameez Joya
 * Author URI:      https://twitter.com/rameezjoya
 * Text Domain:     custom-quote
 * Version:         0.1.0
 *
 * @package         Custom_Quote
 */


 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Random Quote API URI
 */
define( 'CUSTOM_QUOTE_API_URI', 'https://api.quotable.io/random' );

/**
 * Static list of quotes
 */
define(
	'CUSTOM_QUOTE_LOCAL_LIST',
	array(
		'An ant on the move does more than a dozing ox',
		'Life is what happens while you are making other plans.',
		'Can you imagine what I would do if I could do all I can?',
		'If you only have a hammer, you tend to see every problem as a nail.',
		'I am a great believer in luck and I find the harder I work, the more I have of it.',
		'Ignorant men do not know what good they hold in their hands until they have flung it away.',
		'If you must tell me your opinions, tell me what you believe in. I have plenty of doubts of my own.',
		'True friendship is a plant of slow growth, and must undergo and withstand the shocks of adversity, before it is entitled to the appellation.',
	)
);

/**
 * Get Random quote from local list of quotes
 */
function custom_quote_get_random_quote_local() {
	$random_index = wp_rand( 0, count( CUSTOM_QUOTE_LOCAL_LIST ) - 1 ); // Get random index
	return CUSTOM_QUOTE_LOCAL_LIST[ $random_index ];
}

/**
 * Get Random Quote from Remote API.
 */
function custom_quote_fetch_random_quote_from_api() {
	$response  = wp_remote_get( CUSTOM_QUOTE_API_URI );
	$http_code = wp_remote_retrieve_response_code( $response );

	// Check api call was successful
	if ( $http_code === 200 ) {
		$random_quote = json_decode( wp_remote_retrieve_body( $response ) ); // Decode JSON response to PHP Object
		return $random_quote->content; // Extract just quote from response.
	}

	// If API call ends with an error, then display quote from local.
	return custom_quote_get_random_quote_local();
}

/**
 * Function to process custom_quote shortcode.
 */
function custom_quote_shortcode( $atts, $content = null ) {

	// Extract shortcode attributes, apply default values if not present
	$attributes = shortcode_atts(
		array(
			'length' => -1,
			'class'  => 'blockquote', // default css class
			'api'    => true,
		),
		$atts
	);

	$class_name = $attributes['class']; // CSS class name to apply

	// Check if no_api attribute is provided.
	if ( $attributes['api'] == false ) {
		$random_quote = custom_quote_get_random_quote_local(); // Fetch Random quote from local list
	} else {
		$random_quote = custom_quote_fetch_random_quote_from_api(); // Fetch Random quote from an API
	}

	/**
	 * If length attribute is present then
	 * check if its numeric
	 * check if has value greater than  0
	 * check if specified trim length is less than quote length
	 * then trim quote to specified length and append ellipses.
	 */
	if ( is_numeric( $attributes['length'] )
		&& $attributes['length'] > 0
		&& strlen( $random_quote ) > $attributes['length'] ) {
		$random_quote = substr( $random_quote, 0, $attributes['length'] ) . '...';
	}

	ob_start();
	?>

	<div class="<?php echo $class_name; ?>">
		<?php
			echo $random_quote;
		?>
	</div>
	
	<?php
	return ob_get_clean();
}

add_shortcode( 'custom_quote', 'custom_quote_shortcode' );

/**
 * By default, shortcodes are not allowed to be executed in a custom HTML widget. To change this, we are adding following filter to enable shortcodes for wigets
 */
add_filter( 'widget_text', 'do_shortcode' );
