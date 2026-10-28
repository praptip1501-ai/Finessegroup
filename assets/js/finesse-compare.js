/**
 * Finesse Before/After Concrete Grinding Compare Slider
 */
(function() {
  'use strict';

  function initCompare() {
    const range = document.getElementById('cmpRange');
    const before = document.getElementById('cmpBefore');
    const handle = document.getElementById('cmpHandle');
    const pct = document.getElementById('cmpPct');

    if (!range || !before || !handle) return;

    function rng(seed) {
      let s = seed % 2147483647;
      if (s <= 0) s += 2147483646;
      return function() {
        s = (s * 16807) % 2147483647;
        return (s - 1) / 2147483646;
      };
    }

    function blob(r) {
      const p = () => Math.round(30 + r() * 40);
      return `${p()}% ${p()}% ${p()}% ${p()}% / ${p()}% ${p()}% ${p()}% ${p()}%`;
    }

    // Procedural stone aggregate generation
    function genStones(seed, scale) {
      const r = rng(seed);
      const pal = ['#6f675d', '#4d4843', '#8f8474', '#3a3633', '#a99d8a', '#7d7366', '#c2b8a6', '#58504a', '#d3cbbd'];
      const out = [];
      const add = (n, min, max, alpha) => {
        for (let k = 0; k < n; k++) {
          const w = (min + r() * (max - min)) * scale;
          const h = w * (0.6 + r() * 0.4);
          const c = pal[Math.floor(r() * pal.length)];
          out.push(`<span style="position: absolute; left: ${(r() * 100).toFixed(2)}%; top: ${(r() * 100).toFixed(2)}%; width: ${w.toFixed(1)}px; height: ${h.toFixed(1)}px; background: ${c}; opacity: ${alpha}; border-radius: ${blob(r)}; transform: translate(-50%,-50%) rotate(${Math.round(r() * 180)}deg)"></span>`);
        }
      };
      add(150, 9, 28, 1);
      add(380, 1.6, 4.5, 0.9);
      return out.join('');
    }

    // Procedural glue/adhesive residue generation
    function genResidue(seed, scale) {
      const r = rng(seed);
      const out = [];
      for (let k = 0; k < 11; k++) {
        const w = (70 + r() * 150) * scale;
        out.push(`<span style="position: absolute; left: ${(r() * 100).toFixed(1)}%; top: ${(r() * 100).toFixed(1)}%; width: ${w.toFixed(0)}px; height: ${(w * (0.5 + r() * 0.5)).toFixed(0)}px; background: rgba(201,182,128,${(0.45 + r() * 0.3).toFixed(2)}); border-radius: ${blob(r)}; transform: translate(-50%,-50%)"></span>`);
      }
      for (let k = 0; k < 5; k++) {
        const w = (120 + r() * 140) * scale;
        out.push(`<span style="position: absolute; left: ${(r() * 100).toFixed(1)}%; top: ${(r() * 100).toFixed(1)}%; width: ${w.toFixed(0)}px; height: ${(w * 0.6).toFixed(0)}px; background: repeating-linear-gradient(${Math.round(20 + r() * 40)}deg, rgba(24,22,20,.62) 0 3px, transparent 3px 11px); border-radius: ${blob(r)}; transform: translate(-50%,-50%)"></span>`);
      }
      return out.join('');
    }

    const cmpStonesEl = document.getElementById('cmpStones');
    if (cmpStonesEl) cmpStonesEl.innerHTML = genStones(2024, 1.5);

    const cmpRawEl = document.getElementById('cmpRaw');
    if (cmpRawEl) cmpRawEl.innerHTML = genResidue(909, 1.8);

    function updateSlider(val) {
      const rightCut = 100 - val;
      before.style.clipPath = `inset(0 ${rightCut}% 0 0)`;
      handle.style.left = val + '%';
      if (pct) pct.textContent = rightCut;
    }

    range.addEventListener('input', function() {
      updateSlider(Number(this.value));
    });

    updateSlider(Number(range.value || 50));
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCompare);
  } else {
    initCompare();
  }
})();
