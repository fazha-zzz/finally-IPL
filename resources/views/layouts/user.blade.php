<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PP8B')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>

       

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* CSS dashboard kamu tetap sama */
        .mobile-container { max-width: 1200px; margin: 0 auto; background: white; min-height: 100vh; position: relative; overflow: hidden; }
        .header-section { background: linear-gradient(135deg, #029e48ff 0%, #023914ff 50%); color: white; padding: 40px 30px 140px 30px; position: relative; border-radius: 30px 30px 0 0; }
        .profile-avatar { position: absolute; top: 30px; right: 30px; width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 100%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255,255,255,0.3); }
        .profile-avatar i { font-size: 24px; color: white; }
        .greeting-text { font-size: 16px; opacity: 0.9; margin-bottom: 8px; }
        .user-name { font-size: 28px; font-weight: 700; margin: 0; }
        .balance-card { position: absolute; bottom: -70px; left: 30px; right: 30px; background: white; border-radius: 20px; padding: 25px; box-shadow: 0 12px 40px rgba(0,0,0,0.12); }
        .balance-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .balance-label { font-size: 14px; color: #6b7280; margin: 0 0 5px 0; }
        .balance-amount { font-size: 32px; font-weight: 700; color: #111827; margin: 0; }
        .balance-detail { font-size: 12px; color: #3ad61eff; text-decoration: none; font-weight: 500; }
        .topup-btn { background: #079813ff; color: white; border: none; border-radius: 14px; padding: 12px 24px; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .check-bill-btn { background: #058022ff; color: white; border: none; border-radius: 18px; padding: 18px; font-size: 18px; font-weight: 600; width: 100%; margin: 40px 0; display: flex; align-items: center; justify-content: center; gap: 12px; }
        .main-content { padding: 90px 30px 30px 30px; }
        .section-title { font-size: 22px; font-weight: 700; color: #111827; margin-bottom: 25px; }
        .service-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 25px; margin-bottom: 40px; max-width: 1200px; }
        .service-item { text-align: center; text-decoration: none; color: inherit; }
        .service-icon { width: 64px; height: 64px; background: #18af45ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto; color: white; font-size: 24px; }
        .service-label { font-size: 15px; font-weight: 600; color: #374151; }
        .info-section { margin-top: 30px; }
        .info-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .view-all-link { color: #3b82f6; font-size: 14px; font-weight: 600; text-decoration: none; }
        .news-item { display: flex; gap: 12px; padding: 10px 0; }
        .news-image { width: 70px; height: 70px; border-radius: 8px; background: #e5e7eb; flex-shrink: 0; }
        .news-content h6 { font-size: 15px; font-weight: 600; color: #111827; margin: 0 0 4px 0; line-height: 1.3; }
        .news-content p { font-size: 13px; color: #6b7280; margin: 0; line-height: 1.3; }

        @media (max-width: 768px) {
            .mobile-container { max-width: 400px; }
            .header-section { padding: 30px 20px 120px 20px; }
            .profile-avatar { top: 20px; right: 20px; width: 50px; height: 50px; }
            .profile-avatar i { font-size: 20px; }
            .greeting-text { font-size: 14px; margin-bottom: 5px; }
            .user-name { font-size: 22px; }
            .balance-card { bottom: -60px; left: 20px; right: 20px; padding: 20px; border-radius: 16px; }
            .balance-amount { font-size: 24px; }
            .topup-btn { padding: 10px 20px; font-size: 14px; border-radius: 12px; gap: 8px; }
            .check-bill-btn { border-radius: 16px; padding: 16px; font-size: 16px; margin: 30px 0; gap: 10px; }
            .main-content { padding: 80px 20px 20px 20px; }
            .section-title { font-size: 18px; margin-bottom: 20px; }
            .service-grid { grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
            .service-icon { width: 56px; height: 56px; margin-bottom: 12px; font-size: 20px; }
            .service-label { font-size: 13px; }
            .news-image { width: 60px; height: 60px; }
            .news-content h6 { font-size: 13px; }
            .news-content p { font-size: 11px; }
        }

        /* 🔹 Enhanced Transition - Replace yang lama */
        .transition-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #1a5f3f 0%, #0d2818 50%, #1a5f3f 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 5000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .transition-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .transition-logo-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .transition-logo {
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: logoFloat 3s ease-in-out infinite;
        }

        .transition-logo svg {
            width: 80px;
            height: 80px;
        }

        .logo-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        .transition-text {
            color: white;
            text-align: center;
            margin-top: 20px;
        }

        .transition-text .brand-name {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .transition-text .brand-subtitle {
            font-size: 16px;
            font-weight: 400;
            opacity: 0.9;
            letter-spacing: 2px;
        }

        /* Floating particles effect */
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: particleFloat 4s ease-in-out infinite;
        }

        .particle:nth-child(1) { width: 4px; height: 4px; top: 20%; left: 15%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 6px; height: 6px; top: 30%; right: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { width: 3px; height: 3px; top: 60%; left: 25%; animation-delay: 2s; }
        .particle:nth-child(4) { width: 5px; height: 5px; top: 70%; right: 30%; animation-delay: 1.5s; }
        .particle:nth-child(5) { width: 4px; height: 4px; top: 85%; left: 40%; animation-delay: 0.5s; }

        .loading-spinner {
            margin-top: 40px;
            display: flex;
            gap: 8px;
        }

        .spinner-dot {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: spinnerBounce 1.4s ease-in-out infinite both;
        }

        .spinner-dot:nth-child(1) { animation-delay: -0.32s; }
        .spinner-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes logoFloat {
            0%, 100% { 
                transform: translateY(0px) scale(1);
            }
            50% { 
                transform: translateY(-20px) scale(1.08);
            }
        }

        @keyframes particleFloat {
            0%, 100% { 
                transform: translateY(0px) scale(1);
                opacity: 0.1;
            }
            25% {
                opacity: 0.3;
            }
            50% { 
                transform: translateY(-30px) scale(1.2);
                opacity: 0.6;
            }
            75% {
                opacity: 0.2;
            }
        }

        @keyframes spinnerBounce {
            0%, 80%, 100% { 
                transform: scale(0);
            }
            40% { 
                transform: scale(1);
            }
        }

        /* Mobile responsive untuk transition */
        @media (max-width: 768px) {
            .transition-logo { 
                width: 100px; 
                height: 100px; 
            }
            .transition-logo svg { 
                width: 65px; 
                height: 65px; 
            }
            .logo-image { 
                width: 100px; 
                height: 100px; 
            }
            .transition-text .brand-name { 
                font-size: 20px; 
            }
            .transition-text .brand-subtitle { 
                font-size: 14px; 
            }
        }

        @yield('styles')
    </style>
    
</head>
<body>

    {{-- Midtrans Snap --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    

    @include('layouts.components.header')
    @yield('content')
    @stack('scripts')
    @include('layouts.components.bottomnav')

    <!-- 🔹 Enhanced Transition Overlay - Replace struktur yang lama -->
    <div id="pageTransition" class="transition-overlay d-none">
        <!-- Floating particles -->
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>

        <div class="transition-logo-container">
            <div class="transition-logo">
                <!-- PP8B Logo Image -->
                <img src="{{ asset('assets/images/carossel/pesona1.png') }}" alt="PP8B Logo" class="logo-image">
            </div>
            
            <div class="transition-text">
                <div class="brand-name">PESONA PRIMA 8</div>
                <div class="brand-subtitle">BANJARAN</div>
            </div>

            <div class="loading-spinner">
                <div class="spinner-dot"></div>
                <div class="spinner-dot"></div>
                <div class="spinner-dot"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const transition = document.getElementById("pageTransition");

            // klik link di bottom nav → aktifkan transisi
            document.querySelectorAll(".bottom-nav a").forEach(link => {
                link.addEventListener("click", function() {
                    if (this.classList.contains("fw-bold")) return;
                    transition.classList.remove("d-none");
                    transition.classList.add("active");
                });
            });

            // pas halaman baru muncul → hilangkan transisi
            window.addEventListener("pageshow", function() {
                setTimeout(() => {
                    transition.classList.remove("active");
                    setTimeout(() => transition.classList.add("d-none"), 600);
                }, 1500); // Diperpanjang jadi 1.5 detik biar keliatan bagus
            });
        });
    </script>

</body>
</html>