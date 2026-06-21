<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SIGAP TUHA - Karang Taruna Kecamatan Pandrah, Kabupaten Bireuen')</title>
    <meta name="description"
        content="SIGAP TUHA - Siaga, Tanggap dan Peduli untuk Lansia Pasca Bencana. Program Karang Taruna Kecamatan Pandrah, Kabupaten Bireuen." />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy: #0b2c6b;
            --navy-dark: #072150;
            --blue: #1d4ed8;
            --blue-mid: #2563eb;
            --gold: #f5b400;
            --gold-light: #fbc531;
            --red: #d12027;
            --ink: #0f2350;
            --muted: #4b5b76;
            --soft: #eef3fb;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            background: #eef3fb;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--ink);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .hero {
            position: relative;
            overflow: hidden;
            height: 100vh;
            min-height: 660px;
            display: flex;
            flex-direction: column;
        }

        @media (max-width:860px) {
            .hero {
                height: auto;
                min-height: 100vh;
                overflow: visible;
            }
        }

        .hero.hero--subpage {
            height: auto;
            min-height: 100vh;
            overflow: visible;
        }

        .hero>.container {
            display: flex;
            flex-direction: column;
            width: 100%;
            flex: 1;
        }

        .hero.hero--subpage>.container {
            height: auto;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            display: block;
        }

        .hero-bg .bg-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.12) 0%,
                    rgba(255, 255, 255, 0.08) 35%,
                    rgba(255, 255, 255, 0.03) 65%,
                    rgba(11, 44, 107, 0.01) 100%);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 5;
            max-width: 1680px;
            margin: 0 auto;
            padding: 0 28px;
        }

        /* NAV */
        nav {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 0 10px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand .logo {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand .logo svg {
            width: 34px;
            height: 34px;
        }

        .brand .name {
            line-height: 1.15;
        }

        .brand .name b {
            display: block;
            font-size: 19px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: .3px;
        }

        .brand .name span {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--muted);
            letter-spacing: .5px;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .menu a {
            padding: 10px 16px;
            border-radius: 22px;
            font-size: 15px;
            font-weight: 600;
            color: #2a3a55;
            transition: .2s;
        }

        .menu a:hover {
            color: var(--blue);
        }

        .menu a.active {
            background: var(--navy);
            color: #fff;
            box-shadow: 0 6px 16px rgba(11, 44, 107, .3);
        }

        /* Hamburger / Mobile Menu */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            z-index: 100;
        }

        .hamburger span {
            display: block;
            width: 26px;
            height: 3px;
            background: var(--navy);
            border-radius: 3px;
            transition: .3s;
        }

        .hamburger.open span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 6px);
        }

        .hamburger.open span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.open span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -6px);
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 35, 80, 0.6);
            backdrop-filter: blur(4px);
            z-index: 90;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s;
        }

        .mobile-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            right: -300px;
            width: 280px;
            max-width: 80vw;
            height: 100vh;
            background: #fff;
            z-index: 95;
            padding: 90px 28px 40px;
            box-shadow: -10px 0 40px rgba(11, 44, 107, .2);
            transition: right .35s cubic-bezier(.4, 0, .2, 1);
            overflow-y: auto;
        }

        .mobile-menu.open {
            right: 0;
        }

        .mobile-menu a {
            display: block;
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 600;
            color: #2a3a55;
            transition: .2s;
            margin-bottom: 4px;
        }

        .mobile-menu a:hover {
            background: var(--soft);
            color: var(--blue);
        }

        .mobile-menu a.active {
            background: var(--navy);
            color: #fff;
        }

        /* HERO CONTENT (TEKS DI DEPAN) */
        .hero-grid {
            flex: 1 1 auto;
            display: grid;
            grid-template-columns: 1.05fr 1fr;
            gap: 30px;
            align-items: center;
            padding: 10px 0 20px;
        }

        .headline-row {
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }

        .heart-logo {
            flex: 0 0 auto;
            width: 140px;
            height: 140px;
            margin-top: -8px;
        }

        .heart-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .title h1 {
            font-size: 84px;
            line-height: .92;
            font-weight: 900;
            letter-spacing: -1px;
            text-shadow: 0 2px 10px rgba(255, 255, 255, 0.95), 0 0 20px rgba(255, 255, 255, 0.8);
        }

        .title .sigap {
            color: var(--navy);
            display: block;
        }

        .title .tuha {
            color: var(--red);
            display: block;
        }

        .subtitle {
            margin-top: 18px;
            font-size: 27px;
            font-weight: 800;
            color: #1f3357;
            line-height: 1.25;
            text-shadow: 0 2px 10px rgba(255, 255, 255, 0.9);
        }

        .subtitle .accent {
            color: var(--blue);
        }

        .desc {
            margin-top: 18px;
            font-size: 16.5px;
            color: #112244;
            max-width: 430px;
            font-weight: 700;
            text-shadow: 0 2px 8px rgba(255, 255, 255, 0.9);
        }

        .cta {
            display: flex;
            gap: 16px;
            margin-top: 28px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 26px;
            border-radius: 32px;
            font-size: 15.5px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: .2s;
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        .btn-primary {
            background: var(--navy);
            color: #fff;
            box-shadow: 0 10px 22px rgba(11, 44, 107, .32);
        }

        .btn-primary:hover {
            background: var(--navy-dark);
            transform: translateY(-2px);
        }

        .btn-gold {
            background: var(--gold);
            color: #3a2a00;
            box-shadow: 0 10px 22px rgba(245, 180, 0, .4);
        }

        .btn-gold:hover {
            background: var(--gold-light);
            transform: translateY(-2px);
        }

        .hero-photo {
            min-height: 1px;
        }

        /* FEATURE CARDS */
        .features {
            position: relative;
            z-index: 6;
            flex: 0 0 auto;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            padding-bottom: 22px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 18px 14px 18px;
            text-align: center;
            box-shadow: 0 18px 40px rgba(11, 44, 107, .18);
            transition: .25s;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 26px 50px rgba(11, 44, 107, .28);
        }

        .card .ic {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .card .ic svg {
            width: 26px;
            height: 26px;
        }

        .ic.blue {
            background: var(--blue);
        }

        .ic.gold {
            background: var(--gold);
        }

        .ic.red {
            background: var(--red);
        }

        .card h3 {
            font-size: 14.5px;
            font-weight: 800;
            letter-spacing: .4px;
            color: var(--ink);
            text-transform: uppercase;
        }

        .card p {
            margin-top: 8px;
            font-size: 13px;
            color: var(--muted);
            line-height: 1.45;
        }

        /* Page Content (for subpages) */
        .page-content {
            flex: 1 1 auto;
            padding: 40px 0 60px;
        }

        .content-box {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(11, 44, 107, 0.1);
        }

        .content-box h2 {
            font-size: clamp(24px, 4vw, 32px);
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .content-box p {
            font-size: clamp(14px, 2vw, 16px);
            color: var(--muted);
            line-height: 1.7;
        }

        .content-box strong {
            color: var(--ink);
        }

        /* ==================== */
        /* PROGRAM PAGE STYLES  */
        /* ==================== */
        .program-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 48px;
            padding: 0 16px;
        }

        .program-header h2 {
            font-size: clamp(28px, 5vw, 52px);
            font-weight: 900;
            color: var(--navy);
            letter-spacing: -0.5px;
            margin-bottom: 16px;
            line-height: 1.1;
        }

        .program-header .divider {
            width: 80px;
            height: 6px;
            background: var(--blue);
            border-radius: 99px;
            margin: 0 auto 20px;
        }

        .program-header p {
            font-size: clamp(15px, 2.2vw, 18px);
            color: var(--muted);
            font-weight: 500;
            line-height: 1.6;
        }

        .program-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .program-card {
            display: flex;
            flex-direction: column;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 28px 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(11, 44, 107, .06);
            transition: box-shadow .35s, transform .35s;
        }

        .program-card:hover {
            box-shadow: 0 12px 36px rgba(11, 44, 107, .14);
            transform: translateY(-4px);
        }

        .program-card .card-glow {
            position: absolute;
            top: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(29, 78, 216, .08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            transition: background .35s;
        }

        .program-card:hover .card-glow {
            background: radial-gradient(circle, rgba(29, 78, 216, .14) 0%, transparent 70%);
        }

        .program-card h3 {
            font-size: clamp(18px, 2.5vw, 22px);
            font-weight: 800;
            color: var(--navy-dark);
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
            line-height: 1.3;
        }

        .program-card .card-desc {
            font-size: clamp(14px, 1.8vw, 15px);
            color: var(--muted);
            flex-grow: 1;
            line-height: 1.65;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .program-card .btn-toggle {
            width: 100%;
            padding: 13px 20px;
            border-radius: 14px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: var(--navy);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .3s;
            position: relative;
            z-index: 1;
        }

        .program-card .btn-toggle:hover {
            background: var(--navy);
            color: #fff;
            border-color: var(--navy);
        }

        .program-card .btn-toggle svg {
            width: 18px;
            height: 18px;
            transition: transform .3s;
        }

        .activities-container {
            position: relative;
            z-index: 1;
            margin-bottom: 20px;
        }

        .activities-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 360px;
            overflow-y: auto;
            padding-right: 6px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            transition: border-color .25s, box-shadow .25s;
        }

        .activity-item:hover {
            border-color: #93c5fd;
            box-shadow: 0 4px 12px rgba(29, 78, 216, .08);
        }

        .activity-item img {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
            background: #e2e8f0;
        }

        .activity-item .activity-info {
            flex: 1;
            min-width: 0;
        }

        .activity-item h4 {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .activity-item .btn-detail {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            background: var(--blue);
            color: #fff;
            padding: 6px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background .2s;
        }

        .activity-item .btn-detail:hover {
            background: var(--navy);
        }

        /* Skeleton loader */
        .skeleton-loader {
            margin-bottom: 20px;
        }

        .skeleton-loader .sk-row {
            display: flex;
            gap: 14px;
            padding: 12px;
            background: #f1f5f9;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
        }

        .skeleton-loader .sk-img {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            background: #e2e8f0;
            animation: pulse 1.5s ease-in-out infinite;
        }

        .skeleton-loader .sk-lines {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 10px;
        }

        .skeleton-loader .sk-line {
            height: 14px;
            border-radius: 6px;
            background: #e2e8f0;
            animation: pulse 1.5s ease-in-out infinite;
        }

        .skeleton-loader .sk-line:first-child {
            width: 75%;
        }

        .skeleton-loader .sk-line:last-child {
            width: 40%;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .4;
            }
        }

        /* Modal */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 35, 80, 0.75);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 16px;
            opacity: 0;
            visibility: hidden;
            transition: opacity .3s, visibility .3s;
        }

        .modal-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-panel {
            background: #fff;
            border-radius: 24px;
            width: 100%;
            max-width: 640px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(11, 44, 107, .25);
            transform: scale(.92) translateY(20px);
            opacity: 0;
            transition: transform .35s cubic-bezier(.4, 0, .2, 1), opacity .35s;
            position: relative;
        }

        .modal-backdrop.show .modal-panel {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            z-index: 20;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .9);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            transition: background .2s, color .2s;
            color: #64748b;
        }

        .modal-close:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .modal-close svg {
            width: 22px;
            height: 22px;
        }

        .modal-img-wrap {
            position: relative;
            height: 240px;
            overflow: hidden;
        }

        .modal-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-img-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, .45) 0%, transparent 60%);
        }

        .modal-body-content {
            padding: 28px;
        }

        .modal-body-content h3 {
            font-size: clamp(20px, 3vw, 26px);
            font-weight: 800;
            color: var(--navy-dark);
            margin-bottom: 12px;
            line-height: 1.25;
        }

        .modal-body-content .modal-divider {
            width: 50px;
            height: 4px;
            background: var(--blue);
            border-radius: 99px;
            margin-bottom: 16px;
        }

        .modal-body-content .modal-text {
            max-height: 260px;
            overflow-y: auto;
            padding-right: 8px;
        }

        .modal-body-content p {
            font-size: 15px;
            color: var(--muted);
            line-height: 1.7;
            font-weight: 500;
        }

        /* responsive */
        @media (max-width:1024px) {
            .title h1 {
                font-size: 64px;
            }

            .cards {
                grid-template-columns: repeat(3, 1fr);
            }

            .program-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }

        @media (max-width:860px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }

            .hero-bg .bg-overlay {
                background: linear-gradient(180deg,
                        rgba(255, 255, 255, 0.18) 0%,
                        rgba(255, 255, 255, 0.12) 50%,
                        rgba(255, 255, 255, 0.06) 75%,
                        rgba(11, 44, 107, 0.02) 100%);
            }

            .menu {
                display: none;
            }

            .hamburger {
                display: flex;
            }

            .mobile-overlay,
            .mobile-menu {
                display: block;
            }

            .cards {
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
            }

            .card {
                padding: 14px 10px;
            }

            .card .ic {
                width: 44px;
                height: 44px;
                margin-bottom: 8px;
            }

            .card .ic svg {
                width: 22px;
                height: 22px;
            }

            .card h3 {
                font-size: 12px;
            }

            .card p {
                font-size: 11px;
                margin-top: 4px;
            }

            .page-content {
                padding: 24px 0;
            }

            .content-box {
                padding: 24px 16px;
                border-radius: 18px;
            }

            .program-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .program-header {
                margin-bottom: 32px;
            }

            .modal-img-wrap {
                height: 200px;
            }

            .modal-body-content {
                padding: 20px;
            }
        }

        @media (max-width:560px) {
            .title h1 {
                font-size: 44px;
            }

            .subtitle {
                font-size: 20px;
            }

            .heart-logo {
                width: 60px;
                height: 60px;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .card {
                padding: 12px 8px;
                border-radius: 12px;
            }

            .card .ic {
                width: 40px;
                height: 40px;
                margin-bottom: 6px;
            }

            .card .ic svg {
                width: 20px;
                height: 20px;
            }

            .card h3 {
                font-size: 11px;
                letter-spacing: .2px;
            }

            .card p {
                font-size: 10.5px;
                margin-top: 4px;
                line-height: 1.35;
            }

            .container {
                padding: 0 14px;
            }

            .content-box {
                padding: 20px 14px;
                border-radius: 16px;
            }

            .program-grid {
                grid-template-columns: 1fr;
            }

            .program-card {
                padding: 22px 18px;
                border-radius: 18px;
            }

            .program-card .btn-toggle {
                padding: 12px 16px;
                font-size: 13px;
            }

            .activity-item {
                gap: 10px;
                padding: 10px;
            }

            .activity-item img {
                width: 52px;
                height: 52px;
                border-radius: 10px;
            }

            .modal-img-wrap {
                height: 180px;
            }

            .modal-body-content {
                padding: 18px;
            }
        }

        @media (max-width:380px) {
            .title h1 {
                font-size: 38px;
            }

            .subtitle {
                font-size: 18px;
            }

            .heart-logo {
                width: 50px;
                height: 50px;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .card {
                padding: 10px 6px;
            }

            .program-card {
                padding: 18px 14px;
            }

            .program-header h2 {
                margin-bottom: 10px;
            }

            .program-card h3 {
                font-size: 17px;
            }
        }
    </style>
</head>

<body>
    <header class="hero @hasSection('content')
@if (!request()->routeIs('beranda')) hero--subpage @endif
@endif">

        <div class="hero-bg" aria-hidden="true">
            <img src="/images/bg-landing-page.png" alt="SIGAP TUHA Background">
            <div class="bg-overlay"></div>
        </div>

        <!-- NAV -->
        <nav>
            <div class="container">
                <div class="nav-inner">
                    <div class="brand">
                        <div class="logo" aria-hidden="true">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo">
                        </div>
                        <div class="name">
                            <b>KARANG TARUNA</b>
                            <span>KECAMATAN PANDRAH</span>
                            <span>KABUPATEN BIREUEN</span>
                        </div>
                    </div>
                    <div class="menu">
                        <a href="{{ route('beranda') }}"
                            class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
                        <a href="{{ route('profil') }}"
                            class="{{ request()->routeIs('profil') ? 'active' : '' }}">Profil</a>
                        <a href="{{ route('program') }}"
                            class="{{ request()->routeIs('program') ? 'active' : '' }}">Program</a>
                        <a href="{{ route('berita') }}"
                            class="{{ request()->routeIs('berita') ? 'active' : '' }}">Berita</a>
                        <a href="{{ route('kontak') }}"
                            class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a>
                    </div>
                    <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
                        <span></span><span></span><span></span>
                    </button>

                    <!-- Mobile Menu -->
                    <div class="mobile-overlay" id="mobileOverlay"></div>
                    <div class="mobile-menu" id="mobileMenu">
                        <a href="{{ route('beranda') }}"
                            class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
                        <a href="{{ route('profil') }}"
                            class="{{ request()->routeIs('profil') ? 'active' : '' }}">Profil</a>
                        <a href="{{ route('program') }}"
                            class="{{ request()->routeIs('program') ? 'active' : '' }}">Program</a>
                        <a href="{{ route('berita') }}"
                            class="{{ request()->routeIs('berita') ? 'active' : '' }}">Berita</a>
                        <a href="{{ route('kontak') }}"
                            class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container">
            @yield('content')
        </div>
    </header>

    <script>
        // Hamburger Menu Toggle
        (function() {
            const btn = document.getElementById('hamburgerBtn');
            const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('mobileOverlay');
            if (!btn || !menu || !overlay) return;

            function toggleMenu() {
                btn.classList.toggle('open');
                menu.classList.toggle('open');
                overlay.classList.toggle('show');
                document.body.style.overflow = menu.classList.contains('open') ? 'hidden' : '';
            }
            btn.addEventListener('click', toggleMenu);
            overlay.addEventListener('click', toggleMenu);
        })();
    </script>
</body>

</html>
