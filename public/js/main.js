/**
 * Destinara - Main Interactivity Engine
 * Handles Mobile Menu, Filtering, Dossier Modals, Forms & Toasts
 */

document.addEventListener('DOMContentLoaded', () => {
  initHeaderScroll();
  initThemeToggle();
  initMobileMenu();
  initDesktopLangDropdown();
  initActiveNavLink();
  initBackToTop();
  initDestinasiFilter();
  initCeritaFilter();
  initForms();
  initDossierModals();
});

/* ==========================================================================
   0. Header Scroll Transparency Engine (Transparent on Top, Solid on Scroll)
   ========================================================================== */
function initHeaderScroll() {
  const header = document.getElementById('mainHeader');
  if (!header) return;

  const isHome = header.classList.contains('is-home-header');
  // Beranda dengan scroll hero: header tetap transparan selama hero masih membesar.
  const scrollHero = document.querySelector('[data-scroll-hero]');

  function updateHeader() {
    const threshold = scrollHero && scrollHero.classList.contains('is-animated')
      ? scrollHero.offsetTop + scrollHero.offsetHeight - window.innerHeight - 25
      : 25;
    const isScrolled = window.scrollY > threshold;
    if (isScrolled) {
      if (isHome) {
        header.classList.remove('header-transparent');
      }
      header.classList.remove('bg-transparent', 'border-transparent', 'shadow-none');
      header.classList.add('bg-white/95', 'dark:bg-[#111315]/95', 'backdrop-blur-md', 'shadow-xs', 'border-gray-100', 'dark:border-white/10');
    } else {
      if (isHome) {
        header.classList.add('header-transparent');
        header.classList.add('bg-transparent', 'border-transparent', 'shadow-none');
        header.classList.remove('bg-white/95', 'dark:bg-[#111315]/95', 'backdrop-blur-md', 'shadow-xs', 'border-gray-100', 'dark:border-white/10');
      } else {
        header.classList.remove('bg-transparent', 'border-transparent', 'shadow-none');
        header.classList.add('bg-white/95', 'dark:bg-[#111315]/95', 'backdrop-blur-md', 'shadow-xs', 'border-gray-100', 'dark:border-white/10');
      }
    }
  }

  window.addEventListener('scroll', updateHeader, { passive: true });
  updateHeader();
}

/* ==========================================================================
   0.1 Light Mode & Dark Mode System
   ========================================================================== */
function initThemeToggle() {
  const desktopBtn = document.getElementById('themeToggleBtn');
  const mobileBtn = document.getElementById('mobileThemeToggleBtn');
  const drawerBtn = document.getElementById('drawerThemeToggleBtn');

  function isDarkMode() {
    return document.documentElement.classList.contains('dark');
  }

  function applyTheme(theme) {
    if (theme === 'dark') {
      document.documentElement.classList.add('dark');
      localStorage.setItem('destinara-theme', 'dark');
    } else {
      document.documentElement.classList.remove('dark');
      localStorage.setItem('destinara-theme', 'light');
    }
    updateToggleButtons(theme === 'dark');
    window.dispatchEvent(new CustomEvent('destinara-theme-changed', { detail: { theme } }));
  }

  function toggleTheme() {
    const nextTheme = isDarkMode() ? 'light' : 'dark';
    applyTheme(nextTheme);
  }

  function updateToggleButtons(isDark) {
    const buttons = [desktopBtn, mobileBtn, drawerBtn].filter(Boolean);
    buttons.forEach((btn) => {
      const sunIcon = btn.querySelector('.theme-icon-light');
      const moonIcon = btn.querySelector('.theme-icon-dark');
      
      btn.setAttribute('aria-label', isDark ? 'Beralih ke Mode Terang (Light Mode)' : 'Beralih ke Mode Gelap (Dark Mode)');
      btn.setAttribute('title', isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap');

      if (sunIcon && moonIcon) {
        if (isDark) {
          sunIcon.classList.add('hidden');
          moonIcon.classList.remove('hidden');
        } else {
          sunIcon.classList.remove('hidden');
          moonIcon.classList.add('hidden');
        }
      }
    });
  }

  // Initial sync with active DOM state
  updateToggleButtons(isDarkMode());

  // Attach click listeners to all buttons
  [desktopBtn, mobileBtn, drawerBtn].filter(Boolean).forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      toggleTheme();
    });
  });

  // Listen for OS system preference changes if user hasn't set an explicit preference
  if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
      const stored = localStorage.getItem('destinara-theme');
      if (!stored) {
        applyTheme(e.matches ? 'dark' : 'light');
      }
    });
  }

  // Synchronize across tabs and between public website, login, and admin panel
  window.addEventListener('storage', (e) => {
    if (e.key === 'destinara-theme') {
      applyTheme(e.newValue);
    }
  });
}

