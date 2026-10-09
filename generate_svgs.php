<?php

// Script to generate high quality, rich cartoon SVGs for Dapur Kartun

function saveSvg($path, $content) {
    file_put_contents($path, trim($content));
    echo "Saved: $path\n";
}

// 1. Logo
$logo = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 80" fill="none">
    <defs>
        <linearGradient id="hatGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#FF6B35" />
            <stop offset="100%" stop-color="#E8501E" />
        </linearGradient>
        <linearGradient id="brushGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#FFC107" />
            <stop offset="100%" stop-color="#FF8F00" />
        </linearGradient>
    </defs>
    <!-- Mascot Chef Hat & Brush Icon -->
    <g transform="translate(10, 10)">
        <path d="M25 45 C15 45 10 38 12 28 C8 26 6 18 12 12 C18 6 26 8 30 10 C34 4 44 4 48 10 C52 6 62 8 66 14 C72 20 70 28 66 32 C68 40 62 45 53 45 Z" fill="#FFFDF8" stroke="#1F1135" stroke-width="4" stroke-linejoin="round"/>
        <rect x="22" y="44" width="34" height="12" rx="4" fill="url(#hatGrad)" stroke="#1F1135" stroke-width="4"/>
        <circle cx="28" cy="50" r="2" fill="#FFFDF8"/>
        <circle cx="39" cy="50" r="2" fill="#FFFDF8"/>
        <circle cx="50" cy="50" r="2" fill="#FFFDF8"/>
        <!-- Pencil / Brush sticking out -->
        <g transform="rotate(25 45 15)">
            <path d="M42 -4 L48 -4 L48 24 L42 24 Z" fill="url(#brushGrad)" stroke="#1F1135" stroke-width="3"/>
            <path d="M42 -4 L45 -12 L48 -4 Z" fill="#38B6FF" stroke="#1F1135" stroke-width="2"/>
        </g>
        <circle cx="16" cy="18" r="3" fill="#FFC107"/>
        <polygon points="62,6 64,1 66,6 71,8 66,10 64,15 62,10 57,8" fill="#FFC107"/>
    </g>
    <!-- Brand Typography -->
    <text x="85" y="42" font-family="'Plus Jakarta Sans', 'Fredoka', 'Nunito', sans-serif" font-weight="900" font-size="30" fill="#1F1135" letter-spacing="-0.5">Dapur<tspan fill="#FF6B35">Kartun</tspan></text>
    <text x="86" y="60" font-family="'Plus Jakarta Sans', sans-serif" font-weight="700" font-size="11" fill="#7E6E94" letter-spacing="2">STUDIO KREATIF &amp; ANIMASI</text>
</svg>
SVG;
saveSvg(__DIR__ . '/public/images/logo.svg', $logo);

