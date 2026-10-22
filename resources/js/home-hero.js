/* ==========================================================================
   Beranda — Scroll Expansion Hero (Motion / Framer Motion vanilla API)
   Media kecil di tengah membesar menjadi layar penuh mengikuti posisi scroll.
   Tidak membajak scroll: section sticky setinggi beberapa layar, progress
   dibaca dari posisi scroll lalu dihaluskan dengan spring.
   ========================================================================== */
import { animate, inView, motionValue, scroll, springValue, stagger } from 'motion';

const clamp01 = (v) => Math.min(Math.max(v, 0), 1);

function initScrollHero() {
  const section = document.querySelector('[data-scroll-hero]');
  if (!section) return;

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const video = section.querySelector('video');

  if (reduceMotion) {
    if (video) {
      video.removeAttribute('autoplay');
      video.pause();
    }
    return; // Tampilan statis (layout tanpa JS) sudah lengkap.
  }

  // Atribut autoplay saja kadang ditunda browser (hemat daya/data, video dari server luar
  // belum ter-buffer). Coba putar segera, saat data siap, dan pada interaksi pertama.
  if (video) {
    const play = () => {
      if (video.paused) video.play().catch(() => {});
    };
    play();
    video.addEventListener('canplay', play, { once: true });
    ['pointerdown', 'touchstart', 'keydown', 'scroll'].forEach((type) =>
      window.addEventListener(type, play, { once: true, passive: true }),
    );
    document.addEventListener('visibilitychange', () => {
      if (!document.hidden) play();
    });
  }

  const bg = section.querySelector('[data-hero-bg]');
  const media = section.querySelector('[data-hero-media]');
  const shade = section.querySelector('[data-hero-shade]');
  const splitLeft = section.querySelector('[data-hero-split-left]');
  const splitRight = section.querySelector('[data-hero-split-right]');
  const kickerLeft = section.querySelector('[data-hero-kicker-left]');
  const kickerRight = section.querySelector('[data-hero-kicker-right]');
  const content = section.querySelector('[data-hero-content]');

  section.classList.add('is-animated');

  function render(p) {
    const vw = window.innerWidth;
    const vh = window.innerHeight;
    const isMobile = vw < 768;

    // e = progres pembesaran media (selesai di 80% scroll), c = progres munculnya konten akhir.
    const e = clamp01(p / 0.8);
    const c = clamp01((p - 0.62) / 0.25);

    const startW = isMobile ? Math.min(260, vw * 0.7) : 300;
    const startH = isMobile ? 360 : 400;
    media.style.width = `${startW + (vw - startW) * e}px`;
    media.style.height = `${startH + (vh - startH) * e}px`;
    media.style.borderRadius = `${20 * (1 - e)}px`;

    bg.style.opacity = String(1 - e);
    bg.style.transform = `scale(${1 + 0.08 * e})`;
    shade.style.opacity = String(0.3 - 0.15 * e + 0.4 * c);

    const shift = e * (isMobile ? 140 : 110);
    splitLeft.style.transform = `translateX(-${shift}vw)`;
    splitRight.style.transform = `translateX(${shift}vw)`;
    kickerLeft.style.transform = `translateX(-${shift}vw)`;
    kickerRight.style.transform = `translateX(${shift}vw)`;

    content.style.opacity = String(c);
    content.style.transform = `translateY(${(1 - c) * 28}px)`;
    content.style.pointerEvents = c > 0.5 ? 'auto' : 'none';
  }

  const progress = motionValue(0);
  const smooth = springValue(progress, { stiffness: 140, damping: 30, restDelta: 0.0005 });
  smooth.on('change', render);

  scroll((p) => progress.set(p), { target: section, offset: ['start start', 'end end'] });
  window.addEventListener('resize', () => render(smooth.get()), { passive: true });
  render(0);

  // Fokus keyboard ke CTA saat konten belum tampil → lompat ke akhir hero agar CTA terlihat.
  content.addEventListener('focusin', () => {
    if (smooth.get() < 0.85) {
      window.scrollTo({ top: section.offsetTop + section.offsetHeight - window.innerHeight });
    }
  });

  // Teks pembuka masuk dengan halus saat halaman dimuat.
  animate(
    section.querySelectorAll('[data-hero-intro]'),
    { opacity: [0, 1], y: [24, 0] },
    { duration: 0.9, delay: stagger(0.12), ease: [0.16, 1, 0.3, 1] },
  );
}

function initSectionReveal() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  document.querySelectorAll('[data-reveal]').forEach((el) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(32px)';
    inView(
      el,
      () => {
        animate(el, { opacity: 1, y: 0 }, { duration: 0.8, ease: [0.16, 1, 0.3, 1] });
      },
      { amount: 0.15 },
    );
  });
}

initScrollHero();
initSectionReveal();
