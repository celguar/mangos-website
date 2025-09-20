
(function(){
  const tt = document.createElement('div');
  tt.className = 'talent-tt';
  tt.style.display = 'none';
  document.body.appendChild(tt);

  let showTimer = null;
  let anchorEl = null;

  function render(el){
    const title = el.getAttribute('data-tt-title') || '';
    const desc  = el.getAttribute('data-tt-desc')  || '';
    tt.innerHTML = '<h5>'+title+'</h5><p>'+desc+'</p>';
  }

  function placeToTopRight(el){
    const pad = 8;
    const vw = innerWidth;

    const rEl = el.getBoundingClientRect();
    const rTT = tt.getBoundingClientRect();

    let left = rEl.right + pad;
    let top  = rEl.top - rTT.height - pad;

    if (left + rTT.width > vw - 6) left = vw - rTT.width - 6;
    if (left < 6) left = 6;
    if (top < 6) top = rEl.bottom + pad;

    tt.style.left = left + 'px';
    tt.style.top  = top + 'px';
  }

  function show(el){
    anchorEl = el;
    render(el);
    tt.style.display = 'block';
    placeToTopRight(el);
  }

  function hide(){
    clearTimeout(showTimer);
    tt.style.display = 'none';
    anchorEl = null;
  }

  document.addEventListener('mouseover', function(e){
    const el = e.target.closest('.talent-cell[data-tt-title]');
    if (!el) return;
    clearTimeout(showTimer);
    showTimer = setTimeout(function(){ show(el); }, 60);
  });

  document.addEventListener('mouseout', function(e){
    const el = e.target.closest('.talent-cell[data-tt-title]');
    if (!el) return;
    if (!e.relatedTarget || !el.contains(e.relatedTarget)) hide();
  });

  document.addEventListener('scroll', function(){
    if (tt.style.display !== 'none' && anchorEl) placeToTopRight(anchorEl);
  }, {passive:true});

  window.addEventListener('resize', function(){
    if (tt.style.display !== 'none' && anchorEl) placeToTopRight(anchorEl);
  });
})();