// 2. Parallax Hero Elements
$mascotHero = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 600" fill="none">
    <defs>
        <linearGradient id="bodyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#FFD6A5" />
            <stop offset="100%" stop-color="#FFBC80" />
        </linearGradient>
        <linearGradient id="apronGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#FF6B35" />
            <stop offset="100%" stop-color="#E04812" />
        </linearGradient>
        <linearGradient id="brushWood" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#C68B59" />
            <stop offset="100%" stop-color="#8B5A2B" />
        </linearGradient>
        <filter id="softGlow" x="-20%" y="-20%" width="140%" height="140%">
            <feGaussianBlur stdDeviation="8" result="blur" />
            <feComposite in="SourceGraphic" in2="blur" operator="over" />
        </filter>
    </defs>
    <!-- Magic Splash Background -->
    <circle cx="300" cy="300" r="230" fill="#FFECC7" opacity="0.45"/>
    <path d="M120 280 C80 180 200 100 300 90 C420 80 520 180 490 300 C470 420 380 500 270 510 C160 520 140 380 120 280 Z" fill="#F4E8FF" opacity="0.6"/>
    
    <!-- Floating Paint Splats -->
    <path d="M80 180 Q60 150 90 140 Q130 130 110 170 Q100 200 80 180 Z" fill="#38B6FF" stroke="#1F1135" stroke-width="4"/>
    <path d="M480 140 Q520 110 530 150 Q540 190 500 180 Q460 170 480 140 Z" fill="#FFC107" stroke="#1F1135" stroke-width="4"/>
    <circle cx="510" cy="380" r="16" fill="#FF6B35" stroke="#1F1135" stroke-width="4"/>
    <circle cx="100" cy="370" r="14" fill="#38B6FF" stroke="#1F1135" stroke-width="4"/>
    
    <!-- Big Giant Magic Paintbrush -->
    <g transform="translate(180, 20) rotate(32 200 200)">
        <path d="M190 20 L220 20 L216 380 L194 380 Z" fill="url(#brushWood)" stroke="#1F1135" stroke-width="6" stroke-linejoin="round"/>
        <rect x="186" y="380" width="38" height="30" rx="4" fill="#E2E8F0" stroke="#1F1135" stroke-width="6"/>
        <path d="M186 410 C186 470 205 490 205 490 C205 490 224 470 224 410 Z" fill="#38B6FF" stroke="#1F1135" stroke-width="6"/>
        <path d="M200 450 C200 480 205 490 205 490 C205 490 210 480 210 450 Z" fill="#FFFDF8"/>
    </g>

    <!-- Character Body / Koki Maskot -->
    <g transform="translate(170, 160)">
        <!-- Head -->
        <ellipse cx="130" cy="140" rx="95" ry="90" fill="url(#bodyGrad)" stroke="#1F1135" stroke-width="7"/>
        <!-- Ears -->
        <circle cx="35" cy="140" r="22" fill="url(#bodyGrad)" stroke="#1F1135" stroke-width="6"/>
        <circle cx="225" cy="140" r="22" fill="url(#bodyGrad)" stroke="#1F1135" stroke-width="6"/>
        <!-- Big Chef Hat with Art Flairs -->
        <path d="M45 75 C10 65 15 20 50 15 C45 -25 110 -35 130 5 C160 -35 225 -20 215 20 C250 25 250 65 215 75 Z" fill="#FFFDF8" stroke="#1F1135" stroke-width="7" stroke-linejoin="round"/>
        <rect x="60" y="72" width="140" height="26" rx="8" fill="url(#apronGrad)" stroke="#1F1135" stroke-width="6"/>
        <circle cx="85" cy="85" r="4" fill="#FFFDF8"/>
        <circle cx="130" cy="85" r="4" fill="#FFFDF8"/>
        <circle cx="175" cy="85" r="4" fill="#FFFDF8"/>

        <!-- Eyes & Cheeks -->
        <!-- Cheeks -->
        <ellipse cx="75" cy="165" rx="16" ry="10" fill="#FF8A8A" opacity="0.6"/>
        <ellipse cx="185" cy="165" rx="16" ry="10" fill="#FF8A8A" opacity="0.6"/>
        <!-- Eyes -->
        <ellipse cx="85" cy="135" rx="18" ry="24" fill="#1F1135"/>
        <circle cx="80" cy="125" r="8" fill="#FFFDF8"/>
        <circle cx="92" cy="144" r="3.5" fill="#FFFDF8"/>
        
        <ellipse cx="175" cy="135" rx="18" ry="24" fill="#1F1135"/>
        <circle cx="170" cy="125" r="8" fill="#FFFDF8"/>
        <circle cx="182" cy="144" r="3.5" fill="#FFFDF8"/>
        
        <!-- Eyebrows -->
        <path d="M68 105 Q85 96 100 106" stroke="#1F1135" stroke-width="6" stroke-linecap="round" fill="none"/>
        <path d="M160 106 Q175 96 192 105" stroke="#1F1135" stroke-width="6" stroke-linecap="round" fill="none"/>

        <!-- Cute Nose & Big Happy Smile -->
        <path d="M125 145 C125 152 135 152 135 145" stroke="#1F1135" stroke-width="5" stroke-linecap="round" fill="none"/>
        <path d="M95 168 Q130 215 165 168" fill="#E04812" stroke="#1F1135" stroke-width="6" stroke-linejoin="round"/>
        <path d="M108 178 Q130 200 152 178 Q130 168 108 178 Z" fill="#FFFDF8"/>
        <path d="M112 188 Q130 210 148 188 Q130 182 112 188 Z" fill="#FF8A8A"/>

        <!-- Torso & Chef Apron -->
        <path d="M70 230 L50 370 C50 390 210 390 210 370 L190 230 Z" fill="url(#apronGrad)" stroke="#1F1135" stroke-width="7" stroke-linejoin="round"/>
        <!-- Apron Straps -->
        <path d="M75 230 L95 280 L165 280 L185 230" fill="none" stroke="#FFFDF8" stroke-width="6"/>
        <!-- Palette in Hand -->
        <g transform="translate(150, 230) rotate(-15)">
            <path d="M0 40 C-20 0 60 -30 90 10 C120 50 80 100 40 90 C10 80 20 60 0 40 Z" fill="#FFFDF8" stroke="#1F1135" stroke-width="6"/>
            <circle cx="65" cy="55" r="10" fill="#1F1135"/>
            <!-- Paint Dots -->
            <circle cx="35" cy="18" r="8" fill="#FF6B35"/>
            <circle cx="65" cy="14" r="8" fill="#FFC107"/>
            <circle cx="85" cy="35" r="8" fill="#38B6FF"/>
            <circle cx="45" cy="65" r="8" fill="#9C27B0"/>
        </g>
    </g>
