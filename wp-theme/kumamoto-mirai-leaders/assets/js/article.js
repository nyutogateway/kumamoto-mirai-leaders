/* 記事ページ: reveal監視 ＋ 画像のなめらか追従（元 article.html インラインJS） */
(function(){
  var els=document.querySelectorAll('.reveal');
  if(!('IntersectionObserver' in window)){els.forEach(function(e){e.classList.add('in');});return;}
  var io=new IntersectionObserver(function(ents){ents.forEach(function(x){if(x.isIntersecting){x.target.classList.add('in');io.unobserve(x.target);}});},{threshold:.12,rootMargin:'0px 0px -8% 0px'});
  els.forEach(function(e){io.observe(e);});
})();

/* 画像のなめらかスクロール追従（PC・モーション許可時のみ。非対応時はCSSのstickyにフォールバック） */
(function(){
  var reduce=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if(reduce) return;
  var mq=window.matchMedia('(min-width:721px)');
  var GAP=24, EASE=.06, FLOAT_AMP=7, FLOAT_SPEED=2600, items=[], raf=null;
  var HDR=document.querySelector('.hdr');
  function teardown(){
    if(raf){cancelAnimationFrame(raf);raf=null;}
    items.forEach(function(it){var s=it.spic.style;s.position='';s.top='';s.transform='';s.willChange='';});
    items=[];
  }
  function setup(){
    teardown();
    if(!mq.matches) return;
    document.querySelectorAll('.cols .pic').forEach(function(pic){
      var spic=pic.querySelector('.spic');
      if(!spic) return;
      var s=spic.style;s.position='relative';s.top='0';s.willChange='transform';
      items.push({pic:pic,spic:spic,cur:0,phase:items.length*1.7});
    });
    if(items.length) raf=requestAnimationFrame(loop);
  }
  function loop(now){
    var clear=(HDR?HDR.offsetHeight:96)+GAP;
    items.forEach(function(it){
      var top=it.pic.getBoundingClientRect().top;
      var max=Math.max(0,it.pic.offsetHeight-it.spic.offsetHeight);
      var target=Math.min(Math.max(clear-top,0),max);
      it.cur+=(target-it.cur)*EASE;
      var float=Math.sin(now/FLOAT_SPEED+it.phase)*FLOAT_AMP;
      var y=Math.min(it.cur+float,max);
      it.spic.style.transform='translateY('+y.toFixed(2)+'px)';
    });
    raf=requestAnimationFrame(loop);
  }
  var rt;
  window.addEventListener('resize',function(){clearTimeout(rt);rt=setTimeout(setup,200);});
  setup();
})();
