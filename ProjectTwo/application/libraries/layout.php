<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Layout
{
	private $CI;
	private $var = array();	//content HTML
	private $layout = 'default';
	
/*
|===============================================================================
| Constructeur
|===============================================================================
*/
	
	public function __construct()
	{
		$this->CI = get_instance();

		$this->var['header'] = '';
		$this->var['categories'] = '';

		//$output = HTML / php (view)
		$this->var['output'] = '';

		//$titre = Method - Class
		$this->var['title'] = ucfirst( $this->CI->router->fetch_method() ) . ' - ' . ucfirst( $this->CI->router->fetch_class() );

		//$charset = key-> config.php
		$this->var['charset'] = $this->CI->config->item('charset');

		// css / js
		$this->var['css'] = array();
		$this->var['js'] = array();
	}
	
/*
|===============================================================================
| Méthodes pour charger les vues
|	. view
|	. views
|===============================================================================
*/
	/**
	 * load layout
	 */
	public function view( $name, $data = array())
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		$this->CI->load->view('../layout/' . $this->layout, $this->var );
	}
	
	/**
	 * add view -> var['output']
	 */
	public function views( $name, $data = array())
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		return $this;
	}
	
/*
|===============================================================================
| Méthodes pour modifier les variables envoyées au layout
|   . set_title
|   . set_charset
|===============================================================================
*/

	public function set_title($title)
	{
	    if(is_string($title) AND !empty($title))
	    {
	        $this->var['title'] = $title;
	        return true;
	    }

	    return false;
	}


	public function set_charset($charset)
	{
	    if(is_string($charset) AND !empty($charset))
	    {
	        $this->var['charset'] = $charset;
	        return true;
	    }

	    return false;

	}

/*
|===============================================================================
| Méthodes pour ajouter des feuilles de CSS et de JavaScript
|   . add_css
|   . add_js
|===============================================================================
*/

	public function add_css($nom)
	{
	    if(is_string($nom) AND !empty($nom) AND file_exists('./assets/css/' . $nom . '.css'))
	    {
	        $this->var['css'][] = css_url($nom);
	        return true;
	    }

	    return false;

	}


	public function add_js($nom)
	{
	    if(is_string($nom) AND !empty($nom) AND file_exists('./assets/javascript/' . $nom . '.js'))
	    {
	        $this->var['js'][] = js_url($nom);
	        return true;
	    }

	    return false;

	}

/*
|===============================================================================
| Méthodes pour ajouter des feuilles de CSS et de JavaScript de components
|   . add_css_components
|   . add_js_components
|===============================================================================
*/

	public function add_css_components($nom)
	{
	    if(is_string($nom) AND !empty($nom) AND file_exists('./assets/components/' . $nom . '.css'))
	    {
	        $this->var['css'][] = cmp_css_url($nom);
	        return true;
	    }

	    return false;

	}


	public function add_js_components($nom)
	{
	    if(is_string($nom) AND !empty($nom) AND file_exists('./assets/components/' . $nom . '.js'))
	    {
	        $this->var['js'][] = cmp_js_url($nom);
	        return true;
	    }

	    return false;

	}
	
/*
|===============================================================================
| Méthodes pour changer le layout
|   . set_theme
|===============================================================================
*/

	public function set_theme($layout)
	{
	    if(is_string( $layout ) AND !empty( $layout ) AND file_exists('./application/layout/' . $layout . '.php'))
	    {
	        $this->layout = $layout;
	        return true;
	    }

	    return false;
	}
}


/* End of file layout.php */
/* Location: ./application/libraries/layout.php */