</svg>
SVG;
saveSvg(__DIR__ . '/public/images/hero/mascot-chef-artist.svg', $mascotHero);

// Clouds and Floating Props
$cloud1 = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 280 140" fill="none">
    <path d="M40 100 C20 100 10 85 20 70 C10 50 35 30 55 45 C70 15 115 10 135 35 C155 15 200 20 215 50 C235 40 260 55 255 80 C270 95 255 115 235 110 C215 125 60 125 40 100 Z" fill="#FFFDF8" stroke="#1F1135" stroke-width="5" stroke-linejoin="round"/>
    <ellipse cx="90" cy="70" rx="14" ry="7" fill="#E2E8F0" opacity="0.6"/>
    <ellipse cx="170" cy="75" rx="20" ry="8" fill="#E2E8F0" opacity="0.6"/>
</svg>
SVG;
saveSvg(__DIR__ . '/public/images/hero/cloud-1.svg', $cloud1);

$cloud2 = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 110" fill="none">
    <path d="M30 80 C15 80 8 68 15 56 C8 40 28 25 44 36 C56 12 92 8 108 28 C124 12 160 16 172 40 C188 32 208 44 204 64 C216 76 204 92 188 88 C172 100 48 100 30 80 Z" fill="#FFEEDB" stroke="#1F1135" stroke-width="4" stroke-linejoin="round"/>
</svg>
SVG;
saveSvg(__DIR__ . '/public/images/hero/cloud-2.svg', $cloud2);

$floatingStars = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 160" fill="none">
    <!-- Big 4-point cartoon star -->
    <g transform="translate(30, 30)">
        <polygon points="50,0 62,38 100,50 62,62 50,100 38,62 0,50 38,38" fill="#FFC107" stroke="#1F1135" stroke-width="5" stroke-linejoin="round"/>
        <circle cx="50" cy="50" r="12" fill="#FFFDF8"/>
    </g>
    <!-- Little companions -->
    <polygon points="135,15 140,28 153,33 140,38 135,51 130,38 117,33 130,28" fill="#38B6FF" stroke="#1F1135" stroke-width="3"/>
    <circle cx="20" cy="120" r="6" fill="#FF6B35" stroke="#1F1135" stroke-width="3"/>
</svg>
SVG;
saveSvg(__DIR__ . '/public/images/hero/floating-stars.svg', $floatingStars);

$floatingPencil = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 160" fill="none">
    <g transform="translate(30, 20) rotate(-35 50 60)">
        <polygon points="50,10 65,10 65,95 50,95" fill="#FFC107" stroke="#1F1135" stroke-width="4"/>
        <polygon points="50,95 65,95 57,118" fill="#F4E8D8" stroke="#1F1135" stroke-width="4"/>
        <polygon points="54,110 60,110 57,118" fill="#1F1135"/>
        <rect x="50" y="0" width="15" height="10" rx="3" fill="#FF6B35" stroke="#1F1135" stroke-width="4"/>
    </g>
</svg>
SVG;
saveSvg(__DIR__ . '/public/images/hero/floating-pencil.svg', $floatingPencil);

