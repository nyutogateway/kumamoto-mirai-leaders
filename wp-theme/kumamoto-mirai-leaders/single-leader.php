<?php
/**
 * リーダー個別ページ（インタビュー記事）
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$uri = get_template_directory_uri();
get_header();

while ( have_posts() ) : the_post();

	$name     = get_the_title();
	$headline = kml_field( 'headline' );
	if ( ! $headline ) { $headline = $name; }
	$en       = kml_field( 'en_name' );
	$company  = kml_field( 'company' );
	$role     = kml_field( 'role' );
	$aff      = trim( $company . ( $company && $role ? ' ｜ ' : '' ) . $role );
	$lead     = kml_field( 'lead' );
	$url      = kml_field( 'url' );
	$logo     = kml_field( 'logo' );
	$person   = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	?>

	<!-- HERO -->
	<section class="ahero">
		<?php if ( $logo ) : ?><img class="co-logo-pc" src="<?php echo esc_url( $logo ); ?>" alt=""><?php endif; ?>
		<div class="ahero-inner">
			<div class="ahero-left">
				<div class="ahero-photo"><?php if ( $person ) : ?><img class="person" src="<?php echo esc_url( $person ); ?>" alt="<?php echo esc_attr( $name ); ?>"><?php endif; ?></div>
			</div>
			<div class="ahero-right">
				<div class="title"><?php echo esc_html( $headline ); ?></div>
				<?php if ( $en ) : ?><div class="en"><?php echo esc_html( $en ); ?></div><?php endif; ?>
				<div class="namebox">
					<?php if ( $logo ) : ?><img class="co-logo" src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $company ); ?>"><?php endif; ?>
					<div class="nametxt">
						<div class="jp"><?php echo esc_html( $name ); ?></div>
						<?php if ( $aff ) : ?><div class="aff"><?php echo esc_html( $aff ); ?></div><?php endif; ?>
					</div>
				</div>
				<?php if ( $lead ) : ?><p class="lead"><?php echo nl2br( esc_html( $lead ) ); ?></p><?php endif; ?>
				<?php if ( $url ) : ?><a class="co-url" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $url ); ?></a><?php endif; ?>
			</div>
		</div>
	</section>

	<?php
	/* ---- 本文: ACF PRO のリピーターがあればそれを、無ければ投稿本文にフォールバック ---- */
	$has_stories = function_exists( 'have_rows' ) && have_rows( 'story_sections' );
	if ( $has_stories ) {
		echo '<div class="article">';
		$sidx = 0;
		while ( have_rows( 'story_sections' ) ) : the_row();
			$heading = get_sub_field( 'heading' );
			$side    = get_sub_field( 'side_image' );
			echo '<div class="mystory reveal"><b><i>MY STORY</i></b></div>';
			if ( $heading ) {
				echo '<h2 class="story-h reveal">' . esc_html( $heading ) . '</h2>';
			}

			// Q&A ブロック
			ob_start();
			echo '<div class="qa">';
			if ( have_rows( 'qa' ) ) {
				while ( have_rows( 'qa' ) ) : the_row();
					$question = get_sub_field( 'question' );
					$answer   = get_sub_field( 'answer' );
					if ( $question ) {
						echo '<div class="q"><span class="mk">Q</span><span class="qt">' . esc_html( $question ) . '</span></div>';
					}
					if ( $answer ) {
						echo '<div class="a"><span class="mk">A</span>' . wpautop( esc_html( $answer ) ) . '</div>';
					}
				endwhile;
			}
			echo '</div>';
			$qa_html = ob_get_clean();

			if ( $side ) {
				$rev = ( $sidx % 2 === 1 ) ? ' rev' : '';
				echo '<div class="cols' . $rev . ' reveal"><div class="txt">' . $qa_html . '</div>';
				echo '<div class="pic"><div class="spic"><img class="phf" src="' . esc_url( $side ) . '" alt=""></div></div></div>';
			} else {
				echo '<div class="reveal">' . $qa_html . '</div>';
			}
			$sidx++;
		endwhile;
		echo '</div>';

		/* ---- ギャラリー（自動スクロール帯） ---- */
		$gallery = kml_field( 'gallery' );
		if ( $gallery && is_array( $gallery ) ) {
			echo '<div class="gallery reveal" aria-hidden="true"><div class="gtrack">';
			// シームレスループのため2周ぶん出力
			for ( $rep = 0; $rep < 2; $rep++ ) {
				foreach ( $gallery as $g ) {
					$src = is_array( $g ) ? ( $g['url'] ?? '' ) : $g;
					if ( $src ) {
						echo '<div class="gph"><img loading="lazy" decoding="async" class="phf" src="' . esc_url( $src ) . '" alt=""></div>';
					}
				}
			}
			echo '</div></div>';
		}

		/* ---- 締めのメッセージ ---- */
		$closing = kml_field( 'closing' );
		if ( $closing ) {
			echo '<div class="article">';
			echo '<div class="mystory reveal"><b><i>MY STORY</i></b></div>';
			echo '<h2 class="story-h reveal">＜若者へのメッセージ＞</h2>';
			echo '<div class="closing reveal">' . wpautop( esc_html( $closing ) ) . '</div>';
			echo '</div>';
		}

	} else {
		// ACF PRO 無し or 未入力 → 投稿本文をそのまま記事本文に
		echo '<div class="article"><div class="cms-body reveal">';
		the_content();
		echo '</div></div>';
	}
	?>

	<div class="article">
		<div class="backwrap reveal"><a class="backbtn" href="<?php echo esc_url( home_url( '/#leaders' ) ); ?>">← 一覧へ戻る</a></div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
