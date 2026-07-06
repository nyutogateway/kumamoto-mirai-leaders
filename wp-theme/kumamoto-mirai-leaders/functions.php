<?php
/**
 * 熊本未来リーダーズ テーマ functions
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'KML_VER', '1.0.0' );

/* ------------------------------------------------------------------
 * テーマサポート
 * ---------------------------------------------------------------- */
function kml_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' ); // リーダーの人物写真＝アイキャッチ
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	register_nav_menus( array(
		'primary' => 'ヘッダーナビ',
		'footer'  => 'フッターナビ',
	) );
}
add_action( 'after_setup_theme', 'kml_setup' );

/* ------------------------------------------------------------------
 * CSS / JS 読み込み
 * ---------------------------------------------------------------- */
function kml_assets() {
	$uri = get_template_directory_uri();
	$ver = KML_VER;

	// Google Fonts
	wp_enqueue_style( 'kml-gfonts', 'https://fonts.googleapis.com/css2?family=Reggae+One&family=Bungee&family=Zen+Kaku+Gothic+New:wght@400;500;700&family=Noto+Sans+JP:wght@400;500;700&family=Inter:wght@400;500&display=swap', array(), null );

	// 共通CSS（style.css はテーマ識別用。実体は main.css）
	wp_enqueue_style( 'kml-main', $uri . '/assets/css/main.css', array(), $ver );

	// ページ別CSS
	if ( is_front_page() ) {
		wp_enqueue_style( 'kml-index', $uri . '/assets/css/index.css', array( 'kml-main' ), $ver );
		wp_enqueue_script( 'kml-index-js', $uri . '/assets/js/index.js', array(), $ver, true );
	}
	if ( is_singular( 'leader' ) ) {
		wp_enqueue_style( 'kml-article', $uri . '/assets/css/article.css', array( 'kml-main' ), $ver );
		wp_enqueue_script( 'kml-article-js', $uri . '/assets/js/article.js', array(), $ver, true );
	}

	// 全ページ共通JS（ハンバーガー）
	wp_enqueue_script( 'kml-main-js', $uri . '/assets/js/main.js', array(), $ver, true );
}
add_action( 'wp_enqueue_scripts', 'kml_assets' );

/* ------------------------------------------------------------------
 * カスタム投稿タイプ / ACF ローカルJSON
 * ---------------------------------------------------------------- */
require_once get_template_directory() . '/inc/cpt.php';

// ACF ローカルJSONの保存先をテーマの acf-json/ に（同梱フィールド群を自動読込）
add_filter( 'acf/settings/save_json', function ( $path ) {
	return get_stylesheet_directory() . '/acf-json';
} );
add_filter( 'acf/settings/load_json', function ( $paths ) {
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;
} );

/* ------------------------------------------------------------------
 * 管理画面: ACF未導入なら通知
 * ---------------------------------------------------------------- */
add_action( 'admin_notices', function () {
	if ( ! class_exists( 'ACF' ) ) {
		echo '<div class="notice notice-warning"><p><strong>熊本未来リーダーズ テーマ:</strong> プラグイン「Advanced Custom Fields（無料）」を有効化してください。リーダー情報の入力欄はACFで提供されます。</p></div>';
	}
} );

/* ------------------------------------------------------------------
 * ヘルパー: ACF get_field の安全ラッパー（ACF未導入でも致命エラーにしない）
 * ---------------------------------------------------------------- */
function kml_field( $name, $post_id = false ) {
	return function_exists( 'get_field' ) ? get_field( $name, $post_id ) : '';
}

/**
 * リーダーのカード色を index から自動割当（blue/pink/yellow/teal を循環）
 * @param int $i 0始まりの通し番号
 * @return array [--c の変数名, 追加style(黄色は文字を濃く)]
 */
function kml_card_color( $i ) {
	$colors = array(
		array( 'c-blue', '' ),
		array( 'c-pink', '' ),
		array( 'c-yellow', ';--tc:var(--navy)' ),
		array( 'c-teal', '' ),
	);
	return $colors[ $i % 4 ];
}

/* グループ見出しの色（blue/pink/yellow/teal を循環） */
function kml_group_color( $g ) {
	$c = array( 'c-blue', 'c-pink', 'c-yellow', 'c-teal', 'c-blue' );
	return $c[ $g % count( $c ) ];
}
