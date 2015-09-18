<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.1.5
 *
 * @package    Load_more
 * @subpackage Load_more/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.1.5
 * @package    Load_more
 * @subpackage Load_more/includes
 * @author     Your Name <email@example.com>
 */
class Load_more {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.1.5
	 * @access   protected
	 * @var      Load_more_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.1.5
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.1.5
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.1.5
	 */
	public function __construct() {

		$this->plugin_name = 'wp-load-more';
		$this->version = '1.0.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->register_shortcode();
		$this->register_ajax();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Load_more_Loader. Orchestrates the hooks of the plugin.
	 * - Load_more_i18n. Defines internationalization functionality.
	 * - Load_more_Admin. Defines all hooks for the dashboard.
	 * - Load_more_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.1.5
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-load-more-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-load-more-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-load-more-admin.php';

		

		//$this->loader = new Load_more_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Load_more_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.1.5
	 * @access   private
	 */
	private function set_locale() {

	//	$plugin_i18n = new Load_more_i18n();
	//	$plugin_i18n->set_domain( $this->get_plugin_name() );

	//	$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function register_ajax(){
		add_action( 'wp_ajax_ajax_getPosts', array($this, 'ajax_getPosts') );
		add_action( 'wp_ajax_nopriv_ajax_getPosts', array($this, 'ajax_getPosts') );
		add_action( 'wp_ajax_tweet', array($this, 'tweet') );
		add_action( 'wp_ajax_nopriv_tweet', array($this, 'tweet') );
	}

	public function tweet(){
		echo "tweet tweet!!";
		die();
	}
	public function ajax_getPosts(){
		//  variables
		global $pdir, $wp_query;
		
		$numPosts = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 0;
		$page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 0;
		$term = (isset($_GET['term']) && $_GET['term'] != 'all') ? $_GET['term'] : '';
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $numPosts,
			'paged'          => $page,
			
		);
		if(!!$term){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $term,
				),
			);
		}
		query_posts($args);

		if(isset($_GET['task']) && $_GET['task'] == 'page_count'){
			$total_pages = $wp_query->max_num_pages;
			echo $total_pages;

		}else{
			
			 
			//  loop
			if (have_posts()) {
			       while (have_posts()){
			              the_post();
			              include ($pdir."templates/post-repeater.php");
			       }
			}
			wp_reset_query();


		}

		wp_die();
	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.1.5
	 * @access   private
	 */
	private function define_admin_hooks() {

		//$plugin_admin = new Load_more_Admin( $this->get_plugin_name(), $this->get_version() );
		//$this->loader->add_action( 'admin_menu', $plugin_admin, 'menu_setup' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	private function register_shortcode() {
		add_shortcode( 'loadmore_nav', array($this, 'loadmore_nav') );
		add_shortcode( 'loadmore_template', array($this, 'loadmore_template') );
		add_shortcode( 'loadmore_template_sec', array($this, 'loadmore_template_sec') );
		add_shortcode( 'loadmore_button', array($this, 'loadmore_button') );

	}
	//Post loadmore shortcodes
	public function loadmore_nav( $atts ) {
	    $attr = shortcode_atts( array(
	        'align' => 'center',
	        'taxonomy' => 'category',
	    ), $atts );
	    $res = get_terms( array($attr['taxonomy']));
	    $htm = '<li><a href="#cat=all" data-slug="all" >All</a></li>';
	    $wrap_start = '<section class="loadmore-menu-container"><ul class="loadmore-menu">';
	    $wrap_end = '</ul></section>';
	    foreach ($res as $ret) {
	    	# code...
	    	if($ret->slug !== 'uncategorized')
	    		$htm .= '<li><a href="#cat='.$ret->slug.'" data-slug="'.$ret->slug.'" >'.$ret->name.'</a></li>';
	    }
	    $output = $wrap_start.$htm.$wrap_end;
	    return  $output;
	}
	


	//body template part
	public function loadmore_template( $atts ) {
	    $a = shortcode_atts( array(
	        'template' => 'blog',
	        'post_type' => 'post',
	    ), $atts );
	    $output = '<section id="loadmore-template-container" > </section>';
	    ob_start();
	    ?>
	    <br>
		<script type="text/javascript">
			(function($){
				var loadMore = {
					init: function(){
						this.init_menuScript();
						this.ajaxRequest({
							term : (!!window.location.hash && window.location.hash.replace('cat=', "") != '#all')? window.location.hash.replace('cat=', "") : '',
						});
						this.init_buttonScript();
						this.pageCount = 2;
						$('.loadmore-button-container').hide();
					},
					ajaxRequest: function(options){
						var defaults = {
							totalPage : 1,
							page : 1,
							term : '',
						    loading : true,
						    change: false
						};
						var attrs = $.extend({}, defaults, options || {});
						this.term = attrs.term;
					    var $content = $('#loadmore-template-container');
					    var page_count = function(){
					    	$.ajax({
				                method     : "GET",
				                data       : { action : "ajax_getPosts", task: "page_count", numPosts : 12, pageNumber: attrs.page, term: attrs.term},
				                url        : ajaxurl,
				                
				                success    : function(data){
				                	attrs.totalPage = parseInt(data);

				                },
				                error     : function(jqXHR, textStatus, errorThrown) {
				                    alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
				                }
					        });
					    }
					    var load_posts = function(){
				            $.ajax({
				                method     : "GET",
				                data       : { action : "ajax_getPosts", numPosts : 12, pageNumber: attrs.page, term: attrs.term},
				                dataType   : "html",
				                url        : ajaxurl,
				                beforeSend : function(){
				                },
				                success    : function(data){
				                	$data = $(data);
				                    $data.hide();
				                    if(!!attrs.change)
				                    	$content.html($data);
				                    else
				                    	$content.append($data);

				                    $data.fadeIn(500, function(){
				                        loading = false;
				                    });
				                    //console.log(attrs.totalPage);
				                    if(attrs.page === attrs.totalPage){
				                    	$('.loadmore-button-container').fadeOut(500);
				                    	
				                    }
				                    else{
				                    	$('.loadmore-button-container').fadeIn(500);
				                    	
				                    }
				                   
				                },
				                error     : function(jqXHR, textStatus, errorThrown) {
				                    alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
				                }
					        });
					    }
					    

					    page_count();
					    load_posts();

					    
					},
					init_menuScript: function(){
					 	var that = this;
						$('.loadmore-menu a').on('click', function(ele){
							ele.preventDefault();
							window.location.hash = $(this).attr('href');
							that.pageCount = 2;
							var slug = $(this).data('slug');
							//console.log(slug);
							var args = {
								term: slug,
								change: true
							}
							//that.clean_template_container();
							that.ajaxRequest((slug !== "all")? args : '');
							
						});
					},
					init_buttonScript: function(){
						var that = this;
						
						$('#loadmore-button').on('click', function(ele){
							ele.preventDefault();
							//console.log("button clicked");

							that.ajaxRequest({
								term: that.term,
								page: that.pageCount
							})
							//console.log(that.pageCount);
							that.pageCount++;

						});
					},
					clean_template_container: function(){
						$('#loadmore-template-container').html('');
					}
				};
				$(document).ready(function(){

	 				loadMore.init();
				
				});
			})(jQuery);
				
		</script>
	    <?php 
	    $script = ob_get_contents();
	    ob_end_clean();
	    return $output.$script;
	}
	

	public function loadmore_template_sec(){
		$output = '<section id="loadmore-template-sec-container" > </section>';
		return $output;
	}

	//button template
	public function loadmore_button( $atts ) {
	    $attr = shortcode_atts( array(
	        'text' => 'Load more',
	        'align' => '',
	        'class' => '',
	    ), $atts );
	    $button = '<section class="loadmore-button-container '.$attr['class'].' '.((!!$attr['align'])? 'text-'.$attr['align'] : '').'" ><button class="loadmore-button" id="loadmore-button">'.$attr['text'].'</button></section>';
	    return $button;
	}
	
	public function load_more_short($attr){
		//var_dump($attr);
		ob_start();
		dynamic_sidebar( $attr['id'] );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	public function menu_short($attr){
		//var_dump($attr);
		$args = array();
		foreach ($attr as $key => $value) {
			# code...
			$args[$key] = $value;
		}
		$args['fallback_cb'] = isset($args['fallback_cb'])? $args['fallback_cb'] : false ;
		
		ob_start();
		wp_nav_menu( $args );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.1.5
	 */
	public function run() {
		//$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.1.5
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.1.5
	 * @return    Load_more_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.1.5
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
