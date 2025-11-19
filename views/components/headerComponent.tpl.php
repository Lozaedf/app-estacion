<style>
    /* ========== HEADER MEJORADO CON ESTILOS DE DETALLE.CSS ========== */
    .header {
        background: linear-gradient(135deg, #3d5a6c 0%, #2c3e50 100%);
        padding: var(--spacing-md) 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        position: sticky;
        top: 0;
        z-index: 1000;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="headerPattern" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23headerPattern)"/></svg>');
        pointer-events: none;
    }

    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 var(--spacing-lg);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    /* ========== TITLE SECTION ========== */
    .header-title {
        flex: 1;
    }

    .header-title h1 {
        color: #ffffff;
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        letter-spacing: -0.3px;
    }

    .header-title p {
        color: rgba(255,255,255,0.85);
        margin: var(--spacing-xs) 0 0 0;
        font-size: 0.9rem;
        font-weight: normal;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }

    /* ========== NAVIGATION ========== */
    .header-nav {
        display: flex;
        gap: var(--spacing-md);
        align-items: center;
    }

    /* User Info Premium */
    .user-info {
        color: #ffffff;
        margin-right: var(--spacing-md);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-xs) var(--spacing-md);
        background: rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .user-info::before {
        content: "👤";
        font-size: 1rem;
        filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
    }

    .user-info:hover {
        background: rgba(255, 255, 255, 0.12);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .user-info span {
        font-weight: 500;
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }

    /* Navigation Buttons */
    .nav-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-xs) var(--spacing-lg);
        text-decoration: none;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        color: #ffffff;
        border: none;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .nav-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .nav-btn:hover::before {
        left: 100%;
    }

    /* Panel Button */
    .panel-btn {
        background: #8e44ad;
        box-shadow: 0 2px 8px rgba(142, 68, 173, 0.3);
    }

    .panel-btn:hover {
        background: #7d3c98;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(142, 68, 173, 0.4);
    }

    /* Logout Button */
    .logout-btn {
        background: #e74c3c;
        box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
    }

    .logout-btn:hover {
        background: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
    }

    /* ========== RESPONSIVE DESIGN ========== */
    @media (max-width: 768px) {
        .header {
            padding: var(--spacing-sm) 0;
        }

        .header-content {
            flex-direction: column;
            gap: var(--spacing-md);
            text-align: center;
            padding: 0 var(--spacing-md);
        }

        .header-title h1 {
            font-size: 1.5rem;
        }

        .header-title p {
            font-size: 0.9rem;
        }

        .header-nav {
            flex-wrap: wrap;
            justify-content: center;
            gap: var(--spacing-sm);
            width: 100%;
        }

        .user-info {
            margin-right: 0;
            margin-bottom: var(--spacing-sm);
            order: -1;
            width: 100%;
            justify-content: center;
        }

        .nav-btn {
            padding: var(--spacing-sm) var(--spacing-md);
            font-size: 0.85rem;
            flex: 1;
            min-width: 140px;
        }
    }

    @media (max-width: 480px) {
        .header-content {
            padding: 0 var(--spacing-sm);
        }

        .header-title h1 {
            font-size: 1.3rem;
        }

        .header-title p {
            font-size: 0.85rem;
        }

        .user-info {
            font-size: 0.85rem;
            padding: var(--spacing-xs) var(--spacing-sm);
        }

        .user-info::before {
            font-size: 1rem;
        }

        .nav-btn {
            font-size: 0.8rem;
            padding: var(--spacing-xs) var(--spacing-sm);
            min-width: 120px;
        }
    }

    /* ========== OPTIMIZACIONES ========== */
    /* Smooth scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Mejor rendimiento en animaciones de botones */
    .nav-btn {
        will-change: transform, box-shadow;
    }

    /* Prefers reduced motion */
    @media (prefers-reduced-motion: reduce) {
        .header-title,
        .header-nav,
        .nav-btn,
        .user-info {
            animation: none !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* High contrast mode */
    @media (prefers-contrast: high) {
        .nav-btn,
        .user-info {
            border-width: 3px;
        }
    }

    /* Print styles */
    @media print {
        .header {
            position: static;
            box-shadow: none;
            border-bottom: 2px solid #000;
        }

        .nav-btn,
        .user-info {
            box-shadow: none;
        }
    }
</style>

<div class="header">
    <div class="header-content">
        <div class="header-title">
            <h1>{{ HEADER_TITLE }}</h1>
            {{ HEADER_SUBTITLE }}
        </div>

        <div class="header-nav">
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Usuario logueado -->
                <div class="user-info">
                    Bienvenido, <span><?php echo htmlspecialchars($_SESSION['user']['nombres']); ?></span>
                </div>
                {{ SHOW_PANEL_BTN }}
                <a href="?slug=logout" class="nav-btn logout-btn">Cerrar Sesión</a>
            <?php endif; ?>
        </div>
    </div>
</div>