// 3. Slides (Full Illustrations for 3 Hero Slides)
$slide1 = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 500" fill="none">
    <defs>
        <radialGradient id="cauldronGlow" cx="50%" cy="50%" r="50%">
            <stop offset="0%" stop-color="#FFD600" stop-opacity="0.8"/>
            <stop offset="100%" stop-color="#FF6B35" stop-opacity="0"/>
        </radialGradient>
        <linearGradient id="potGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#3C2A55"/>
            <stop offset="100%" stop-color="#1F1135"/>
        </linearGradient>
    </defs>
    <!-- Background Magic Glow -->
    <ellipse cx="350" cy="300" rx="260" ry="180" fill="url(#cauldronGlow)"/>
    
    <!-- Magic Bubbles & Creativity Popping Out -->
    <path d="M300 250 C260 140 180 120 140 160" stroke="#38B6FF" stroke-width="8" stroke-linecap="round" stroke-dasharray="16 12" fill="none"/>
    <path d="M400 240 C460 130 550 140 580 190" stroke="#FFC107" stroke-width="8" stroke-linecap="round" stroke-dasharray="18 10" fill="none"/>
    
    <!-- Creative Floating Elements -->
    <g transform="translate(110, 80) rotate(-15)">
        <rect x="0" y="0" width="80" height="60" rx="8" fill="#FFFDF8" stroke="#1F1135" stroke-width="5"/>
        <circle cx="25" cy="25" r="10" fill="#FF6B35"/>
        <path d="M10 50 L35 30 L55 45 L70 35 L70 50 Z" fill="#38B6FF"/>
    </g>
    
    <g transform="translate(500, 70) rotate(20)">
        <circle cx="40" cy="40" r="35" fill="#FFC107" stroke="#1F1135" stroke-width="5"/>
        <ellipse cx="30" cy="32" rx="5" ry="8" fill="#1F1135"/>
        <ellipse cx="50" cy="32" rx="5" ry="8" fill="#1F1135"/>
        <path d="M30 48 Q40 60 50 48" stroke="#1F1135" stroke-width="4" stroke-linecap="round" fill="none"/>
    </g>
    
    <!-- The Cauldron / Wajan Kartun Ajaib -->
    <g transform="translate(180, 220)">
        <ellipse cx="170" cy="60" rx="150" ry="35" fill="#38B6FF" stroke="#1F1135" stroke-width="7"/>
        <ellipse cx="170" cy="60" rx="135" ry="25" fill="#FFEAA7"/>
        <!-- Bubbles on surface -->
        <circle cx="120" cy="55" r="15" fill="#38B6FF" stroke="#1F1135" stroke-width="4"/>
        <circle cx="160" cy="50" r="22" fill="#FF6B35" stroke="#1F1135" stroke-width="4"/>
        <circle cx="210" cy="56" r="16" fill="#FFC107" stroke="#1F1135" stroke-width="4"/>
        <!-- Pot Belly -->
        <path d="M20 60 Q10 200 170 200 Q330 200 320 60 Z" fill="url(#potGrad)" stroke="#1F1135" stroke-width="8" stroke-linejoin="round"/>
        <!-- Pot Handles -->
        <path d="M15 90 C-15 90 -15 130 15 130" stroke="#1F1135" stroke-width="8" stroke-linecap="round" fill="none"/>
        <path d="M325 90 C355 90 355 130 325 130" stroke="#1F1135" stroke-width="8" stroke-linecap="round" fill="none"/>
        <!-- Pot Legs -->
        <rect x="70" y="195" width="28" height="40" rx="8" fill="#1F1135"/>
        <rect x="240" y="195" width="28" height="40" rx="8" fill="#1F1135"/>
        <rect x="155" y="198" width="30" height="42" rx="8" fill="#1F1135"/>
    </g>
</svg>
SVG;
saveSvg(__DIR__ . '/public/images/slides/slide-1-dapur-imajinasi.svg', $slide1);

