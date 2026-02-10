<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUXON | ERP Moderno para Tu Negocio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --color-primary: #1e40af;
            --color-primary-light: #3b82f6;
            --color-primary-dark: #1e3a8a;
            --color-secondary: #7c3aed;
            --color-secondary-light: #8b5cf6;
            --color-accent: #f59e0b;
            --color-accent-light: #fbbf24;
            --color-success: #10b981;
            --color-warning: #f97316;
            --color-danger: #ef4444;
            --color-light: #f8fafc;
            --color-light-gray: #e2e8f0;
            --color-dark: #1e293b;
            --color-dark-light: #334155;
            --color-gray: #64748b;
            --color-white: #ffffff;
            --color-black: #0f172a;

            --gradient-primary: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            --gradient-secondary: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
            --gradient-accent: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            --gradient-dark: linear-gradient(135deg, #1e293b 0%, #334155 100%);

            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);

            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;

            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-base: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);

            --header-height: 80px;
        }

        /* Tema oscuro */
        [data-theme="dark"] {
            --color-primary: #3b82f6;
            --color-primary-light: #60a5fa;
            --color-primary-dark: #1d4ed8;
            --color-secondary: #8b5cf6;
            --color-secondary-light: #a78bfa;
            --color-accent: #fbbf24;
            --color-accent-light: #fcd34d;
            --color-success: #34d399;
            --color-warning: #fb923c;
            --color-danger: #f87171;
            --color-light: #1e293b;
            --color-light-gray: #334155;
            --color-dark: #f8fafc;
            --color-dark-light: #e2e8f0;
            --color-gray: #94a3b8;
            --color-white: #0f172a;
            --color-black: #f1f5f9;

            --gradient-primary: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            --gradient-secondary: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
            --gradient-accent: linear-gradient(135deg, #fbbf24 0%, #fcd34d 100%);
            --gradient-dark: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--color-dark);
            background-color: var(--color-white);
            line-height: 1.6;
            overflow-x: hidden;
            transition: background-color var(--transition-base), color var(--transition-base);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            line-height: 1.2;
            color: var(--color-dark);
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: color var(--transition-fast);
        }

        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 2rem;
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: 1rem;
            transition: all var(--transition-base);
            border: none;
            cursor: pointer;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-lg);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .btn-secondary {
            background: var(--gradient-secondary);
            color: white;
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .btn-accent {
            background: var(--gradient-accent);
            color: white;
            box-shadow: var(--shadow-lg);
        }

        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .btn-outline {
            background: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
        }

        .btn-outline:hover {
            background: var(--color-primary);
            color: white;
            transform: translateY(-2px);
        }

        .section {
            padding: 5rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .section-title h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(to right, var(--color-primary), var(--color-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-title p {
            font-size: 1.125rem;
            color: var(--color-gray);
            max-width: 42rem;
            margin: 0 auto;
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            height: var(--header-height);
            transition: all var(--transition-base);
        }

        [data-theme="dark"] header {
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-scrolled {
            box-shadow: var(--shadow-xl);
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 3rem;
            height: 3rem;
            background: var(--gradient-primary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            width: 1.5rem;
            height: 1rem;
            background: white;
            border-radius: 50%;
            top: 0.75rem;
            left: 0.75rem;
            opacity: 0.8;
        }

        .logo-icon::after {
            content: '';
            position: absolute;
            width: 0.75rem;
            height: 0.75rem;
            background: white;
            border-radius: 50%;
            top: 1rem;
            left: 1rem;
        }

        .logo-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.75rem;
            font-weight: 800;
            background: linear-gradient(to right, var(--color-primary), var(--color-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            font-weight: 500;
            position: relative;
            padding: 0.5rem 0;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: width var(--transition-base);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.active::after {
            width: 100%;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Autenticación - Versión Desktop */
        .auth-desktop {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .auth-desktop a {
            padding: 0.5rem 1.25rem;
            border-radius: var(--radius-lg);
            font-size: 0.875rem;
            font-weight: 500;
            transition: all var(--transition-fast);
            border: 1px solid transparent;
        }

        .auth-desktop .login {
            color: var(--color-dark);
            border-color: var(--color-light-gray);
        }

        .auth-desktop .login:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .auth-desktop .register {
            background: var(--gradient-primary);
            color: white;
        }

        .auth-desktop .register:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .auth-desktop .dashboard {
            background: var(--gradient-secondary);
            color: white;
        }

        .auth-desktop .dashboard:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Selector de tema */
        .theme-toggle {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: var(--radius-lg);
            background: var(--color-light);
            border: 1px solid var(--color-light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--color-dark);
            transition: all var(--transition-fast);
        }

        .theme-toggle:hover {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .theme-options {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--color-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-2xl);
            padding: 0.5rem;
            min-width: 10rem;
            display: none;
            border: 1px solid var(--color-light-gray);
        }

        .theme-options.active {
            display: block;
            animation: slideDown 0.2s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .theme-option {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .theme-option:hover {
            background: var(--color-light);
        }

        .theme-option i {
            width: 1.25rem;
            text-align: center;
        }

        /* Menú móvil */
        .mobile-menu-btn {
            display: none;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: var(--radius-lg);
            background: var(--color-light);
            border: 1px solid var(--color-light-gray);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--color-dark);
            transition: all var(--transition-fast);
        }

        .mobile-menu-btn:hover {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .mobile-menu {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: 100%;
            background: var(--color-white);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid var(--color-light-gray);
            padding: 1.5rem;
            transform: translateY(-100%);
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-base);
            z-index: 999;
        }

        .mobile-menu.active {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .mobile-nav-links {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .mobile-nav-link {
            padding: 0.875rem 1rem;
            border-radius: var(--radius-lg);
            font-weight: 500;
            background: var(--color-light);
            transition: all var(--transition-fast);
        }

        .mobile-nav-link:hover {
            background: var(--color-primary);
            color: white;
            transform: translateX(4px);
        }

        .mobile-auth {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--color-light-gray);
        }

        .mobile-auth a {
            padding: 0.875rem 1rem;
            border-radius: var(--radius-lg);
            font-weight: 500;
            text-align: center;
            transition: all var(--transition-fast);
        }

        .mobile-auth .login {
            background: transparent;
            color: var(--color-dark);
            border: 2px solid var(--color-light-gray);
        }

        .mobile-auth .login:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .mobile-auth .register {
            background: var(--gradient-primary);
            color: white;
        }

        .mobile-auth .register:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .mobile-auth .dashboard {
            background: var(--gradient-secondary);
            color: white;
        }

        .mobile-auth .dashboard:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Hero Section */
        .hero {
            padding-top: calc(var(--header-height) + 4rem);
            padding-bottom: 5rem;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(30, 64, 175, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(124, 58, 237, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        .hero-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .hero-content p {
            font-size: 1.125rem;
            color: var(--color-gray);
            margin-bottom: 2rem;
        }

        .hero-cta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--color-primary), var(--color-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--color-gray);
        }

        .hero-visual {
            position: relative;
            perspective: 1000px;
        }

        .dashboard-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.95));
            border-radius: 24px;
            padding: 2rem;
            box-shadow:
                0 20px 60px rgba(30, 64, 175, 0.15),
                0 10px 30px rgba(124, 58, 237, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transform-style: preserve-3d;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        [data-theme="dark"] .dashboard-card {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.3),
                0 10px 30px rgba(124, 58, 237, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(30, 64, 175, 0.3), transparent);
        }

        .dashboard-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.6s ease;
        }

        .dashboard-card:hover {
            transform:
                translateY(-20px) rotateX(5deg) rotateY(-5deg) scale(1.02);
            box-shadow:
                0 40px 80px rgba(30, 64, 175, 0.25),
                0 20px 40px rgba(124, 58, 237, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }

        [data-theme="dark"] .dashboard-card:hover {
            box-shadow:
                0 40px 80px rgba(0, 0, 0, 0.4),
                0 20px 40px rgba(124, 58, 237, 0.25),
                inset 0 1px 0 rgba(255, 255, 255, 0.15);
        }

        .dashboard-card:hover::after {
            opacity: 1;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(30, 64, 175, 0.1);
            position: relative;
        }

        [data-theme="dark"] .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
            border-radius: 3px;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--color-dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-title i {
            color: var(--color-primary);
            font-size: 1.5rem;
        }

        .card-date {
            font-size: 0.875rem;
            color: var(--color-gray);
            font-weight: 500;
            padding: 0.5rem 1rem;
            background: rgba(30, 64, 175, 0.08);
            border-radius: 12px;
            border: 1px solid rgba(30, 64, 175, 0.1);
        }

        [data-theme="dark"] .card-date {
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .metric {
            background: rgba(255, 255, 255, 0.6);
            padding: 1.5rem 1rem;
            border-radius: 16px;
            text-align: center;
            border: 1px solid rgba(30, 64, 175, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        [data-theme="dark"] .metric {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .metric:hover {
            transform: translateY(-5px);
            border-color: var(--color-primary);
            box-shadow: 0 10px 20px rgba(30, 64, 175, 0.1);
        }

        [data-theme="dark"] .metric:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .metric::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
            opacity: 0.8;
        }

        .metric:nth-child(1)::before {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
        }

        .metric:nth-child(2)::before {
            background: linear-gradient(90deg, #8b5cf6, #a78bfa);
        }

        .metric:nth-child(3)::before {
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .metric:nth-child(4)::before {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
        }

        .metric-value {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            display: inline-block;
        }

        .metric-value::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .metric:hover .metric-value::after {
            transform: scaleX(1);
        }

        .metric-label {
            font-size: 0.875rem;
            color: var(--color-gray);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .chart-mini {
            height: 120px;
            margin-top: 1rem;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            background: rgba(30, 64, 175, 0.03);
            border: 1px solid rgba(30, 64, 175, 0.08);
        }

        [data-theme="dark"] .chart-mini {
            background: rgba(59, 130, 246, 0.05);
            border: 1px solid rgba(59, 130, 246, 0.1);
        }

        .chart-line {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: flex-end;
            padding: 1rem;
        }

        .chart-point {
            flex: 1;
            height: var(--height, 50%);
            background: linear-gradient(to top, var(--color-primary), var(--color-secondary));
            margin: 0 2px;
            border-radius: 3px 3px 0 0;
            position: relative;
            animation: wave 2s ease-in-out infinite;
            animation-delay: calc(var(--index) * 0.1s);
            opacity: 0.8;
        }

        @keyframes wave {

            0%,
            100% {
                height: var(--height);
            }

            50% {
                height: calc(var(--height) * 1.3);
            }
        }

        .chart-point::after {
            content: '';
            position: absolute;
            top: -3px;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--color-primary);
            border-radius: 50%;
            opacity: 0.8;
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform:
                    translateY(0px) rotateX(0deg) rotateY(0deg);
            }

            33% {
                transform:
                    translateY(-15px) rotateX(1deg) rotateY(-1deg);
            }

            66% {
                transform:
                    translateY(-10px) rotateX(-1deg) rotateY(1deg);
            }
        }

        /* Partículas decorativas */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--color-primary);
            border-radius: 50%;
            opacity: 0.3;
            animation: particle-float 8s linear infinite;
        }

        @keyframes particle-float {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }

            10% {
                opacity: 0.5;
            }

            90% {
                opacity: 0.5;
            }

            100% {
                transform: translateY(-100px) translateX(20px);
                opacity: 0;
            }
        }

        /* Badge de estado */
        .status-badge {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--color-success);
            z-index: 2;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: var(--color-success);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }

        /* Efecto de brillo en hover */
        .dashboard-card:hover .glow-effect {
            opacity: 0.6;
        }

        .glow-effect {
            position: absolute;
            top: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.6s ease;
            pointer-events: none;
            z-index: 0;
        }

        /* Efecto de borde animado */
        .border-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 24px;
            padding: 2px;
            background: linear-gradient(45deg, var(--color-primary), var(--color-secondary), var(--color-primary));
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.6s ease;
        }

        .dashboard-card:hover .border-glow {
            opacity: 1;
            animation: rotate-gradient 3s linear infinite;
        }

        @keyframes rotate-gradient {
            0% {
                background: linear-gradient(45deg, var(--color-primary), var(--color-secondary), var(--color-primary));
            }

            100% {
                background: linear-gradient(405deg, var(--color-primary), var(--color-secondary), var(--color-primary));
            }
        }

        /* Features */
        .features {
            background: var(--color-light);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--color-white);
            padding: 2rem;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-base);
            border: 1px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
            border-color: var(--color-primary);
        }

        .feature-icon {
            width: 4rem;
            height: 4rem;
            background: var(--gradient-primary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: var(--color-gray);
        }

        /* Dashboard Preview - Solo Desktop */
        .dashboard-preview {
            background: var(--gradient-dark);
            border-radius: var(--radius-2xl);
            overflow: hidden;
            box-shadow: var(--shadow-2xl);
            margin-top: 2rem;
            display: none;
        }

        @media (min-width: 1024px) {
            .dashboard-preview {
                display: block;
            }
        }

        .preview-header {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .preview-title {
            color: white;
            font-weight: 600;
        }

        .preview-nav {
            display: flex;
            gap: 1rem;
        }

        .preview-nav a {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            transition: color var(--transition-fast);
        }

        .preview-nav a:hover {
            color: white;
        }

        .preview-content {
            display: flex;
            min-height: 400px;
        }

        .preview-sidebar {
            width: 250px;
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .sidebar-menu a {
            color: rgba(255, 255, 255, 0.7);
            padding: 0.75rem 1rem;
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-menu a.active {
            background: var(--color-primary);
            color: white;
        }

        .preview-main {
            flex: 1;
            padding: 1.5rem;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: var(--radius-xl);
        }

        .chart-card h3 {
            color: white;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .chart-container {
            height: 200px;
            position: relative;
        }

        /* Solutions */
        .solutions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .solution-card {
            background: var(--color-white);
            padding: 2rem;
            border-radius: var(--radius-xl);
            text-align: center;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-base);
            border: 1px solid var(--color-light-gray);
        }

        .solution-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-2xl);
            border-color: var(--color-primary);
        }

        .solution-icon {
            width: 4rem;
            height: 4rem;
            background: var(--gradient-secondary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1.5rem;
        }

        .solution-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .solution-card p {
            color: var(--color-gray);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .solution-link {
            color: var(--color-primary);
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: gap var(--transition-fast);
        }

        .solution-link:hover {
            gap: 0.75rem;
        }

        /* Pricing */
        .pricing {
            background: var(--color-light);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .pricing-card {
            background: var(--color-white);
            border-radius: var(--radius-2xl);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            transition: all var(--transition-base);
            border: 2px solid transparent;
            position: relative;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-2xl);
        }

        .pricing-card.popular {
            border-color: var(--color-primary);
            transform: scale(1.05);
        }

        .pricing-card.popular:hover {
            transform: scale(1.05) translateY(-10px);
        }

        .popular-badge {
            position: absolute;
            top: 1rem;
            right: -2rem;
            background: var(--gradient-accent);
            color: white;
            padding: 0.25rem 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transform: rotate(45deg);
        }

        .pricing-header {
            padding: 2.5rem 2rem;
            text-align: center;
            background: var(--gradient-primary);
            color: white;
        }

        .pricing-card.popular .pricing-header {
            background: var(--gradient-secondary);
        }

        .pricing-name {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .pricing-price {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .pricing-period {
            opacity: 0.9;
            font-size: 0.875rem;
        }

        .pricing-features {
            padding: 2rem;
        }

        .pricing-features ul {
            list-style: none;
        }

        .pricing-features li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            color: var(--color-dark);
        }

        .pricing-features i {
            color: var(--color-success);
            font-size: 1.25rem;
        }

        .pricing-cta {
            padding: 0 2rem 2rem;
        }

        .select-plan-btn {
            width: 100%;
            padding: 1rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: var(--radius-lg);
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-base);
        }

        .select-plan-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .pricing-card.popular .select-plan-btn {
            background: var(--gradient-secondary);
        }

        /* Selection Panel */
        .selection-panel {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 350px;
            max-width: calc(100vw - 4rem);
            background: var(--color-white);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-2xl);
            z-index: 1001;
            transform: translateY(20px) scale(0.95);
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-base);
            border: 1px solid var(--color-light-gray);
            overflow: hidden;
        }

        .selection-panel.active {
            transform: translateY(0) scale(1);
            opacity: 1;
            visibility: visible;
        }

        .panel-header {
            padding: 1.5rem;
            background: var(--gradient-primary);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .close-panel {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 2rem;
            height: 2rem;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: background var(--transition-fast);
        }

        .close-panel:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .panel-content {
            padding: 1.5rem;
            max-height: 400px;
            overflow-y: auto;
        }

        .selected-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--color-light-gray);
        }

        .item-info h4 {
            margin-bottom: 0.25rem;
        }

        .item-price {
            font-weight: 700;
            color: var(--color-primary);
            font-size: 1.25rem;
        }

        .remove-item {
            background: var(--color-light);
            border: none;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-gray);
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .remove-item:hover {
            background: var(--color-danger);
            color: white;
        }

        .panel-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--color-light-gray);
        }

        .panel-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .whatsapp-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 1rem;
            background: #25D366;
            color: white;
            border-radius: var(--radius-lg);
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-base);
        }

        .whatsapp-btn:hover {
            background: #128C7E;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Floating Button */
        .selection-float {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 4rem;
            height: 4rem;
            background: var(--gradient-accent);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: var(--shadow-2xl);
            z-index: 1000;
            transition: all var(--transition-base);
            opacity: 0;
            visibility: hidden;
        }

        .selection-float.active {
            opacity: 1;
            visibility: visible;
        }

        .selection-float:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .float-badge {
            position: absolute;
            top: -0.5rem;
            right: -0.5rem;
            width: 1.5rem;
            height: 1.5rem;
            background: var(--color-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }

        /* Contact */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }

        .contact-info h3 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .contact-info p {
            color: var(--color-gray);
            margin-bottom: 2rem;
        }

        .contact-numbers {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .contact-number {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .number-icon {
            width: 3rem;
            height: 3rem;
            background: var(--gradient-primary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .number-info h4 {
            font-size: 1.125rem;
            margin-bottom: 0.25rem;
        }

        .number-info p {
            color: var(--color-primary);
            font-weight: 600;
            margin: 0;
        }

        .contact-form {
            background: var(--color-white);
            padding: 2.5rem;
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-2xl);
            border: 1px solid var(--color-light-gray);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--color-dark);
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--color-light-gray);
            border-radius: var(--radius-lg);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            transition: all var(--transition-fast);
            background: var(--color-light);
            color: var(--color-dark);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            background: var(--color-white);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* Footer */
        footer {
            background: var(--gradient-dark);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-col h4 {
            color: white;
            margin-bottom: 1.5rem;
            font-size: 1.125rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .footer-logo .logo-icon {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1.25rem;
        }

        .footer-logo .logo-text {
            font-size: 1.5rem;
            background: linear-gradient(to right, white, #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            transition: all var(--transition-fast);
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(4px);
        }

        .footer-contact p {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            width: 2.5rem;
            height: 2.5rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all var(--transition-fast);
        }

        .social-links a:hover {
            background: var(--color-primary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .contact-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .section-title h2 {
                font-size: 2.5rem;
            }

            .hero-content h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 768px) {

            .nav-links,
            .auth-desktop,
            .theme-selector {
                display: none;
            }

            .mobile-menu-btn {
                display: flex;
            }

            .hero {
                padding-top: calc(var(--header-height) + 2rem);
                padding-bottom: 3rem;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .section {
                padding: 3rem 0;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .hero-stats {
                flex-wrap: wrap;
                gap: 1.5rem;
            }

            .pricing-card.popular {
                transform: none;
            }

            .pricing-card.popular:hover {
                transform: translateY(-10px);
            }

            .selection-panel {
                width: 90%;
                right: 5%;
                bottom: 5rem;
            }

            .selection-float {
                right: 5%;
                bottom: 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .container {
                padding: 0 1rem;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-cta {
                flex-direction: column;
                align-items: stretch;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .features-grid,
            .solutions-grid,
            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .contact-form {
                padding: 1.5rem;
            }
        }

        /* Animaciones */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Estilos para elementos específicos */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hover-lift {
            transition: transform var(--transition-base);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
        }

        .gradient-text {
            background: linear-gradient(to right, var(--color-primary), var(--color-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header id="header">
        <div class="container header-container">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-cat"></i>
                </div>
                <div class="logo-text">TUXON</div>
            </div>

            <nav class="nav-links">
                <a href="#home" class="nav-link active">Inicio</a>
                <a href="#features" class="nav-link">Características</a>
                <a href="#dashboard" class="nav-link">Dashboard</a>
                <a href="#solutions" class="nav-link">Soluciones</a>
                <a href="#pricing" class="nav-link">Planes</a>
                <a href="#contact" class="nav-link">Contacto</a>
            </nav>

            <div class="header-actions">
                <!-- Autenticación Desktop -->
                <div class="auth-desktop">
                    <!-- Laravel Blade Directives - Esto será procesado por Laravel -->
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/inicio') }}" class="dashboard">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="login">
                                <i class="fas fa-sign-in-alt"></i> Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="register">
                                    <i class="fas fa-user-plus"></i> Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Selector de Tema -->
                <div class="theme-selector">
                    <button class="theme-toggle" id="theme-toggle">
                        <i class="fas fa-moon"></i>
                    </button>
                    <div class="theme-options" id="theme-options">
                        <div class="theme-option" data-theme="light">
                            <i class="fas fa-sun"></i>
                            <span>Claro</span>
                        </div>
                        <div class="theme-option" data-theme="dark">
                            <i class="fas fa-moon"></i>
                            <span>Oscuro</span>
                        </div>
                        <div class="theme-option" data-theme="system">
                            <i class="fas fa-desktop"></i>
                            <span>Sistema</span>
                        </div>
                    </div>
                </div>

                <!-- Botón Menú Móvil -->
                <button class="mobile-menu-btn" id="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Menú Móvil -->
        <div class="mobile-menu" id="mobile-menu">
            <div class="mobile-nav-links">
                <a href="#home" class="mobile-nav-link active">Inicio</a>
                <a href="#features" class="mobile-nav-link">Características</a>
                <a href="#dashboard" class="mobile-nav-link">Dashboard</a>
                <a href="#solutions" class="mobile-nav-link">Soluciones</a>
                <a href="#pricing" class="mobile-nav-link">Planes</a>
                <a href="#contact" class="mobile-nav-link">Contacto</a>
            </div>

            <!-- Autenticación Móvil -->
            <div class="mobile-auth">
                <!-- Laravel Blade Directives - Esto será procesado por Laravel -->
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/inicio') }}" class="dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="login">
                            <i class="fas fa-sign-in-alt"></i> Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="register">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="hero-container">
                <div class="hero-content">
                    <h1>Potencia tu negocio con el <span class="gradient-text">ERP más moderno</span></h1>
                    <p>Gestiona todas las operaciones de tu empresa desde una sola plataforma en la nube. Multiempresa,
                        multisucursal y 100% en línea.</p>
                    <div class="hero-cta">
                        <a href="#pricing" class="btn btn-primary">
                            <i class="fas fa-rocket"></i> Comenzar ahora
                        </a>
                        <a href="#features" class="btn btn-outline">
                            <i class="fas fa-play-circle"></i> Ver demostración
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat">
                            <div class="stat-value">+500</div>
                            <div class="stat-label">Empresas confían en nosotros</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">99.9%</div>
                            <div class="stat-label">Disponibilidad</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">24/7</div>
                            <div class="stat-label">Soporte especializado</div>
                        </div>
                    </div>
                </div>
                <div class="hero-visual">
                    <!-- Nuevo Dashboard Card Mejorado -->
                    <div class="dashboard-card floating">
                        <!-- Efectos visuales -->
                        <div class="glow-effect"></div>
                        <div class="border-glow"></div>
                        <div class="particles" id="particles-container"></div>

                        <!-- Badge de estado -->
                        <div class="status-badge">
                            <div class="status-dot"></div>
                            <span>En tiempo real</span>
                        </div>

                        <!-- Encabezado -->
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-tachometer-alt"></i>
                                Panel de Control
                            </div>
                            <div class="card-date" id="current-date"></div>
                        </div>

                        <!-- Métricas -->
                        <div class="metrics-grid">
                            <div class="metric">
                                <div class="metric-value" data-target="12500">$12.5K</div>
                                <div class="metric-label">Ventas Hoy</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value" data-target="243">243</div>
                                <div class="metric-label">Clientes</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value" data-target="89">89</div>
                                <div class="metric-label">Órdenes</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value" data-target="92">92%</div>
                                <div class="metric-label">Inventario</div>
                            </div>
                        </div>

                        <!-- Gráfico mini animado -->
                        <div class="chart-mini">
                            <div class="chart-line" id="mini-chart"></div>
                        </div>

                        <!-- Indicadores adicionales -->
                        <div
                            style="display: flex; justify-content: space-between; margin-top: 1.5rem; font-size: 0.875rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-arrow-up" style="color: var(--color-success);"></i>
                                <span style="color: var(--color-gray);">+12% vs ayer</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-bolt" style="color: var(--color-accent);"></i>
                                <span style="color: var(--color-gray);">Rendimiento óptimo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="section features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Características Principales</h2>
                <p>Descubre todas las ventajas que nuestro ERP ofrece para optimizar tu negocio</p>
            </div>
            <div class="features-grid">
                <div class="feature-card hover-lift">
                    <div class="feature-icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3>100% en la Nube</h3>
                    <p>Accede desde cualquier dispositivo sin necesidad de instalaciones complejas. Todo en línea y
                        actualizado en tiempo real.</p>
                </div>
                <div class="feature-card hover-lift">
                    <div class="feature-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <h3>Multiempresa</h3>
                    <p>Gestiona múltiples empresas y sucursales desde una sola cuenta con perfiles de acceso
                        personalizados para cada usuario.</p>
                </div>
                <div class="feature-card hover-lift">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Dashboard Inteligente</h3>
                    <p>Toma decisiones basadas en datos con nuestro dashboard interactivo y reportes personalizados en
                        tiempo real.</p>
                </div>
                <div class="feature-card hover-lift">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Seguridad Avanzada</h3>
                    <p>Encriptación de extremo a extremo, copias de seguridad automáticas y autenticación de dos
                        factores.</p>
                </div>
                <div class="feature-card hover-lift">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Totalmente Responsivo</h3>
                    <p>Interfaz adaptativa que funciona perfectamente en computadoras, tablets y smartphones.</p>
                </div>
                <div class="feature-card hover-lift">
                    <div class="feature-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3>Actualizaciones Automáticas</h3>
                    <p>Siempre tendrás la última versión sin costos adicionales. Nos encargamos de las actualizaciones
                        por ti.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview -->
    <section class="section dashboard-preview" id="dashboard">
        <div class="container">
            <div class="section-title">
                <h2>Dashboard Avanzado</h2>
                <p>Visualiza el rendimiento de tu empresa con nuestro panel de control interactivo (Solo visible en
                    desktop)</p>
            </div>
            <div class="dashboard-preview">
                <div class="preview-header">
                    <div class="preview-title">Panel de Control TUXON ERP</div>
                    <nav class="preview-nav">
                        <a href="#" class="active">Dashboard</a>
                        <a href="#">Ventas</a>
                        <a href="#">Inventario</a>
                        <a href="#">Reportes</a>
                    </nav>
                </div>
                <div class="preview-content">
                    <div class="preview-sidebar">
                        <div class="sidebar-menu">
                            <a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                            <a href="#"><i class="fas fa-shopping-cart"></i> Ventas</a>
                            <a href="#"><i class="fas fa-boxes"></i> Inventario</a>
                            <a href="#"><i class="fas fa-users"></i> Clientes</a>
                            <a href="#"><i class="fas fa-chart-bar"></i> Reportes</a>
                            <a href="#"><i class="fas fa-cog"></i> Configuración</a>
                        </div>
                    </div>
                    <div class="preview-main">
                        <div class="charts-grid">
                            <div class="chart-card">
                                <h3>Ventas Mensuales</h3>
                                <div class="chart-container">
                                    <canvas id="sales-chart"></canvas>
                                </div>
                            </div>
                            <div class="chart-card">
                                <h3>Distribución por Categoría</h3>
                                <div class="chart-container">
                                    <canvas id="category-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions -->
    <section class="section solutions" id="solutions">
        <div class="container">
            <div class="section-title">
                <h2>Soluciones Especializadas</h2>
                <p>Adaptamos nuestro ERP a las necesidades específicas de cada industria</p>
            </div>
            <div class="solutions-grid">
                <div class="solution-card hover-lift">
                    <div class="solution-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>E-commerce</h3>
                    <p>Sistema completo para tiendas online con gestión de productos, pedidos y pagos.</p>
                    <a href="#" class="solution-link">
                        Ver más <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="solution-card hover-lift">
                    <div class="solution-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <h3>Gimnasios</h3>
                    <p>Control de membresías, clases y pagos para centros deportivos y gimnasios.</p>
                    <a href="#" class="solution-link">
                        Ver más <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="solution-card hover-lift">
                    <div class="solution-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3>Restaurantes</h3>
                    <p>Sistema POS para gestión de mesas, pedidos y control de inventario.</p>
                    <a href="#" class="solution-link">
                        Ver más <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="solution-card hover-lift">
                    <div class="solution-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3>Servicios</h3>
                    <p>Gestión de proyectos, clientes y facturación para empresas de servicios.</p>
                    <a href="#" class="solution-link">
                        Ver más <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="section pricing" id="pricing">
        <div class="container">
            <div class="section-title">
                <h2>Planes y Precios</h2>
                <p>Elige el plan perfecto para el crecimiento de tu empresa</p>
            </div>
            <div class="pricing-grid">
                <div class="pricing-card" data-plan="basico" data-price="49">
                    <div class="pricing-header">
                        <div class="pricing-name">Básico</div>
                        <div class="pricing-price">$49<span>/mes</span></div>
                        <div class="pricing-period">Facturación mensual</div>
                    </div>
                    <div class="pricing-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Hasta 5 usuarios</li>
                            <li><i class="fas fa-check"></i> 1 empresa y 3 sucursales</li>
                            <li><i class="fas fa-check"></i> Dashboard básico</li>
                            <li><i class="fas fa-check"></i> Gestión de inventario</li>
                            <li><i class="fas fa-check"></i> Reportes estándar</li>
                            <li><i class="fas fa-check"></i> Soporte por email</li>
                        </ul>
                    </div>
                    <div class="pricing-cta">
                        <button class="select-plan-btn" data-plan="basico" data-price="49" data-name="Plan Básico">
                            Seleccionar Plan
                        </button>
                    </div>
                </div>

                <div class="pricing-card popular" data-plan="profesional" data-price="89">
                    <div class="popular-badge">Popular</div>
                    <div class="pricing-header">
                        <div class="pricing-name">Profesional</div>
                        <div class="pricing-price">$89<span>/mes</span></div>
                        <div class="pricing-period">Facturación mensual</div>
                    </div>
                    <div class="pricing-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Hasta 15 usuarios</li>
                            <li><i class="fas fa-check"></i> 3 empresas y 10 sucursales</li>
                            <li><i class="fas fa-check"></i> Dashboard avanzado</li>
                            <li><i class="fas fa-check"></i> Gestión de inventario avanzada</li>
                            <li><i class="fas fa-check"></i> Reportes personalizados</li>
                            <li><i class="fas fa-check"></i> Soporte prioritario 24/7</li>
                        </ul>
                    </div>
                    <div class="pricing-cta">
                        <button class="select-plan-btn" data-plan="profesional" data-price="89"
                            data-name="Plan Profesional">
                            Seleccionar Plan
                        </button>
                    </div>
                </div>

                <div class="pricing-card" data-plan="empresarial" data-price="149">
                    <div class="pricing-header">
                        <div class="pricing-name">Empresarial</div>
                        <div class="pricing-price">$149<span>/mes</span></div>
                        <div class="pricing-period">Facturación mensual</div>
                    </div>
                    <div class="pricing-features">
                        <ul>
                            <li><i class="fas fa-check"></i> Usuarios ilimitados</li>
                            <li><i class="fas fa-check"></i> Empresas y sucursales ilimitadas</li>
                            <li><i class="fas fa-check"></i> Dashboard personalizado</li>
                            <li><i class="fas fa-check"></i> Gestión de inventario completa</li>
                            <li><i class="fas fa-check"></i> Reportes analíticos avanzados</li>
                            <li><i class="fas fa-check"></i> Soporte dedicado y consultoría</li>
                        </ul>
                    </div>
                    <div class="pricing-cta">
                        <button class="select-plan-btn" data-plan="empresarial" data-price="149"
                            data-name="Plan Empresarial">
                            Seleccionar Plan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="section contact" id="contact">
        <div class="container">
            <div class="section-title">
                <h2>Contáctanos</h2>
                <p>Estamos aquí para ayudarte a transformar tu negocio</p>
            </div>
            <div class="contact-grid">
                <div class="contact-info">
                    <h3>Hablemos sobre tu proyecto</h3>
                    <p>Nuestro equipo de expertos está listo para asesorarte y mostrar cómo TUXON puede optimizar las
                        operaciones de tu empresa.</p>
                    <div class="contact-numbers">
                        <div class="contact-number">
                            <div class="number-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="number-info">
                                <h4>Ventas</h4>
                                <p>+591 78538094</p>
                            </div>
                        </div>
                        <div class="contact-number">
                            <div class="number-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="number-info">
                                <h4>Soporte Técnico</h4>
                                <p>+591 78538094</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-form">
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="company" class="form-label">Empresa</label>
                            <input type="text" id="company" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="message" class="form-label">Mensaje</label>
                            <textarea id="message" class="form-control"
                                placeholder="Cuéntanos sobre tu proyecto..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-paper-plane"></i> Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <div class="logo-icon">
                            <i class="fas fa-cat"></i>
                        </div>
                        <div class="logo-text">TUXON</div>
                    </div>
                    <p>Desarrollamos soluciones ERP innovadoras que transforman la gestión empresarial y potencian el
                        crecimiento.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Enlaces Rápidos</h4>
                    <div class="footer-links">
                        <a href="#home">Inicio</a>
                        <a href="#features">Características</a>
                        <a href="#dashboard">Dashboard</a>
                        <a href="#solutions">Soluciones</a>
                        <a href="#pricing">Planes</a>
                        <a href="#contact">Contacto</a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Contacto</h4>
                    <div class="footer-contact">
                        <p><i class="fas fa-map-marker-alt"></i> Bolivia Santa Cruz - Montero</p>
                        <p><i class="fas fa-clock"></i> Lunes a Viernes: 9am - 6pm</p>
                        <p><i class="fas fa-envelope"></i> info@tuxon.com</p>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2026 TUXON. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Panel de Selección -->
    <div class="selection-panel" id="selection-panel">
        <div class="panel-header">
            <div class="panel-title">Tu Selección</div>
            <button class="close-panel" id="close-panel">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="panel-content" id="panel-content">
            <p style="text-align: center; color: var(--color-gray); padding: 2rem 0;">No has seleccionado ningún plan
            </p>
        </div>
        <div class="panel-footer" id="panel-footer" style="display: none;">
            <div class="panel-total">
                <span>Total mensual:</span>
                <span id="total-price">$0</span>
            </div>
            <a href="#" class="whatsapp-btn" id="whatsapp-btn" target="_blank">
                <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
            </a>
        </div>
    </div>

    <!-- Botón Flotante -->
    <div class="selection-float" id="selection-float">
        <i class="fas fa-shopping-cart"></i>
        <div class="float-badge" id="float-badge">0</div>
    </div>

    <script>
        // Variables globales
        let currentTheme = localStorage.getItem('theme') || 'light';
        let selectedPlan = null;

        // Inicializar cuando el DOM esté cargado
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializar fecha
            updateCurrentDate();
            // INICIALIZAR NUEVAS FUNCIONALIDADES
            initParticles();
            initMiniChart();
            animateNumbers();
            initTiltEffect();
            updateRealTimeMetrics();

            // Inicializar tema
            initTheme();

            // Inicializar gráficos solo en desktop
            if (window.innerWidth > 1024) {
                initCharts();
            }

            // Inicializar eventos
            initEvents();

            // Manejar redimensionamiento
            window.addEventListener('resize', handleResize);

            // Efecto de scroll en header
            window.addEventListener('scroll', handleScroll);

            // Inicializar animaciones
            initAnimations();
        });
        // NUEVO: Efecto de tilt 3D mejorado
        function initTiltEffect() {
            const card = document.querySelector('.dashboard-card');
            if (!card) return;

            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateY = ((x - centerX) / centerX) * 5; // ±5 grados
                const rotateX = ((centerY - y) / centerY) * 5; // ±5 grados

                card.style.transform = `
                    translateY(-20px)
                    rotateX(${rotateX}deg)
                    rotateY(${rotateY}deg)
                    scale(1.02)
                `;

                // Efecto de movimiento de partículas
                const particles = document.querySelectorAll('.particle');
                particles.forEach(particle => {
                    const speed = 0.5;
                    particle.style.transform = `translate(${rotateY * speed}px, ${rotateX * speed}px)`;
                });
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = `
                    translateY(0)
                    rotateX(0)
                    rotateY(0)
                    scale(1)
                `;

                // Restaurar partículas
                const particles = document.querySelectorAll('.particle');
                particles.forEach(particle => {
                    particle.style.transform = 'translate(0, 0)';
                });
            });
        }


        // NUEVO: Inicializar partículas
        function initParticles() {
            const container = document.getElementById('particles-container');
            if (!container) return;

            const particleCount = 15;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';

                // Posición aleatoria
                const left = Math.random() * 100;
                const top = Math.random() * 100;
                const delay = Math.random() * 8;
                const size = 2 + Math.random() * 4;

                particle.style.left = `${left}%`;
                particle.style.top = `${top}%`;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.animationDelay = `${delay}s`;

                // Color aleatorio del gradiente
                const colors = [
                    'rgba(59, 130, 246, 0.4)',
                    'rgba(124, 58, 237, 0.4)',
                    'rgba(245, 158, 11, 0.4)',
                    'rgba(16, 185, 129, 0.4)'
                ];
                particle.style.background = colors[Math.floor(Math.random() * colors.length)];

                container.appendChild(particle);
            }
        }

        // NUEVO: Inicializar gráfico mini
        function initMiniChart() {
            const chartLine = document.getElementById('mini-chart');
            if (!chartLine) return;

            const dataPoints = [40, 65, 80, 55, 90, 75, 85, 70, 95, 60, 85, 70];
            const maxHeight = Math.max(...dataPoints);

            chartLine.innerHTML = '';

            dataPoints.forEach((value, index) => {
                const point = document.createElement('div');
                point.className = 'chart-point';
                point.style.setProperty('--height', `${(value / maxHeight) * 80}%`);
                point.style.setProperty('--index', index);

                // Colores alternados
                if (index % 4 === 0) {
                    point.style.background = 'linear-gradient(to top, #3b82f6, #60a5fa)';
                } else if (index % 4 === 1) {
                    point.style.background = 'linear-gradient(to top, #8b5cf6, #a78bfa)';
                } else if (index % 4 === 2) {
                    point.style.background = 'linear-gradient(to top, #10b981, #34d399)';
                } else {
                    point.style.background = 'linear-gradient(to top, #f59e0b, #fbbf24)';
                }

                chartLine.appendChild(point);
            });
        }

        // NUEVO: Animación de números contadores
        function animateNumbers() {
            const metricValues = document.querySelectorAll('.metric-value');

            metricValues.forEach(element => {
                const target = element.getAttribute('data-target');
                if (!target) return;

                const value = element.textContent;
                const isCurrency = value.includes('$');
                const isPercentage = value.includes('%');
                const numericValue = parseFloat(value.replace(/[^0-9.-]+/g, ""));
                const targetValue = parseFloat(target);

                let startTime = null;
                const duration = 2000;

                function animateCounter(timestamp) {
                    if (!startTime) startTime = timestamp;
                    const progress = Math.min((timestamp - startTime) / duration, 1);

                    // Easing function
                    const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                    const currentValue = numericValue + (targetValue - numericValue) * easeOutQuart;

                    let displayValue;
                    if (isCurrency) {
                        displayValue = `$${(currentValue / 1000).toFixed(1)}K`;
                    } else if (isPercentage) {
                        displayValue = `${Math.round(currentValue)}%`;
                    } else {
                        displayValue = Math.round(currentValue);
                    }

                    element.textContent = displayValue;

                    if (progress < 1) {
                        requestAnimationFrame(animateCounter);
                    }
                }

                // Iniciar animación cuando el elemento sea visible
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            requestAnimationFrame(animateCounter);
                            observer.unobserve(entry.target);
                        }
                    });
                });

                observer.observe(element);
            });
        }

        // NUEVO: Actualizar métricas en tiempo real
        function updateRealTimeMetrics() {
            setInterval(() => {
                const metrics = document.querySelectorAll('.metric-value');

                metrics.forEach(metric => {
                    const currentText = metric.textContent;
                    const isCurrency = currentText.includes('$');
                    const isPercentage = currentText.includes('%');

                    let currentValue = parseFloat(currentText.replace(/[^0-9.-]+/g, ""));
                    let newValue;

                    // Pequeña variación aleatoria
                    if (isCurrency) {
                        const variation = Math.random() * 200 - 100; // -100 a +100
                        newValue = Math.max(10000, currentValue * 1000 + variation);
                        metric.textContent = `$${(newValue / 1000).toFixed(1)}K`;
                    } else if (isPercentage) {
                        const variation = Math.random() * 2 - 1; // -1% a +1%
                        newValue = Math.max(80, Math.min(100, currentValue + variation));
                        metric.textContent = `${Math.round(newValue)}%`;
                    } else {
                        const variation = Math.random() * 10 - 5; // -5 a +5
                        newValue = Math.max(200, Math.round(currentValue + variation));
                        metric.textContent = newValue;
                    }

                    // Actualizar data-target para futuras animaciones
                    metric.setAttribute('data-target', isCurrency ? (newValue / 1000).toFixed(1) : Math.round(newValue));
                });
            }, 10000); // Actualizar cada 10 segundos
        }


        // Actualizar fecha
        function updateCurrentDate() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('current-date').textContent =
                now.toLocaleDateString('es-ES', options);
        }

        // Inicializar tema
        function initTheme() {
            const savedTheme = localStorage.getItem('theme');

            if (savedTheme === 'system') {
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                currentTheme = systemPrefersDark ? 'dark' : 'light';
                localStorage.setItem('theme', 'system');
            } else if (savedTheme) {
                currentTheme = savedTheme;
                localStorage.setItem('theme', currentTheme);
            }

            applyTheme(currentTheme);

            // Escuchar cambios del sistema
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
                if (localStorage.getItem('theme') === 'system') {
                    currentTheme = e.matches ? 'dark' : 'light';
                    applyTheme(currentTheme);
                }
            });
        }

        // Aplicar tema
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);

            // Actualizar ícono
            const icon = document.querySelector('#theme-toggle i');
            if (theme === 'dark') {
                icon.className = 'fas fa-sun';
            } else {
                icon.className = 'fas fa-moon';
            }
        }

        // Inicializar gráficos
        function initCharts() {
            // Gráfico de ventas
            const salesCtx = document.getElementById('sales-chart');
            if (salesCtx) {
                new Chart(salesCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        datasets: [{
                            label: 'Ventas',
                            data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 32000, 40000, 38000, 45000],
                            borderColor: 'rgba(59, 130, 246, 0.8)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                },
                                ticks: {
                                    color: 'rgba(255, 255, 255, 0.7)',
                                    callback: function (value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                },
                                ticks: {
                                    color: 'rgba(255, 255, 255, 0.7)'
                                }
                            }
                        }
                    }
                });
            }

            // Gráfico de categorías
            const categoryCtx = document.getElementById('category-chart');
            if (categoryCtx) {
                new Chart(categoryCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Electrónicos', 'Ropa', 'Hogar', 'Alimentos', 'Otros'],
                        datasets: [{
                            data: [35, 25, 20, 15, 5],
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(124, 58, 237, 0.8)',
                                'rgba(245, 158, 11, 0.8)',
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(100, 116, 139, 0.8)'
                            ],
                            borderWidth: 1,
                            borderColor: 'rgba(255, 255, 255, 0.1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: 'rgba(255, 255, 255, 0.7)',
                                    padding: 20
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            }
        }

        // Inicializar eventos
        function initEvents() {
            // Menú móvil
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
                mobileMenuBtn.innerHTML = mobileMenu.classList.contains('active')
                    ? '<i class="fas fa-times"></i>'
                    : '<i class="fas fa-bars"></i>';
            });

            // Cerrar menú al hacer clic en enlaces
            document.querySelectorAll('.mobile-nav-link, .mobile-auth a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                });
            });

            // Selector de tema
            document.getElementById('theme-toggle').addEventListener('click', (e) => {
                e.stopPropagation();
                const options = document.getElementById('theme-options');
                options.classList.toggle('active');
            });

            document.querySelectorAll('.theme-option').forEach(option => {
                option.addEventListener('click', function () {
                    const theme = this.getAttribute('data-theme');
                    changeTheme(theme);
                });
            });

            // Cerrar menús al hacer clic fuera
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.theme-selector')) {
                    document.getElementById('theme-options').classList.remove('active');
                }
                if (!e.target.closest('#mobile-menu') && !e.target.closest('#mobile-menu-btn')) {
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                }
                if (!e.target.closest('.selection-panel') && !e.target.closest('.selection-float') && !e.target.closest('.select-plan-btn')) {
                    closeSelectionPanel();
                }
            });

            // Selección de planes
            document.querySelectorAll('.select-plan-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const plan = this.getAttribute('data-plan');
                    const price = parseInt(this.getAttribute('data-price'));
                    const name = this.getAttribute('data-name');

                    selectPlan(plan, price, name);
                });
            });

            // Panel de selección
            document.getElementById('close-panel').addEventListener('click', closeSelectionPanel);
            document.getElementById('selection-float').addEventListener('click', toggleSelectionPanel);

            // Formulario de contacto
            document.getElementById('contactForm').addEventListener('submit', function (e) {
                e.preventDefault();
                showNotification('¡Mensaje enviado! Te contactaremos pronto.', 'success');
                this.reset();
            });

            // Scroll suave
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const target = document.querySelector(targetId);
                    if (target) {
                        const headerHeight = document.querySelector('header').offsetHeight;
                        const targetPosition = target.offsetTop - headerHeight;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Navegación activa
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link');

            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    if (scrollY >= sectionTop - 200) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${current}`) {
                        link.classList.add('active');
                    }
                });
            });
        }

        // Cambiar tema
        function changeTheme(theme) {
            if (theme === 'system') {
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                currentTheme = systemPrefersDark ? 'dark' : 'light';
                localStorage.setItem('theme', 'system');
            } else {
                currentTheme = theme;
                localStorage.setItem('theme', theme);
            }

            applyTheme(currentTheme);
            document.getElementById('theme-options').classList.remove('active');
        }

        // Seleccionar plan
        function selectPlan(plan, price, name) {
            selectedPlan = { plan, price, name };
            updateSelectionUI();
            document.getElementById('selection-float').classList.add('active');
            openSelectionPanel();

            // Mostrar notificación
            showNotification(`Plan ${name} seleccionado`, 'success');
        }

        // Actualizar UI de selección
        function updateSelectionUI() {
            const panelContent = document.getElementById('panel-content');
            const panelFooter = document.getElementById('panel-footer');
            const floatBadge = document.getElementById('float-badge');
            const totalPrice = document.getElementById('total-price');
            const whatsappBtn = document.getElementById('whatsapp-btn');

            if (!selectedPlan) {
                panelContent.innerHTML = '<p style="text-align: center; color: var(--color-gray); padding: 2rem 0;">No has seleccionado ningún plan</p>';
                panelFooter.style.display = 'none';
                floatBadge.textContent = '0';
                return;
            }

            // Actualizar contenido del panel
            panelContent.innerHTML = `
                <div class="selected-item">
                    <div class="item-info">
                        <h4>${selectedPlan.name}</h4>
                        <p style="color: var(--color-gray); font-size: 0.875rem;">Facturación mensual</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div class="item-price">$${selectedPlan.price}/mes</div>
                        <button class="remove-item" onclick="removePlan()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            // Actualizar total
            totalPrice.textContent = `$${selectedPlan.price}/mes`;
            panelFooter.style.display = 'block';

            // Actualizar botón de WhatsApp
            const phoneNumbers = ['51987654321', '51912345678']; // Dos números de referencia
            const selectedNumber = phoneNumbers[Math.floor(Math.random() * phoneNumbers.length)];
            const message = `¡Hola TUXON! 👋\n\nEstoy interesado en el *${selectedPlan.name}* ($${selectedPlan.price}/mes) y me gustaría:\n• Recibir más información\n• Solicitar una demostración\n• Consultar sobre implementación\n\nMi nombre es [Tu Nombre] y mi empresa es [Nombre Empresa].`;
            const encodedMessage = encodeURIComponent(message);
            whatsappBtn.href = `https://wa.me/${selectedNumber}?text=${encodedMessage}`;

            // Actualizar badge
            floatBadge.textContent = '1';
        }

        // Remover plan
        function removePlan() {
            selectedPlan = null;
            updateSelectionUI();
            document.getElementById('selection-float').classList.remove('active');
            showNotification('Plan removido', 'info');
        }

        // Abrir panel de selección
        function openSelectionPanel() {
            document.getElementById('selection-panel').classList.add('active');
        }

        // Cerrar panel de selección
        function closeSelectionPanel() {
            document.getElementById('selection-panel').classList.remove('active');
        }

        // Alternar panel de selección
        function toggleSelectionPanel() {
            const panel = document.getElementById('selection-panel');
            panel.classList.toggle('active');
        }

        // Manejar redimensionamiento
        function handleResize() {
            // Ocultar/mostrar dashboard según tamaño
            const dashboardSection = document.querySelector('.dashboard-preview');
            if (window.innerWidth <= 1024) {
                dashboardSection.style.display = 'none';
            } else {
                dashboardSection.style.display = 'block';
            }
        }

        // Manejar scroll
        function handleScroll() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        }

        // Inicializar animaciones
        function initAnimations() {
            // Observador de intersección para animaciones
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, observerOptions);

            // Observar elementos para animaciones
            document.querySelectorAll('.feature-card, .solution-card, .pricing-card').forEach(el => {
                observer.observe(el);
            });
        }

        // Mostrar notificación
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div style="
                    position: fixed;
                    top: 100px;
                    right: 20px;
                    background: ${type === 'success' ? 'var(--color-success)' : 'var(--color-warning)'};
                    color: white;
                    padding: 1rem 1.5rem;
                    border-radius: var(--radius-lg);
                    box-shadow: var(--shadow-xl);
                    z-index: 10000;
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                    animation: slideIn 0.3s ease;
                ">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Estilos para animaciones de notificación
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            
            .animate-in {
                animation: fadeInUp 0.6s ease;
            }
            
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>