// State tata letak panel admin (sidebar inset + tema), sama dengan portal destinara-system.
// Layar >= 1024px: sidebar lebar/ciut (diingat). Layar kecil: sidebar jadi laci.
document.addEventListener('alpine:init', () => {
    window.Alpine.data('portalShell', () => ({
        mobileSidebarOpen: false,
        desktop: window.matchMedia('(min-width: 1024px)').matches,
        sidebarOpen: (() => {
            try { return localStorage.getItem('destinara-admin-sidebar') !== '0'; } catch (e) { return true; }
        })(),
        dark: document.documentElement.classList.contains('dark'),

        get rail() {
            return this.desktop && !this.sidebarOpen;
        },

        init() {
            window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => {
                this.desktop = e.matches;
                if (e.matches) this.mobileSidebarOpen = false;
            });
            this.$watch('sidebarOpen', (v) => {
                try { localStorage.setItem('destinara-admin-sidebar', v ? '1' : '0'); } catch (e) {}
            });
        },

        toggleSidebar() {
            if (this.desktop) this.sidebarOpen = !this.sidebarOpen;
            else this.mobileSidebarOpen = !this.mobileSidebarOpen;
        },

        setTheme(mode) {
            this.dark = mode === 'dark';
            document.documentElement.classList.toggle('dark', this.dark);
            try { localStorage.setItem('destinara-theme', mode); } catch (e) {}
        },
    }));
});
