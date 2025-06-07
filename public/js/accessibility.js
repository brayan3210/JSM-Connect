/**
 * =============================================================================
 * ACCESSIBILITY JAVASCRIPT
 * Sistema de accesibilidad para personas con discapacidades
 * =============================================================================
 */

class AccessibilityManager {
    constructor() {
        this.settings = {
            colorblind: false,
            colorblindType: 'none',
            highContrast: false,
            largeText: false,
            darkMode: false,
            reducedMotion: false,
            dyslexiaFont: false,
            readingGuide: false,
            largeCursor: false,
            enhancedFocus: false,
            zoom: 100
        };
        
        this.init();
        this.loadSettings();
    }

    init() {
        this.createAccessibilityMenu();
        this.createColorBlindFilters();
        this.setupEventListeners();
        this.createReadingGuide();
        this.setupKeyboardShortcuts();
        this.createFloatingToggle();
    }

    createAccessibilityMenu() {
        const menuHTML = `
            <div id="accessibility-menu" class="accessibility-menu collapsed" role="region" aria-label="Menú de Accesibilidad">
                <button class="accessibility-toggle" 
                        onclick="accessibilityManager.toggleMenu()" 
                        aria-label="Abrir menú de accesibilidad"
                        title="Herramientas de Accesibilidad (Alt+A)">
                    <i class="fas fa-universal-access" aria-hidden="true"></i>
                    <span>Accesibilidad</span>
                </button>
                
                <div class="accessibility-content">
                    <div class="accessibility-header">
                        <h3>
                            <i class="fas fa-universal-access" aria-hidden="true"></i>
                            Herramientas de Accesibilidad
                        </h3>
                        <button class="close-btn" onclick="accessibilityManager.closeMenu()" 
                                aria-label="Cerrar menú" title="Cerrar menú">
                            <i class="fas fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    
                    <!-- Zoom Controls -->
                    <div class="accessibility-section">
                        <h4>
                            <i class="fas fa-search-plus" aria-hidden="true"></i>
                            Zoom de Página
                        </h4>
                        <div class="zoom-controls">
                            <button class="zoom-control" onclick="accessibilityManager.zoomOut()" 
                                    aria-label="Reducir zoom" title="Reducir zoom">-</button>
                            <span class="zoom-level" id="zoom-level">100%</span>
                            <button class="zoom-control" onclick="accessibilityManager.zoomIn()" 
                                    aria-label="Aumentar zoom" title="Aumentar zoom">+</button>
                            <button class="zoom-control reset-btn" onclick="accessibilityManager.resetZoom()" 
                                    aria-label="Restablecer zoom" title="Restablecer zoom">↺</button>
                        </div>
                    </div>

                    <!-- Visual Accessibility -->
                    <div class="accessibility-section">
                        <h4>
                            <i class="fas fa-eye" aria-hidden="true"></i>
                            Accesibilidad Visual
                        </h4>
                        <div class="accessibility-controls">
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleHighContrast()" 
                                    id="high-contrast-btn"
                                    data-tooltip="Mejora la visibilidad del texto"
                                    aria-pressed="false">
                                <i class="fas fa-adjust" aria-hidden="true"></i>
                                <span>Alto Contraste</span>
                            </button>
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleLargeText()" 
                                    id="large-text-btn"
                                    data-tooltip="Aumenta el tamaño del texto moderadamente"
                                    aria-pressed="false">
                                <i class="fas fa-font" aria-hidden="true"></i>
                                <span>Texto Grande</span>
                            </button>
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleDarkMode()" 
                                    id="dark-mode-btn"
                                    data-tooltip="Cambia a modo oscuro"
                                    aria-pressed="false">
                                <i class="fas fa-moon" aria-hidden="true"></i>
                                <span>Modo Oscuro</span>
                            </button>
                        </div>
                    </div>

                    <!-- Color Blind Support -->
                    <div class="accessibility-section">
                        <h4>
                            <i class="fas fa-palette" aria-hidden="true"></i>
                            Daltonismo
                        </h4>
                        <div class="accessibility-controls colorblind-controls">
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleColorBlind('protanopia')" 
                                    id="protanopia-btn"
                                    data-tooltip="Filtro para protanopia (rojo-verde)"
                                    aria-pressed="false">
                                <i class="fas fa-circle" style="color: #ff0000;" aria-hidden="true"></i>
                                <span>Protanopia</span>
                            </button>
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleColorBlind('deuteranopia')" 
                                    id="deuteranopia-btn"
                                    data-tooltip="Filtro para deuteranopia (rojo-verde)"
                                    aria-pressed="false">
                                <i class="fas fa-circle" style="color: #00ff00;" aria-hidden="true"></i>
                                <span>Deuteranopia</span>
                            </button>
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleColorBlind('tritanopia')" 
                                    id="tritanopia-btn"
                                    data-tooltip="Filtro para tritanopia (azul-amarillo)"
                                    aria-pressed="false">
                                <i class="fas fa-circle" style="color: #0000ff;" aria-hidden="true"></i>
                                <span>Tritanopia</span>
                            </button>
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleColorBlind('achromatopsia')" 
                                    id="achromatopsia-btn"
                                    data-tooltip="Filtro escala de grises"
                                    aria-pressed="false">
                                <i class="fas fa-circle" style="color: #888888;" aria-hidden="true"></i>
                                <span>Monocromatismo</span>
                            </button>
                        </div>
                    </div>

                    <!-- Reading & Navigation -->
                    <div class="accessibility-section">
                        <h4>
                            <i class="fas fa-book-reader" aria-hidden="true"></i>
                            Lectura y Navegación
                        </h4>
                        <div class="accessibility-controls">
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleDyslexiaFont()" 
                                    id="dyslexia-font-btn"
                                    data-tooltip="Fuente especial para dislexia"
                                    aria-pressed="false">
                                <i class="fas fa-spell-check" aria-hidden="true"></i>
                                <span>Fuente Dislexia</span>
                            </button>
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleReadingGuide()" 
                                    id="reading-guide-btn"
                                    data-tooltip="Línea guía para lectura"
                                    aria-pressed="false">
                                <i class="fas fa-minus" aria-hidden="true"></i>
                                <span>Guía de Lectura</span>
                            </button>
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleEnhancedFocus()" 
                                    id="enhanced-focus-btn"
                                    data-tooltip="Mejora los indicadores de foco"
                                    aria-pressed="false">
                                <i class="fas fa-crosshairs" aria-hidden="true"></i>
                                <span>Foco Mejorado</span>
                            </button>
                        </div>
                    </div>

                    <!-- Motor & Interaction -->
                    <div class="accessibility-section">
                        <h4>
                            <i class="fas fa-mouse-pointer" aria-hidden="true"></i>
                            Motor e Interacción
                        </h4>
                        <div class="accessibility-controls">
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleLargeCursor()" 
                                    id="large-cursor-btn"
                                    data-tooltip="Cursor más grande y visible"
                                    aria-pressed="false">
                                <i class="fas fa-mouse-pointer" aria-hidden="true"></i>
                                <span>Cursor Grande</span>
                            </button>
                            <button class="accessibility-btn accessibility-tooltip" 
                                    onclick="accessibilityManager.toggleReducedMotion()" 
                                    id="reduced-motion-btn"
                                    data-tooltip="Reduce animaciones y movimiento"
                                    aria-pressed="false">
                                <i class="fas fa-pause" aria-hidden="true"></i>
                                <span>Menos Movimiento</span>
                            </button>
                        </div>
                    </div>

                    <!-- Reset & Help -->
                    <div class="accessibility-section">
                        <div class="accessibility-controls">
                            <button class="accessibility-btn reset-all-btn" onclick="accessibilityManager.resetAll()" 
                                    title="Restablecer todas las configuraciones">
                                <i class="fas fa-undo" aria-hidden="true"></i>
                                <span>Restablecer Todo</span>
                            </button>
                        </div>
                        <div class="keyboard-shortcuts">
                            <small>
                                <strong>Atajos de teclado:</strong><br>
                                Alt+A: Abrir/Cerrar menú<br>
                                Alt+H: Alto contraste<br>
                                Alt+D: Modo oscuro<br>
                                Alt++/Alt+-: Zoom<br>
                                Alt+R: Restablecer
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botón flotante para reabrir fácilmente -->
            <button id="accessibility-floating-toggle" class="accessibility-floating-toggle hidden" 
                    onclick="accessibilityManager.showMenu()" 
                    aria-label="Abrir herramientas de accesibilidad"
                    title="Herramientas de Accesibilidad">
                <i class="fas fa-universal-access" aria-hidden="true"></i>
            </button>
        `;
        
        document.body.insertAdjacentHTML('beforeend', menuHTML);
    }

