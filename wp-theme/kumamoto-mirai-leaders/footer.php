<?php if ( ! defined( 'ABSPATH' ) ) exit; $uri = get_template_directory_uri(); ?>
<footer class="ftr">
  <div class="ftr-strip"><i></i><i></i><i></i><i></i></div>
  <div class="ftr-main">
    <div class="ftr-brand">
      <img loading="lazy" decoding="async" class="ftr-logo" src="<?php echo esc_url( $uri ); ?>/assets/img/asset-21.svg" alt="熊本未来リーダーズ">
    </div>
    <div class="ftr-right">
      <nav class="ftr-nav">
        <?php
        if ( has_nav_menu( 'footer' ) ) {
          wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 1, 'fallback_cb' => false ) );
        } else {
          echo '<a href="' . esc_url( home_url( '/#concept' ) ) . '">CONCEPT</a>';
          echo '<a href="' . esc_url( home_url( '/#leaders' ) ) . '">LEADERS</a>';
          echo '<a href="' . esc_url( home_url( '/privacy/' ) ) . '">POLICY</a>';
          echo '<a href="' . esc_url( home_url( '/contact/' ) ) . '">CONTACT</a>';
        }
        ?>
      </nav>
    </div>
  </div>
  <div class="ftr-bottom">
    <span class="cr">&copy; kumamoto-futureleaders. All rights reserved.</span>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
