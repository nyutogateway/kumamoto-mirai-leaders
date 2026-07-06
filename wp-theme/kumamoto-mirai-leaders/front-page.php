<?php
/**
 * トップページ（FV / CONCEPT / LEADERS[CPT] / FM791）
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$uri = get_template_directory_uri();
get_header();
?>

<section class="fv">
  <div class="orbs">
    <div class="orb o1" style="width:375px;height:375px;top:6%;left:-6%;background:radial-gradient(circle,rgba(46,174,150,.42),rgba(46,174,150,0) 70%)"></div>
    <div class="orb o2" style="width:330px;height:330px;top:58%;left:60%;background:radial-gradient(circle,rgba(226,80,138,.38),rgba(226,80,138,0) 70%)"></div>
    <div class="orb o3" style="width:360px;height:360px;top:28%;left:70%;background:radial-gradient(circle,rgba(45,147,204,.36),rgba(45,147,204,0) 70%)"></div>
    <div class="orb o4" style="width:308px;height:308px;top:68%;left:4%;background:radial-gradient(circle,rgba(239,181,42,.42),rgba(239,181,42,0) 70%)"></div>
    <div class="orb o5" style="width:285px;height:285px;top:-4%;left:52%;background:radial-gradient(circle,rgba(45,147,204,.30),rgba(45,147,204,0) 70%)"></div>
  </div>
  <div class="field" id="field" aria-hidden="true"></div>
  <div class="fv-core">
    <span class="sticker">SELECTED</span>
    <img class="fv-logo" src="<?php echo esc_url( $uri ); ?>/assets/img/asset-03.svg" alt="熊本未来リーダーズ">
  </div>
  <a class="fv-scroll" href="#concept" aria-label="下へスクロール"><span></span><span></span></a>
</section>

<section class="sec concept" id="concept">
  <div class="concept-deco" aria-hidden="true">
    <img loading="lazy" decoding="async" class="cblob cblob1" src="<?php echo esc_url( $uri ); ?>/assets/img/asset-04.svg" alt=""><img loading="lazy" decoding="async" class="cblob cblob2" src="<?php echo esc_url( $uri ); ?>/assets/img/asset-04.svg" alt="">
  </div>
  <div class="inner">
    <div class="c-head reveal">
      <div class="eyebrow">CONCEPT</div>
      <h2>熊本の<span class="hl">未来</span>を創り上げる</h2>
      <div class="rule"></div>
    </div>
    <div class="c-body reveal">
      <p>「熊本未来リーダーズ」は、熊本県において多様な分野で活躍するリーダーたちの姿とその想いを特集しています。地域の発展に貢献し、未来を創造するストーリーを通して、地域社会の可能性や魅力を再発見していただけることを目指しています。</p>
      <span class="c-badge">★ SELECTED STORIES</span>
    </div>
  </div>
</section>

<section class="sec leaders" id="leaders">
  <div class="head reveal">
    <div class="head-main">
      <span class="head-eyebrow">INTERVIEW SERIES ／ 選ばれし熊本の挑戦者たち</span>
      <h2 class="head-title">LEADERS</h2>
      <span class="head-jp">熊本の未来を動かす人々</span>
    </div>
  </div>

  <?php
  $q = new WP_Query( array(
    'post_type'      => 'leader',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
    'no_found_rows'  => true,
  ) );

  if ( $q->have_posts() ) :
    $i = 0;                 // 全体通し番号（色の循環用）
    $per_group = 5;         // 1グループ=5枚
    $group = 0;
    while ( $q->have_posts() ) : $q->the_post();
      $pos = $i % $per_group;

      // グループの開始
      if ( $pos === 0 ) {
        $gc = kml_group_color( $group );
        echo '<div class="group">';
        echo '<div class="group-tag reveal" style="--gc:var(--' . esc_attr( $gc ) . ')"><b>GROUP ' . ( $group + 1 ) . '</b><span></span></div>';
        echo '<div class="grid">';
      }

      // カード
      list( $ccls, $cextra ) = kml_card_color( $i );
      $logo   = kml_field( 'logo' );
      $person = get_the_post_thumbnail_url( get_the_ID(), 'large' );
      $en     = kml_field( 'en_name' );
      $co     = kml_field( 'company' );
      $role   = kml_field( 'role' );
      ?>
      <a class="card reveal" style="--c:var(--<?php echo esc_attr( $ccls ); ?>)<?php echo $cextra; ?>" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>の記事を読む">
        <svg class="bg" viewBox="0 0 300 420" preserveAspectRatio="xMidYMid slice" aria-hidden="true"><circle cx="266" cy="48" r="118" fill="#fff" opacity="0.08"/><circle cx="40" cy="408" r="120" fill="#fff" opacity="0.06"/><path d="M0,34 C70,92 120,162 162,198 S282,226 300,234" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round" opacity="0.8"/></svg>
        <?php if ( $logo ) : ?><img loading="lazy" decoding="async" class="logo" src="<?php echo esc_url( $logo ); ?>" alt=""><?php endif; ?>
        <?php if ( $person ) : ?><img loading="lazy" decoding="async" class="person" src="<?php echo esc_url( $person ); ?>" alt=""><?php endif; ?>
        <div class="info">
          <?php if ( $en ) : ?><div class="rom"><?php echo esc_html( $en ); ?></div><?php endif; ?>
          <div class="name"><?php the_title(); ?></div>
          <?php if ( $co ) : ?><div class="co"><?php echo esc_html( $co ); ?></div><?php endif; ?>
          <?php if ( $role ) : ?><div class="role"><?php echo esc_html( $role ); ?></div><?php endif; ?>
        </div>
      </a>
      <?php
      $i++;
      // グループの終了（5枚たまった or 最後の投稿）
      if ( $i % $per_group === 0 || ! $q->have_posts() ) {
        echo '</div>'; // .grid
        get_template_part( 'template-parts/spot-slider' );
        echo '</div>'; // .group
        $group++;
      }
    endwhile;
    wp_reset_postdata();
  else :
    echo '<p style="text-align:center;color:var(--gray);padding:40px">リーダーがまだ登録されていません。管理画面の「リーダー」から追加してください。</p>';
  endif;
  ?>
</section>

<section class="sec station" id="station"><div class="st2"><div class="st2-card reveal"><svg class="st2-wave" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" aria-hidden="true"><circle cx="50" cy="50" r="10"/><path d="M32,32 A26,26 0 0,1 32,68"/><path d="M68,32 A26,26 0 0,0 68,68"/><path d="M20,20 A42,42 0 0,1 20,80"/><path d="M80,20 A42,42 0 0,0 80,80"/></svg><div class="st2-left"><span class="st2-onair"><i></i>ON AIR</span><a href="https://fm791.jp/" target="_blank" rel="noopener" aria-label="FM791公式サイト"><img loading="lazy" decoding="async" class="st2-fm" src="<?php echo esc_url( $uri ); ?>/assets/img/asset-02.png" alt="FM791 熊本シティエフエム"></a></div><div class="st2-right"><h3 class="st2-name">熊本シティエフエム<em>FM79.1MHz</em></h3><p class="st2-area">熊本市のコミュニティFM・熊本市およびその周辺<br>熊本市中央区辛島町8-23</p><a class="st2-cta" href="https://fm791.jp/" target="_blank" rel="noopener">公式サイトを見る<span>→</span></a></div></div></div></section>

<?php get_footer(); ?>