/* ==========================================================================
   1. Navigation Menu Drawer (Desktop & Mobile)
   ========================================================================== */
function initMobileMenu() {
  const closeBtn = document.getElementById('mobileMenuCloseBtn');
  const overlay = document.getElementById('mobileMenuOverlay');
  const drawer = document.getElementById('mobileMenuDrawer');

  const openBtns = [
    document.getElementById('headerDrawerBtn'),
    document.getElementById('mobileMenuBtn')
  ].filter(Boolean);

  if (openBtns.length === 0 || !drawer) return;

  function openMenu() {
    if (overlay) {
      overlay.classList.remove('hidden');
      requestAnimationFrame(() => {
        overlay.classList.remove('opacity-0');
        overlay.classList.add('opacity-100');
      });
    }
    drawer.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    if (overlay) {
      overlay.classList.remove('opacity-100');
      overlay.classList.add('opacity-0');
      setTimeout(() => {
        overlay.classList.add('hidden');
      }, 300);
    }
    drawer.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  openBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      openMenu();
    });
  });


  if (closeBtn) {
    closeBtn.addEventListener('click', (e) => {
      e.preventDefault();
      closeMenu();
    });
  }

  if (overlay) {
    overlay.addEventListener('click', closeMenu);
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
      closeMenu();
    }
  });

  // Tutup drawer secara otomatis saat navigasi link mobile diklik
  const mobileLinks = drawer.querySelectorAll('a');
  mobileLinks.forEach((link) => {
    link.addEventListener('click', () => {
      closeMenu();
    });
  });
}

/* ==========================================================================
   1.1 Desktop Language Switcher Click Handling
   ========================================================================== */
function initDesktopLangDropdown() {
  const container = document.getElementById('desktopLangDropdown');
  const btn = document.getElementById('desktopLangBtn');
  const menu = document.getElementById('desktopLangMenu');
  if (!container || !btn || !menu) return;

  btn.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('hidden');
  });

  document.addEventListener('click', (e) => {
    if (!container.contains(e.target)) {
      menu.classList.add('hidden');
    }
  });
}

/* ==========================================================================
   2. Active Nav Link Auto-Detection
   ========================================================================== */
function initActiveNavLink() {
  const currentPath = window.location.pathname;
  let pageName = currentPath.split('/').pop().replace('.html', '') || 'index';
  if (pageName === '' || pageName === 'index') pageName = 'beranda';

  // Match desktop & mobile links
  const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link');
  navLinks.forEach((link) => {
    const targetPage = link.getAttribute('data-page');
    if (targetPage === pageName) {
      link.classList.add('active');
      link.setAttribute('aria-current', 'page');
    } else {
      link.classList.remove('active');
      link.removeAttribute('aria-current');
    }
  });
}

/* ==========================================================================
   3. Back to Top Button
   ========================================================================== */