$slide2 = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 500" fill="none">
    <defs>
        <linearGradient id="bgS2" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#E0F2FE"/>
            <stop offset="100%" stop-color="#BAE6FD"/>
        </linearGradient>
    </defs>
    <rect x="50" y="40" width="600" height="420" rx="40" fill="url(#bgS2)" stroke="#1F1135" stroke-width="6"/>
    
    <!-- Character 1: Astronaut Bunny -->
    <g transform="translate(100, 140)">
        <!-- Helmet -->
        <circle cx="70" cy="80" r="65" fill="#FFFFFF" fill-opacity="0.85" stroke="#1F1135" stroke-width="6"/>
        <!-- Ears poking up -->
        <path d="M40 25 C30 -30 60 -30 65 20" fill="#FFFDF8" stroke="#1F1135" stroke-width="5"/>
        <path d="M75 20 C80 -30 110 -30 100 25" fill="#FFFDF8" stroke="#1F1135" stroke-width="5"/>
        <!-- Bunny Face -->
        <ellipse cx="60" cy="80" rx="5" ry="8" fill="#1F1135"/>
        <ellipse cx="80" cy="80" rx="5" ry="8" fill="#1F1135"/>
        <polygon points="70,92 65,88 75,88" fill="#FF6B35"/>
        <!-- Suit -->
        <path d="M30 145 L110 145 L120 220 L20 220 Z" fill="#FF6B35" stroke="#1F1135" stroke-width="6"/>
        <circle cx="70" cy="180" r="14" fill="#FFC107" stroke="#1F1135" stroke-width="4"/>
    </g>

    <!-- Character 2: Friendly Baker Bot (Center) -->
    <g transform="translate(270, 90)">
        <!-- Antenna -->
        <line x1="80" y1="20" x2="80" y2="50" stroke="#1F1135" stroke-width="6"/>
        <circle cx="80" cy="16" r="10" fill="#FF6B35" stroke="#1F1135" stroke-width="4"/>
        <!-- Head Box -->
        <rect x="25" y="50" width="110" height="90" rx="20" fill="#FFFDF8" stroke="#1F1135" stroke-width="6"/>
        <!-- Screen Face -->
        <rect x="40" y="65" width="80" height="55" rx="10" fill="#1F1135"/>
        <circle cx="62" cy="90" r="9" fill="#38B6FF"/>
        <circle cx="98" cy="90" r="9" fill="#38B6FF"/>
        <path d="M72 105 Q80 112 88 105" stroke="#38B6FF" stroke-width="4" stroke-linecap="round" fill="none"/>
        <!-- Body -->
        <rect x="35" y="145" width="90" height="120" rx="15" fill="#38B6FF" stroke="#1F1135" stroke-width="6"/>
        <!-- Cupcake on plate -->
        <ellipse cx="80" cy="200" rx="25" ry="8" fill="#FFFDF8" stroke="#1F1135" stroke-width="4"/>
        <path d="M68 200 L92 200 L90 180 L70 180 Z" fill="#C68B59" stroke="#1F1135" stroke-width="3"/>
        <circle cx="80" cy="175" r="7" fill="#FF6B35"/>
    </g>

    <!-- Character 3: Cat Wizard Explorer -->
    <g transform="translate(460, 140)">
        <!-- Wizard Hat -->
        <polygon points="70,0 20,80 120,80" fill="#7C3AED" stroke="#1F1135" stroke-width="6"/>
        <ellipse cx="70" cy="80" rx="60" ry="14" fill="#5B21B6" stroke="#1F1135" stroke-width="5"/>
        <!-- Cat Face -->
        <circle cx="70" cy="115" r="45" fill="#FFBC80" stroke="#1F1135" stroke-width="6"/>
        <!-- Cat ears -->
        <polygon points="35,80 25,50 50,70" fill="#FFBC80" stroke="#1F1135" stroke-width="5"/>
        <polygon points="105,80 115,50 90,70" fill="#FFBC80" stroke="#1F1135" stroke-width="5"/>
        <!-- Whiskers & Eyes -->
        <ellipse cx="55" cy="110" rx="5" ry="7" fill="#1F1135"/>
        <ellipse cx="85" cy="110" rx="5" ry="7" fill="#1F1135"/>
        <line x1="25" y1="120" x2="45" y2="120" stroke="#1F1135" stroke-width="3"/>
        <line x1="95" y1="120" x2="115" y2="120" stroke="#1F1135" stroke-width="3"/>
        <!-- Robe -->
        <path d="M40 160 L100 160 L115 225 L25 225 Z" fill="#7C3AED" stroke="#1F1135" stroke-width="6"/>
    </g>
</svg>
SVG;
saveSvg(__DIR__ . '/public/images/slides/slide-2-dunia-karakter.svg', $slide2);

