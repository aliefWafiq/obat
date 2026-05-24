<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Sedang Pemeliharaan - ObatKita</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top right, #1e1b4b, #0f172a);
            overflow-x: hidden;
            position: relative;
            color: #f8fafc;
            padding: 2rem 1.25rem;
        }

        /* Ambient Background Blobs Wrapper */
        .ambient-bg-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        /* Ambient Background Blobs */
        .blob-1, .blob-2 {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.12;
            pointer-events: none;
        }

        .blob-1 {
            top: 10%;
            left: 10%;
            width: 350px;
            height: 350px;
            background: #6366f1;
            animation: float-blob-1 20s infinite alternate ease-in-out;
        }

        .blob-2 {
            bottom: 10%;
            right: 10%;
            width: 450px;
            height: 450px;
            background: #a855f7;
            animation: float-blob-2 25s infinite alternate ease-in-out;
        }

        @keyframes float-blob-1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(60px, 40px) scale(1.15); }
        }

        @keyframes float-blob-2 {
            0% { transform: translate(0, 0) scale(1.1); }
            100% { transform: translate(-80px, -50px) scale(0.9); }
        }

        /* Glassmorphic Container */
        .maintenance-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 520px;
            margin: auto;
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5),
                        0 0 40px rgba(99, 102, 241, 0.07);
            text-align: center;
            animation: card-fade-in 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes card-fade-in {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Brand Logo styling */
        .brand-logo {
            margin-bottom: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .brand-logo img {
            width: 100%;
            max-width: 260px;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(99, 102, 241, 0.3));
        }

        /* Gear Animation Container */
        .illustration-container {
            position: relative;
            width: 160px;
            height: 160px;
            margin: 0 auto 2.2rem auto;
        }

        .glow-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 110px;
            height: 110px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.35) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            animation: pulse-glow 3s infinite ease-in-out;
        }

        .gear-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            animation: float 4s infinite ease-in-out;
        }

        .gear-main {
            position: absolute;
            top: 25px;
            left: 25px;
            font-size: 5.5rem;
            color: #6366f1;
            text-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
            animation: spin-clockwise 14s infinite linear;
        }

        .gear-secondary {
            position: absolute;
            top: 75px;
            left: 95px;
            font-size: 3.2rem;
            color: #a855f7;
            text-shadow: 0 0 15px rgba(168, 85, 247, 0.3);
            animation: spin-counter-clockwise 9s infinite linear;
        }

        .tool-icon {
            position: absolute;
            top: 85px;
            left: 20px;
            font-size: 2.4rem;
            color: #ec4899;
            text-shadow: 0 0 15px rgba(236, 72, 153, 0.3);
            transform: rotate(-45deg);
            animation: tool-float 3s infinite ease-in-out;
        }

        @keyframes spin-clockwise {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes spin-counter-clockwise {
            0% { transform: rotate(360deg); }
            100% { transform: rotate(0deg); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        @keyframes tool-float {
            0%, 100% { transform: translateY(0) rotate(-45deg); }
            50% { transform: translateY(-5px) rotate(-35deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(0.95); }
            50% { opacity: 0.9; transform: translate(-50%, -50%) scale(1.15); }
        }

        /* Pill Badge */
        .pill-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 999px;
            color: #818cf8;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.2rem;
        }

        .pill-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #818cf8;
            animation: pulse-dot 1.5s infinite ease-in-out;
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.5; }
        }

        /* Typography */
        h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #f8fafc 30%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }

        p.description {
            color: #94a3b8;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            font-weight: 400;
        }

        /* Progress Bar Section */
        .progress-container {
            margin: 2rem 0;
            text-align: left;
        }

        .progress-bar-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .progress-bar-track {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 999px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-fill {
            width: 85%;
            height: 100%;
            background: linear-gradient(90deg, #6366f1, #a855f7);
            border-radius: 999px;
            position: absolute;
            left: 0;
            top: 0;
            animation: fill-progress 2s ease-out forwards;
        }

        @keyframes fill-progress {
            0% { width: 0%; }
            100% { width: 85%; }
        }

        /* Status Grid */
        .status-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin: 2rem 0 2.5rem 0;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .status-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot.online {
            background-color: #10b981;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
        }

        .status-dot.maintenance {
            background-color: #f59e0b;
            box-shadow: 0 0 10px rgba(245, 158, 11, 0.5);
            animation: status-blink 1.5s infinite ease-in-out;
        }

        @keyframes status-blink {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 1; }
        }

        .status-text {
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 500;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.6rem;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 22px rgba(99, 102, 241, 0.45);
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.04);
            color: #f8fafc;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .btn-secondary:active {
            transform: translateY(0);
        }

        /* Responsive layout tweaks */
        @media (max-width: 480px) {
            .maintenance-card {
                padding: 2.5rem 1.5rem;
            }

            h1 {
                font-size: 1.7rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Ambient Background Blobs Container -->
    <div class="ambient-bg-wrapper">
        <div class="blob-1"></div>
        <div class="blob-2"></div>
    </div>

    <!-- Main Content Card -->
    <div class="maintenance-card">
        <!-- Logo -->
        <div class="brand-logo">
            <img src="{{ asset('img/obatkitaputihfull.png') }}" alt="ObatKita Logo" />
        </div>

        <!-- Animated Gears -->
        <div class="illustration-container">
            <div class="glow-bg"></div>
            <div class="gear-wrapper">
                <i class="fas fa-cog gear-main"></i>
                <i class="fas fa-cog gear-secondary"></i>
                <i class="fas fa-wrench tool-icon"></i>
            </div>
        </div>

        <!-- Badge -->
        <div class="pill-badge">
            <span class="pill-badge-dot"></span>
            Pemeliharaan Sistem
        </div>

        <!-- Title & description -->
        <h1>Website Sedang Maintenance</h1>
        <p class="description">
            Kami sedang melakukan peningkatan sistem dan pemeliharaan rutin untuk memberikan layanan yang lebih cepat, aman, dan handal bagi Anda. Kami akan segera kembali online.
        </p>

        <!-- Status Grid -->
        <div class="status-grid">
            <div class="status-item">
                <span class="status-dot online"></span>
                <span class="status-text">Server</span>
            </div>
            <div class="status-item">
                <span class="status-dot maintenance"></span>
                <span class="status-text">Database</span>
            </div>
            <div class="status-item">
                <span class="status-dot online"></span>
                <span class="status-text">Layanan</span>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="action-buttons">
            <button onclick="window.location.reload();" class="btn btn-primary">
                <i class="fas fa-sync-alt"></i> Refresh Halaman
            </button>
            @if(Auth::check())
            <a href="{{ route('logOut') }}" class="btn btn-secondary" style="border-color: rgba(239, 68, 68, 0.4); color: #f87171;">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
            @endif
            <a href="https://wa.me/629623479137" target="_blank" class="btn btn-secondary">
                <i class="fab fa-whatsapp"></i> Hubungi Dukungan
            </a>
        </div>
    </div>
</body>

</html>
