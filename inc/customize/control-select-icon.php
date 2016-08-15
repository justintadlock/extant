<?php
/**
 * Select font icon customizer control.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Select icon customize control.
 *
 * @since  1.0.0
 * @access public
 */
class Extant_Customize_Control_Select_Icon extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'select-icon';

	/**
	 * The default customizer section this control is attached to.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $section = 'icons';

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		if ( ! isset( $args['choices'] ) )
			$args['choices'] = $this->get_icon_choices();

		// Let the parent class handle the rest.
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Loads the control scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {

		wp_enqueue_script( 'extant-customize-controls' );

		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'extant-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['value']   = $this->value();
		$this->json['id']      = $this->id;
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( ! data.choices ) {
			return;
		} #>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<select {{{ data.link }}}>

			<# _.each( data.choices, function( label, choice ) { #>

				<option value="{{ choice }}" <# if ( choice === data.value ) { #> selected="selected" <# } #>>{{{ label }}}</option>

			<# } ) #>
		</select>
	<?php }

	/**
	 * Returns an array of icons for use in the option.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_icon_choices() {

		foreach ( extant_get_font_icons() as $class => $code )
			$icons[ $class ] = "&#x{$code};";

		return $icons;
	}
}
