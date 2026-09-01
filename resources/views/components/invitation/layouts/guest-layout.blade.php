<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings['general']['invitation_title'] ?? 'The Wedding of Ramazan & Dede' }}</title>
    
    <!-- OpenGraph / WhatsApp Preview Metadata -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $settings['general']['invitation_title'] ?? 'Tasyakuran Pernikahan Ramazan & Dede' }}">
    <meta property="og:description" content="Dengan memohon Rahmat & Ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara Tasyakuran Pernikahan kami.">
    <meta property="og:image" content="{{ asset('images/cartoon_couple_cover.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- High Priority Preload for Instant Cover Rendering -->
    <link rel="preload" as="image" href="{{ asset('images/cartoon_couple_cover.webp') }}">

    <!-- Google Fonts: Great Vibes, Alex Brush, Playfair Display, Cinzel, Amiri, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Amiri:ital,wght@0,400;0,700;1,400&family=Cinzel:wght@400;600;700;900&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind Play CDN for Instant Zero-Fail Styling on Mobile / Ngrok -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        script: ['Great Vibes', 'Alex Brush', 'cursive'],
                        serif: ['Playfair Display', 'Cormorant Garamond', 'Georgia', 'serif'],
                        sans: ['Plus Jakarta Sans', 'system-ui', '-apple-system', 'sans-serif'],
                        arabic: ['Amiri', 'Traditional Arabic', 'serif'],
                        display: ['Cinzel', 'serif']
                    },
                    colors: {
                        sage: {
                            50: '#f4f7f4',
                            100: '#eaf0eb',
                            200: '#d5e2d7',
                            300: '#b6cdb9',
                            400: '#91b395',
                            500: '#6f9575',
                            600: '#57795c',
                            700: '#425e47',
                            800: '#314736',
                            900: '#233327',
                            950: '#162119'
                        },
                        gold: {
                            50: '#f4f7f4',
                            100: '#eaf0eb',
                            200: '#d5e2d7',
                            300: '#b6cdb9',
                            400: '#91b395',
                            500: '#6f9575',
                            600: '#57795c',
                            700: '#425e47',
                            800: '#314736',
                            900: '#233327'
                        },
                        champagne: {
                            50: '#f4f7f4',
                            100: '#eaf0eb',
                            200: '#d5e2d7',
                            300: '#b6cdb9',
                            400: '#91b395',
                            500: '#6f9575'
                        },
                        emerald: {
                            800: '#314736',
                            900: '#233327',
                            950: '#162119'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Compiled Local Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F7F4] text-[#233327] font-sans antialiased selection:bg-[#6F9575]/25 selection:text-[#314736] min-h-screen overflow-x-hidden">

    <!-- Main Content Slot -->
    {{ $slot }}

    <!-- Global Persistent Falling Leaves & Petals Canvas (Persistent overlay across all sections, cover, and on scroll) -->
    <canvas id="global-falling-leaves-canvas" class="fixed inset-0 w-full h-full pointer-events-none z-[60]"></canvas>

    <!-- Global Floating Toast Notification -->
    <div x-data="{
            show: false,
            message: '',
            type: 'success',
            timeout: null,
            init() {
                window.addEventListener('toast-notify', (e) => {
                    this.message = e.detail.message;
                    this.type = e.detail.type || 'success';
                    this.show = true;
                    clearTimeout(this.timeout);
                    this.timeout = setTimeout(() => { this.show = false; }, 3500);
                });
            }
         }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         style="display: none;"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[9999] max-w-sm w-[90%] sm:w-auto px-5 py-3 rounded-full shadow-2xl backdrop-blur-md text-sm font-medium flex items-center gap-2 border text-white"
         :class="type === 'success' ? 'bg-[#314736]/95 border-[#6F9575]/60' : 'bg-red-900/95 border-red-500/50'">
        <svg x-show="type === 'success'" class="w-5 h-5 text-[#B6CDB9] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <svg x-show="type !== 'success'" class="w-5 h-5 text-red-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span x-text="message"></span>
    </div>

    <!-- Global Falling Leaves & Petals Animation Script -->
    <script>
        (function() {
            function initFallingPetals() {
                const canvas = document.getElementById('global-falling-leaves-canvas');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                if (!ctx) return;

                let width = (canvas.width = window.innerWidth);
                let height = (canvas.height = window.innerHeight);

                function onResize() {
                    width = canvas.width = window.innerWidth;
                    height = canvas.height = window.innerHeight;
                }
                window.addEventListener('resize', onResize, { passive: true });

                // Particles: Sage green leaves, white rose petals, and delicate soft sparkles
                const particleCount = 38;
                const particles = [];

                for (let i = 0; i < particleCount; i++) {
                    const typeRand = Math.random();
                    let type = 'petal';
                    let size = Math.random() * 6 + 4;
                    let speedY = Math.random() * 0.9 + 0.5;
                    let swaySpeed = Math.random() * 0.02 + 0.01;
                    let rotSpeed = (Math.random() - 0.5) * 1.8;
                    let alpha = Math.random() * 0.5 + 0.35;
                    let color = 'rgba(255, 255, 255,';

                    if (typeRand < 0.45) {
                        // Sage Green Leaf
                        type = 'leaf';
                        size = Math.random() * 7 + 5;
                        color = Math.random() > 0.5 ? 'rgba(111, 149, 117,' : 'rgba(145, 179, 149,';
                    } else if (typeRand < 0.85) {
                        // White Rose Petal
                        type = 'petal';
                        size = Math.random() * 7 + 4;
                        color = 'rgba(255, 255, 255,';
                    } else {
                        // Soft Golden Shimmer
                        type = 'sparkle';
                        size = Math.random() * 2.5 + 1.5;
                        speedY = Math.random() * 0.5 + 0.3;
                        color = 'rgba(213, 226, 215,';
                        alpha = Math.random() * 0.7 + 0.3;
                    }

                    particles.push({
                        x: Math.random() * width,
                        y: Math.random() * height,
                        type,
                        size,
                        speedY,
                        swaySpeed,
                        swayAngle: Math.random() * Math.PI * 2,
                        rotation: Math.random() * 360,
                        rotSpeed,
                        color,
                        alpha,
                        wind: (Math.random() - 0.5) * 0.3
                    });
                }

                function drawLeaf(ctx, p) {
                    ctx.save();
                    ctx.translate(p.x, p.y);
                    ctx.rotate((p.rotation * Math.PI) / 180);
                    ctx.beginPath();
                    ctx.moveTo(0, -p.size);
                    ctx.quadraticCurveTo(p.size * 0.6, 0, 0, p.size);
                    ctx.quadraticCurveTo(-p.size * 0.6, 0, 0, -p.size);
                    ctx.fillStyle = `${p.color} ${p.alpha})`;
                    ctx.fill();
                    ctx.beginPath();
                    ctx.moveTo(0, -p.size * 0.8);
                    ctx.lineTo(0, p.size * 0.8);
                    ctx.strokeStyle = `rgba(35, 51, 39, ${p.alpha * 0.35})`;
                    ctx.lineWidth = 0.6;
                    ctx.stroke();
                    ctx.restore();
                }

                function drawPetal(ctx, p) {
                    ctx.save();
                    ctx.translate(p.x, p.y);
                    ctx.rotate((p.rotation * Math.PI) / 180);
                    ctx.beginPath();
                    ctx.ellipse(0, 0, p.size * 1.3, p.size * 0.8, 0, 0, Math.PI * 2);
                    ctx.fillStyle = `${p.color} ${p.alpha})`;
                    ctx.shadowColor = 'rgba(255, 255, 255, 0.4)';
                    ctx.shadowBlur = 4;
                    ctx.fill();
                    ctx.restore();
                }

                function drawSparkle(ctx, p) {
                    ctx.save();
                    ctx.translate(p.x, p.y);
                    ctx.beginPath();
                    ctx.arc(0, 0, p.size, 0, Math.PI * 2);
                    ctx.fillStyle = `${p.color} ${p.alpha})`;
                    ctx.shadowColor = 'rgba(182, 205, 185, 0.8)';
                    ctx.shadowBlur = 6;
                    ctx.fill();
                    ctx.restore();
                }

                function render() {
                    ctx.clearRect(0, 0, width, height);

                    for (let i = 0; i < particles.length; i++) {
                        const p = particles[i];
                        p.y += p.speedY;
                        p.swayAngle += p.swaySpeed;
                        p.x += Math.sin(p.swayAngle) * 0.8 + p.wind;
                        p.rotation += p.rotSpeed;

                        if (p.y > height + 20) {
                            p.y = -20;
                            p.x = Math.random() * width;
                        }
                        if (p.x > width + 20) p.x = -20;
                        if (p.x < -20) p.x = width + 20;

                        if (p.type === 'leaf') {
                            drawLeaf(ctx, p);
                        } else if (p.type === 'petal') {
                            drawPetal(ctx, p);
                        } else {
                            drawSparkle(ctx, p);
                        }
                    }

                    requestAnimationFrame(render);
                }

                requestAnimationFrame(render);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initFallingPetals);
            } else {
                initFallingPetals();
            }
        })();
    </script>
</body>
</html>