function initBackToTop() {
  let backBtn = document.getElementById('backToTopBtn');
  if (!backBtn) {
    backBtn = document.createElement('button');
    backBtn.id = 'backToTopBtn';
    backBtn.setAttribute('aria-label', 'Kembali ke atas');
    backBtn.className = 'fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-primary text-on-primary shadow-lg flex items-center justify-center hover:bg-primary-container transition-all';
    backBtn.innerHTML = '<span class="material-symbols-outlined text-[22px]">arrow_upward</span>';
    document.body.appendChild(backBtn);
  }

  window.addEventListener('scroll', () => {
    if (window.scrollY > 350) {
      backBtn.classList.add('show');
    } else {
      backBtn.classList.remove('show');
    }
  }, { passive: true });

  backBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

/* ==========================================================================
   4. Category Filter for Destinasi Page
   ========================================================================== */
function initDestinasiFilter() {
  const filterContainer = document.getElementById('categoryFilter');
  if (!filterContainer) return;

  const buttons = filterContainer.querySelectorAll('button[data-filter]');
  const sections = document.querySelectorAll('section[data-category]');
  const countBadge = document.getElementById('destinasiCountBadge');

  buttons.forEach((btn) => {
    btn.addEventListener('click', () => {
      const filter = btn.getAttribute('data-filter');

      // Update button visual state
      buttons.forEach((b) => {
        b.classList.remove('bg-primary-container', 'text-on-primary', 'font-semibold', 'border-primary/20', 'shadow-sm');
        b.classList.add('text-on-surface-variant', 'bg-surface', 'border-outline-variant/30', 'font-medium');
      });
      btn.classList.add('bg-primary-container', 'text-on-primary', 'font-semibold', 'border-primary/20', 'shadow-sm');
      btn.classList.remove('text-on-surface-variant', 'bg-surface', 'border-outline-variant/30', 'font-medium');

      // Filter sections
      let visibleCount = 0;
      sections.forEach((sec) => {
        const category = sec.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          sec.style.display = '';
          sec.style.opacity = '0';
          sec.style.transform = 'translateY(10px)';
          setTimeout(() => {
            sec.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            sec.style.opacity = '1';
            sec.style.transform = 'translateY(0)';
          }, 50);
          visibleCount++;
        } else {
          sec.style.display = 'none';
        }
      });

      if (countBadge) {
        countBadge.textContent = `${visibleCount} tapak aktif ditemukan`;
      }
    });
  });
}

/* ==========================================================================
   5. Category Filter for Cerita Page
   ========================================================================== */
function initCeritaFilter() {
  const filterContainer = document.getElementById('filter-container');
  if (!filterContainer) return;

  const pills = filterContainer.querySelectorAll('.filter-pill');
  const articles = document.querySelectorAll('article[data-category]');

  pills.forEach((pill) => {
    pill.addEventListener('click', () => {
      const filter = pill.getAttribute('data-filter');

      // Update pill classes
      pills.forEach((p) => {
        p.classList.remove('bg-primary', 'text-on-primary', 'shadow-sm');
        p.classList.add('bg-surface', 'text-on-surface-variant');
      });
      pill.classList.remove('bg-surface', 'text-on-surface-variant');
      pill.classList.add('bg-primary', 'text-on-primary', 'shadow-sm');

      // Filter articles if present
      if (articles.length > 0) {
        articles.forEach((art) => {
          const cat = art.getAttribute('data-category');
          if (filter === 'all' || cat === filter) {
            art.style.display = '';
          } else {
            art.style.display = 'none';
          }
        });
      }
    });
  });
}

/* ==========================================================================
   6. Form Submissions & Toast Feedback
   ========================================================================== */
