<?php

	/**
	 * The core plugin class.
	 *
	 * This is used to define internationalization, admin-specific hooks, and
	 * public-facing site hooks.
	 *
	 * Also maintains the unique identifier of this plugin as well as the current
	 * version of the plugin.
	 *
	 * @since      1.0.0
	 * @package    Contentlocalized/
	 * @subpackage Contentlocalized/CLWP_WritersPro
	 * @author     ContentLocalized <marko.janosevic@firstbeatmedia.com >
	 */

	namespace Contentlocalized {

		class CLWP_WritersPro {

			/**
			 * The loader that's responsible for maintaining and registering all hooks that power
			 * the plugin.
			 *
			 * @since    1.0.0
			 * @access   protected
			 * @var      Writers_Pro_Loader $loader Maintains and registers all hooks for the plugin.
			 */
			protected $loader;

			/**
			 * The unique identifier of this plugin.
			 *
			 * @since    1.0.0
			 * @access   protected
			 * @var      string $plugin_name The string used to uniquely identify this plugin.
			 */
			protected $plugin_name;

			/**
			 * The current version of the plugin.
			 *
			 * @since    1.0.0
			 * @access   protected
			 * @var      string $version The current version of the plugin.
			 */
			protected $version;

			/**
			 * Define the core functionality of the plugin.
			 *
			 * Set the plugin name and the plugin version that can be used throughout the plugin.
			 * Load the dependencies, define the locale, and set the hooks for the admin area and
			 * the public-facing side of the site.
			 *
			 * @since    1.0.0
			 */
			public function __construct() {
				if ( defined( 'CLWP_WRITERSPRO_PLUGIN_VERSION' ) ) {
					$this->version = CLWP_WRITERSPRO_PLUGIN_VERSION;
				} else {
					$this->version = '1.0.0';
				}
				$this->plugin_name = 'writers-pro';

				define( 'CLWP_WRITERSPRO_PLUGIN_PATH', plugin_dir_path( dirname( __FILE__ ) ) );


				$this->load_dependencies();
				$this->define_admin_hooks();
			}

			/**
			 * Load the required dependencies for this plugin.
			 *
			 * Include the following files that make up the plugin:
			 *
			 * - Writers_Pro_Loader. Orchestrates the hooks of the plugin.
			 * - Writers_Pro_i18n. Defines internationalization functionality.
			 * - Writers_Pro_Admin. Defines all hooks for the admin area.
			 * - Writers_Pro_Public. Defines all hooks for the public side of the site.
			 *
			 * Create an instance of the loader which will be used to register the hooks
			 * with WordPress.
			 *
			 * @since    1.0.0
			 * @access   private
			 */
			private function load_dependencies() {

				/**
				 * The class responsible for orchestrating the actions and filters of the
				 * core plugin.
				 */
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-writers-pro-loader.php';
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/admin/class-writers-pro-article-list.php';
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/admin/contentlocalized-api.php';

				/**
				 * The class responsible for defining all actions that occur in the admin area.
				 */
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/admin/writers-pro-admin-pages-trait.php';
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-writers-pro-admin.php';

				$this->loader = new \Contentlocalized\CLWP_WritersPro_Loader();

			}

			/**
			 * Register all of the hooks related to the admin area functionality
			 * of the plugin.
			 *
			 * @since    1.0.0
			 * @access   private
			 */
			private function define_admin_hooks() {

				$plugin_admin = new \Contentlocalized\CLWP_WritersPro_Admin( $this->get_plugin_name(), $this->get_version() );

				$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
				$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
				$this->loader->add_action( 'admin_menu', $plugin_admin, 'bar_menu' );

				$this->loader->add_action( 'admin_menu', $plugin_admin, 'Messages' );
				$this->loader->add_action( 'admin_post_clwp_login_form', $plugin_admin, 'SettingsProcess' );
				$this->loader->add_action( 'admin_post_clwp_unlink_login_details', $plugin_admin, 'SettingsLogoutProcess' );

				$this->loader->add_action( 'admin_post_clwp_create_blog_posting_order', $plugin_admin, 'CreateOrderBlogPosting' );
				$this->loader->add_action( 'admin_post_clwp_ppc_calculate_project', $plugin_admin, 'CalculatePPCProject' );
				$this->loader->add_action( 'admin_post_clwp_create_order', $plugin_admin, 'CreateOrderBlogPosting' );
				$this->loader->add_action( 'admin_post_clwp_create_ppc_ads_order', $plugin_admin, 'CreateOrderPPC' );

				$this->loader->add_action( 'admin_post_clwp_target_language', $plugin_admin, 'GetTargetLanguage' );
				$this->loader->add_action( 'admin_post_clwp_bp_calculate_project', $plugin_admin, 'CalculateBPProject' );
				$this->loader->add_action( 'admin_post_clwp_add_balance', $plugin_admin, 'AddBalance' );

				$this->loader->add_action( 'admin_post_clwp_signup_form', $plugin_admin, 'SingUpProcess' );

				$this->loader->add_action( 'admin_post_clwp_select_page_source', $plugin_admin, 'SelectPageSource' );
			}


			/**
			 * Run the loader to execute all of the hooks with WordPress.
			 *
			 * @since    1.0.0
			 */
			public function run() {
				$this->loader->run();
			}

			/**
			 * The name of the plugin used to uniquely identify it within the context of
			 * WordPress and to define internationalization functionality.
			 *
			 * @since     1.0.0
			 * @return    string    The name of the plugin.
			 */
			public function get_plugin_name() {
				return $this->plugin_name;
			}

			/**
			 * The reference to the class that orchestrates the hooks with the plugin.
			 *
			 * @since     1.0.0
			 * @return    Writers_Pro_Loader    Orchestrates the hooks of the plugin.
			 */
			public function get_loader() {
				return $this->loader;
			}

			/**
			 * Retrieve the version number of the plugin.
			 *
			 * @since     1.0.0
			 * @return    string    The version number of the plugin.
			 */
			public function get_version() {
				return $this->version;
			}

		}
	}