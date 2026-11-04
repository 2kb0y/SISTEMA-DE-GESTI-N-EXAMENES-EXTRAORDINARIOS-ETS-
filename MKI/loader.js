/* ========================================
   PRELOADER MODERNO - JAVASCRIPT
   ======================================== */

class ModernLoader {
    constructor(options = {}) {
        this.options = {
            videoUrl: options.videoUrl || 'img/carga.mov',
            hideOnLoad: options.hideOnLoad !== false,
            hideDelay: options.hideDelay || 0,
            minimal: options.minimal || false,
            onShow: options.onShow || null,
            onHide: options.onHide || null,
            ...options
        };
        
        this.overlay = null;
        this.isHidden = false;
        this.init();
    }
    
    init() {
        this.createHTML();
        this.attachEventListeners();
        
        if (this.options.hideOnLoad) {
            this.waitForLoad();
        }
    }
    
    createHTML() {
        // Verificar si ya existe el overlay
        if (document.querySelector('.loader-overlay')) {
            this.overlay = document.querySelector('.loader-overlay');
            return;
        }
        
        // Crear la estructura HTML
        const loader = document.createElement('div');
        loader.className = `loader-overlay ${this.options.minimal ? 'minimal' : ''}`;
        
        loader.innerHTML = `
            <div class="loader-container">
                <div class="graphic-loader">
                    <svg class="loader-svg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    </svg>
                    <div class="video-center">
                        <video autoplay muted loop playsinline preload="auto" class="center-video">
                            <source src="${this.options.videoUrl}" type="video/quicktime">
                        </video>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(loader);
        this.overlay = loader;
    }
    
    attachEventListeners() {
        // El loader gráfico no necesita event listeners para video
        // Las animaciones son puramente CSS
    }
    
    waitForLoad() {
        // Esperar a que cargue la página
        if (document.readyState === 'complete') {
            // Ya está cargada
            setTimeout(() => this.hide(), this.options.hideDelay);
        } else {
            // Esperar al evento load
            window.addEventListener('load', () => {
                setTimeout(() => this.hide(), this.options.hideDelay);
            }, { once: true });
        }
    }
    
    show() {
        if (!this.overlay) return;
        
        this.isHidden = false;
        this.overlay.classList.remove('hidden');
        
        if (this.options.onShow) {
            this.options.onShow();
        }
    }
    
    hide() {
        if (!this.overlay) return;
        
        this.isHidden = true;
        this.overlay.classList.add('hidden');
        
        if (this.options.onHide) {
            this.options.onHide();
        }
    }
    
    toggle() {
        if (this.isHidden) {
            this.show();
        } else {
            this.hide();
        }
    }
    
    setMinimal(minimal = true) {
        if (this.overlay) {
            if (minimal) {
                this.overlay.classList.add('minimal');
            } else {
                this.overlay.classList.remove('minimal');
            }
        }
    }
}

// ========================================
// INSTANCIA GLOBAL DEL LOADER
// ========================================

let globalLoader = null;

function initLoader(options = {}) {
    if (!globalLoader) {
        globalLoader = new ModernLoader(options);
    }
    return globalLoader;
}

function showLoader() {
    if (!globalLoader) {
        globalLoader = initLoader();
    }
    globalLoader.show();
}

function hideLoader() {
    if (globalLoader) {
        globalLoader.hide();
    }
}

function toggleLoader() {
    if (!globalLoader) {
        globalLoader = initLoader();
    }
    globalLoader.toggle();
}

function setLoaderMinimal(minimal = true) {
    if (!globalLoader) {
        globalLoader = initLoader();
    }
    globalLoader.setMinimal(minimal);
}

// ========================================
// FUNCIONES DE TRANSICIÓN ENTRE PÁGINAS
// ========================================

function navigateWithLoader(url, minimal = false) {
    if (!globalLoader) {
        globalLoader = initLoader();
    }
    
    globalLoader.setMinimal(minimal);
    globalLoader.show();
    
    // Transición suave del contenido
    const main = document.querySelector('main');
    if (main) {
        main.classList.add('fade-out');
    }
    
    // Redirigir después de la animación
    setTimeout(() => {
        window.location.href = url;
    }, 400);
}

// ========================================
// AUTO-INICIALIZAR AL CARGAR EL DOCUMENTO
// ========================================

document.addEventListener('DOMContentLoaded', () => {
    // Inicializar el loader automáticamente
    globalLoader = initLoader({
        hideDelay: 500 // Pequeño delay para que se vea la animación
    });
    
    // Mostrar loader en redirecciones a través de enlaces
    document.addEventListener('click', (e) => {
        // Detectar enlaces de redirección
        const link = e.target.closest('a');
        if (link && link.href && !link.target && !link.href.includes('#')) {
            const href = link.href;
            
            // No mostrar loader para links de download o externos
            if (!href.includes('download') && href.includes(window.location.hostname)) {
                e.preventDefault();
                navigateWithLoader(href);
            }
        }
    });
});

// Inicializar inmediatamente si aún no se ha hecho
if (!globalLoader) {
    globalLoader = initLoader();
}