function initForms() {
  // Ensure Toast Container exists
  let toastContainer = document.getElementById('toastContainer');
  if (!toastContainer) {
    toastContainer = document.createElement('div');
    toastContainer.id = 'toastContainer';
    document.body.appendChild(toastContainer);
  }

  // 1. Kontak Form
  const formKonsultasi = document.getElementById('form-konsultasi');
  if (formKonsultasi) {
    formKonsultasi.addEventListener('submit', (e) => {
      e.preventDefault();
      const submitBtn = formKonsultasi.querySelector('button[type="submit"]');
      const originalHtml = submitBtn ? submitBtn.innerHTML : '';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="material-symbols-outlined text-[20px] animate-spin">progress_activity</span><span>Mengirimkan Pesan...</span>';
      }

      setTimeout(() => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalHtml;
        }
        formKonsultasi.reset();
        const confirmBox = document.getElementById('confirm-box');
        if (confirmBox) {
          confirmBox.classList.remove('hidden');
          confirmBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
        showToast(
          'Matur nuwun! Formulir penjajakan agenda Anda telah diterima. Fasilitator akademik Destinara akan menghubungi Anda dalam 1x24 jam kerja.',
          'success'
        );
      }, 700);
    });
  }

  // 2. Mitra Desa Form
  const mitraForm = document.getElementById('mitraForm');
  if (mitraForm) {
    mitraForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const submitBtn = mitraForm.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerText = 'Mendaftarkan Desa...';
      }

      setTimeout(() => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerText = 'Kirimkan Keterangan Desa Kami';
        }
        mitraForm.reset();
        showToast(
          'Matur nuwun, terima kasih! Keterangan desa Anda telah kami terima dengan penuh hormat. Tim kurator Destinara akan segera menyapa Anda lewat WhatsApp.',
          'success'
        );
      }, 700);
    });
  }

  // 3. Destinasi Inquiry Form
  const submissionForm = document.getElementById('submissionForm');
  if (submissionForm) {
    submissionForm.addEventListener('submit', (e) => {
      e.preventDefault();
      submissionForm.reset();
      showToast('Permohonan dossier tapak telah dicatat. Berkas silabus segera dikirimkan ke pos-el Anda.', 'success');
    });
  }

  // 4. Newsletter Form
  const newsletterForm = document.getElementById('newsletter-form');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', (e) => {
      e.preventDefault();
      newsletterForm.reset();
      showToast('Terima kasih. Konfirmasi lembar warta bulanan telah dikirimkan ke kotak masuk pos-el Anda.', 'success');
    });
  }
}

/**
 * Display toast notification
 */
window.showToast = function(message, type = 'success') {
  const container = document.getElementById('toastContainer');
  if (!container) return;

  const toast = document.createElement('div');
  toast.className = `toast ${type === 'success' ? 'toast-success' : ''}`;
  
  const icon = type === 'success' ? 'check_circle' : 'info';
  const iconColor = type === 'success' ? 'text-[#51634b]' : 'text-[#1F2B45]';

  toast.innerHTML = `
    <span class="material-symbols-outlined ${iconColor} text-[24px] flex-shrink-0">${icon}</span>
    <div class="flex-1">
      <p class="font-semibold text-sm text-on-surface mb-0.5">${type === 'success' ? 'Pemberitahuan Berhasil' : 'Informasi'}</p>
      <p class="text-xs text-on-surface-variant leading-relaxed">${message}</p>
    </div>
    <button class="text-outline hover:text-on-surface p-1 text-sm font-bold ml-1 cursor-pointer" onclick="this.parentElement.remove()">✕</button>
  `;

  container.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(40px)';
    setTimeout(() => toast.remove(), 250);
  }, 4500);
};

/* ==========================================================================
   7. Dossier Modal Popups for Destinasi Page
   ========================================================================== */
