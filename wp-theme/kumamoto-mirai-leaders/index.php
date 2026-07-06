<?php
/**
 * 汎用フォールバックテンプレート（アーカイブ/検索/その他）
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<main class="subpage">
	<?php if ( have_posts() ) : ?>
		<h1 class="sp-title"><?php echo esc_html( wp_get_document_title() ); ?></h1>
		<div class="sp-rule"></div>
		<?php while ( have_posts() ) : the_post(); ?>
			<article style="margin-bottom:32px">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<h1 class="sp-title">コンテンツが見つかりません</h1>
		<div class="sp-rule"></div>
		<p>お探しのページは存在しないか、移動した可能性があります。</p>
	<?php endif; ?>
</main>
<div class="backbtn-wrap">
	<a class="backbtn" href="<?php echo esc_url( home_url( '/' ) ); ?>">← トップへ戻る</a>
</div>
<?php get_footer(); ?>
