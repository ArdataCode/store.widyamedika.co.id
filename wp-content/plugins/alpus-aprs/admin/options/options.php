<?php
/**
 * Options page
 *
 * @author AlpusTheme
 * @package Alpus APRS (AI Product Review Summary)
 * @version 1.0.0
 */
defined( 'ABSPATH' ) || die;

$api = array(
	'alpus_aprs_api_start' => array(
		'type'  => 'section_start',
		'title' => esc_html__( 'ChatGPT API', 'alpus-aprs' ),
	),
	'alpus_aprs_api_key'   => array(
		'type'  => 'text',
		'title' => esc_html__( 'API Key', 'alpus-aprs' ),
		'desc'  => sprintf( esc_html__( 'You can get your API Key in your %1$sOpenAI Acount%2$s.', 'alpus-aprs' ), '<a href="https://platform.openai.com/account/api-keys" target="__blank">', '</a>' ),
	),
	'alpus_aprs_text_model'   => array(
		'type'    => 'select',
		'title'   => esc_html__( 'Text Models', 'alpus-aprs' ),
		'options' => $this->get_models_from_openai(),
		'desc'    => esc_html__( 'You can choose any OpenAI Model as you want. ( If you want to update OpenAI models, please click update button. )', 'alpus-aprs' ),
	),
	'alpus_aprs_api_end' => array(
		'type'  => 'section_end',
	),
	'alpus_aprs_summary_start' => array(
		'type'  => 'section_start',
		'title' => esc_html__( 'Summary', 'alpus-aprs' ),
	),
	'alpus_aprs_summary_title' => array(
		'type'  => 'text',
		'title' => esc_html__( 'Title', 'alpus-aprs' ),
		'desc'  => esc_html__( 'Please input Product Review Summary Section title.', 'alpus-aprs' ),
	),
	'alpus_aprs_summary_end' => array(
		'type'  => 'section_end',
	),
);

return apply_filters( 'alpus_aprs_api_options', $api );
