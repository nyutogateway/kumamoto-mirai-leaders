<?php
/**
 * 汎用固定ページ（プライバシーポリシー等）。サブページ意匠 + 本文。
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
?>
<main class="subpage">
	<div class="sp-eyebrow"><?php echo esc_html( strtoupper( get_post_field( 'post_name', get_the_ID() ) ) ); ?></div>
	<h1 class="sp-title"><?php the_title(); ?></h1>
	<div class="sp-rule"></div>
	<?php the_content(); ?>
</main>

<div class="backbtn-wrap">
	<a class="backbtn" href="<?php echo esc_url( home_url( '/' ) ); ?>">← トップへ戻る</a>
</div>
<?php endwhile; ?>
<?php get_footer(); ?>