$slide3 = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 700 500" fill="none">
    <defs>
        <linearGradient id="filmGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#FF6B35"/>
            <stop offset="100%" stop-color="#FFC107"/>
        </linearGradient>
    </defs>
    <!-- Dynamic Waving Animation Film Strip -->
    <path d="M60 380 C150 320 220 440 350 360 C480 280 540 380 640 260" stroke="#1F1135" stroke-width="84" stroke-linecap="round" fill="none"/>
    <path d="M60 380 C150 320 220 440 350 360 C480 280 540 380 640 260" stroke="#FFFDF8" stroke-width="72" stroke-linecap="round" fill="none"/>
    
    <!-- Film Holes -->
    <g stroke="#1F1135" stroke-width="3" fill="#1F1135">
        <circle cx="100" cy="340" r="5"/> <circle cx="100" cy="385" r="5"/>
        <circle cx="170" cy="345" r="5"/> <circle cx="170" cy="390" r="5"/>
        <circle cx="250" cy="370" r="5"/> <circle cx="250" cy="415" r="5"/>
        <circle cx="340" cy="340" r="5"/> <circle cx="340" cy="385" r="5"/>
        <circle cx="430" cy="285" r="5"/> <circle cx="430" cy="330" r="5"/>
        <circle cx="520" cy="305" r="5"/> <circle cx="520" cy="350" r="5"/>
        <circle cx="600" cy="250" r="5"/> <circle cx="600" cy="295" r="5"/>
    </g>

    <!-- Flying Clapperboard -->
    <g transform="translate(180, 80) rotate(-12)">
        <rect x="0" y="30" width="160" height="120" rx="12" fill="#1F1135" stroke="#1F1135" stroke-width="6"/>
        <rect x="15" y="50" width="130" height="80" rx="6" fill="#FFFDF8"/>
        <!-- Clapper top sticks -->
        <g transform="translate(-10, -5) rotate(-15)">
            <rect x="10" y="10" width="160" height="28" rx="6" fill="#1F1135"/>
            <polygon points="30,10 45,10 30,38 15,38" fill="#FFFDF8"/>
            <polygon points="65,10 80,10 65,38 50,38" fill="#FFFDF8"/>
            <polygon points="100,10 115,10 100,38 85,38" fill="#FFFDF8"/>
            <polygon points="135,10 150,10 135,38 120,38" fill="#FFFDF8"/>
        </g>
        <text x="35" y="85" font-family="'Plus Jakarta Sans', sans-serif" font-weight="900" font-size="16" fill="#FF6B35">SCENE 01</text>
        <text x="35" y="110" font-family="'Plus Jakarta Sans', sans-serif" font-weight="700" font-size="12" fill="#1F1135">TAKE: ACTION!</text>
    </g>

    <!-- Animation Keyframe Bubbles -->
    <g transform="translate(420, 70)">
        <circle cx="80" cy="80" r="75" fill="url(#filmGrad)" stroke="#1F1135" stroke-width="7"/>
        <polygon points="65,50 110,80 65,110" fill="#FFFDF8" stroke="#1F1135" stroke-width="4" stroke-linejoin="round"/>
    </g>
</svg>
SVG;
saveSvg(__DIR__ . '/public/images/slides/slide-3-animasi-cerita.svg', $slide3);

