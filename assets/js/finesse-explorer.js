/**
 * Finesse 3D Interactive Concrete Explorer Component
 */
(function() {
  'use strict';

  class DCLogic {
    constructor(props) { this.props = props || {}; }
    setState(u) {
      const next = typeof u === 'function' ? u(this.state) : u;
      Object.assign(this.state, next);
      schedule();
    }
  }

  class Component extends DCLogic {
    constructor(...args) {
      super(...args);
      this.state = { intro: false, i: 0, step: 4, swap: 'swapA', stepSwap: 'stepA', cmp: 50, playing: false };
      this.timer = null;
      this._c = {};
      this.spin = 0;
      this.drag = null;
      this.stage = null;
      this.stageRef = (el) => { this.stage = el; };
      this.heroRef = (el) => { this.hero = el; };
      this.replay = () => {
        clearTimeout(this.introT);
        this.setState({ intro: false });
        this.introT = setTimeout(() => this.setState({ intro: true }), 80);
      };
      this.videoRef = (el) => {
        if (!el || el === this.video) return;
        this.video = el;
        el.muted = true; el.defaultMuted = true; el.loop = true; el.playsInline = true;
        el.setAttribute('playsinline', ''); el.setAttribute('muted', '');
        try { const pr = el.play(); if (pr && pr.catch) pr.catch(() => {}); } catch (err) {}
      };
      this.setVar = (k, v) => { if (this.stage) this.stage.style.setProperty(k, v); };
      this.onMove = (e) => {
        if (!this.stage) return;
        const r = this.stage.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width;
        const y = (e.clientY - r.top) / r.height;
        if (this.drag) {
          this.spin = this.drag.spin + (e.clientX - this.drag.x) * 0.4;
          this.setVar('--spin', this.spin.toFixed(1) + 'deg');
        }
        this.setVar('--tx', (x - 0.5).toFixed(3));
        this.setVar('--ty', (y - 0.5).toFixed(3));
        this.setVar('--mx', (x * 100).toFixed(1) + '%');
        this.setVar('--my', (y * 100).toFixed(1) + '%');
      };
      this.onDown = (e) => {
        if (e.target && e.target.closest && e.target.closest('button')) return;
        this.drag = { x: e.clientX, spin: this.spin };
        if (this.stage) this.stage.style.cursor = 'grabbing';
        try { e.currentTarget.setPointerCapture(e.pointerId); } catch (err) {}
      };
      this.onUp = () => {
        this.drag = null;
        if (this.stage) this.stage.style.cursor = '';
      };
      this.onLeave = () => {
        this.onUp();
        this.setVar('--tx', '0');
        this.setVar('--ty', '0');
      };
      this.turn = () => {
        this.spin += 45;
        this.setVar('--spin', this.spin + 'deg');
      };
      this.onCmp = (e) => this.setState({ cmp: Number(e.target.value) });
      this.stopPlay = () => { if (this.timer) { clearInterval(this.timer); this.timer = null; } };
      this.setStep = (n) => this.setState((st) => ({ step: n, stepSwap: st.stepSwap === 'stepA' ? 'stepB' : 'stepA' }));
      this.play = () => {
        if (this.timer) { this.stopPlay(); this.setState({ playing: false }); return; }
        this.setStep(0);
        this.setState({ playing: true });
        this.timer = setInterval(() => {
          const n = this.state.step + 1;
          if (n > 4) { this.stopPlay(); this.setState({ playing: false }); return; }
          this.setStep(n);
        }, 1700);
      };
    }

    componentDidMount() {
      this.introT = setTimeout(() => this.setState({ intro: true }), 350);
      if (typeof IntersectionObserver !== 'undefined' && this.hero) {
        let wasOut = false;
        this.io = new IntersectionObserver((entries) => {
          entries.forEach((en) => {
            if (en.intersectionRatio < 0.15) wasOut = true;
            else if (en.intersectionRatio > 0.6 && wasOut) { wasOut = false; this.replay(); }
          });
        }, { threshold: [0, 0.15, 0.6, 1] });
        this.io.observe(this.hero);
      }
    }

    componentWillUnmount() { this.stopPlay(); clearTimeout(this.introT); if (this.io) this.io.disconnect(); }

    rng(seed) {
      let s = seed % 2147483647;
      if (s <= 0) s += 2147483646;
      return () => { s = (s * 16807) % 2147483647; return (s - 1) / 2147483646; };
    }

    memo(key, fn) {
      if (!this._c[key]) this._c[key] = fn();
      return this._c[key];
    }

    blob(r) {
      const p = () => Math.round(30 + r() * 40);
      return `${p()}% ${p()}% ${p()}% ${p()}% / ${p()}% ${p()}% ${p()}% ${p()}%`;
    }

    stones(mode, seed, scale) {
      return this.memo('st-' + mode + seed + scale, () => {
        const r = this.rng(seed);
        const pal = ['#6f675d', '#4d4843', '#8f8474', '#3a3633', '#a99d8a', '#7d7366', '#c2b8a6', '#58504a', '#d3cbbd'];
        const out = [];
        const add = (n, min, max, alpha) => {
          for (let k = 0; k < n; k++) {
            const w = (min + r() * (max - min)) * scale;
            const h = w * (0.6 + r() * 0.4);
            const c = pal[Math.floor(r() * pal.length)];
            out.push({ st: `left: ${(r() * 100).toFixed(2)}%; top: ${(r() * 100).toFixed(2)}%; width: ${w.toFixed(1)}px; height: ${h.toFixed(1)}px; background: ${c}; opacity: ${alpha}; border-radius: ${this.blob(r)}; transform: translate(-50%,-50%) rotate(${Math.round(r() * 180)}deg)` });
          }
        };
        if (mode === 'cream') add(300, 1, 2.6, 0.55);
        if (mode === 'salt') { add(520, 1.6, 5, 0.85); add(160, 1, 2, 0.6); }
        if (mode === 'full') { add(150, 9, 28, 1); add(380, 1.6, 4.5, 0.9); }
        return out;
      });
    }

    flakes(idx) {
      return this.memo('fl-' + idx, () => {
        const r = this.rng(97 + idx * 13);
        const pals = [
          ['#1a1a1a', '#f2f0eb', '#8d8a85', '#5d5a55', '#bdb9b2'],
          ['#22262a', '#e9ecef', '#6b7680', '#a9b2ba', '#3d454d'],
          ['#6b5844', '#efe6d8', '#b39e80', '#3d342b', '#d6c4a6']
        ];
        const pal = pals[idx] || pals[0];
        const out = [];
        for (let k = 0; k < 520; k++) {
          const w = 4 + r() * 8;
          const h = 3 + r() * 6;
          out.push({ st: `left: ${(r() * 102 - 1).toFixed(2)}%; top: ${(r() * 102 - 1).toFixed(2)}%; width: ${w.toFixed(1)}px; height: ${h.toFixed(1)}px; background: ${pal[Math.floor(r() * pal.length)]}; border-radius: 1px ${Math.round(r() * 4)}px 1px ${Math.round(r() * 3)}px; transform: rotate(${Math.round(r() * 180)}deg)` });
        }
        return out;
      });
    }

    blockShapes() {
      return this.memo('blocks', () => {
        const r = this.rng(4242);
        const out = [];
        const S = 500;
        const gap = 5;
        let y = -10;
        while (y < S) {
          const h = 46 + r() * 50;
          let x = -10 - r() * 40;
          while (x < S) {
            const w = 54 + r() * 110;
            out.push({ x: x / S * 100, y: y / S * 100, w, h, b: (0.88 + r() * 0.22).toFixed(2), rad: this.blob(r) });
            x += w + gap;
          }
          y += h + gap;
        }
        return out;
      });
    }

    blotches() {
      return this.memo('blot', () => {
        const r = this.rng(777);
        const out = [];
        for (let k = 0; k < 26; k++) {
          const w = 120 + r() * 260;
          const light = r() > 0.45;
          const c = light ? `rgba(255,255,255,${(0.14 + r() * 0.16).toFixed(2)})` : `rgba(40,34,28,${(0.06 + r() * 0.08).toFixed(2)})`;
          out.push({ st: `left: ${(r() * 100).toFixed(1)}%; top: ${(r() * 100).toFixed(1)}%; width: ${w.toFixed(0)}px; height: ${(w * (0.35 + r() * 0.4)).toFixed(0)}px; background: radial-gradient(closest-side, ${c}, transparent); transform: translate(-50%,-50%) rotate(${Math.round(r() * 180)}deg)` });
        }
        return out;
      });
    }

    residue(seed, scale) {
      return this.memo('res-' + seed + scale, () => {
        const r = this.rng(seed);
        const out = [];
        for (let k = 0; k < 11; k++) {
          const w = (70 + r() * 150) * scale;
          out.push({ st: `left: ${(r() * 100).toFixed(1)}%; top: ${(r() * 100).toFixed(1)}%; width: ${w.toFixed(0)}px; height: ${(w * (0.5 + r() * 0.5)).toFixed(0)}px; background: rgba(201,182,128,${(0.45 + r() * 0.3).toFixed(2)}); border-radius: ${this.blob(r)}; transform: translate(-50%,-50%)` });
        }
        for (let k = 0; k < 5; k++) {
          const w = (120 + r() * 140) * scale;
          out.push({ st: `left: ${(r() * 100).toFixed(1)}%; top: ${(r() * 100).toFixed(1)}%; width: ${w.toFixed(0)}px; height: ${(w * 0.6).toFixed(0)}px; background: repeating-linear-gradient(${Math.round(20 + r() * 40)}deg, rgba(24,22,20,.62) 0 3px, transparent 3px 11px); border-radius: ${this.blob(r)}; transform: translate(-50%,-50%)` });
        }
        for (let k = 0; k < 6; k++) {
          const w = (40 + r() * 110) * scale;
          out.push({ st: `left: ${(r() * 100).toFixed(1)}%; top: ${(r() * 100).toFixed(1)}%; width: ${w.toFixed(0)}px; height: ${(w * (0.4 + r() * 0.6)).toFixed(0)}px; background: rgba(238,235,228,${(0.5 + r() * 0.3).toFixed(2)}); border-radius: ${this.blob(r)}; transform: translate(-50%,-50%)` });
        }
        for (let k = 0; k < 7; k++) {
          const w = (90 + r() * 200) * scale;
          out.push({ st: `left: ${(r() * 100).toFixed(1)}%; top: ${(r() * 100).toFixed(1)}%; width: ${w.toFixed(0)}px; height: ${w.toFixed(0)}px; background: radial-gradient(closest-side, rgba(40,36,30,.35), transparent); transform: translate(-50%,-50%)` });
        }
        return out;
      });
    }

    swirls() {
      return this.memo('sw', () => {
        const r = this.rng(31337);
        const out = [];
        for (let k = 0; k < 12; k++) {
          const w = 200 + r() * 160;
          out.push({ st: `left: ${(r() * 100).toFixed(1)}%; top: ${(r() * 100).toFixed(1)}%; width: ${w.toFixed(0)}px; height: ${w.toFixed(0)}px; border-radius: 50%; background: repeating-radial-gradient(circle, transparent 0 5px, rgba(255,255,255,.09) 5px 6px, transparent 6px 9px, rgba(0,0,0,.05) 9px 10px); transform: translate(-50%,-50%)` });
        }
        return out;
      });
    }

    shade(hex, amt) {
      if (!hex || hex[0] !== '#') return hex;
      const n = parseInt(hex.slice(1), 16);
      const f = (v) => Math.max(0, Math.min(255, Math.round(v + (amt < 0 ? v * amt : (255 - v) * amt))));
      const rr = f(n >> 16), gg = f((n >> 8) & 255), bb = f(n & 255);
      return '#' + ((1 << 24) + (rr << 16) + (gg << 8) + bb).toString(16).slice(1);
    }

    services() {
      if (window.FINESSE_SERVICES && Array.isArray(window.FINESSE_SERVICES) && window.FINESSE_SERVICES.length > 0) {
        return window.FINESSE_SERVICES;
      }
      return [
        { id: 'polished', short: 'Polished Concrete', word: 'Polished', tag: 'The slab becomes the floor', name: 'Mechanical Polished Concrete',
          desc: 'Concrete progressively ground, honed and polished — the finish is part of the slab, not a coating on top. Tailored by how much aggregate shows and how much it shines.',
          best: ['High-end homes', 'Retail', 'Showrooms', 'Offices', 'Restaurants', 'Warehouses'],
          specs: [{ k: 'Maintenance', v: 'Very low. Vacuum and damp-mop with a neutral cleaner — no sealer layer to replace.' }, { k: 'Durability', v: 'Handles heavy foot traffic and can last for decades.' }, { k: 'Finish options', v: 'Cream through to full aggregate; matte, satin or high gloss.' }],
          base: '#958F85',
          steps: [
            { t: 'Assess & prepare', d: 'We inspect the slab, flag repairs or contaminants, and agree on aggregate exposure and finish.', look: 'raw', sheen: 0 },
            { t: 'Grind & flatten', d: 'Industrial diamond tooling, in stages, exposes the aggregate and flattens the surface.', look: 'ground', sheen: 0.04 },
            { t: 'Refine', d: 'Progressively finer diamond grits remove the scratches left by earlier passes.', look: 'full', sheen: 0.22 },
            { t: 'Densify & polish', d: 'A densifier hardens the surface, then we polish to your chosen sheen.', look: 'full', sheen: 0.6 },
            { t: 'Protect & finish', d: 'Final polishing passes and a protective treatment complete the floor.', look: 'full', sheen: 0.95 }
          ] },
        { id: 'seal', short: 'Grind & Seal', word: 'Sealed', tag: 'Natural character, clear sealed', name: 'Grind & Seal Concrete',
          desc: 'Grinding reveals the natural character of the concrete, finished with a clear protective sealer — a cost-effective alternative to full mechanical polishing.',
          best: ['Homes', 'Garages', 'Retail', 'Cafés', 'Showrooms', 'Light commercial'],
          specs: [{ k: 'Maintenance', v: 'Vacuum and mop. The sealer resists stains and can be recoated over time.' }, { k: 'Durability', v: 'Durable with the right sealer — and refreshable without replacing the floor.' }, { k: 'Finish options', v: 'Light grind to full exposure; matte, satin or gloss sealer.' }],
          base: '#A19B91',
          steps: [
            { t: 'Assess & prepare', d: 'We inspect the concrete, identify repairs and agree on exposure level and appearance.', look: 'raw', sheen: 0 },
            { t: 'Grind', d: 'Industrial diamond tooling removes the surface layer to reveal the aggregate.', look: 'ground', sheen: 0.04 },
            { t: 'Refine & repair', d: 'Heavy grind marks are refined out; cracks, holes and imperfections repaired.', look: 'salt', sheen: 0.08 },
            { t: 'Clean & prepare', d: 'A thorough clean so the sealer bonds properly and finishes evenly.', look: 'salt', sheen: 0.12 },
            { t: 'Seal & protect', d: 'A protective sealer in matte, satin or gloss guards against stains and wear.', look: 'salt', sheen: 0.55 }
          ] },
        { id: 'micro', short: 'Micro Cement', word: 'Micro', tag: 'Seamless, hand-applied', name: 'Micro Cement',
          desc: 'A decorative finish hand-applied in thin layers over floors, walls and existing surfaces — seamless, with natural movement, and no tiles or heavy demolition.',
          best: ['Bathrooms', 'Floors', 'Feature walls', 'Fireplaces', 'Kitchens', 'Laundries'],
          specs: [{ k: 'Maintenance', v: 'Mild cleaning products; a high-performance sealer guards against stains and moisture.' }, { k: 'Durability', v: 'Strong for daily residential and commercial use over a properly prepared substrate.' }, { k: 'Finish options', v: 'A wide range of colours and textures, from soft concrete looks to pronounced trowel marks.' }],
          base: '#C2B9AB',
          steps: [
            { t: 'Assess & prepare', d: 'We inspect the substrate, confirm it is suitable and complete any repairs.', look: 'raw', sheen: 0 },
            { t: 'Prime & reinforce', d: 'Primer and reinforcement create a stable base for the system.', look: 'solid', solid: '#9C978E', sheen: 0.05 },
            { t: 'Base coats', d: 'Hand-applied base coats build strength and level the surface.', look: 'solid', solid: '#B3AA9C', sheen: 0.05 },
            { t: 'Finish coats', d: 'Fine finish coats are hand-trowelled for colour, texture and movement.', look: 'micro', sheen: 0.12 },
            { t: 'Seal & protect', d: 'A high-performance sealer resists moisture, stains and wear.', look: 'micro', sheen: 0.38 }
          ] },
        { id: 'epoxy', short: 'Epoxy & Flake', word: 'Epoxy', tag: 'Seamless and hard-wearing', name: 'Epoxy & Flake Flooring',
          desc: 'Seamless, hard-wearing epoxy systems — from solid colours to full decorative flake under a clear protective topcoat — for demanding spaces.',
          best: ['Garages', 'Workshops', 'Warehouses', 'Commercial kitchens', 'Showrooms', 'Plant rooms'],
          specs: [{ k: 'Maintenance', v: 'Few gaps for dirt to collect — sweep, vacuum, mop or wash.' }, { k: 'Durability', v: 'Resists abrasion, impact, staining and wear; specified from home garage to industrial.' }, { k: 'Finish options', v: 'Solid colours or decorative flake blends, with slip-resistance to suit.' }],
          base: '#6F6C68',
          steps: [
            { t: 'Assess & prepare', d: 'We check for coatings, contamination and cracks, and choose the right system.', look: 'raw', sheen: 0 },
            { t: 'Mechanically grind', d: 'Diamond grinding removes contaminants and profiles the slab so the coating bonds.', look: 'ground', sheen: 0.04 },
            { t: 'Repair & prime', d: 'Cracks and holes are filled, then primed for a consistent base.', look: 'solid', solid: '#8E8A84', sheen: 0.2 },
            { t: 'Apply epoxy & flake', d: 'The epoxy base coat goes down and decorative flake is broadcast evenly.', look: 'flake', sheen: 0.25 },
            { t: 'Seal & protect', d: 'Excess flake removed, then a protective topcoat with the right slip resistance.', look: 'flake', sheen: 0.7 }
          ] },
        { id: 'resin', short: 'Spray Resin', word: 'Resin', tag: 'Outdoor resurfacing', name: 'Spray Resin',
          desc: 'Decorative resurfacing that renews existing outdoor concrete with a durable, customisable finish — without the cost of removal and replacement.',
          best: ['Driveways', 'Pathways', 'Patios', 'Pool surrounds', 'Entertaining areas', 'Entrances'],
          specs: [{ k: 'Maintenance', v: 'Sweep and occasionally pressure wash. It can be refreshed down the track.' }, { k: 'Durability', v: 'Built for harsh outdoor conditions, foot and vehicle traffic.' }, { k: 'Finish options', v: 'Colours, stencil patterns and multi-colour designs; slip-resistant options.' }],
          base: '#BCA888',
          steps: [
            { t: 'Assess & prepare', d: 'We inspect for cracks, damage, contamination and previous coatings.', look: 'raw', sheen: 0 },
            { t: 'Mechanically prepare', d: 'The surface is cleaned and mechanically prepared to a sound base.', look: 'ground', sheen: 0.03 },
            { t: 'Repair & base coat', d: 'Cracks and defects are repaired, then the base system is applied.', look: 'solid', solid: '#B4A386', sheen: 0.05 },
            { t: 'Apply decorative finish', d: 'Your colour, pattern and texture go on — including custom designs.', look: 'resin', sheen: 0.06 },
            { t: 'Seal & protect', d: 'Sealed for stain and weather resistance, with slip resistance where needed.', look: 'resin', sheen: 0.28 }
          ] },
        { id: 'prep', short: 'Prep Grinding', word: 'Prep', tag: 'The foundation of every floor', name: 'Concrete Preparation Grinding',
          desc: 'Mechanical grinding that removes adhesives, tile glue, membranes, coatings, paint and laitance — creating the profile your next flooring system needs.',
          best: ['Commercial fit-outs', 'Warehouses', 'Retail', 'Industrial', 'New builds', 'Renovations'],
          specs: [{ k: 'Dust control', v: 'Grinders paired with H-class/HEPA extraction for a cleaner, safer site.' }, { k: 'Equipment', v: 'Compact grinders for tight access through to remote-control machines for large floors.' }, { k: 'The result', v: 'A clean substrate ready for epoxy, waterproofing, levelling, tiles, vinyl or coatings.' }],
          base: '#A39E95',
          steps: [
            { t: 'Assess the substrate', d: 'We identify coatings, adhesives, membranes and defects, and set the preparation level.', look: 'raw', sheen: 0 },
            { t: 'Select tooling', d: 'Diamond tooling and machinery are matched to the substrate and target profile.', look: 'raw', sheen: 0 },
            { t: 'Mechanically grind', d: 'Coatings, adhesives, membranes and laitance are removed to a consistent profile.', look: 'ground', sheen: 0.03 },
            { t: 'Detail & edge work', d: 'Edges, corners and tight areas are prepared with specialised equipment.', look: 'ground', sheen: 0.04 },
            { t: 'Clean & ready', d: 'Vacuumed with H-class/HEPA extraction, ready for the next system.', look: 'ground', sheen: 0.1 }
          ] }
      ];
    }

    renderVals() {
      const motion = this.props.motion ?? true;
      const accent = this.props.accent ?? '#FFFFFF';
      const S = this.memo('svc', () => this.services());
      const { i, step, swap, stepSwap, cmp, playing } = this.state;
      const cur = S[i];
      const st = cur.steps[step];
      const look = st.look;
      const isAgg = look === 'cream' || look === 'salt' || look === 'full';
      const base = look === 'raw' ? '#7F7A71' : look === 'ground' ? '#A39E95' : look === 'solid' ? (st.solid || '#9C978E') : cur.base;
      const nextSwap = swap === 'swapA' ? 'swapB' : 'swapA';
      const go = (n) => {
        this.stopPlay();
        this.setState({ i: (n + S.length) % S.length, step: 4, swap: nextSwap, playing: false });
      };
      const noiseOp = { raw: 0.6, ground: 0.5, solid: 0.15, cream: 0.32, salt: 0.32, full: 0.32, micro: 0.22, flake: 0.18, resin: 0.6 }[look] || 0.3;

      const lines = {
        polished: 'Durable, low-maintenance polished finishes for homes, retail, offices and commercial spaces.',
        seal: 'Natural concrete character under a durable protective sealer — a cost-effective finish.',
        micro: 'Seamless, hand-applied finishes for floors, walls, bathrooms, fireplaces and feature surfaces.',
        epoxy: 'Hard-wearing, seamless systems for garages, workshops, commercial and industrial spaces.',
        resin: 'Decorative resurfacing for driveways, paths, patios and outdoor areas.',
        prep: 'Grinding away adhesives, membranes and coatings to prepare for new flooring.'
      };

      return {
        accent,
        rootClass: motion ? 'fin fx' : 'fin',
        swap,
        stepSwap,
        cur,
        curStep: st,
        stepNum: String(step + 1).padStart(2, '0'),
        num: String(i + 1).padStart(2, '0'),
        faceLabel: `${cur.name}: ${st.t}`,
        faceBg: look === 'resin' ? this.shade(base, -0.42) : base,
        edge: this.shade(base, -0.22),
        edge2: this.shade(base, -0.36),
        isAgg,
        isMicro: look === 'micro',
        isFlake: look === 'flake',
        isResin: look === 'resin',
        isRaw: look === 'raw',
        isGround: look === 'ground',
        stones: isAgg ? this.stones(look, 11 + i, 1) : [],
        blotches: look === 'micro' ? this.blotches() : [],
        flakes: look === 'flake' ? this.flakes(0) : [],
        blocks: look === 'resin' ? this.blockShapes().map((k) => ({ st: `left: ${k.x.toFixed(2)}%; top: ${k.y.toFixed(2)}%; width: ${k.w.toFixed(0)}px; height: ${k.h.toFixed(0)}px; background: ${base}; filter: brightness(${k.b}); border-radius: 3px` })) : [],
        residue: look === 'raw' ? this.residue(555, 1) : [],
        swirls: look === 'ground' ? this.swirls() : [],
        noiseOp,
        sheenOp: st.sheen,
        bestList: cur.best.map((t, j) => ({ t, d: (0.05 * j).toFixed(2) })),
        specs: cur.specs || [],
        stepList: cur.steps.map((p, j) => ({
          n: String(j + 1).padStart(2, '0'), t: p.t,
          pressed: j === step ? 'true' : 'false',
          fill: j <= step ? 1 : 0,
          numSt: j === step ? `color: ${accent}` : 'color: #6B6B6B',
          tSt: j === step ? 'color: #FFFFFF' : 'color: #8E8E8E',
          pick: () => { this.stopPlay(); this.setState({ playing: false }); this.setStep(j); }
        })),
        playing,
        notPlaying: !playing,
        play: this.play,
        selList: S.map((s, j) => ({
          id: s.id, short: s.short, pressed: j === i ? 'true' : 'false',
          st: j === i ? 'color: #FFFFFF; border-top: 2px solid #FFFFFF' : '',
          pick: () => { if (j !== i) go(j); }
        })),
        ovList: S.map((s, j) => ({
          id: s.id, n: String(j + 1).padStart(2, '0'), name: s.name, line: s.tag || s.desc || lines[s.id],
          pick: () => go(j)
        })),
        prev: () => go(i - 1),
        next: () => go(i + 1),
        turn: this.turn,
        stageRef: this.stageRef,
        videoRef: this.videoRef,
        heroRef: this.heroRef,
        replay: this.replay,
        heroClass: this.state.intro ? 'go' : '',
        onMove: this.onMove,
        onDown: this.onDown,
        onUp: this.onUp,
        onLeave: this.onLeave,
        cmp,
        cmpRight: 100 - cmp,
        polishedPct: 100 - cmp,
        onCmp: this.onCmp,
        cmpStones: this.stones('full', 2024, 1.5),
        cmpRaw: this.residue(909, 1.8)
      };
    }
  }

  const $ = (id) => document.getElementById(id);
  const esc = (t) => String(t).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  const c = new Component({});
  let vals = null;
  let lastKey = '';
  let lastSvc = -1;
  let queued = false;

  function schedule() {
    if (queued) return;
    queued = true;
    requestAnimationFrame(() => { queued = false; render(); });
  }

  const spans = (list) => list.map((s) => `<span style="position: absolute; ${s.st}"></span>`).join('');
  const arrow = '<svg width="22" height="22" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M1 8h13M9 3l5 5-5 5"></path></svg>';

  function faceHTML(v) {
    let h = '';
    if (v.isAgg) h += spans(v.stones);
    if (v.isMicro) {
      h += '<svg aria-hidden="true" width="100%" height="100%" style="position: absolute; inset: 0; mix-blend-mode: soft-light; opacity: .9"><filter id="fz-cloud"><feTurbulence type="fractalNoise" baseFrequency="0.006 0.011" numOctaves="4" seed="7"></feTurbulence><feColorMatrix type="saturate" values="0"></feColorMatrix></filter><rect width="100%" height="100%" filter="url(#fz-cloud)"></rect></svg>';
      h += spans(v.blotches);
    }
    if (v.isFlake) h += spans(v.flakes);
    if (v.isResin) h += spans(v.blocks);
    if (v.isRaw) h += spans(v.residue);
    if (v.isGround) h += spans(v.swirls);
    h += `<svg aria-hidden="true" width="100%" height="100%" style="position: absolute; inset: 0; mix-blend-mode: multiply; opacity: ${v.noiseOp}"><filter id="fz-noise"><feTurbulence type="fractalNoise" baseFrequency="0.85" numOctaves="3" stitchTiles="stitch"></feTurbulence><feColorMatrix type="saturate" values="0"></feColorMatrix></filter><rect width="100%" height="100%" filter="url(#fz-noise)"></rect></svg>`;
    h += `<span class="gloss" style="opacity: ${v.sheenOp}"></span><span class="plight"></span>`;
    return h;
  }

  function render() {
    const v = c.renderVals();
    vals = v;

    const key = [c.state.i, c.state.step, c.state.playing].join('-');
    if (key !== lastKey) {
      lastKey = key;
      const svcChanged = c.state.i !== lastSvc;
      lastSvc = c.state.i;

      const tabsEl = $('tabs');
      if (tabsEl) {
        tabsEl.innerHTML = v.selList.map((s, j) => `<button type="button" class="tab ${s.pressed === 'true' ? 'is-active' : ''}" data-act="svc" data-i="${j}" aria-pressed="${s.pressed}" style="${s.st}"><span class="sw sw-${s.id}" aria-hidden="true"></span><span class="tn">${esc(s.short)}</span></button>`).join('');
      }

      const face = $('face');
      if (face) {
        face.innerHTML = faceHTML(v);
        face.className = 'face ' + v.stepSwap;
        face.style.background = v.faceBg;
        face.setAttribute('aria-label', v.faceLabel);
      }

      const edgeB = $('edgeB');
      if (edgeB) edgeB.style.background = v.edge;
      const edgeR = $('edgeR');
      if (edgeR) edgeR.style.background = v.edge2;

      const ovl = $('ovl');
      if (ovl) {
        ovl.innerHTML = `
          <p class="txtin" style="margin: 0; line-height: 1"><span style="font-family: 'Barlow Condensed', sans-serif; font-size: 96px; font-weight: 600; color: ${v.accent}">${v.num}</span><span style="font-size: 14px; color: #8E8E8E"> / 06</span></p>
          <p class="txtin" style="margin: 12px 0 0; font-size: 22px; font-weight: 500; line-height: 1.2">${esc(v.cur.name)}</p>
          <p class="cap txtin" style="margin: 10px 0 0; color: #A3A3A3">${esc(v.cur.tag)}</p>
          <div class="stagechip"><span style="color: #A3A3A3">Stage</span><span class="${v.stepSwap} chipin" style="font-weight: 600">${v.stepNum} · ${esc(v.curStep.t)}</span></div>
          <div><button type="button" class="pill" data-act="turn" style="margin-top: 14px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M20 12a8 8 0 1 1-2.3-5.7M20 4v5h-5"></path></svg>${esc((window.FINESSE_LABELS && window.FINESSE_LABELS.turn) || 'Turn sample')}</button></div>`;
      }

      const stepText = $('stepText');
      if (stepText) stepText.textContent = v.curStep.d;
      const stepDetail = $('stepDetail');
      if (stepDetail) stepDetail.className = 'g-stepdetail ' + v.stepSwap;

      const stepsEl = $('steps');
      if (stepsEl) {
        stepsEl.innerHTML = v.stepList.map((p, j) => `<button type="button" class="stepbtn" data-act="step" data-i="${j}" aria-pressed="${p.pressed}"><span class="bar2"><span class="fill" style="transform: scaleX(${p.fill})"></span></span><span style="font-family: 'Barlow Condensed', sans-serif; font-size: 32px; font-weight: 600; line-height: 1; ${p.numSt}">${p.n}</span><span style="font-size: 15px; font-weight: 500; ${p.tSt}">${esc(p.t)}</span></button>`).join('');
      }

      const playBtn = $('playBtn');
      if (playBtn) {
        playBtn.innerHTML = v.playing
          ? '<svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><rect x="3" y="2" width="3.5" height="12"></rect><rect x="9.5" y="2" width="3.5" height="12"></rect></svg>Pause'
          : '<svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M4 2l10 6-10 6z"></path></svg>Play the process';
      }

      if (svcChanged) {
        const stage = $('stage');
        if (stage) stage.className = 'stage ' + v.swap;
        const bgword = $('bgword');
        if (bgword) bgword.textContent = v.cur.word;
        const best = $('best');
        if (best) best.innerHTML = v.bestList.map((b) => `<span class="tag txtin" style="animation-delay: ${b.d}s">${esc(b.t)}</span>`).join('');
        const infoWrap = $('infoWrap');
        if (infoWrap) infoWrap.className = v.swap;
        const infoName = $('infoName');
        if (infoName) infoName.textContent = v.cur.name;
        const infoDesc = $('infoDesc');
        if (infoDesc) infoDesc.textContent = v.cur.desc;
        const procName = $('procName');
        if (procName) procName.textContent = 'Our process — ' + v.cur.name;

        const specs = $('specs');
        if (specs && v.specs) {
          specs.className = 'g-spec ' + v.swap;
          specs.innerHTML = v.specs.map((x) => `<div class="txtin"><p class="cap" style="margin: 0 0 10px; color: #A3A3A3">${esc(x.k)}</p><p style="margin: 0; font-size: 17px; line-height: 1.55">${esc(x.v)}</p></div>`).join('');
        }
      }
    }
  }

  function initExplorer() {
    const ovList = $('ovList');
    if (ovList) {
      const v0 = c.renderVals();
      ovList.innerHTML = v0.ovList.map((o, j) => `<a class="srow" href="#services" data-act="ov" data-i="${j}"><span class="lbl snum">${o.n}</span><span class="sname">${esc(o.name)}</span><span class="sdesc">${esc(o.line)}</span><span class="sthumb sw sw-${o.id}" aria-hidden="true"></span>${arrow.replace('<svg', '<svg class="sarr"')}</a>`).join('');
    }

    const stage = $('stage');
    if (stage) {
      c.stageRef(stage);
      stage.addEventListener('pointermove', c.onMove);
      stage.addEventListener('pointerdown', c.onDown);
      stage.addEventListener('pointerup', c.onUp);
      stage.addEventListener('pointercancel', c.onUp);
      stage.addEventListener('pointerleave', c.onLeave);
    }

    document.addEventListener('click', (e) => {
      const el = e.target.closest('[data-act]');
      if (!el || !vals) return;
      const act = el.dataset.act;
      const i = Number(el.dataset.i);
      if (act === 'prev') vals.prev();
      else if (act === 'next') vals.next();
      else if (act === 'play') c.play();
      else if (act === 'turn') c.turn();
      else if (act === 'svc') vals.selList[i].pick();
      else if (act === 'step') vals.stepList[i].pick();
      else if (act === 'ov') {
        vals.ovList[i].pick();
        // Smooth scroll to explorer stage
        const svcSection = $('services');
        if (svcSection) {
          const topPos = svcSection.getBoundingClientRect().top + window.pageYOffset - 72;
          window.scrollTo({ top: topPos, behavior: 'smooth' });
        }
      }
    });

    render();
    c.componentDidMount();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initExplorer);
  } else {
    initExplorer();
  }
})();