    createColorBlindFilters() {
        const filtersHTML = `
            <svg style="position: absolute; width: 0; height: 0;" aria-hidden="true">
                <defs>
                    <filter id="protanopia-filter">
                        <feColorMatrix type="matrix" values="0.567 0.433 0 0 0
                                                           0.558 0.442 0 0 0
                                                           0 0.242 0.758 0 0
                                                           0 0 0 1 0"/>
                    </filter>
                    <filter id="deuteranopia-filter">
                        <feColorMatrix type="matrix" values="0.625 0.375 0 0 0
                                                           0.7 0.3 0 0 0
                                                           0 0.3 0.7 0 0
                                                           0 0 0 1 0"/>
                    </filter>
                    <filter id="tritanopia-filter">
                        <feColorMatrix type="matrix" values="0.95 0.05 0 0 0
                                                           0 0.433 0.567 0 0
                                                           0 0.475 0.525 0 0
                                                           0 0 0 1 0"/>
                    </filter>
                </defs>
            </svg>
        `;
        document.body.insertAdjacentHTML('beforeend', filtersHTML);
    }

    createReadingGuide() {
        const guideHTML = `
            <div id="reading-guide" class="reading-guide" style="display: none;" aria-hidden="true"></div>
        `;
        document.body.insertAdjacentHTML('beforeend', guideHTML);
    }