// 4. About Section Storyteller Mascot
$aboutMascot = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" fill="none">
    <!-- Big Book Stack Base -->
    <g transform="translate(60, 310)">
        <rect x="20" y="60" width="340" height="50" rx="10" fill="#38B6FF" stroke="#1F1135" stroke-width="6"/>
        <rect x="35" y="66" width="310" height="38" rx="4" fill="#FFFDF8"/>
        
        <rect x="0" y="10" width="370" height="50" rx="10" fill="#FF6B35" stroke="#1F1135" stroke-width="6"/>
        <rect x="15" y="16" width="340" height="38" rx="4" fill="#FFFDF8"/>
    </g>
    <!-- Character sitting happily -->
    <g transform="translate(140, 100)">
        <!-- Head -->
        <circle cx="110" cy="110" r="65" fill="#FFBC80" stroke="#1F1135" stroke-width="6"/>
        <!-- Beret Artist Hat -->
        <path d="M45 80 C40 30 160 20 175 75 C185 95 160 105 130 95 C90 100 50 95 45 80 Z" fill="#7C3AED" stroke="#1F1135" stroke-width="6"/>
        <circle cx="110" cy="35" r="7" fill="#FFC107" stroke="#1F1135" stroke-width="3"/>
        <!-- Big Round Glasses -->
        <circle cx="85" cy="110" r="22" fill="#FFFFFF" fill-opacity="0.6" stroke="#1F1135" stroke-width="5"/>
        <circle cx="135" cy="110" r="22" fill="#FFFFFF" fill-opacity="0.6" stroke="#1F1135" stroke-width="5"/>
        <line x1="107" y1="110" x2="113" y2="110" stroke="#1F1135" stroke-width="5"/>
        <circle cx="88" cy="110" r="6" fill="#1F1135"/>
        <circle cx="138" cy="110" r="6" fill="#1F1135"/>
        <!-- Big Smile -->
        <path d="M92 140 Q110 160 128 140" stroke="#1F1135" stroke-width="5" stroke-linecap="round" fill="none"/>
        <!-- Body holding open sketchbook -->
        <rect x="65" y="175" width="90" height="80" rx="16" fill="#FF6B35" stroke="#1F1135" stroke-width="6"/>
        <!-- Open Sketchbook in Hands -->
        <g transform="translate(30, 210)">
            <polygon points="10,20 80,35 80,95 10,80" fill="#FFFDF8" stroke="#1F1135" stroke-width="5"/>
            <polygon points="80,35 150,20 150,80 80,95" fill="#FFFDF8" stroke="#1F1135" stroke-width="5"/>
            <path d="M25 45 Q45 35 65 50" stroke="#FF6B35" stroke-width="3" fill="none"/>
            <circle cx="115" cy="50" r="10" fill="#38B6FF"/>
        </g>
    </g>
</svg>
SVG;
saveSvg(__DIR__ . '/public/images/about/mascot-storyteller.svg', $aboutMascot);

// 5. Gallery Artworks (8 items)
$artworks = [
    'artwork-1-petualangan-awan.svg' => [
        'title' => 'Petualangan Awan',
        'color1' => '#38B6FF',
        'color2' => '#0284C7',
        'tag' => 'ILUSTRASI',
        'icon' => 'cloud'
    ],
    'artwork-2-koki-bintang.svg' => [
        'title' => 'Koki Pemetik Bintang',
        'color1' => '#FFC107',
        'color2' => '#F59E0B',
        'tag' => 'KARAKTER',
        'icon' => 'star'
    ],
    'artwork-3-mesin-waktu-kucing.svg' => [
        'title' => 'Mesin Waktu Kucing',
        'color1' => '#8B5CF6',
        'color2' => '#6D28D9',
        'tag' => 'ANIMASI',
        'icon' => 'time'
    ],
    'artwork-4-hutan-jamur-ajaib.svg' => [
        'title' => 'Hutan Jamur Bercahaya',
        'color1' => '#10B981',
        'color2' => '#059669',
        'tag' => 'ILUSTRASI',
        'icon' => 'nature'
    ],
    'artwork-5-kelinci-antariksa.svg' => [
        'title' => 'Kelinci Antariksa',
        'color1' => '#EC4899',
        'color2' => '#DB2777',
        'tag' => 'KARAKTER',
        'icon' => 'bunny'
    ],
    'artwork-6-buku-cerita-raksasa.svg' => [
        'title' => 'Buku Dongeng Ajaib',
        'color1' => '#F97316',
        'color2' => '#EA580C',
        'tag' => 'DESAIN',
        'icon' => 'book'
    ],
    'artwork-7-orkestra-hewan-ceria.svg' => [
        'title' => 'Orkestra Hutan Ceria',
        'color1' => '#6366F1',
        'color2' => '#4F46E5',
        'tag' => 'ANIMASI',
        'icon' => 'music'
    ],
    'artwork-8-kemasan-susu-kartun.svg' => [
        'title' => 'Desain Kemasan Moo-Moo',
        'color1' => '#14B8A6',
        'color2' => '#0D9488',
        'tag' => 'DESAIN',
        'icon' => 'milk'
    ],
];

