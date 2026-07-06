<?php
/**
 * お問い合わせページ（スラッグ contact の固定ページで自動適用）
 * ※フォーム送信を機能させるには Contact Form 7 等のプラグイン連携か、送信先の実装が必要です。
 *   その場合は下の <form> をプラグインのショートコード出力に置き換えてください（CSSクラス .cform を付ければ意匠は流用可）。
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
?>
<main class="subpage">
	<div class="sp-eyebrow">CONTACT</div>
	<h1 class="sp-title">お問い合わせ<span class="en">CONTACT</span></h1>
	<div class="sp-rule"></div>

	<?php the_content(); // 導入文＋（任意で）フォームプラグインのショートコードを本文に書けます ?>

	<?php // 本文にフォーム系ショートコード（例: [contact-form-7 ...]）が含まれていない場合のみ、デザイン用の静的フォームを表示 ?>
	<?php if ( ! has_shortcode( get_the_content(), 'contact-form-7' ) ) : ?>
	<form class="cform" action="#" method="post">
		<div class="row">
			<label for="name">お名前<span class="req">必須</span></label>
			<input type="text" id="name" name="name" autocomplete="name" required>
		</div>
		<div class="row">
			<label for="company">会社名・団体名</label>
			<input type="text" id="company" name="company" autocomplete="organization">
		</div>
		<div class="row">
			<label for="email">メールアドレス<span class="req">必須</span></label>
			<input type="email" id="email" name="email" autocomplete="email" required>
		</div>
		<div class="row">
			<label for="tel">電話番号</label>
			<input type="tel" id="tel" name="tel" autocomplete="tel">
		</div>
		<div class="row">
			<label for="message">お問い合わせ内容<span class="req">必須</span></label>
			<textarea id="message" name="message" required></textarea>
		</div>
		<p class="note">ご入力いただいた個人情報は、<a class="inline" href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>">プライバシーポリシー</a>に基づき適切に取り扱います。</p>
		<button class="submit" type="submit">送信する<span>→</span></button>
	</form>
	<?php endif; ?>
</main>

<div class="backbtn-wrap">
	<a class="backbtn" href="<?php echo esc_url( home_url( '/' ) ); ?>">← トップへ戻る</a>
</div>
<?php endwhile; ?>
<?php get_footer(); ?>
