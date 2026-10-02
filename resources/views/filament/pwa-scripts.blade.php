<script>
(function() {
    // 1. Register Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('HisabKitab PWA: ServiceWorker registered with scope:', registration.scope);
                })
                .catch(function(error) {
                    console.warn('HisabKitab PWA: ServiceWorker registration failed:', error);
                });
        });
    }

    // 2. Check if already installed / standalone
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
    if (isStandalone) {
        console.log('HisabKitab: Running as installed standalone app.');
        return;
    }

    let deferredPrompt = null;
    const installContainer = document.getElementById('pwa-install-container');

    window.addEventListener('beforeinstallprompt', function(e) {
        // Prevent default mini-infobar on mobile
        e.preventDefault();
        deferredPrompt = e;
        window.deferredPWAInstallPrompt = e;

        // Show install button in topbar
        if (installContainer) {
            installContainer.style.display = 'inline-flex';
        }
    });

    window.triggerPWAInstall = async function() {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            console.log('HisabKitab PWA install outcome:', outcome);
            if (outcome === 'accepted') {
                if (installContainer) {
                    installContainer.style.display = 'none';
                }
            }
            deferredPrompt = null;
            window.deferredPWAInstallPrompt = null;
        } else {
            // Fallback for browsers that don't emit beforeinstallprompt (e.g. macOS Safari)
            const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            
            if (isMac && !isIOS) {
                alert('To install HisabKitab on your Mac:\n\n• In Chrome/Edge: Click the Install icon in the right side of the address bar.\n• In Safari: Click "File" menu -> "Add to Dock".');
            } else if (isIOS) {
                alert('To install HisabKitab on iPhone/iPad:\n\nTap the Share button in Safari and choose "Add to Home Screen".');
            } else {
                alert('To install HisabKitab:\n\nClick the install icon in your browser address bar or menu -> "Install HisabKitab".');
            }
        }
    };

    window.addEventListener('appinstalled', function() {
        console.log('HisabKitab PWA was successfully installed.');
        if (installContainer) {
            installContainer.style.display = 'none';
        }
        deferredPrompt = null;
        window.deferredPWAInstallPrompt = null;
    });
})();
</script>
