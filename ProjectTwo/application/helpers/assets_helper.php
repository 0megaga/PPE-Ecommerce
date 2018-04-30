<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');			//verif script not exe depuis URL

/*
|===============================================================================
| Basic css / js / font
|	- css_url
|	- js_url
|	- font_url
|===============================================================================
*/

	if ( ! function_exists('css_url') )		//permet de modif les fonction natif de CI
	{
		function css_url($nom)
		{
			return base_url() . 'assets/css/' . $nom . '.css';
		}
	}
		
	if ( ! function_exists('js_url') )
	{
		function js_url($nom)
		{
			return base_url() . 'assets/javascript/' . $nom . '.js';
		}
	}

	if ( ! function_exists('font_url') )
	{
		function font_url($nom)
		{
			return base_url() . 'assets/fonts/' . $nom . '.css';
		}
	}

/*
|===============================================================================
| Basic components
|	- cmp_css_url
|	- cmp_js_url
|===============================================================================
*/

	if ( ! function_exists('cmp_css_url') )
	{
		function cmp_css_url($nom)
		{
			return base_url() . 'assets/components/' . $nom . '.css';
		}
	}
		
	if ( ! function_exists('cmp_js_url') )
	{
		function cmp_js_url($nom)
		{
			return base_url() . 'assets/components/' . $nom . '.js';
		}
	}

/*
|===============================================================================
| Basic image
|	- img_url
|	- img
|===============================================================================
*/

	if ( ! function_exists('img_url') )
	{
		/*Attention extension*/
		function img_url($nom)
		{
			return base_url() . 'assets/images/' . $nom;
		}
	}

	if ( ! function_exists('img') )
	{
		function img($nom, $alt = '')
		{
			return '<img src="' . img_url($nom) . '" alt="' . $alt . '" />';
		}
	}

?>