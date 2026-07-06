/* 全ページ共通 — SPハンバーガーメニュー */
(function () {
  var hdr = document.querySelector('.hdr');
  var btn = document.querySelector('.hmb');
  if (!hdr || !btn) return;

  function setOpen(open) {
    hdr.classList.toggle('open', open);
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  }

  btn.addEventListener('click', function (e) {
    e.stopPropagation();
    setOpen(!hdr.classList.contains('open'));
  });

  // メニュー内リンクを押したら閉じる
  hdr.querySelectorAll('.hdr-r a').forEach(function (a) {
    a.addEventListener('click', function () { setOpen(false); });
  });

  // 外側クリック・Escで閉じる
  document.addEventListener('click', function (e) {
    if (hdr.classList.contains('open') && !hdr.contains(e.target)) setOpen(false);
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') setOpen(false);
  });

  // PC幅に戻ったら閉じる
  window.addEventListener('resize', function () {
    if (window.innerWidth > 720) setOpen(false);
  });
})();
