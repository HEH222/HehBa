<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GameHub - Play Games!</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root{
      --accent: #00e5ff;
      --ball-size: 8px;
      --ball-shadow: 0 6px 18px rgba(0,229,255,0.3);
    }

    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}

    body{
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      color:#fff;
      line-height:1.6;
      min-height:100vh;
      display:flex;
      flex-direction:column;
      overflow-x:hidden;
      position:relative;
    }

    canvas#bgParticles{
      position:fixed;
      top:0;
      left:0;
      width:100%;
      height:100%;
      z-index:-1;
    }

    /* ---------- NAVBAR ---------- */
    .navbar{
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      border-bottom:1px solid #111;
      padding:1.2rem 2rem;
      position:sticky;
      top:0;
      z-index:100;
      overflow:hidden;
    }
    .nav-container{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;}
    .logo{font-size:1.8rem;font-weight:800;color:var(--accent);letter-spacing:0px;text-shadow:0 0 8px rgba(0,229,255,0.7);}
    .nav-links{display:flex;list-style:none;}
    .nav-links li{margin-left:2.5rem;position:relative;}
    .nav-links a{text-decoration:none;color:#fff;font-weight:500;transition:color 0.3s,font-weight 0.3s;font-size:1.1rem;}
    .nav-links a:hover{color:var(--accent);font-weight:600;}
    .nav-links a.active{color:var(--accent);}
    .nav-links a.active::after{content:'';position:absolute;bottom:-5px;left:0;width:100%;height:2px;background-color:var(--accent);}
    .car {position:absolute;top:0;left:-100px;font-size:1.5rem;color:#ffcc00;animation: drive 8s linear infinite;}
    @keyframes drive {0% { left:-100px; } 100% { left:110%; }}

    /* Mobile Nav */
    .mobile-nav-toggle {
      display: none;
      background: transparent;
      border: none;
      color: var(--accent);
      font-size: 1.5rem;
      cursor: pointer;
      z-index: 1000;
      padding: 0.5rem;
    }

    .mobile-nav {
      display: none;
      position: fixed;
      top: 0;
      right: -100%;
      width: 80%;
      max-width: 300px;
      height: 100vh;
      background: rgba(10, 20, 30, 0.98);
      backdrop-filter: blur(15px);
      border-left: 2px solid var(--accent);
      box-shadow: -5px 0 25px rgba(0,229,255,0.3);
      z-index: 999;
      transition: right 0.4s ease;
      padding: 0.2rem 1.5rem 2rem;
      overflow-y: auto;
    }

    .mobile-nav.active {
      right: 0;
    }

    .mobile-nav ul {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .mobile-nav a {
      color: #fff;
      text-decoration: none;
      font-size: 1.2rem;
      padding: 0.8rem 1rem;
      border-radius: 8px;
      display: block;
      transition: all 0.3s;
      border-left: 3px solid transparent;
    }

    .mobile-nav a:hover,
    .mobile-nav a.active {
      background: rgba(0,229,255,0.1);
      border-left: 3px solid var(--accent);
      color: var(--accent);
    }

    .mobile-nav-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(5px);
      z-index: 998;
    }

    .mobile-nav-overlay.active {
      display: block;
    }

    /* Mobile Nav Logo - Moved Up Version */
    .mobile-nav-logo {
      text-align: center;
      padding: 0.8rem 1rem 0.3rem;
      border-bottom: 1px solid rgba(0,229,255,0.3);
      margin-bottom: 1rem;
      position: relative;
      top: -10px;
    }

    .mobile-nav-logo .logo {
      font-size: 2rem;
      font-weight: 800;
      color: var(--accent);
      text-shadow: 
        0 0 8px rgba(0,229,255,0.7),
        0 0 15px rgba(255,255,255,0.5),
        0 0 20px rgba(255,255,255,0.3);
      letter-spacing: 1px;
      animation: neonGlow 2s infinite alternate;
    }

    /* ---------- MAIN CONTENT ---------- */
    .main-content{
      flex:1;
      max-width:1200px;
      margin:2rem auto;
      padding:0 2rem;
      width:100%;
    }
    .page-title{
      font-size:2.5rem;
      margin-bottom:2rem;
      color:var(--accent);
      text-align:center;
      font-weight:700;
      text-transform:uppercase;
      text-shadow:0 0 12px rgba(0,229,255,0.7);
      animation: glow 2s infinite alternate;
    }
    @keyframes glow{from{text-shadow:0 0 12px rgba(0,229,255,0.7),0 0 20px rgba(0,229,255,0.3);}to{text-shadow:0 0 20px rgba(0,229,255,1),0 0 30px rgba(0,229,255,0.5);}}

    /* Back Button */
    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(0, 0, 0, 0.3);
      color: var(--accent);
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      margin-bottom: 2rem;
      border: 1px solid rgba(0,229,255,0.3);
      transition: all 0.3s ease;
      backdrop-filter: blur(5px);
    }
    
    .back-btn:hover {
      background: rgba(0,229,255,0.1);
      box-shadow: 0 0 15px rgba(0,229,255,0.4);
      transform: translateY(-2px);
    }

    /* Game Cards Section */
    .games-section {
      margin-top: 2rem;
    }
    
    .games-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }
    
    .game-card {
      background: rgba(0, 0, 0, 0.85);
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0,229,255,0.3);
      transition: all 0.4s ease;
      border: 2px solid transparent;
      position: relative;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s forwards;
    }
    
    .game-card:nth-child(1) { animation-delay: 0.2s; }
    .game-card:nth-child(2) { animation-delay: 0.4s; }
    .game-card:nth-child(3) { animation-delay: 0.6s; }
    
    .game-card:hover {
      transform: translateY(-10px) scale(1.03);
      box-shadow: 0 15px 35px rgba(0,229,255,0.5);
      border-color: var(--accent);
    }
    
    .game-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--accent), #ff00ff, var(--accent));
      background-size: 200% 100%;
      animation: shimmer 3s infinite linear;
    }
    
    @keyframes shimmer {
      0% { background-position: -200% 0; }
      100% { background-position: 200% 0; }
    }
    
    .game-image {
      height: 200px;
      overflow: hidden;
      position: relative;
    }
    
    .game-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    
    .game-card:hover .game-image img {
      transform: scale(1.1);
    }
    
    .game-content {
      padding: 1.5rem;
      position: relative;
    }
    
    .game-title {
      font-size: 1.5rem;
      margin-bottom: 0.8rem;
      color: var(--accent);
      text-shadow: 0 0 8px rgba(0,229,255,0.5);
    }
    
    .game-desc {
      color: #ccc;
      margin-bottom: 1.2rem;
      line-height: 1.5;
    }
    
    .play-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, var(--accent), #0099cc);
      color: #000;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0,229,255,0.4);
    }
    
    .play-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,229,255,0.6);
    }
    
    .game-meta {
      display: flex;
      justify-content: space-between;
      margin-top: 1rem;
      color: var(--accent);
      font-size: 0.9rem;
    }

    footer{
      background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      color:#fff;
      padding:1.5rem;
      text-align:center;
      margin-top:3rem;
      border-top:1px solid #111;
    }
    .copyright{margin-top:0.5rem;font-size:0.9rem;color:#888;}

    .cursor-ball{
      position: fixed;
      top:0;
      left:0;
      width: var(--ball-size);
      height: var(--ball-size);
      border-radius:50%;
      background: var(--accent);
      box-shadow: var(--ball-shadow);
      transform: translate(-50%, -50%) scale(1);
      pointer-events: none;
      z-index: 9999;
      opacity:0.9;
      transition: transform 120ms ease, opacity 180ms ease;
    }

    .ball-container{
      position: fixed;
      bottom: 80px;
      left: 40px;
      z-index: 500;
    }
    
    @keyframes rotateBall {
      0%{transform:rotateY(0deg) rotateX(0deg);}
      100%{transform:rotateY(720deg) rotateX(720deg);}
    }
    
    @keyframes bounceBall {
      0% { transform: translateY(-70px) scale(1,1); }
      45% { transform: translateY(70px) scale(1,1); }
      50% { transform: translateY(75px) scale(1,0.9); }
      100% { transform: translateY(-70px) scale(1,1); }
    }
    
    .ball {
      animation:bounceBall 1.2s infinite;
      border-radius:50%;
      height:60px;
      width:60px;
      position:relative;
    }
    
    .ball::before {
      background:radial-gradient(circle at 36px 20px,#00e5ff,#004466);
      border:2px solid #111;
      border-radius:50%;
      content:"";
      height:calc(100% + 6px);
      left:-6px;
      position:absolute;
      top:-3px;
      width:calc(100% + 6px);
    }
    
    .ball .inner {
      animation:rotateBall 25s linear infinite;
      border-radius:50%;
      height:100%;
      position:absolute;
      width:100%;
    }
    
    .shadow {
      animation:bounceShadow 1.2s infinite;
      background:black;
      filter:blur(2px);
      border-radius:50%;
      height:6px;
      width:54px;
      transform:translateY(73px);
      margin:auto;
    }
    
    @keyframes bounceShadow {
      0%,100% {opacity:0.6;transform:translateY(73px) scale(0.5);}
      45% {opacity:0.9;transform:translateY(73px) scale(1);}
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .nav-links{display:none;}
      .mobile-nav-toggle{display:block;}
      .mobile-nav{display:block;}
      
      .navbar{padding:1rem 1.5rem;}
      .logo{font-size:1.5rem;}
      
      .main-content{padding:0 1rem;margin:1.5rem auto;}
      .page-title{font-size:2rem;}
      
      .games-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }
      
      .game-card {
        width: 100%;
      }
      
      .game-content {
        padding: 1.2rem;
      }
      
      .game-title {
        font-size: 1.3rem;
      }
      
      .game-desc {
        font-size: 0.95rem;
      }
      
      .ball-container{
        bottom: 20px;
        left: 20px;
      }
      
      .ball, .shadow {
        transform: scale(0.8);
      }
    }

    @media (max-width: 576px) {
      .page-title{font-size:1.8rem;}
      .main-content{padding:0 1rem;margin:1rem auto;}
      
      .games-grid {
        gap: 1rem;
      }
      
      .game-image {
        height: 160px;
      }
      
      .game-content {
        padding: 1rem;
      }
      
      .game-title {
        font-size: 1.2rem;
      }
      
      .game-desc {
        font-size: 0.9rem;
      }
      
      .play-btn {
        padding: 8px 16px;
        font-size: 0.9rem;
      }
      
      .game-meta {
        font-size: 0.8rem;
      }
    }
  </style>
</head>
<body>
  <canvas id="bgParticles"></canvas>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">HehBa</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="game.php" class="active">Games</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="gamesheld.php">Games Held</a></li>
      </ul>
      <button class="mobile-nav-toggle" id="mobileNavToggle">
        <i class="fas fa-bars"></i>
      </button>
    </div>
    <div class="car">🚗💨</div>
  </nav>

  <!-- Mobile Navigation -->
  <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
  <div class="mobile-nav" id="mobileNav">
    <div class="mobile-nav-logo">
      <div class="logo">HehBa</div>
    </div>
    
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="game.php" class="active">Games</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="gamesheld.php">Games Held</a></li>
    </ul>
  </div>

  <main class="main-content">
    <a href="game.php" class="back-btn">
      <i class="fas fa-arrow-left"></i> Back
    </a>
    
    <h1 class="page-title">Play Games!</h1>
    
    <section class="games-section">
      <div class="games-grid">
        <div class="game-card">
          <div class="game-image">
            <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f" alt="Game 1">
          </div>
          <div class="game-content">
            <h3 class="game-title">Game No 1</h3>
            <p class="game-desc">Experience the thrill of this action-packed adventure game with stunning graphics and immersive gameplay.</p>
            <a href="neuro.php" class="play-btn">
              <i class="fas fa-play"></i> Play Now
            </a>
            <div class="game-meta">
              <span class="game-rating">⭐ 4.8</span>
              <span class="game-players">2.4M Players</span>
            </div>
          </div>
        </div>
        
        <div class="game-card">
          <div class="game-image">
            <img src="https://images.unsplash.com/photo-1551103782-8ab07afd45c1" alt="Game 2">
          </div>
          <div class="game-content">
            <h3 class="game-title">Game No 2</h3>
            <p class="game-desc">Challenge your strategic thinking in this mind-bending puzzle game with hundreds of unique levels.</p>
            <a href="knowledge.php" class="play-btn">
              <i class="fas fa-play"></i> Play Now
            </a>
            <div class="game-meta">
              <span class="game-rating">⭐ 4.6</span>
              <span class="game-players">1.8M Players</span>
            </div>
          </div>
        </div>
        
        <div class="game-card">
          <div class="game-image">
            <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e" alt="Game 3">
          </div>
          <div class="game-content">
            <h3 class="game-title">Game No 3</h3>
            <p class="game-desc">Race against time and opponents in this high-speed racing game with realistic physics and stunning tracks.</p>
            <a href="cs.php" class="play-btn">
              <i class="fas fa-play"></i> Play Now
            </a>
            <div class="game-meta">
              <span class="game-rating">⭐ 4.9</span>
              <span class="game-players">3.1M Players</span>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <div class="ball-container">
    <div class="ball"><div class="inner"></div></div>
    <div class="shadow"></div>
  </div>

  <footer>
    <p>Gaming excellence since 2023</p>
    <p class="copyright">&copy; 2023 All rights reserved.</p>
  </footer>

  <div class="cursor-ball" id="cursorBall" aria-hidden="true"></div>

  <script>
    const cursorBall = document.getElementById('cursorBall');
    const mobileNavToggle = document.getElementById('mobileNavToggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileNavOverlay = document.getElementById('mobileNavOverlay');

    // Cursor ball effect
    document.addEventListener('mousemove', e => {
      cursorBall.style.transform = `translate(${e.clientX}px,${e.clientY}px) scale(1)`;
    });

    // Mobile navigation toggle
    mobileNavToggle.addEventListener('click', () => {
      mobileNav.classList.toggle('active');
      mobileNavOverlay.classList.toggle('active');
    });

    // Close mobile nav when clicking on overlay
    mobileNavOverlay.addEventListener('click', () => {
      mobileNav.classList.remove('active');
      mobileNavOverlay.classList.remove('active');
    });

    // Close mobile nav when clicking on a link
    document.querySelectorAll('.mobile-nav a').forEach(link => {
      link.addEventListener('click', () => {
        mobileNav.classList.remove('active');
        mobileNavOverlay.classList.remove('active');
      });
    });

    /* -------- YOUTUBE-STYLE GEOMETRIC PARTICLE BACKGROUND -------- */
    const canvas = document.getElementById('bgParticles');
    const ctx = canvas.getContext('2d');
    let particlesArray = [];
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    window.addEventListener('resize', () => {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
      initParticles();
    });

    class Particle {
      constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 60 + 20;
        this.speedX = Math.random() * 1.5 - 0.75;
        this.speedY = Math.random() * 1.5 - 0.75;
        this.rotation = Math.random() * 360;
        this.rotationSpeed = Math.random() * 1 - 0.5;
        this.shape = Math.floor(Math.random() * 5); // 0: triangle, 1: square, 2: hexagon, 3: circle, 4: diamond
        this.pulseSpeed = Math.random() * 0.03 + 0.01;
        this.pulseOffset = Math.random() * Math.PI * 2;
        this.colorHue = Math.random() * 60 + 180; // Blue to cyan range
        this.alpha = 0.1 + Math.random() * 0.15;
        this.glowIntensity = Math.random() * 0.3 + 0.2;
      }

      update() {
        this.x += this.speedX;
        this.y += this.speedY;
        this.rotation += this.rotationSpeed;
        
        // Bounce off edges
        if (this.x < -this.size || this.x > canvas.width + this.size) this.speedX *= -1;
        if (this.y < -this.size || this.y > canvas.height + this.size) this.speedY *= -1;
      }

      draw() {
        const pulse = Math.sin(Date.now() * this.pulseSpeed + this.pulseOffset) * 0.4 + 0.6;
        const size = this.size * pulse;
        const currentAlpha = this.alpha * pulse;
        
        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.rotation * Math.PI / 180);
        
        // Create gradient for YouTube-style effect
        const gradient = ctx.createRadialGradient(0, 0, 0, 0, 0, size/2);
        gradient.addColorStop(0, `hsla(${this.colorHue}, 100%, 60%, ${currentAlpha})`);
        gradient.addColorStop(1, `hsla(${this.colorHue}, 100%, 40%, 0)`);
        
        ctx.fillStyle = gradient;
        ctx.strokeStyle = `hsla(${this.colorHue}, 100%, 70%, ${currentAlpha * 0.7})`;
        ctx.lineWidth = 2;
        ctx.shadowColor = `hsla(${this.colorHue}, 100%, 60%, ${this.glowIntensity})`;
        ctx.shadowBlur = 20;
        
        ctx.beginPath();
        
        switch(this.shape) {
          case 0: // Triangle
            ctx.moveTo(0, -size/2);
            ctx.lineTo(size * 0.433, size/4);
            ctx.lineTo(-size * 0.433, size/4);
            break;
          case 1: // Square
            ctx.rect(-size/3, -size/3, size*2/3, size*2/3);
            break;
          case 2: // Hexagon
            for (let i = 0; i < 6; i++) {
              const angle = (i * 60) * Math.PI / 180;
              const x = Math.cos(angle) * size/2.5;
              const y = Math.sin(angle) * size/2.5;
              if (i === 0) ctx.moveTo(x, y);
              else ctx.lineTo(x, y);
            }
            break;
          case 3: // Circle
            ctx.arc(0, 0, size/3, 0, Math.PI * 2);
            break;
          case 4: // Diamond
            ctx.moveTo(0, -size/3);
            ctx.lineTo(size/3, 0);
            ctx.lineTo(0, size/3);
            ctx.lineTo(-size/3, 0);
            break;
        }
        
        ctx.closePath();
        ctx.fill();
        ctx.stroke();
        ctx.restore();
      }

      // Draw connections between nearby particles
      drawConnections() {
        particlesArray.forEach(particle => {
          const dx = this.x - particle.x;
          const dy = this.y - particle.y;
          const distance = Math.sqrt(dx * dx + dy * dy);
          
          if (distance < 200) {
            ctx.beginPath();
            ctx.strokeStyle = `hsla(${this.colorHue}, 70%, 60%, ${0.08 * (1 - distance/200)})`;
            ctx.lineWidth = 1.5;
            ctx.moveTo(this.x, this.y);
            ctx.lineTo(particle.x, particle.y);
            ctx.stroke();
          }
        });
      }
    }

    function initParticles() {
      particlesArray = [];
      for(let i = 0; i < 20; i++) {
        particlesArray.push(new Particle());
      }
    }

    function animateParticles() {
      // Clear with semi-transparent background for trail effect
      ctx.fillStyle = 'rgba(15, 32, 39, 0.05)';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      
      // Draw connections first (behind particles)
      particlesArray.forEach(particle => {
        particle.drawConnections();
      });
      
      // Draw particles
      particlesArray.forEach(particle => {
        particle.update();
        particle.draw();
      });
      
      requestAnimationFrame(animateParticles);
    }

    initParticles();
    animateParticles();
  </script>
</body>
</html>