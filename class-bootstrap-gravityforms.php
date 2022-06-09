<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

if ( ! class_exists( 'Bootstrap_Gravity_Forms' ) ) {

	/**
	 * 'Bootstrap_Gravity_Forms.
	 */
	class Bootstrap_Gravity_Forms {

		/**
		 * Construct
		 *
		 * @access public
		 * @return void
		 */

		function __construct() {
			add_filter( 'gform_field_content', array( $this, 'add_bootstrap_classes_to_fields' ), 10, 5 );
			add_filter( 'gform_submit_button', array( $this, 'add_bootstrap_classes_to_submit' ), 10, 2 );
			// add_filter( 'gform_field_container', array( $this, 'bootstrapify_container' ), 10, 6 );
		}


		/**
		 * Add Bootstrap Classes to Form Fields.
		 *
		 * @access public
		 * @param mixed $content Content.
		 * @param mixed $field Field.
		 * @param mixed $value Value.
		 * @param mixed $lead_id Lead ID.
		 * @param mixed $form_id Form ID.
		 * @return void
		 */
		function add_bootstrap_classes_to_fields( $content, $field, $value, $lead_id, $form_id ) {
			// Bootstrapify it..

			$class = 'form-control';

			if( $field->type == 'website' || $field->type == 'email' ){
				$class .= ' medium';
			}

			switch( $field->type ){
				// Forms that by default have classes.
				case 'text':
				case 'textarea':
				case 'select':
				case 'multiselect':
				case 'number':
				case 'phone':
				case 'post_title':
				case 'post_content':
				case 'post_excerpt':
				case 'post_tags':
				case 'post_custom_field':
				case 'quantity':
					$content = str_replace( 'small', $class . ' small', $content );
					$content = str_replace( 'medium', $class . ' medium', $content );
					$content = str_replace( 'large', $class . ' large', $content );
					break;
				// Forms that do not have classes (by default).
				case 'address':
				case 'post_category':
				case 'option':
				case 'time':
					// Bottom one will be hit for the else.
					$content = str_replace( '<select', '<select class="' . $class . '"', $content );
				case 'website':
				case 'email':
				case 'name':
					$content = str_replace( 'input type=', 'input class="' . $class . '" type=', $content );
					break;
				case 'radio':
				case 'checkbox':
					$content = str_replace( '<li', '<div', $content );
					$content = str_replace( 'class=\'', 'class=\'form-check ', $content );
					$content = str_replace( '</li>', '</div>', $content );

					$content = str_replace( '<label', '<label class="form-check-label"', $content );
					$content = str_replace( '<input', '<input class="form-check-input" style="margin-left: -1.25rem;"', $content );
					break;
				case 'date':
					$content = str_replace( 'datepicker', $class . ' datepicker', $content );
					break;
				case 'post_image':
					$content = str_replace( 'ginput_container_post_image', 'ginput_container_post_image custom-file', $content );
					$content = str_replace( 'ginput_complex', '', $content );
					$content = str_replace( '</span', '<label class="custom-file-label">Choose File</label></span', $content );
					$content = str_replace( 'medium', 'medium custom-file-input', $content );
					break;
				case 'fileupload':
					$content = str_replace( 'ginput_container_fileupload', 'ginput_container_fileupload custom-file', $content );
					$content = str_replace( '<span', '<label class="custom-file-label">Choose File</label><span', $content );
					$content = str_replace( 'medium', 'medium custom-file-input', $content );
					break;
				case 'list':
					$content = str_replace( '<input type', '<input class="form-control" type', $content );
					break;
				case 'product':
				case 'shipping':
				case 'total':
					// Other cases...
					break;
			}

			return $content;
		}

		/**
		 * Add Bootstrap classes to Submit Button.
		 *
		 * @access public
		 * @param mixed $button Button.
		 * @param mixed $form Form.
		 * @return void
		 */
		function add_bootstrap_classes_to_submit( $button, $form ) {
			return '<input type="submit" class="btn btn-primary btn-gform" id="gform_submit_button_' . $form['id'] . '" value="' . $form['button']['text'] . '">';
		}

		function bootstrapify_container( $field_container, $field, $form, $css_class, $style, $field_content ){
			// $field_container = str_replace( '{FIELD_CONTENT}', '<div class="form-group row">{FIELD_CONTENT}</div>', $field_container );
			return $field_container;
		}


	}

new Bootstrap_Gravity_Forms();

}