    createFloatingToggle() {
        // El botón flotante ya se crea en createAccessibilityMenu
    }

    setupEventListeners() {
        // Mouse tracking for reading guide
        document.addEventListener('mousemove', (e) => {
            if (this.settings.readingGuide) {
                const guide = document.getElementById('reading-guide');
                guide.style.top = e.clientY + 'px';
            }
        });

        // Window resize
        window.addEventListener('resize', () => {
            this.adjustForMobile();
        });

        // Initial mobile adjustment
        this.adjustForMobile();
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            if (e.altKey) {
                switch(e.key.toLowerCase()) {
                    case 'a':
                        e.preventDefault();
                        this.toggleMenu();
                        break;
                    case 'h':
                        e.preventDefault();
                        this.toggleHighContrast();
                        break;
                    case 'd':
                        e.preventDefault();
                        this.toggleDarkMode();
                        break;
                    case '+':
                    case '=':
                        e.preventDefault();
                        this.zoomIn();
                        break;
                    case '-':
                        e.preventDefault();
                        this.zoomOut();
                        break;
                    case 'r':
                        e.preventDefault();
                        this.resetAll();
                        break;
                }
            }
        });
    }

    toggleMenu() {
        const menu = document.getElementById('accessibility-menu');
        const floatingToggle = document.getElementById('accessibility-floating-toggle');
        const isCollapsed = menu.classList.contains('collapsed');
        
        if (isCollapsed) {
            this.showMenu();
        } else {
            this.closeMenu();
        }
    }

    showMenu() {
        const menu = document.getElementById('accessibility-menu');
        const floatingToggle = document.getElementById('accessibility-floating-toggle');
        
        menu.classList.remove('collapsed');
        menu.classList.add('opening');
        floatingToggle.classList.add('hidden');
        
        // Focus on first interactive element
        setTimeout(() => {
            const firstButton = menu.querySelector('button:not(.accessibility-toggle)');
            if (firstButton) firstButton.focus();
        }, 300);
        
        this.announceToScreenReader('Menú de accesibilidad abierto');
    }

    closeMenu() {
        const menu = document.getElementById('accessibility-menu');
        const floatingToggle = document.getElementById('accessibility-floating-toggle');
        
        menu.classList.add('collapsed');
        menu.classList.add('closing');
        
        // Mostrar botón flotante después de un delay
        setTimeout(() => {
            floatingToggle.classList.remove('hidden');
            menu.classList.remove('opening', 'closing');
        }, 300);
        
        this.announceToScreenReader('Menú de accesibilidad cerrado');
    }

    // Zoom functions - Valores más moderados
    zoomIn() {
        this.settings.zoom = Math.min(this.settings.zoom + 5, 150); // Reducido de 10 a 5, máximo de 150
        this.applyZoom();
    }

    zoomOut() {
        this.settings.zoom = Math.max(this.settings.zoom - 5, 75); // Reducido de 10 a 5, mínimo de 75
        this.applyZoom();
    }

    resetZoom() {
        this.settings.zoom = 100;
        this.applyZoom();
    }

    applyZoom() {
        // Usar transform scale en lugar de zoom para mejor compatibilidad
        const scale = this.settings.zoom / 100;
        document.documentElement.style.fontSize = `${16 * scale}px`;
        document.getElementById('zoom-level').textContent = this.settings.zoom + '%';
        this.saveSettings();
        this.announceToScreenReader(`Zoom ajustado a ${this.settings.zoom}%`);
    }

    // Visual accessibility functions
    toggleHighContrast() {
        this.settings.highContrast = !this.settings.highContrast;
        document.body.classList.toggle('high-contrast', this.settings.highContrast);
        this.updateButtonState('high-contrast-btn', this.settings.highContrast);
        this.saveSettings();
        this.announceToScreenReader(this.settings.highContrast ? 'Alto contraste activado' : 'Alto contraste desactivado');
    }

    toggleLargeText() {
        this.settings.largeText = !this.settings.largeText;
        document.body.classList.toggle('large-text', this.settings.largeText);
        this.updateButtonState('large-text-btn', this.settings.largeText);
        this.saveSettings();
        this.announceToScreenReader(this.settings.largeText ? 'Texto grande activado' : 'Texto grande desactivado');
    }

    toggleDarkMode() {
        this.settings.darkMode = !this.settings.darkMode;
        document.body.classList.toggle('dark-mode', this.settings.darkMode);
        this.updateButtonState('dark-mode-btn', this.settings.darkMode);
        this.saveSettings();
        this.announceToScreenReader(this.settings.darkMode ? 'Modo oscuro activado' : 'Modo oscuro desactivado');
    }

    // Color blind functions
    toggleColorBlind(type) {
        // Reset all colorblind filters first
        this.clearColorBlindFilters();
        
        if (this.settings.colorblindType === type) {
            // If same type clicked, disable
            this.settings.colorblind = false;
            this.settings.colorblindType = 'none';
        } else {
            // Enable new type
            this.settings.colorblind = true;
            this.settings.colorblindType = type;
            document.body.classList.add(`colorblind-${type}`);
        }
        
        this.updateColorBlindButtons();
        this.saveSettings();
        this.announceToScreenReader(this.settings.colorblind ? 
            `Filtro para ${type} activado` : 'Filtros de daltonismo desactivados');
    }

    clearColorBlindFilters() {
        document.body.classList.remove('colorblind-protanopia', 'colorblind-deuteranopia', 
                                       'colorblind-tritanopia', 'colorblind-achromatopsia');
    }

    updateColorBlindButtons() {
        ['protanopia', 'deuteranopia', 'tritanopia', 'achromatopsia'].forEach(type => {
            this.updateButtonState(`${type}-btn`, this.settings.colorblindType === type);
        });
    }

    // Reading and navigation functions
    toggleDyslexiaFont() {
        this.settings.dyslexiaFont = !this.settings.dyslexiaFont;
        document.body.classList.toggle('dyslexia-font', this.settings.dyslexiaFont);
        this.updateButtonState('dyslexia-font-btn', this.settings.dyslexiaFont);
        this.saveSettings();
        this.announceToScreenReader(this.settings.dyslexiaFont ? 'Fuente para dislexia activada' : 'Fuente para dislexia desactivada');
    }

    toggleReadingGuide() {
        this.settings.readingGuide = !this.settings.readingGuide;
        const guide = document.getElementById('reading-guide');
        guide.style.display = this.settings.readingGuide ? 'block' : 'none';
        this.updateButtonState('reading-guide-btn', this.settings.readingGuide);
        this.saveSettings();
        this.announceToScreenReader(this.settings.readingGuide ? 'Guía de lectura activada' : 'Guía de lectura desactivada');
    }

    toggleEnhancedFocus() {
        this.settings.enhancedFocus = !this.settings.enhancedFocus;
        document.body.classList.toggle('accessibility-focus', this.settings.enhancedFocus);
        this.updateButtonState('enhanced-focus-btn', this.settings.enhancedFocus);
        this.saveSettings();
        this.announceToScreenReader(this.settings.enhancedFocus ? 'Foco mejorado activado' : 'Foco mejorado desactivado');
    }

    // Motor and interaction functions
    toggleLargeCursor() {
        this.settings.largeCursor = !this.settings.largeCursor;
        document.body.classList.toggle('large-cursor', this.settings.largeCursor);
        this.updateButtonState('large-cursor-btn', this.settings.largeCursor);
        this.saveSettings();
        this.announceToScreenReader(this.settings.largeCursor ? 'Cursor grande activado' : 'Cursor grande desactivado');
    }

    toggleReducedMotion() {
        this.settings.reducedMotion = !this.settings.reducedMotion;
        document.body.classList.toggle('reduced-motion', this.settings.reducedMotion);
        this.updateButtonState('reduced-motion-btn', this.settings.reducedMotion);
        this.saveSettings();
        this.announceToScreenReader(this.settings.reducedMotion ? 'Movimiento reducido activado' : 'Movimiento reducido desactivado');
    }

    // Utility functions
    updateButtonState(buttonId, isActive) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.classList.toggle('active', isActive);
            button.setAttribute('aria-pressed', isActive.toString());
        }
    }

    resetAll() {
        // Reset all settings
        Object.keys(this.settings).forEach(key => {
            if (key !== 'zoom') {
                this.settings[key] = false;
            } else {
                this.settings[key] = 100;
            }
        });
        this.settings.colorblindType = 'none';

        // Remove all classes
        document.body.className = document.body.className.replace(/\b(high-contrast|large-text|dark-mode|colorblind-\w+|dyslexia-font|accessibility-focus|large-cursor|reduced-motion)\b/g, '');
        
        // Reset zoom
        document.documentElement.style.fontSize = '16px';
        document.getElementById('zoom-level').textContent = '100%';
        
        // Hide reading guide
        document.getElementById('reading-guide').style.display = 'none';
        
        // Update all button states
        document.querySelectorAll('.accessibility-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.setAttribute('aria-pressed', 'false');
        });

        this.saveSettings();
        this.announceToScreenReader('Todas las configuraciones de accesibilidad han sido restablecidas');
    }

    // Settings persistence
    saveSettings() {
        localStorage.setItem('accessibility-settings', JSON.stringify(this.settings));
    }

    loadSettings() {
        try {
            const saved = localStorage.getItem('accessibility-settings');
            if (saved) {
                this.settings = { ...this.settings, ...JSON.parse(saved) };
                this.applyLoadedSettings();
            }
        } catch (e) {
            console.warn('Error loading accessibility settings:', e);
        }
    }

    applyLoadedSettings() {
        // Apply visual settings
        if (this.settings.highContrast) {
            document.body.classList.add('high-contrast');
            this.updateButtonState('high-contrast-btn', true);
        }
        
        if (this.settings.largeText) {
            document.body.classList.add('large-text');
            this.updateButtonState('large-text-btn', true);
        }
        
        if (this.settings.darkMode) {
            document.body.classList.add('dark-mode');
            this.updateButtonState('dark-mode-btn', true);
        }
        
        // Apply colorblind settings
        if (this.settings.colorblind && this.settings.colorblindType !== 'none') {
            document.body.classList.add(`colorblind-${this.settings.colorblindType}`);
            this.updateColorBlindButtons();
        }
        
        // Apply other settings
        if (this.settings.dyslexiaFont) {
            document.body.classList.add('dyslexia-font');
            this.updateButtonState('dyslexia-font-btn', true);
        }
        
        if (this.settings.readingGuide) {
            document.getElementById('reading-guide').style.display = 'block';
            this.updateButtonState('reading-guide-btn', true);
        }
        
        if (this.settings.enhancedFocus) {
            document.body.classList.add('accessibility-focus');
            this.updateButtonState('enhanced-focus-btn', true);
        }
        
        if (this.settings.largeCursor) {
            document.body.classList.add('large-cursor');
            this.updateButtonState('large-cursor-btn', true);
        }
        
        if (this.settings.reducedMotion) {
            document.body.classList.add('reduced-motion');
            this.updateButtonState('reduced-motion-btn', true);
        }
        
        // Apply zoom
        if (this.settings.zoom !== 100) {
            this.applyZoom();
        }
    }

    adjustForMobile() {
        const isMobile = window.innerWidth <= 768;
        const menu = document.getElementById('accessibility-menu');
        const floatingToggle = document.getElementById('accessibility-floating-toggle');
        
        if (isMobile) {
            menu.classList.add('mobile-responsive');
            floatingToggle.classList.add('mobile-responsive');
        } else {
            menu.classList.remove('mobile-responsive');
            floatingToggle.classList.remove('mobile-responsive');
        }
    }

    announceToScreenReader(message) {
        // Create temporary element for screen reader announcement
        const announcement = document.createElement('div');
        announcement.setAttribute('aria-live', 'polite');
        announcement.setAttribute('aria-atomic', 'true');
        announcement.className = 'sr-only';
        announcement.textContent = message;
        
        document.body.appendChild(announcement);
        
        // Remove after announcement
        setTimeout(() => {
            document.body.removeChild(announcement);
        }, 1000);
    }
}

// Initialize accessibility manager when DOM is loaded
let accessibilityManager;
document.addEventListener('DOMContentLoaded', function() {
    accessibilityManager = new AccessibilityManager();
    console.log('✅ Sistema de accesibilidad inicializado correctamente');
}); 