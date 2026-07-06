<?php
/**
 * カスタム投稿タイプ「leader」（リーダー / インタビュー）
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
	register_post_type( 'leader', array(
		'labels' => array(
			'name'               => 'リーダー',
			'singular_name'      => 'リーダー',
			'add_new'            => '新規追加',
			'add_new_item'       => 'リーダーを追加',
			'edit_item'          => 'リーダーを編集',
			'new_item'           => '新規リーダー',
			'view_item'          => 'リーダーを表示',
			'search_items'       => 'リーダーを検索',
			'not_found'          => 'リーダーが見つかりません',
			'all_items'          => 'リーダー一覧',
			'menu_name'          => 'リーダー',
		),
		'public'        => true,
		'has_archive'   => false,
		'menu_position' => 5,
		'menu_icon'     => 'dashicons-groups',
		'supports'      => array( 'title', 'thumbnail', 'page-attributes' ), // title=氏名, thumbnail=人物写真, menu_order=並び順
		'rewrite'       => array( 'slug' => 'leaders' ),
		'show_in_rest'  => true,
	) );
} );

/* 管理一覧に「並び順(menu_order)」で表示できるよう、既定の並びを menu_order 昇順に */
add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() && $q->is_main_query() && $q->get( 'post_type' ) === 'leader' && ! $q->get( 'orderby' ) ) {
		$q->set( 'orderby', 'menu_order' );
		$q->set( 'order', 'ASC' );
	}
} );

/* 「氏名」を入力欄プレースホルダに */
add_filter( 'enter_title_here', function ( $t, $post ) {
	if ( $post && $post->post_type === 'leader' ) return '氏名（例: 宮本 功）';
	return $t;
}, 10, 2 );