function initDossierModals() {
  const modalBackdrop = document.getElementById('dossierModal');
  if (!modalBackdrop) return;

  const closeBtn = document.getElementById('closeDossierModal');
  const triggerBtns = document.querySelectorAll('[data-open-dossier]');

  const modalTitle = document.getElementById('modalDossierTitle');
  const modalLocation = document.getElementById('modalDossierLocation');
  const modalDesc = document.getElementById('modalDossierDesc');
  const modalModules = document.getElementById('modalDossierModules');
  const modalCapacity = document.getElementById('modalDossierCapacity');
  const modalFpic = document.getElementById('modalDossierFpic');

  const dossierData = {
    sade: {
      title: 'Desa Adat Sasak Sade',
      location: 'Lombok Tengah, Nusa Tenggara Barat (8°53\'38"S 116°17\'31"E)',
      desc: 'Tegak melintasi lima belas generasi, struktur Bale Tani memanfaatkan campuran tanah lempung, sekam padi, dan getah pohon kamboja yang lentur meredam gelombang seismik tektonik zona sesar busur belakang. Sistem sosial diatur oleh kearifan Awig-Awig adat yang menjaga harmoni antar warga.',
      modules: 'Rekayasa Material Vernakular, Etnomatematika Tenun Ikat Subahnale, Filsafat Ruang Bale Sasak, & Konservasi Sumber Pangan Lokal.',
      capacity: '24 Peneliti / Siswa per gelombang',
      fpic: 'Persetujuan Bebas Didahulukan (FPIC) Terverifikasi Nomor FPIC/NTB/2024/012 bersama Tetua Mangku Sade.'
    },
    wonosadi: {
      title: 'Hutan Adat Wonosadi',
      location: 'Gunungkidul, D.I. Yogyakarta',
      desc: 'Hutan larangan seluas 25 hektar yang dikelola secara komunal dengan prinsip Sadumuk Bathuk Sanyari Bumi. Menyimpan lebih dari 120 spesies flora obat tradisional dan menjadi benteng resapan air bawah tanah formasi karst Sewu.',
      modules: 'Hidrologi Karst Tropis, Etnobotani Jamu Tradisional, Mitigasi Kekeringan Berbasis Kearifan Lokal, & Seni Musik Rinding Gumbeng.',
      capacity: '30 Peneliti / Siswa per gelombang',
      fpic: 'FPIC Terverifikasi Nomor FPIC/DIY/2023/008 bersama Paguyuban Jagawana Wonosadi.'
    },
    kintamani: {
      title: 'Kampung Kopi Kintamani',
      location: 'Bangli, Bali',
      desc: 'Penerapan nyata filosofi kosmologi Tri Hita Karana dalam manajemen agroforestri kopi Arabika organik. Sistem irigasi dan keorganisasian Subak Abian telah diakui UNESCO sebagai warisan budaya tak benda yang terbukti tahan krisis iklim.',
      modules: 'Agroforestri Organik Subak Abian, Fermentasi Kopi Mikro-Lot, Tata Ruang Spiritual Pura Desa, & Analisis Rantai Nilai Berkeadilan.',
      capacity: '20 Peneliti / Siswa per gelombang',
      fpic: 'FPIC Terverifikasi Nomor FPIC/BALI/2024/005 bersama Pekaseh Subak Abian Kintamani.'
    },
    cirebon: {
      title: 'Pesisir Kerang Simping Cirebon',
      location: 'Cirebon, Jawa Barat',
      desc: 'Laboratorium hidup konservasi pesisir berbasis partisipasi nelayan tradisional. Mengkaji restorasi mangrove estuari, pengelolaan limbah cangkang kerang menjadi biokalsium, dan dinamika kebudayaan maritim Pantura.',
      modules: 'Restorasi Hutan Bakau Pantai Utara, Ekonomi Sirkular Pesisir, Oseanografi Estuari, & Budaya Maritim Nadran.',
      capacity: '25 Peneliti / Siswa per gelombang',
      fpic: 'FPIC Terverifikasi Nomor FPIC/JBR/2024/019 bersama Rukun Nelayan Baro.'
    }
  };

  triggerBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const dossierKey = btn.getAttribute('data-open-dossier');
      const data = dossierData[dossierKey] || dossierData.sade;

      if (modalTitle) modalTitle.textContent = data.title;
      if (modalLocation) modalLocation.textContent = data.location;
      if (modalDesc) modalDesc.textContent = data.desc;
      if (modalModules) modalModules.textContent = data.modules;
      if (modalCapacity) modalCapacity.textContent = data.capacity;
      if (modalFpic) modalFpic.textContent = data.fpic;

      modalBackdrop.classList.remove('hidden');
      requestAnimationFrame(() => {
        modalBackdrop.classList.add('open');
      });
      document.body.style.overflow = 'hidden';
    });
  });

  function closeModal() {
    modalBackdrop.classList.remove('open');
    setTimeout(() => {
      modalBackdrop.classList.add('hidden');
      document.body.style.overflow = '';
    }, 250);
  }

  if (closeBtn) closeBtn.addEventListener('click', closeModal);
  modalBackdrop.addEventListener('click', (e) => {
    if (e.target === modalBackdrop) closeModal();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modalBackdrop.classList.contains('open')) {
      closeModal();
    }
  });
}
