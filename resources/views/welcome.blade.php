@extends('layout.app')

@section('content')
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        /* ── NAVBAR ── */
        .lp-nav {
            position: fixed; top: 0; left: 0; width: 100%; z-index: 1050;
            padding: 0 0;
            background: rgba(10,10,18,0.65);
            backdrop-filter: blur(20px) saturate(1.4);
            -webkit-backdrop-filter: blur(20px) saturate(1.4);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: background 0.35s, box-shadow 0.35s;
        }
        .lp-nav.scrolled {
            background: rgba(10,10,18,0.92);
            box-shadow: 0 4px 30px rgba(0,0,0,0.25);
        }
        .lp-nav-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 24px;
        }
        .lp-nav-links { display: flex; gap: 32px; list-style: none; margin: 0; padding: 0; }
        .lp-nav-links a {
            color: rgba(255,255,255,0.55); text-decoration: none;
            font-size: 0.88rem; font-weight: 500; letter-spacing: 0.01em;
            transition: color 0.2s; position: relative;
        }
        .lp-nav-links a::after {
            content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px;
            background: #818cf8; border-radius: 2px; transition: width 0.3s;
        }
        .lp-nav-links a:hover { color: #e2e8f0; }
        .lp-nav-links a:hover::after { width: 100%; }
        .lp-nav-btns { display: flex; gap: 10px; align-items: center; }
        .btn-nav-ghost {
            padding: 8px 18px; border-radius: 8px; font-size: 0.85rem; font-weight: 500;
            color: rgba(255,255,255,0.65); border: 1px solid rgba(255,255,255,0.12);
            background: transparent; text-decoration: none; transition: all 0.2s;
        }
        .btn-nav-ghost:hover { color: #fff; border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.04); }
        .btn-nav-solid {
            padding: 8px 20px; border-radius: 8px; font-size: 0.85rem; font-weight: 600;
            color: #fff; border: none; text-decoration: none;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 2px 12px rgba(99,102,241,0.3);
            transition: all 0.25s;
        }
        .btn-nav-solid:hover { transform: translateY(-1px); box-shadow: 0 4px 20px rgba(99,102,241,0.45); color: #fff; }

        /* ── Hamburger mobile ── */
        .lp-hamburger {
            display: none; background: none; border: none; cursor: pointer; padding: 4px;
        }
        .lp-hamburger span {
            display: block; width: 22px; height: 2px; background: rgba(255,255,255,0.7);
            margin: 5px 0; border-radius: 2px; transition: all 0.3s;
        }
        .lp-mobile-menu {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100vh;
            background: rgba(10,10,18,0.97); z-index: 1060;
            flex-direction: column; align-items: center; justify-content: center; gap: 28px;
        }
        .lp-mobile-menu.open { display: flex; }
        .lp-mobile-menu a {
            color: rgba(255,255,255,0.8); text-decoration: none; font-size: 1.3rem; font-weight: 500;
            transition: color 0.2s;
        }
        .lp-mobile-menu a:hover { color: #818cf8; }
        .lp-mobile-close {
            position: absolute; top: 20px; right: 24px; background: none; border: none;
            color: rgba(255,255,255,0.6); font-size: 1.8rem; cursor: pointer;
        }

        /* ── HERO ── */
        .lp-hero {
            min-height: 100vh; display: flex; align-items: center;
            background: #08080f;
            position: relative; overflow: hidden;
            padding-top: 80px;
        }
        .lp-hero-mesh {
            position: absolute; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% 80%, rgba(99,102,241,0.15), transparent),
                radial-gradient(ellipse 60% 50% at 85% 20%, rgba(139,92,246,0.12), transparent),
                radial-gradient(ellipse 50% 40% at 50% 50%, rgba(14,165,233,0.06), transparent);
            animation: meshShift 12s ease-in-out infinite alternate;
        }
        @keyframes meshShift {
            0% { opacity: 1; filter: hue-rotate(0deg); }
            100% { opacity: 0.85; filter: hue-rotate(15deg); }
        }
        .lp-hero-grid {
            position: absolute; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 20%, transparent 70%);
            -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 20%, transparent 70%);
        }
        .lp-hero-glow {
            position: absolute; width: 420px; height: 420px; border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.2), transparent 70%);
            filter: blur(60px); z-index: 0;
            top: 15%; right: 10%;
            animation: glowPulse 6s ease-in-out infinite alternate;
        }
        @keyframes glowPulse {
            0% { transform: scale(1); opacity: 0.7; }
            100% { transform: scale(1.15); opacity: 1; }
        }
        .lp-hero-content { position: relative; z-index: 2; }
        .lp-hero-chip {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 7px 16px 7px 10px; border-radius: 100px;
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.18);
            color: #a5b4fc; font-size: 0.8rem; font-weight: 500;
            margin-bottom: 2rem;
        }
        .lp-hero-chip i { font-size: 1rem; }
        .lp-hero h1 {
            font-size: clamp(2.5rem, 5.5vw, 4rem);
            font-weight: 800; line-height: 1.08;
            color: #f0f0f5; letter-spacing: -0.03em;
            margin-bottom: 1.5rem;
        }
        .lp-hero h1 .gradient-text {
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 40%, #38bdf8 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .lp-hero-sub {
            font-size: 1.1rem; color: rgba(180,190,210,0.75);
            line-height: 1.75; max-width: 480px; margin-bottom: 2.5rem;
        }
        .lp-hero-actions { display: flex; flex-wrap: wrap; gap: 14px; }
        .btn-primary-glow {
            padding: 15px 34px; border-radius: 12px; font-weight: 600; font-size: 0.95rem;
            color: #fff; border: none; text-decoration: none;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            box-shadow: 0 0 30px rgba(99,102,241,0.3), 0 4px 14px rgba(99,102,241,0.25);
            transition: all 0.3s;
        }
        .btn-primary-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 50px rgba(99,102,241,0.4), 0 8px 24px rgba(99,102,241,0.3);
            color: #fff;
        }
        .btn-ghost-light {
            padding: 15px 34px; border-radius: 12px; font-weight: 600; font-size: 0.95rem;
            color: rgba(220,220,235,0.8); border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.03); text-decoration: none;
            transition: all 0.3s;
        }
        .btn-ghost-light:hover {
            color: #fff; border-color: rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.06);
        }
        .lp-hero-visual {
            position: relative; z-index: 2;
        }
        .lp-hero-img-wrap {
            position: relative; border-radius: 18px; overflow: hidden;
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 30px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.04) inset;
            transform: perspective(1200px) rotateY(-3deg) rotateX(2deg);
            transition: transform 0.5s;
        }
        .lp-hero-img-wrap:hover {
            transform: perspective(1200px) rotateY(0deg) rotateX(0deg);
        }
        .lp-hero-img-wrap img { display: block; width: 100%; }
        .lp-hero-img-shine {
            position: absolute; inset: 0; z-index: 3;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.03) 45%, rgba(255,255,255,0.06) 50%, transparent 55%);
            pointer-events: none;
        }

        /* ── MÉTRICAS ── */
        .lp-metrics {
            background: #0a0a12;
            padding: 4.5rem 0;
            border-top: 1px solid rgba(255,255,255,0.04);
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }
        .lp-metrics-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
            max-width: 1200px; margin: 0 auto; padding: 0 24px;
        }
        .lp-metric {
            text-align: center; padding: 2rem 1rem;
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            transition: all 0.3s;
        }
        .lp-metric:hover {
            background: rgba(255,255,255,0.04);
            border-color: rgba(99,102,241,0.15);
            transform: translateY(-4px);
        }
        .lp-metric-val {
            font-size: 2.4rem; font-weight: 800; letter-spacing: -0.03em;
            background: linear-gradient(135deg, #818cf8, #38bdf8);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text; margin-bottom: 6px;
        }
        .lp-metric-lbl {
            font-size: 0.85rem; color: rgba(180,190,210,0.5); font-weight: 500;
            letter-spacing: 0.03em;
        }

        /* ── SECCIÓN GENÉRICA ── */
        .lp-section { padding: 6rem 0; }
        .lp-section-light { background: #f7f8fc; }
        .lp-section-white { background: #fff; }
        .lp-container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        .lp-tag {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em;
            text-transform: uppercase; color: #6366f1; margin-bottom: 12px;
        }
        .lp-tag::before {
            content: ''; display: block; width: 20px; height: 2px;
            background: linear-gradient(90deg, #6366f1, #a78bfa); border-radius: 2px;
        }
        .lp-heading {
            font-size: clamp(1.8rem, 3vw, 2.4rem); font-weight: 750;
            color: #12131a; letter-spacing: -0.025em;
            margin-bottom: 1rem; line-height: 1.15;
        }
        .lp-subdesc {
            font-size: 1.02rem; color: #6b7280; line-height: 1.7;
            max-width: 540px;
        }

        /* ── SERVICIOS ── */
        .lp-services-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px;
        }
        .lp-svc {
            background: #fff; border-radius: 16px; padding: 2rem;
            border: 1px solid #eef0f6;
            position: relative; overflow: hidden;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .lp-svc::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--svc-accent); opacity: 0;
            transition: opacity 0.3s;
        }
        .lp-svc:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.06);
            border-color: transparent;
        }
        .lp-svc:hover::before { opacity: 1; }
        .lp-svc-icon {
            width: 50px; height: 50px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; margin-bottom: 1.25rem;
            background: var(--svc-bg); color: var(--svc-accent);
        }
        .lp-svc h4 {
            font-size: 1.05rem; font-weight: 650; color: #1a1b25;
            margin-bottom: 10px;
        }
        .lp-svc p {
            font-size: 0.9rem; color: #6b7280; line-height: 1.65; margin: 0;
        }

        /* ── PROCESO ── */
        .lp-process-grid { display: flex; flex-direction: column; gap: 0; }
        .lp-step {
            display: flex; gap: 28px; align-items: flex-start;
            position: relative;
        }
        .lp-step-rail {
            display: flex; flex-direction: column; align-items: center;
            flex-shrink: 0; width: 48px;
        }
        .lp-step-dot {
            width: 48px; height: 48px; border-radius: 14px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff; font-weight: 700; font-size: 1rem;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 16px rgba(99,102,241,0.25);
            flex-shrink: 0;
        }
        .lp-step-line {
            width: 2px; flex: 1; min-height: 40px;
            background: linear-gradient(180deg, rgba(99,102,241,0.3), rgba(99,102,241,0.05));
        }
        .lp-step-body { padding: 6px 0 3rem 0; }
        .lp-step:last-child .lp-step-body { padding-bottom: 0; }
        .lp-step:last-child .lp-step-line { display: none; }
        .lp-step h4 {
            font-size: 1.08rem; font-weight: 650; color: #1a1b25;
            margin: 0 0 6px;
        }
        .lp-step p {
            font-size: 0.9rem; color: #6b7280; margin: 0; line-height: 1.6;
            max-width: 380px;
        }

        /* ── CTA ── */
        .lp-cta {
            position: relative; overflow: hidden;
            padding: 6rem 0; text-align: center;
            background: #08080f;
        }
        .lp-cta-bg {
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 50% 50%, rgba(99,102,241,0.14), transparent),
                radial-gradient(ellipse 40% 40% at 25% 70%, rgba(139,92,246,0.08), transparent),
                radial-gradient(ellipse 35% 35% at 75% 30%, rgba(56,189,248,0.06), transparent);
        }
        .lp-cta-inner {
            position: relative; z-index: 1;
            max-width: 620px; margin: 0 auto; padding: 0 24px;
        }
        .lp-cta-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 16px; border-radius: 100px;
            background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.18);
            color: #a5b4fc; font-size: 0.78rem; font-weight: 600;
            letter-spacing: 0.04em; text-transform: uppercase;
            margin-bottom: 1.5rem;
        }
        .lp-cta h3 {
            font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 800;
            color: #f0f0f5; margin-bottom: 1.2rem; letter-spacing: -0.03em;
            line-height: 1.12;
        }
        .lp-cta h3 span {
            background: linear-gradient(135deg, #818cf8, #c084fc, #38bdf8);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .lp-cta p {
            font-size: 1.05rem; color: rgba(180,190,210,0.65);
            max-width: 440px; margin: 0 auto 2.5rem; line-height: 1.7;
        }
        .lp-cta-actions { display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; }
        .btn-cta-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 16px 36px; border-radius: 12px;
            font-weight: 650; font-size: 0.95rem;
            color: #fff; border: none; text-decoration: none;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            box-shadow: 0 0 40px rgba(99,102,241,0.25), 0 4px 16px rgba(99,102,241,0.2);
            transition: all 0.3s;
        }
        .btn-cta-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 60px rgba(99,102,241,0.35), 0 8px 28px rgba(99,102,241,0.3);
            color: #fff;
        }
        .btn-cta-ghost {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 16px 36px; border-radius: 12px;
            font-weight: 600; font-size: 0.95rem;
            color: rgba(220,220,235,0.7); text-decoration: none;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.03);
            transition: all 0.3s;
        }
        .btn-cta-ghost:hover {
            color: #fff; border-color: rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.06);
        }

        /* ── CONTACTO ── */
        .lp-contact {
            background: #fff;
            padding: 6rem 0;
        }
        .lp-contact-header {
            text-align: center; margin-bottom: 3.5rem;
        }
        .lp-contact-grid {
            display: grid; grid-template-columns: 5fr 7fr; gap: 32px;
            max-width: 1000px; margin: 0 auto;
        }
        .lp-contact-info {
            background: linear-gradient(160deg, #0f0d2e 0%, #1a1145 50%, #0d1f3a 100%);
            border-radius: 24px; padding: 3rem;
            color: #fff; position: relative; overflow: hidden;
        }
        .lp-contact-info::before {
            content: ''; position: absolute; top: -20%; right: -15%;
            width: 200px; height: 200px; border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.2), transparent 70%);
        }
        .lp-contact-info::after {
            content: ''; position: absolute; bottom: -25%; left: -10%;
            width: 250px; height: 250px; border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.12), transparent 70%);
        }
        .lp-contact-info h4 {
            font-size: 1.4rem; font-weight: 700; margin-bottom: 6px;
            position: relative; z-index: 1;
        }
        .lp-contact-info > p {
            color: rgba(255,255,255,0.45); font-size: 0.9rem;
            margin-bottom: 2.5rem; line-height: 1.6; position: relative; z-index: 1;
        }
        .lp-ci {
            display: flex; gap: 14px; align-items: center;
            margin-bottom: 1.5rem; position: relative; z-index: 1;
        }
        .lp-ci:last-child { margin-bottom: 0; }
        .lp-ci-icon {
            width: 42px; height: 42px; border-radius: 12px;
            background: rgba(255,255,255,0.06); backdrop-filter: blur(4px);
            display: flex; align-items: center; justify-content: center;
            color: #a5b4fc; font-size: 1.15rem; flex-shrink: 0;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .lp-ci-label {
            font-size: 0.72rem; color: rgba(255,255,255,0.35);
            margin-bottom: 2px; font-weight: 600; letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .lp-ci-value { font-size: 0.92rem; color: #e2e8f0; font-weight: 500; }
        .lp-contact-form {
            background: #f9fafb; border-radius: 24px; padding: 3rem;
            border: 1px solid #eef0f6;
        }
        .lp-contact-form h5 {
            font-size: 1.15rem; font-weight: 650; color: #1a1b25;
            margin-bottom: 0.4rem;
        }
        .lp-contact-form > p {
            font-size: 0.88rem; color: #9ca3af; margin-bottom: 1.8rem;
        }
        .lp-input-group { margin-bottom: 18px; }
        .lp-input-group label {
            display: block; font-size: 0.8rem; font-weight: 600; color: #4b5563;
            margin-bottom: 6px; letter-spacing: 0.01em;
        }
        .lp-input-group input,
        .lp-input-group textarea {
            width: 100%; padding: 12px 16px; border-radius: 12px;
            border: 1.5px solid #e5e7eb; font-size: 0.9rem;
            color: #1f2937; background: #fff;
            transition: border-color 0.25s, box-shadow 0.25s;
            outline: none; font-family: inherit;
        }
        .lp-input-group input::placeholder,
        .lp-input-group textarea::placeholder {
            color: #c0c5ce;
        }
        .lp-input-group input:focus,
        .lp-input-group textarea:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.08);
        }
        .lp-input-group textarea { resize: vertical; min-height: 110px; }
        .lp-input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .btn-submit {
            width: 100%; padding: 14px; border-radius: 12px;
            font-weight: 650; font-size: 0.92rem;
            color: #fff; border: none; cursor: pointer;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            box-shadow: 0 4px 16px rgba(99,102,241,0.2);
            transition: all 0.3s; margin-top: 6px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(99,102,241,0.3);
        }

        /* ── FOOTER ── */
        .lp-footer {
            background: #08080f; padding: 0; overflow: hidden;
        }
        .lp-footer-top {
            max-width: 1200px; margin: 0 auto; padding: 3.5rem 24px 2.5rem;
            display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 40px;
        }
        .lp-footer-brand p {
            font-size: 0.88rem; color: rgba(180,190,210,0.4);
            line-height: 1.7; margin-top: 16px; max-width: 280px;
        }
        .lp-footer-col h6 {
            font-size: 0.78rem; font-weight: 700; letter-spacing: 0.1em;
            text-transform: uppercase; color: rgba(180,190,210,0.5);
            margin-bottom: 16px;
        }
        .lp-footer-col a {
            display: block; color: rgba(180,190,210,0.4); text-decoration: none;
            font-size: 0.88rem; font-weight: 500; margin-bottom: 10px;
            transition: color 0.2s;
        }
        .lp-footer-col a:hover { color: #a5b4fc; }
        .lp-footer-bottom {
            max-width: 1200px; margin: 0 auto; padding: 1.5rem 24px;
            border-top: 1px solid rgba(255,255,255,0.04);
            display: flex; align-items: center; justify-content: space-between;
        }
        .lp-footer-copy {
            font-size: 0.78rem; color: rgba(180,190,210,0.2);
        }
        .lp-footer-legal { display: flex; gap: 20px; }
        .lp-footer-legal a {
            font-size: 0.78rem; color: rgba(180,190,210,0.25);
            text-decoration: none; transition: color 0.2s;
        }
        .lp-footer-legal a:hover { color: rgba(180,190,210,0.5); }

        /* ── FADE-IN SCROLL ── */
        .lp-reveal {
            opacity: 0; transform: translateY(32px);
            transition: opacity 0.7s cubic-bezier(0.4, 0, 0.2, 1), transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .lp-reveal.visible {
            opacity: 1; transform: translateY(0);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .lp-services-grid { grid-template-columns: repeat(2, 1fr); }
            .lp-contact-grid { grid-template-columns: 1fr; }
            .lp-footer-top { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .lp-nav-links { display: none; }
            .lp-hamburger { display: block; }
            .lp-hero { min-height: auto; padding: 7rem 0 3.5rem; }
            .lp-hero-visual { margin-top: 3rem; }
            .lp-hero-img-wrap { transform: none; }
            .lp-hero-img-wrap:hover { transform: none; }
            .lp-metrics-grid { grid-template-columns: repeat(2, 1fr); }
            .lp-services-grid { grid-template-columns: 1fr; }
            .lp-input-row { grid-template-columns: 1fr; }
            .lp-footer-top { grid-template-columns: 1fr; gap: 24px; }
            .lp-footer-bottom { flex-direction: column; gap: 12px; text-align: center; }
            .lp-cta-actions { flex-direction: column; align-items: center; }
        }
    </style>

    {{-- NAVBAR --}}
    <nav class="lp-nav" id="lpNav">
        <div class="lp-nav-inner">
            <a href="{{ route('home.index') }}" style="display:flex;align-items:center;">
                <img src="{{ asset('assets/img/Alobri/Alobri-light.png') }}" alt="Alobri" height="34"
                     data-app-light-img="Alobri/Alobri-light.png" data-app-dark-img="Alobri/Alobri-dark.png"
                     style="filter: brightness(1.1);">
            </a>
            <ul class="lp-nav-links">
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#proceso">Proceso</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
            <div class="lp-nav-btns">
                @guest
                    <a href="{{ route('login') }}" class="btn-nav-ghost">Iniciar sesi&oacute;n</a>
                    <a href="{{ route('register.wizard') }}" class="btn-nav-solid">Registrarse</a>
                @else
                    <a href="/psicometricas/admin" class="btn-nav-solid">
                        <i class="ri-dashboard-fill me-1"></i> Panel
                    </a>
                @endguest
            </div>
            <button class="lp-hamburger" id="lpHamburger" aria-label="Men&uacute;">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    {{-- MOBILE MENU --}}
    <div class="lp-mobile-menu" id="lpMobileMenu">
        <button class="lp-mobile-close" id="lpMobileClose">&times;</button>
        <a href="#servicios" onclick="closeMobile()">Servicios</a>
        <a href="#proceso" onclick="closeMobile()">Proceso</a>
        <a href="#contacto" onclick="closeMobile()">Contacto</a>
        @guest
            <a href="{{ route('login') }}" style="color:#a5b4fc;">Iniciar sesi&oacute;n</a>
            <a href="{{ route('register.wizard') }}" style="color:#c084fc;">Registrarse</a>
        @else
            <a href="/psicometricas/admin" style="color:#a5b4fc;">Panel de Control</a>
        @endguest
    </div>

    {{-- HERO --}}
    <section class="lp-hero">
        <div class="lp-hero-mesh"></div>
        <div class="lp-hero-grid"></div>
        <div class="lp-hero-glow"></div>
        <div class="lp-container lp-hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="lp-hero-chip">
                        <i class="ri-shield-check-line"></i>
                        Evaluaci&oacute;n psicom&eacute;trica en l&iacute;nea
                    </div>
                    <h1>
                        Contrata mejor.<br>
                        <span class="gradient-text">Eval&uacute;a con datos.</span>
                    </h1>
                    <p class="lp-hero-sub">
                        Aplica pruebas psicom&eacute;tricas a tus candidatos y obt&eacute;n reportes de personalidad, competencias y aptitudes. Todo desde un solo panel.
                    </p>
                    <div class="lp-hero-actions">
                        <a href="{{ route('register.wizard') }}" class="btn-primary-glow">Crear cuenta gratis</a>
                        <a href="#proceso" class="btn-ghost-light">Ver c&oacute;mo funciona</a>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 lp-hero-visual d-none d-lg-block">
                    <div class="lp-hero-img-wrap">
                        <img src="{{ asset('assets/img/front-pages/landing-page/hero-dashboard-light.png') }}"
                             alt="Panel de evaluaciones"
                             data-app-light-img="front-pages/landing-page/hero-dashboard-light.png"
                             data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png">
                        <div class="lp-hero-img-shine"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MÉTRICAS --}}
    <section class="lp-metrics">
        <div class="lp-metrics-grid">
            <div class="lp-metric lp-reveal">
                <div class="lp-metric-val">15+</div>
                <div class="lp-metric-lbl">Tipos de prueba</div>
            </div>
            <div class="lp-metric lp-reveal">
                <div class="lp-metric-val">24h</div>
                <div class="lp-metric-lbl">Resultados listos</div>
            </div>
            <div class="lp-metric lp-reveal">
                <div class="lp-metric-val">100%</div>
                <div class="lp-metric-lbl">En l&iacute;nea</div>
            </div>
            <div class="lp-metric lp-reveal">
                <div class="lp-metric-val">PDF</div>
                <div class="lp-metric-lbl">Reportes descargables</div>
            </div>
        </div>
    </section>

    {{-- SERVICIOS --}}
    <section class="lp-section lp-section-light" id="servicios">
        <div class="lp-container">
            <div class="text-center mb-5 lp-reveal">
                <div class="lp-tag" style="justify-content:center;">Servicios</div>
                <h2 class="lp-heading">Qu&eacute; puedes evaluar</h2>
                <p class="lp-subdesc mx-auto">Bater&iacute;as dise&ntilde;adas para selecci&oacute;n de personal, desarrollo organizacional y diagn&oacute;stico de equipos.</p>
            </div>
            <div class="lp-services-grid">
                <div class="lp-svc lp-reveal" style="--svc-accent:#6366f1; --svc-bg:rgba(99,102,241,0.08);">
                    <div class="lp-svc-icon"><i class="ri-user-heart-line"></i></div>
                    <h4>Personalidad</h4>
                    <p>Perfiles con Cleaver, LIFO y escalas cualitativas. Entiende c&oacute;mo se comporta un candidato en su d&iacute;a a d&iacute;a laboral.</p>
                </div>
                <div class="lp-svc lp-reveal" style="--svc-accent:#0ea5e9; --svc-bg:rgba(14,165,233,0.08);">
                    <div class="lp-svc-icon"><i class="ri-brain-line"></i></div>
                    <h4>Aptitudes Cognitivas</h4>
                    <p>Razonamiento l&oacute;gico, verbal y num&eacute;rico. Mide capacidad de an&aacute;lisis con pruebas estandarizadas.</p>
                </div>
                <div class="lp-svc lp-reveal" style="--svc-accent:#22c55e; --svc-bg:rgba(34,197,94,0.08);">
                    <div class="lp-svc-icon"><i class="ri-heart-pulse-line"></i></div>
                    <h4>Inteligencia Emocional</h4>
                    <p>Autoconocimiento, empat&iacute;a, manejo del estr&eacute;s. Competencias clave para roles de liderazgo y atenci&oacute;n al cliente.</p>
                </div>
                <div class="lp-svc lp-reveal" style="--svc-accent:#f97316; --svc-bg:rgba(249,115,22,0.08);">
                    <div class="lp-svc-icon"><i class="ri-stack-line"></i></div>
                    <h4>Competencias Laborales</h4>
                    <p>Liderazgo, trabajo en equipo, toma de decisiones. Bater&iacute;as orientadas al perfil que necesitas cubrir.</p>
                </div>
                <div class="lp-svc lp-reveal" style="--svc-accent:#ef4444; --svc-bg:rgba(239,68,68,0.08);">
                    <div class="lp-svc-icon"><i class="ri-mental-health-line"></i></div>
                    <h4>Salud Psicol&oacute;gica</h4>
                    <p>Inventarios Beck y PDQ para detectar indicadores de riesgo psicosocial y bienestar emocional.</p>
                </div>
                <div class="lp-svc lp-reveal" style="--svc-accent:#8b5cf6; --svc-bg:rgba(139,92,246,0.08);">
                    <div class="lp-svc-icon"><i class="ri-team-line"></i></div>
                    <h4>Negociaci&oacute;n y MOSS</h4>
                    <p>Capacidad de negociaci&oacute;n, juicio social y adaptabilidad. Pruebas dise&ntilde;adas para roles con alta interacci&oacute;n.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- PROCESO --}}
    <section class="lp-section lp-section-white" id="proceso">
        <div class="lp-container">
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0 lp-reveal">
                    <div class="lp-tag">Proceso</div>
                    <h2 class="lp-heading">De la vacante al reporte en 4 pasos</h2>
                    <p class="lp-subdesc">No necesitas experiencia en psicometr&iacute;a. La plataforma te gu&iacute;a y genera los reportes por ti.</p>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="lp-process-grid">
                        <div class="lp-step lp-reveal">
                            <div class="lp-step-rail">
                                <div class="lp-step-dot">1</div>
                                <div class="lp-step-line"></div>
                            </div>
                            <div class="lp-step-body">
                                <h4>Registra a tus candidatos</h4>
                                <p>Carga sus datos y gen&eacute;rales un c&oacute;digo de acceso para que entren a la plataforma.</p>
                            </div>
                        </div>
                        <div class="lp-step lp-reveal">
                            <div class="lp-step-rail">
                                <div class="lp-step-dot">2</div>
                                <div class="lp-step-line"></div>
                            </div>
                            <div class="lp-step-body">
                                <h4>Asigna las pruebas</h4>
                                <p>Elige la bater&iacute;a de evaluaciones seg&uacute;n el perfil del puesto. Puedes combinar varias.</p>
                            </div>
                        </div>
                        <div class="lp-step lp-reveal">
                            <div class="lp-step-rail">
                                <div class="lp-step-dot">3</div>
                                <div class="lp-step-line"></div>
                            </div>
                            <div class="lp-step-body">
                                <h4>El candidato responde</h4>
                                <p>Ingresa con su c&oacute;digo y contesta desde cualquier dispositivo. T&uacute; ves el avance en tiempo real.</p>
                            </div>
                        </div>
                        <div class="lp-step lp-reveal">
                            <div class="lp-step-rail">
                                <div class="lp-step-dot">4</div>
                            </div>
                            <div class="lp-step-body">
                                <h4>Descarga el reporte</h4>
                                <p>El sistema califica y genera un PDF detallado con los resultados. Listo para tomar decisiones.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="lp-cta">
        <div class="lp-cta-bg"></div>
        <div class="lp-cta-inner lp-reveal">
            <div class="lp-cta-badge">Sin costo inicial</div>
            <h3>Listo para tomar<br><span>mejores decisiones?</span></h3>
            <p>Crea tu cuenta en menos de 2 minutos, carga a tu primer candidato y aplica una bater&iacute;a de evaluaciones.</p>
            <div class="lp-cta-actions">
                <a href="{{ route('register.wizard') }}" class="btn-cta-primary">
                    Crear cuenta gratis <i class="ri-arrow-right-line"></i>
                </a>
                <a href="#contacto" class="btn-cta-ghost">
                    <i class="ri-chat-3-line"></i> Hablar con ventas
                </a>
            </div>
        </div>
    </section>

    {{-- CONTACTO --}}
    <section class="lp-contact" id="contacto">
        <div class="lp-container">
            <div class="lp-contact-header lp-reveal">
                <div class="lp-tag" style="justify-content:center;">Contacto</div>
                <h2 class="lp-heading">Platiquemos sobre tu proyecto</h2>
                <p class="lp-subdesc mx-auto">Ya sea que necesites evaluar a 5 o a 500 candidatos, te ayudamos a armar la bater&iacute;a correcta.</p>
            </div>
            <div class="lp-contact-grid">
                <div class="lp-contact-info lp-reveal">
                    <h4>Cont&aacute;ctanos</h4>
                    <p>Escr&iacute;benos y te respondemos el mismo d&iacute;a h&aacute;bil.</p>

                    <div class="lp-ci">
                        <div class="lp-ci-icon"><i class="ri-mail-line"></i></div>
                        <div>
                            <div class="lp-ci-label">Correo</div>
                            <div class="lp-ci-value">contacto@alobri.com</div>
                        </div>
                    </div>
                    <div class="lp-ci">
                        <div class="lp-ci-icon"><i class="ri-phone-line"></i></div>
                        <div>
                            <div class="lp-ci-label">Tel&eacute;fono</div>
                            <div class="lp-ci-value">+52 (55) 5555-5555</div>
                        </div>
                    </div>
                    <div class="lp-ci">
                        <div class="lp-ci-icon"><i class="ri-map-pin-line"></i></div>
                        <div>
                            <div class="lp-ci-label">Ubicaci&oacute;n</div>
                            <div class="lp-ci-value">Ciudad de M&eacute;xico</div>
                        </div>
                    </div>
                    <div class="lp-ci">
                        <div class="lp-ci-icon"><i class="ri-time-line"></i></div>
                        <div>
                            <div class="lp-ci-label">Horario</div>
                            <div class="lp-ci-value">Lun - Vie, 9:00 a 18:00</div>
                        </div>
                    </div>
                </div>

                <div class="lp-contact-form lp-reveal">
                    <h5>Env&iacute;anos un mensaje</h5>
                    <p>Te responderemos a la brevedad.</p>
                    <form method="POST" action="#">
                        @csrf
                        <div class="lp-input-row">
                            <div class="lp-input-group">
                                <label for="c_name">Nombre</label>
                                <input type="text" id="c_name" name="name" placeholder="Tu nombre completo" required>
                            </div>
                            <div class="lp-input-group">
                                <label for="c_email">Correo corporativo</label>
                                <input type="email" id="c_email" name="email" placeholder="nombre@empresa.com" required>
                            </div>
                        </div>
                        <div class="lp-input-row">
                            <div class="lp-input-group">
                                <label for="c_company">Empresa</label>
                                <input type="text" id="c_company" name="company" placeholder="Nombre de tu empresa">
                            </div>
                            <div class="lp-input-group">
                                <label for="c_phone">Tel&eacute;fono</label>
                                <input type="tel" id="c_phone" name="phone" placeholder="+52 55 1234 5678">
                            </div>
                        </div>
                        <div class="lp-input-group">
                            <label for="c_msg">Mensaje</label>
                            <textarea id="c_msg" name="message" placeholder="Cu&eacute;ntanos qu&eacute; necesitas evaluar, cu&aacute;ntos candidatos tienes, o cualquier duda..." required></textarea>
                        </div>
                        <button type="submit" class="btn-submit">
                            Enviar mensaje <i class="ri-send-plane-2-line"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="lp-footer">
        <div class="lp-footer-top">
            <div class="lp-footer-brand">
                <img src="{{ asset('assets/img/Alobri/Alobri-light.png') }}" alt="Alobri" height="30"
                     data-app-light-img="Alobri/Alobri-light.png" data-app-dark-img="Alobri/Alobri-dark.png">
                <p>Plataforma de evaluaci&oacute;n psicom&eacute;trica en l&iacute;nea para empresas que quieren contratar mejor.</p>
            </div>
            <div class="lp-footer-col">
                <h6>Plataforma</h6>
                <a href="#servicios">Servicios</a>
                <a href="#proceso">C&oacute;mo funciona</a>
                <a href="{{ route('register.wizard') }}">Crear cuenta</a>
                <a href="{{ route('login') }}">Iniciar sesi&oacute;n</a>
            </div>
            <div class="lp-footer-col">
                <h6>Contacto</h6>
                <a href="mailto:contacto@alobri.com">contacto@alobri.com</a>
                <a href="tel:+525555555555">+52 (55) 5555-5555</a>
                <a href="#contacto">Formulario de contacto</a>
            </div>
        </div>
        <div class="lp-footer-bottom">
            <div class="lp-footer-copy">&copy; {{ date('Y') }} Alobri. Todos los derechos reservados.</div>
            <div class="lp-footer-legal">
                <a href="#">Aviso de privacidad</a>
                <a href="#">T&eacute;rminos de uso</a>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        const nav = document.getElementById('lpNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 40);
        });

        // Mobile menu
        const hamburger = document.getElementById('lpHamburger');
        const mobileMenu = document.getElementById('lpMobileMenu');
        const mobileClose = document.getElementById('lpMobileClose');
        hamburger.addEventListener('click', () => mobileMenu.classList.add('open'));
        mobileClose.addEventListener('click', () => mobileMenu.classList.remove('open'));
        function closeMobile() { mobileMenu.classList.remove('open'); }

        // Scroll reveal
        const reveals = document.querySelectorAll('.lp-reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 80);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach(el => observer.observe(el));
    </script>

@endsection
