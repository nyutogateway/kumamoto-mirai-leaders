<?php if ( ! defined( 'ABSPATH' ) ) exit; $uri = get_template_directory_uri(); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="<?php echo esc_url( $uri ); ?>/assets/img/kumamoto_favicon.png">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="bg-orbs" aria-hidden="true"><span class="orb teal o1"></span><span class="orb pink o2"></span><span class="orb yellow o3"></span><span class="orb blue o4"></span><span class="orb teal o5"></span><span class="orb pink o6"></span></div>

<header class="hdr">
  <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="熊本未来リーダーズ ホーム">
    <img class="blogo" src="<?php echo esc_url( $uri ); ?>/assets/img/asset-03.svg" alt="熊本未来リーダーズ">
  </a>
  <div class="hdr-r">
    <nav>
      <?php
      if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 1, 'fallback_cb' => false ) );
      } else {
        // メニュー未設定時のフォールバック
        echo '<a href="' . esc_url( home_url( '/#concept' ) ) . '">CONCEPT</a>';
        echo '<a href="' . esc_url( home_url( '/#leaders' ) ) . '">LEADERS</a>';
        echo '<a href="' . esc_url( home_url( '/contact/' ) ) . '">CONTACT</a>';
      }
      ?>
    </nav>
    <span class="pw"><a href="https://fm791.jp/" target="_blank" rel="noopener" aria-label="FM791公式サイト"><img loading="lazy" decoding="async" class="fm" src="<?php echo esc_url( $uri ); ?>/assets/img/asset-02.png" alt="FM791"></a></span>
  </div>
  <button class="hmb" type="button" aria-label="メニュー" aria-expanded="false"><span></span><span></span><span></span></button>
</header>