foreach ($artworks as $file => $meta) {
    $c1 = $meta['color1'];
    $c2 = $meta['color2'];
    $title = $meta['title'];
    $tag = $meta['tag'];
    
    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 450" fill="none">
    <defs>
        <linearGradient id="g_$file" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="$c1" />
            <stop offset="100%" stop-color="$c2" />
        </linearGradient>
    </defs>
    <!-- Background Frame -->
    <rect width="600" height="450" rx="24" fill="url(#g_$file)"/>
    <!-- Decorative Cartoon Waves / Hills -->
    <path d="M0 350 Q150 280 300 340 Q450 400 600 320 L600 450 L0 450 Z" fill="#FFFDF8" fill-opacity="0.25"/>
    <path d="M0 380 Q200 320 400 370 Q500 390 600 360 L600 450 L0 450 Z" fill="#FFFDF8" fill-opacity="0.35"/>
    
    <!-- Central Cartoon Art Focal Point -->
    <g transform="translate(180, 80)">
        <circle cx="120" cy="120" r="110" fill="#FFFDF8" stroke="#1F1135" stroke-width="7"/>
        <!-- Inner Graphics -->
        <circle cx="120" cy="120" r="85" fill="$c1" fill-opacity="0.2"/>
        <!-- Character Icon Graphic -->
        <path d="M80 150 C70 90 170 90 160 150 Z" fill="$c1" stroke="#1F1135" stroke-width="6"/>
        <circle cx="100" cy="115" r="12" fill="#1F1135"/>
        <circle cx="140" cy="115" r="12" fill="#1F1135"/>
        <circle cx="97" cy="112" r="4" fill="#FFFDF8"/>
        <circle cx="137" cy="112" r="4" fill="#FFFDF8"/>
        <path d="M110 130 Q120 140 130 130" stroke="#1F1135" stroke-width="4" stroke-linecap="round" fill="none"/>
        <polygon points="120,40 126,55 142,60 126,65 120,80 114,65 98,60 114,55" fill="#FFC107" stroke="#1F1135" stroke-width="3"/>
    </g>
    
    <!-- Cartoon Badge Label in artwork -->
    <g transform="translate(40, 40)">
        <rect x="0" y="0" width="110" height="34" rx="17" fill="#FFFDF8" stroke="#1F1135" stroke-width="4"/>
        <text x="55" y="22" font-family="'Plus Jakarta Sans', sans-serif" font-weight="800" font-size="12" fill="#1F1135" text-anchor="middle" letter-spacing="1">$tag</text>
    </g>
</svg>
SVG;
    saveSvg(__DIR__ . '/public/images/gallery/' . $file, $svg);
}

// 6. Testimonial Avatars (4 avatars)
$avatars = [
    'avatar-1.svg' => ['bg' => '#FFD6A5', 'hair' => '#1F1135', 'acc' => '#FF6B35'],
    'avatar-2.svg' => ['bg' => '#BAE6FD', 'hair' => '#7C3AED', 'acc' => '#38B6FF'],
    'avatar-3.svg' => ['bg' => '#FED7AA', 'hair' => '#B45309', 'acc' => '#FFC107'],
    'avatar-4.svg' => ['bg' => '#DDD6FE', 'hair' => '#0F172A', 'acc' => '#10B981'],
];

foreach ($avatars as $file => $cfg) {
    $bg = $cfg['bg'];
    $hair = $cfg['hair'];
    $acc = $cfg['acc'];
    
    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none">
    <circle cx="60" cy="60" r="56" fill="$bg" stroke="#1F1135" stroke-width="6"/>
    <!-- Head -->
    <circle cx="60" cy="60" r="32" fill="#FFFDF8" stroke="#1F1135" stroke-width="5"/>
    <!-- Hair -->
    <path d="M30 55 C30 25 90 25 90 55 C80 40 40 40 30 55 Z" fill="$hair" stroke="#1F1135" stroke-width="4"/>
    <!-- Eyes -->
    <circle cx="50" cy="62" r="4" fill="#1F1135"/>
    <circle cx="70" cy="62" r="4" fill="#1F1135"/>
    <!-- Cheeks -->
    <circle cx="42" cy="70" r="4" fill="#FF8A8A" opacity="0.6"/>
    <circle cx="78" cy="70" r="4" fill="#FF8A8A" opacity="0.6"/>
    <!-- Smile -->
    <path d="M54 72 Q60 78 66 72" stroke="#1F1135" stroke-width="3" stroke-linecap="round" fill="none"/>
    <!-- Shirt -->
    <path d="M32 108 C35 90 85 90 88 108 Z" fill="$acc" stroke="#1F1135" stroke-width="5"/>
</svg>
SVG;
    saveSvg(__DIR__ . '/public/images/avatars/' . $file, $svg);
}

echo "All SVG assets created successfully!\n";
