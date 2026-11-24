<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists( 'skincare_cosmetic_store_Welcome' ) ) {

	class skincare_cosmetic_store_Welcome {
		public $theme_fields;

		public function __construct( $skincare_cosmetic_store_fields = array() ) {
			$this->theme_fields = $skincare_cosmetic_store_fields;
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'admin_menu', array( $this, 'skincare_cosmetic_store_getstart_page_menu' ) );
			add_action( 'in_admin_header', array( $this, 'hide_admin_notices' ), 99 );
		}

		// Remove all admin notices on the Getting Started page.
		public function hide_admin_notices() {
			$skincare_cosmetic_store_screen = get_current_screen();
			if ( ! $skincare_cosmetic_store_screen || 'appearance_page_skincare-cosmetic-store-getstart-page' !== $skincare_cosmetic_store_screen->id ) {
				return;
			}

			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
			remove_all_actions( 'network_admin_notices' );
			remove_all_actions( 'user_admin_notices' );
		}

		public function admin_scripts( $skincare_cosmetic_store_hook ) {
			if ( 'appearance_page_skincare-cosmetic-store-getstart-page' !== $skincare_cosmetic_store_hook ) {
				return;
			}

			wp_enqueue_style(
				'skincare-cosmetic-store-getstart-page-style',
				get_template_directory_uri() . '/getstarted/assets/css/getstart-page.css',
				array( 'dashicons' ),
				filemtime( get_template_directory() . '/getstarted/assets/css/getstart-page.css' )
			);

			wp_enqueue_script(
				'skincare-cosmetic-store-getstart-page-script',
				get_template_directory_uri() . '/getstarted/assets/js/getstart-page.js',
				array(),
				filemtime( get_template_directory() . '/getstarted/assets/js/getstart-page.js' ),
				true
			);

			wp_localize_script(
				'skincare-cosmetic-store-getstart-page-script',
				'wprGetstart',
				array(
					'copied' => esc_html__( 'Copied!', 'skincare-cosmetic-store' ),
					'copy'   => esc_html__( 'Copy Code', 'skincare-cosmetic-store' ),
				)
			);
		}

        public function theme_info($skincare_cosmetic_store_id, $skincare_cosmetic_store_screenshot = false) {
            $skincare_cosmetic_store_themedata = wp_get_theme();
            return ($skincare_cosmetic_store_screenshot === true) ? esc_url($skincare_cosmetic_store_themedata->get_screenshot()) : esc_html($skincare_cosmetic_store_themedata->get($skincare_cosmetic_store_id));
        }

        public function skincare_cosmetic_store_getstart_page_menu() {
            add_theme_page(
                /* translators: 1: Theme Name. */
                sprintf(esc_html__('About %1$s', 'skincare-cosmetic-store'), $this->theme_info('Name')),
                /* translators: 1: Theme Name. */
                sprintf(esc_html__('About %1$s', 'skincare-cosmetic-store'), $this->theme_info('Name')),
                'edit_theme_options',
                'skincare-cosmetic-store-getstart-page',
                array( $this, 'skincare_cosmetic_store_getstart_page' )
            );
		}

        public function skincare_cosmetic_store_getstart_page() {
            $skincare_cosmetic_store_section     = isset( $_GET['section'] ) ? sanitize_key( wp_unslash( $_GET['section'] ) ) : 'skincare_cosmetic_store_getting_started';
            $skincare_cosmetic_store_text_domain = $this->theme_info( 'TextDomain' );
            $skincare_cosmetic_store_page_url    = admin_url( 'themes.php?page=skincare-cosmetic-store-getstart-page' );
            $skincare_cosmetic_store_img_dir     = get_template_directory_uri() . '/assets/images/';
            $skincare_cosmetic_store_screenshot  = $this->theme_info( 'Screenshot', true );

            $skincare_cosmetic_store_tabs = array(
                'skincare_cosmetic_store_getting_started' => array(
                    'label' => esc_html__( 'Getting Started', 'skincare-cosmetic-store' ),
                    'url'   => $skincare_cosmetic_store_page_url,
                ),
                'skincare_cosmetic_store_free_pro' => array(
                    'label' => esc_html__( 'Free VS Pro', 'skincare-cosmetic-store' ),
                    'url'   => add_query_arg( 'section', 'skincare_cosmetic_store_free_pro', $skincare_cosmetic_store_page_url ),
                ),
                'bundle' => array(
                    'label' => esc_html__( 'Theme Bundle', 'skincare-cosmetic-store' ),
                    'url'   => add_query_arg( 'section', 'bundle', $skincare_cosmetic_store_page_url ),
                ),
                'changelog' => array(
                    'label' => esc_html__( 'Changelog', 'skincare-cosmetic-store' ),
                    'url'   => add_query_arg( 'section', 'changelog', $skincare_cosmetic_store_page_url ),
                ),
                'support' => array(
                    'label' => esc_html__( 'Support', 'skincare-cosmetic-store' ),
                    'url'   => add_query_arg( 'section', 'support', $skincare_cosmetic_store_page_url ),
                ),
                'review' => array(
                    'label'    => esc_html__( 'Rate & Review', 'skincare-cosmetic-store' ),
                    'url'      => 'https://wordpress.org/support/theme/' . $skincare_cosmetic_store_text_domain . '/reviews/#new-post',
                    'external' => true,
                ),
            );

            $skincare_cosmetic_store_panels = array(
                'skincare_cosmetic_store_getting_started' => 'skincare_cosmetic_store_getting_started',
                'skincare_cosmetic_store_free_pro'        => 'skincare_cosmetic_store_free_pro',
                'bundle'                                  => 'skincare_cosmetic_store_bundle',
                'changelog'                               => 'changelog',
                'support'                                 => 'skincare_cosmetic_store_support',
            );

            if ( ! isset( $skincare_cosmetic_store_panels[ $skincare_cosmetic_store_section ] ) ) {
                $skincare_cosmetic_store_section = 'skincare_cosmetic_store_getting_started';
            }

            $skincare_cosmetic_store_hero_features = array(
                'art'              => esc_html__( 'Beautiful & Modern Design', 'skincare-cosmetic-store' ),
                'smartphone'       => esc_html__( '100% Responsive & Mobile Ready', 'skincare-cosmetic-store' ),
                'admin-customizer' => esc_html__( 'Easy to Customize with WordPress', 'skincare-cosmetic-store' ),
                'heart'            => esc_html__( 'Perfect for Beauty & Wellness Stores', 'skincare-cosmetic-store' ),
            );

            $skincare_cosmetic_store_bundle_features = array(
                esc_html__( '60+ Premium Themes', 'skincare-cosmetic-store' ),
                esc_html__( 'Regular Updates & Support', 'skincare-cosmetic-store' ),
                esc_html__( 'Use on Unlimited Websites', 'skincare-cosmetic-store' ),
                esc_html__( 'All Future Themes Included', 'skincare-cosmetic-store' ),
            );
            ?>
            <div class="wrap wprev-getstart">

                <section class="wprev-hero">
                    <div class="wprev-hero__content">
                        <p class="wprev-eyebrow"><?php esc_html_e( 'Welcome to', 'skincare-cosmetic-store' ); ?></p>
                        <h1 class="wprev-hero__title">
                            <?php echo esc_html( $this->theme_info( 'Name' ) ); ?>
                            <span class="wprev-badge"><?php esc_html_e( 'Free Version', 'skincare-cosmetic-store' ); ?></span>
                        </h1>
                        <p class="wprev-hero__version">
                            <?php
                            /* translators: %s: Theme version. */
                            printf( esc_html__( 'Version %s', 'skincare-cosmetic-store' ), esc_html( $this->theme_info( 'Version' ) ) );
                            ?>
                        </p>
                    </div>
                    <div class="wprev-hero__media">
                        <nav class="wprev-hero__actions" aria-label="<?php esc_attr_e( 'Quick links', 'skincare-cosmetic-store' ); ?>">
                            <a class="wprev-btn wprev-btn--pink" target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_BUY_NOW ); ?>">
                                <span class="dashicons dashicons-cart" aria-hidden="true"></span>
                                <?php esc_html_e( 'Buy Now', 'skincare-cosmetic-store' ); ?>
                            </a>
                            <a class="wprev-btn wprev-btn--blue" target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_LIVE_DEMO ); ?>">
                                <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
                                <?php esc_html_e( 'Live Demo', 'skincare-cosmetic-store' ); ?>
                            </a>
                            <a class="wprev-btn wprev-btn--outline" target="_blank" rel="noopener" href="<?php echo esc_url( 'https://demo.revolutionwp.com/wpdocs/skincare-cosmetic-store-free/' ); ?>">
                                <span class="dashicons dashicons-media-document" aria-hidden="true"></span>
                                <?php esc_html_e( 'Documentation', 'skincare-cosmetic-store' ); ?>
                            </a>
                            <a class="wprev-btn wprev-btn--outline-pink" target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_BUNDLE ); ?>">
                                <span class="dashicons dashicons-screenoptions" aria-hidden="true"></span>
                                <?php esc_html_e( 'Get Bundle', 'skincare-cosmetic-store' ); ?>
                            </a>
                        </nav>
                    </div>
                </section>

                <section class="wprev-bundle">
                    <div class="wprev-bundle__media" aria-hidden="true">
                        <img class="wprev-bundle__shot wprev-bundle__shot--1" src="<?php echo esc_url( get_template_directory_uri() . '/getstarted/assets/images/getstart-bundle.png' ); ?>" alt="" />
                        <span class="wprev-bundle__seal">
                            <strong><?php esc_html_e( '60+', 'skincare-cosmetic-store' ); ?></strong>
                            <?php esc_html_e( 'Premium Themes', 'skincare-cosmetic-store' ); ?>
                        </span>
                    </div>
                    <div class="wprev-bundle__content">
                        <p class="wprev-eyebrow wprev-eyebrow--offer">
                            <span class="dashicons dashicons-awards" aria-hidden="true"></span>
                            <?php esc_html_e( 'Limited Time Offer', 'skincare-cosmetic-store' ); ?>
                        </p>
                        <h2 class="wprev-bundle__title">
                            <?php esc_html_e( 'Get the Complete', 'skincare-cosmetic-store' ); ?>
                            <span><?php esc_html_e( 'Theme Bundle', 'skincare-cosmetic-store' ); ?></span>
                        </h2>
                        <p class="wprev-bundle__desc"><?php esc_html_e( 'Unlock 60+ premium WordPress themes, including eCommerce, Business, Blog, Portfolio and more. Build unlimited websites with one bundle.', 'skincare-cosmetic-store' ); ?></p>
                        <ul class="wprev-checklist wprev-checklist--grid">
                            <?php foreach ( $skincare_cosmetic_store_bundle_features as $skincare_cosmetic_store_feature ) : ?>
                                <li><?php echo esc_html( $skincare_cosmetic_store_feature ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="wprev-bundle__price">
                        <span class="wprev-ribbon"><?php esc_html_e( 'Best Value', 'skincare-cosmetic-store' ); ?></span>
                        <del><?php esc_html_e( '$2340', 'skincare-cosmetic-store' ); ?></del>
                        <strong><?php esc_html_e( '$79', 'skincare-cosmetic-store' ); ?></strong>
                        <?php $this->coupon( 'BUNDLE10', sprintf( /* translators: %d: Discount percentage. */ esc_html__( 'Flat %d%% OFF on Bundle', 'skincare-cosmetic-store' ), 10 ) ); ?>
                        <a class="wprev-btn wprev-btn--pink" target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_BUNDLE ); ?>">
                            <?php esc_html_e( 'Get the Bundle', 'skincare-cosmetic-store' ); ?>
                            <span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
                        </a>
                    </div>
                </section>

                <nav class="wprev-tabs" aria-label="<?php esc_attr_e( 'Getting started sections', 'skincare-cosmetic-store' ); ?>">
                    <?php foreach ( $skincare_cosmetic_store_tabs as $skincare_cosmetic_store_id => $skincare_cosmetic_store_tab ) : ?>
                        <a
                            class="wprev-tabs__item<?php echo ( $skincare_cosmetic_store_id === $skincare_cosmetic_store_section ) ? ' is-active' : ''; ?>"
                            href="<?php echo esc_url( $skincare_cosmetic_store_tab['url'] ); ?>"
                            <?php if ( ! empty( $skincare_cosmetic_store_tab['external'] ) ) : ?>
                                target="_blank" rel="noopener"
                            <?php else : ?>
                                data-wprev-tab="<?php echo esc_attr( $skincare_cosmetic_store_id ); ?>"
                            <?php endif; ?>
                            <?php if ( $skincare_cosmetic_store_id === $skincare_cosmetic_store_section ) : ?>aria-current="page"<?php endif; ?>
                        >
                            <?php echo esc_html( $skincare_cosmetic_store_tab['label'] ); ?>
                            <?php if ( ! empty( $skincare_cosmetic_store_tab['external'] ) ) : ?>
                                <span class="dashicons dashicons-external" aria-hidden="true"></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </nav>

                <?php foreach ( $skincare_cosmetic_store_panels as $skincare_cosmetic_store_id => $skincare_cosmetic_store_callback ) : ?>
                    <div class="wprev-panel" id="wprev-panel-<?php echo esc_attr( $skincare_cosmetic_store_id ); ?>" data-wprev-panel="<?php echo esc_attr( $skincare_cosmetic_store_id ); ?>"<?php echo ( $skincare_cosmetic_store_id === $skincare_cosmetic_store_section ) ? '' : ' hidden'; ?>>
                        <?php $this->$skincare_cosmetic_store_callback(); ?>
                    </div>
                <?php endforeach; ?>

            </div>
            <?php
		}

        public function skincare_cosmetic_store_getting_started() {
            $skincare_cosmetic_store_pro_features = array(
                esc_html__( 'Advanced Homepage Layouts', 'skincare-cosmetic-store' ),
                esc_html__( 'More Section Blocks & Customization', 'skincare-cosmetic-store' ),
                esc_html__( 'Premium Support', 'skincare-cosmetic-store' ),
                esc_html__( 'Regular Updates', 'skincare-cosmetic-store' ),
            );

            $skincare_cosmetic_store_support_topics = array(
                esc_html__( 'Theme Setup Support', 'skincare-cosmetic-store' ),
                esc_html__( 'Customization Help', 'skincare-cosmetic-store' ),
                esc_html__( 'Bug Fixes & Troubleshooting', 'skincare-cosmetic-store' ),
                esc_html__( 'General Questions', 'skincare-cosmetic-store' ),
            );
            ?>
            <?php if ( class_exists( 'Skincare_Cosmetic_Store_Demo_Import' ) && Skincare_Cosmetic_Store_Demo_Import::current_user_can_run() ) : ?>
                <?php $skincare_cosmetic_store_complete = Skincare_Cosmetic_Store_Demo_Import::is_complete(); ?>
                <div class="wprev-card wprev-import<?php echo $skincare_cosmetic_store_complete ? ' is-complete' : ''; ?>">
                    <span class="wprev-card__icon dashicons dashicons-<?php echo $skincare_cosmetic_store_complete ? 'yes-alt' : 'download'; ?>" aria-hidden="true"></span>
                    <div class="wprev-import__body">
                        <h3 class="wprev-card__title">
                            <?php $skincare_cosmetic_store_complete ? esc_html_e( 'Your Demo Is Ready', 'skincare-cosmetic-store' ) : esc_html_e( 'Plugin Installation & Demo Import', 'skincare-cosmetic-store' ); ?>
                        </h3>
                        <p>
                            <?php
                            $skincare_cosmetic_store_complete
                                ? esc_html_e( 'The recommended plugins are active and the demo products have been imported.', 'skincare-cosmetic-store' )
                                : esc_html_e( 'Install and activate the recommended plugins, including WooCommerce, and import the demo products shown on the homepage, all in one click.', 'skincare-cosmetic-store' );
                            ?>
                        </p>
                    </div>
                    <?php Skincare_Cosmetic_Store_Demo_Import::render_button( 'getstart' ); ?>
                </div>
            <?php endif; ?>

            <div class="wprev-cards">

                <div class="wprev-card wprev-card--preview">
                    <h3 class="wprev-card__title"><?php esc_html_e( 'Theme Preview', 'skincare-cosmetic-store' ); ?></h3>
                    <div class="wprev-card__shot">
                        <img src="<?php echo esc_url( $this->theme_info( 'Screenshot', true ) ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'skincare-cosmetic-store' ); ?>" />
                    </div>
                    <div class="wprev-card__actions">
                        <a class="wprev-btn wprev-btn--blue" target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_LIVE_DEMO ); ?>">
                            <?php esc_html_e( 'Live Demo', 'skincare-cosmetic-store' ); ?>
                            <span class="dashicons dashicons-external" aria-hidden="true"></span>
                        </a>
                        <a class="wprev-btn wprev-btn--outline" target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_BUY_NOW ); ?>">
                            <?php esc_html_e( 'Theme Details', 'skincare-cosmetic-store' ); ?>
                            <span class="dashicons dashicons-external" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>

                <div class="wprev-card wprev-card--pro">
                    <h3 class="wprev-card__title wprev-card__title--pink">
                        <span class="dashicons dashicons-star-filled" aria-hidden="true"></span>
                        <?php esc_html_e( 'Upgrade to Pro Version', 'skincare-cosmetic-store' ); ?>
                    </h3>
                    <p><?php esc_html_e( 'Get more features, advanced sections, premium designs and priority support with the Pro version.', 'skincare-cosmetic-store' ); ?></p>
                    <ul class="wprev-checklist">
                        <?php foreach ( $skincare_cosmetic_store_pro_features as $skincare_cosmetic_store_feature ) : ?>
                            <li><?php echo esc_html( $skincare_cosmetic_store_feature ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="wprev-card__footer">
                        <span class="wprev-card__price"><?php esc_html_e( 'Only $39', 'skincare-cosmetic-store' ); ?></span>
                        <a class="wprev-btn wprev-btn--pink" target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_BUY_NOW ); ?>">
                            <?php esc_html_e( 'Buy Pro Theme', 'skincare-cosmetic-store' ); ?>
                            <span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
                        </a>
                    </div>
                    <?php $this->coupon(); ?>
                </div>

                <div class="wprev-card">
                    <h3 class="wprev-card__title">
                        <span class="wprev-card__icon dashicons dashicons-media-document" aria-hidden="true"></span>
                        <?php esc_html_e( 'Need Documentation?', 'skincare-cosmetic-store' ); ?>
                    </h3>
                    <p><?php esc_html_e( 'Check our detailed documentation for step-by-step guidance on installation, customization and using the Skincare Cosmetic Store theme.', 'skincare-cosmetic-store' ); ?></p>
                    <a class="wprev-btn wprev-btn--outline-blue" target="_blank" rel="noopener" href="<?php echo esc_url( 'https://demo.revolutionwp.com/wpdocs/skincare-cosmetic-store-free/' ); ?>">
                        <?php esc_html_e( 'Go to Documentation', 'skincare-cosmetic-store' ); ?>
                        <span class="dashicons dashicons-external" aria-hidden="true"></span>
                    </a>
                    <div class="wprev-tip">
                        <span class="dashicons dashicons-lightbulb" aria-hidden="true"></span>
                        <p><strong><?php esc_html_e( 'Tip:', 'skincare-cosmetic-store' ); ?></strong> <?php esc_html_e( 'Need help setting up? Start with our documentation or contact our support team.', 'skincare-cosmetic-store' ); ?></p>
                    </div>
                </div>

                <div class="wprev-card wprev-card--support">
                    <h3 class="wprev-card__title">
                        <span class="wprev-card__icon wprev-card__icon--green dashicons dashicons-format-chat" aria-hidden="true"></span>
                        <?php esc_html_e( 'Need Support?', 'skincare-cosmetic-store' ); ?>
                    </h3>
                    <p><?php esc_html_e( 'Facing any issues or have questions? Our dedicated support team is here to help you.', 'skincare-cosmetic-store' ); ?></p>
                    <ul class="wprev-checklist wprev-checklist--green">
                        <?php foreach ( $skincare_cosmetic_store_support_topics as $skincare_cosmetic_store_topic ) : ?>
                            <li><?php echo esc_html( $skincare_cosmetic_store_topic ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a class="wprev-btn wprev-btn--outline-blue" target="_blank" rel="noopener" href="<?php echo esc_url( 'https://wordpress.org/support/theme/' . $this->theme_info( 'TextDomain' ) ); ?>">
                        <?php esc_html_e( 'Get Support', 'skincare-cosmetic-store' ); ?>
                        <span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
                    </a>
                </div>

            </div>
            <?php
        }

        public function coupon( $skincare_cosmetic_store_code = 'STARTUP20', $skincare_cosmetic_store_text = '' ) {
            if ( '' === $skincare_cosmetic_store_text ) {
                /* translators: %s: Coupon code. */
                $skincare_cosmetic_store_text = sprintf( esc_html__( 'Get Extra 20%% OFF Using "%s"', 'skincare-cosmetic-store' ), '<strong>' . esc_html( $skincare_cosmetic_store_code ) . '</strong>' );
            }
            ?>
            <div class="wprev-coupon">
                <p class="wprev-coupon__text">
                    <span class="dashicons dashicons-tickets-alt" aria-hidden="true"></span>
                    <span><?php echo wp_kses( $skincare_cosmetic_store_text, array( 'strong' => array() ) ); ?></span>
                </p>
                <div class="wprev-coupon__field">
                    <code class="wprev-coupon__code"><?php echo esc_html( $skincare_cosmetic_store_code ); ?></code>
                    <button type="button" class="wprev-coupon__copy" data-wprev-copy="<?php echo esc_attr( $skincare_cosmetic_store_code ); ?>">
                        <span class="dashicons dashicons-admin-page" aria-hidden="true"></span>
                        <span class="wprev-coupon__label"><?php esc_html_e( 'Copy Code', 'skincare-cosmetic-store' ); ?></span>
                    </button>
                </div>
                <span class="screen-reader-text" aria-live="polite" data-wprev-copy-status></span>
            </div>
            <?php
        }

        public function skincare_cosmetic_store_bundle() {
            $skincare_cosmetic_store_included = array(
                esc_html__( '60+ Premium WordPress Themes', 'skincare-cosmetic-store' ),
                esc_html__( 'Use on Unlimited Websites', 'skincare-cosmetic-store' ),
                esc_html__( 'All Future Themes Included', 'skincare-cosmetic-store' ),
                esc_html__( '1 Year of Updates & Premium Support', 'skincare-cosmetic-store' ),
                esc_html__( 'One-Click Demo Import', 'skincare-cosmetic-store' ),
                esc_html__( 'WooCommerce Ready Designs', 'skincare-cosmetic-store' ),
                esc_html__( 'Fully Responsive & SEO Friendly', 'skincare-cosmetic-store' ),
                esc_html__( 'Detailed Documentation', 'skincare-cosmetic-store' ),
            );

            $skincare_cosmetic_store_categories = array(
                esc_html__( 'eCommerce', 'skincare-cosmetic-store' ),
                esc_html__( 'Beauty & Spa', 'skincare-cosmetic-store' ),
                esc_html__( 'Business', 'skincare-cosmetic-store' ),
                esc_html__( 'Blog', 'skincare-cosmetic-store' ),
                esc_html__( 'Portfolio', 'skincare-cosmetic-store' ),
                esc_html__( 'Health & Fitness', 'skincare-cosmetic-store' ),
                esc_html__( 'Restaurant', 'skincare-cosmetic-store' ),
                esc_html__( 'Education', 'skincare-cosmetic-store' ),
            );

            $skincare_cosmetic_store_steps = array(
                esc_html__( 'Purchase the bundle', 'skincare-cosmetic-store' ),
                esc_html__( 'Download any theme from your account', 'skincare-cosmetic-store' ),
                esc_html__( 'Install, import the demo and launch', 'skincare-cosmetic-store' ),
            );
            ?>
            <div class="wprev-detail">
                <div class="wprev-detail__main">
                    <div class="wprev-card wprev-detail__intro">
                        <div class="wprev-detail__media" aria-hidden="true">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/getstarted/assets/images/getstart-bundle.png' ); ?>" alt="" />
                        </div>
                        <div>
                            <p class="wprev-eyebrow"><?php esc_html_e( 'WordPress Theme Bundle', 'skincare-cosmetic-store' ); ?></p>
                            <h3 class="wprev-detail__title"><?php esc_html_e( 'Every Premium Theme. One Simple Price.', 'skincare-cosmetic-store' ); ?></h3>
                            <p><?php esc_html_e( 'The bundle gives you instant access to our entire collection of premium themes, so you can build websites for any niche or client without buying themes one by one.', 'skincare-cosmetic-store' ); ?></p>
                        </div>
                    </div>

                    <div class="wprev-card">
                        <h3 class="wprev-card__title"><?php esc_html_e( "What's Included", 'skincare-cosmetic-store' ); ?></h3>
                        <ul class="wprev-checklist wprev-checklist--grid">
                            <?php foreach ( $skincare_cosmetic_store_included as $skincare_cosmetic_store_item ) : ?>
                                <li><?php echo esc_html( $skincare_cosmetic_store_item ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="wprev-card">
                        <h3 class="wprev-card__title"><?php esc_html_e( 'Themes for Every Niche', 'skincare-cosmetic-store' ); ?></h3>
                        <ul class="wprev-chips">
                            <?php foreach ( $skincare_cosmetic_store_categories as $skincare_cosmetic_store_category ) : ?>
                                <li><?php echo esc_html( $skincare_cosmetic_store_category ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <ol class="wprev-steps">
                            <?php foreach ( $skincare_cosmetic_store_steps as $skincare_cosmetic_store_i => $skincare_cosmetic_store_step ) : ?>
                                <li><span><?php echo esc_html( $skincare_cosmetic_store_i + 1 ); ?></span><?php echo esc_html( $skincare_cosmetic_store_step ); ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                </div>

                <aside class="wprev-detail__aside">
                    <div class="wprev-cta">
                        <span class="wprev-ribbon"><?php esc_html_e( 'Best Value', 'skincare-cosmetic-store' ); ?></span>
                        <p class="wprev-cta__label"><?php esc_html_e( 'Complete Theme Bundle', 'skincare-cosmetic-store' ); ?></p>
                        <del><?php esc_html_e( '$2340', 'skincare-cosmetic-store' ); ?></del>
                        <strong class="wprev-cta__price"><?php esc_html_e( '$79', 'skincare-cosmetic-store' ); ?></strong>
                        <?php $this->coupon( 'BUNDLE10', sprintf( /* translators: %d: Discount percentage. */ esc_html__( 'Flat %d%% OFF on Bundle', 'skincare-cosmetic-store' ), 10 ) ); ?>
                        <a class="wprev-btn wprev-btn--pink" target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_BUNDLE ); ?>">
                            <?php esc_html_e( 'Get the Bundle', 'skincare-cosmetic-store' ); ?>
                            <span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
                        </a>
                        <ul class="wprev-cta__trust">
                            <li><span class="dashicons dashicons-lock" aria-hidden="true"></span><?php esc_html_e( 'Secure checkout', 'skincare-cosmetic-store' ); ?></li>
                            <li><span class="dashicons dashicons-update" aria-hidden="true"></span><?php esc_html_e( 'Instant access', 'skincare-cosmetic-store' ); ?></li>
                        </ul>
                    </div>
                </aside>
            </div>
            <?php
        }

        public function skincare_cosmetic_store_support() {
            $skincare_cosmetic_store_text_domain = $this->theme_info( 'TextDomain' );

            $skincare_cosmetic_store_channels = array(
                array(
                    'icon'  => 'WordPress',
                    'title' => esc_html__( 'Free Support Forum', 'skincare-cosmetic-store' ),
                    'desc'  => esc_html__( 'Ask questions about the free theme on the official wordpress.org forum.', 'skincare-cosmetic-store' ),
                    'label' => esc_html__( 'Open Forum', 'skincare-cosmetic-store' ),
                    'url'   => 'https://wordpress.org/support/theme/' . $skincare_cosmetic_store_text_domain,
                ),
                array(
                    'icon'  => 'media-document',
                    'title' => esc_html__( 'Documentation', 'skincare-cosmetic-store' ),
                    'desc'  => esc_html__( 'Step-by-step guides for installation, setup and customization.', 'skincare-cosmetic-store' ),
                    'label' => esc_html__( 'Read Docs', 'skincare-cosmetic-store' ),
                    'url'   => SKINCARE_COSMETIC_STORE_LITE_DOC,
                ),
                array(
                    'icon'  => 'star-filled',
                    'title' => esc_html__( 'Rate & Review', 'skincare-cosmetic-store' ),
                    'desc'  => esc_html__( 'Enjoying the theme? A quick review helps us keep improving it.', 'skincare-cosmetic-store' ),
                    'label' => esc_html__( 'Leave a Review', 'skincare-cosmetic-store' ),
                    'url'   => SKINCARE_COSMETIC_STORE_REVIEW,
                ),
            );

            $skincare_cosmetic_store_topics = array(
                esc_html__( 'Theme Setup Support', 'skincare-cosmetic-store' ),
                esc_html__( 'Customization Help', 'skincare-cosmetic-store' ),
                esc_html__( 'Bug Fixes & Troubleshooting', 'skincare-cosmetic-store' ),
                esc_html__( 'Plugin Compatibility', 'skincare-cosmetic-store' ),
                esc_html__( 'Demo Content Import', 'skincare-cosmetic-store' ),
                esc_html__( 'General Questions', 'skincare-cosmetic-store' ),
            );
            ?>
            <div class="wprev-detail">
                <div class="wprev-detail__main">
                    <div class="wprev-support-grid">
                        <?php foreach ( $skincare_cosmetic_store_channels as $skincare_cosmetic_store_channel ) : ?>
                            <div class="wprev-card">
                                <h3 class="wprev-card__title">
                                    <span class="wprev-card__icon dashicons dashicons-<?php echo esc_attr( strtolower( $skincare_cosmetic_store_channel['icon'] ) ); ?>" aria-hidden="true"></span>
                                    <?php echo esc_html( $skincare_cosmetic_store_channel['title'] ); ?>
                                </h3>
                                <p><?php echo esc_html( $skincare_cosmetic_store_channel['desc'] ); ?></p>
                                <a class="wprev-btn wprev-btn--outline-blue wprev-card__cta" target="_blank" rel="noopener" href="<?php echo esc_url( $skincare_cosmetic_store_channel['url'] ); ?>">
                                    <?php echo esc_html( $skincare_cosmetic_store_channel['label'] ); ?>
                                    <span class="dashicons dashicons-external" aria-hidden="true"></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="wprev-card">
                        <h3 class="wprev-card__title">
                            <span class="wprev-card__icon wprev-card__icon--green dashicons dashicons-format-chat" aria-hidden="true"></span>
                            <?php esc_html_e( 'What We Can Help With', 'skincare-cosmetic-store' ); ?>
                        </h3>
                        <ul class="wprev-checklist wprev-checklist--green wprev-checklist--grid">
                            <?php foreach ( $skincare_cosmetic_store_topics as $skincare_cosmetic_store_topic ) : ?>
                                <li><?php echo esc_html( $skincare_cosmetic_store_topic ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="wprev-tip">
                            <span class="dashicons dashicons-lightbulb" aria-hidden="true"></span>
                            <p><strong><?php esc_html_e( 'Tip:', 'skincare-cosmetic-store' ); ?></strong> <?php esc_html_e( 'Include your WordPress version, theme version and a screenshot or link to the issue so we can help faster.', 'skincare-cosmetic-store' ); ?></p>
                        </div>
                    </div>
                </div>

                <aside class="wprev-detail__aside">
                    <div class="wprev-cta wprev-cta--blue">
                        <span class="wprev-card__icon dashicons dashicons-sos" aria-hidden="true"></span>
                        <p class="wprev-cta__label"><?php esc_html_e( 'Need Priority Help?', 'skincare-cosmetic-store' ); ?></p>
                        <p class="wprev-cta__note"><?php esc_html_e( 'Pro users get fast, one-to-one premium support from our theme experts.', 'skincare-cosmetic-store' ); ?></p>
                        <a class="wprev-btn wprev-btn--blue" target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_PRO_SUPPORT ); ?>">
                            <?php esc_html_e( 'Contact Support', 'skincare-cosmetic-store' ); ?>
                            <span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
                        </a>
                        <a class="wprev-btn wprev-btn--outline" target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_BUY_NOW ); ?>">
                            <?php esc_html_e( 'Upgrade to Pro', 'skincare-cosmetic-store' ); ?>
                        </a>
                    </div>
                </aside>
            </div>
            <?php
        }

		public function skincare_cosmetic_store_free_pro() {
            ?>
            <div class="wprev-compare-wrap">
            <table class="wprev-compare">
                <tbody class="table-body">
                    <tr class="table-head">
                        <th class="large"><?php echo esc_html__( 'Features', 'skincare-cosmetic-store' ); ?></th>
                        <th class="indicator"><?php echo esc_html__( 'Free theme', 'skincare-cosmetic-store' ); ?></th>
                        <th class="indicator"><?php echo esc_html__( 'Pro Theme', 'skincare-cosmetic-store' ); ?></th>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Responsive Design', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Site Logo upload', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Footer Copyright text', 'skincare-cosmetic-store' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'Remove the copyright text from the Footer.', 'skincare-cosmetic-store' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Global Color', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Regular Bug Fixes', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Theme Sections', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="abc"><?php echo esc_html__( '2 Sections', 'skincare-cosmetic-store' ); ?></span></td>
                        <td class="indicator"><span class="abc"><?php echo esc_html__( '15+ Sections', 'skincare-cosmetic-store' ); ?></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Custom colors', 'skincare-cosmetic-store' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'Choose a color for links, buttons, icons and so on.', 'skincare-cosmetic-store' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Google fonts', 'skincare-cosmetic-store' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'You can choose and use over 600 different fonts, for the logo, the menu and the titles.', 'skincare-cosmetic-store' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Enhanced Plugin Integration', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Fully SEO Optimized', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Premium Support', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Extensive Customization', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Custom Post Types', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'High-Level Compatibility with Modern Browsers', 'skincare-cosmetic-store' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="upsell-row">
                        <td></td>
                        <td><span class="abc"><?php echo esc_html__( 'Try Out Our Premium Version', 'skincare-cosmetic-store' ); ?></span></td>
                        <td>
                            <a target="_blank" rel="noopener" href="<?php echo esc_url( SKINCARE_COSMETIC_STORE_BUY_NOW ); ?>" class="wprev-btn wprev-btn--pink"><?php echo esc_html__( 'Buy Pro Theme', 'skincare-cosmetic-store' ); ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <?php
        }

		public function changelog() {
            if ( is_file( trailingslashit( get_stylesheet_directory() ) . '/getstarted/skincare_cosmetic_store_changelog.php' ) ) {
                require_once( trailingslashit( get_stylesheet_directory() ) . '/getstarted/skincare_cosmetic_store_changelog.php' );
            } else {
                require_once( trailingslashit( get_template_directory() ) . '/getstarted/skincare_cosmetic_store_changelog.php' );
            }
        }
	}

}
new skincare_cosmetic_store_Welcome();
