<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GameHub - Ongoing Tournaments</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root{
      --accent: #00e5ff; /* neon cyan */
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

    /* ---------- PARTICLE BACKGROUND ---------- */
    canvas#bgParticles{
      position:fixed;
      top:0;
      left:0;
      width:100%;
      height:100%;
      z-index:-1;
    }

    /* ---------- NAV ---------- */
    .navbar{
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      border-bottom:1px solid #111;
      padding:1.2rem 2rem;
      position:sticky;
      top:0;
      z-index:100;
    }
    .nav-container{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;}
    .logo{font-size:1.8rem;font-weight:800;color:var(--accent);letter-spacing:0px;text-shadow:0 0 8px rgba(0,229,255,0.7);}
    .nav-links{display:flex;list-style:none;}
    .nav-links li{margin-left:2.5rem;position:relative;}
    .nav-links a{text-decoration:none;color:#fff;font-weight:500;transition:color 0.3s,font-weight 0.3s;font-size:1.1rem;}
    .nav-links a:hover{color:var(--accent);font-weight:600;}
    .nav-links a.active{color:var(--accent);}
    .nav-links a.active::after{content:'';position:absolute;bottom:-5px;left:0;width:100%;height:2px;background-color:var(--accent);}

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
      padding: 5rem 1.5rem 2rem;
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
  padding: 0.8rem 1rem 0.3rem; /* Even less padding */
  border-bottom: 1px solid rgba(0,229,255,0.3);
  margin-bottom: 1rem;
  position: relative;
  top: -10px; /* This directly moves it up */
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

/* Adjust mobile nav padding */
.mobile-nav {
  padding: 0.2rem 1.5rem 2rem; /* Minimal top padding */
}

    .car {position:absolute;top:0;left:-100px;font-size:1.5rem;color:#ffcc00;animation: drive 8s linear infinite;}
    @keyframes drive {0% { left:-100px; } 100% { left:110%; }}

    /* ---------- CONTENT ---------- */
    .main-content{flex:1;max-width:1200px;margin:2rem auto;padding:0 2rem;width:100%;}
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

    @keyframes glow{
      from{text-shadow:0 0 12px rgba(0,229,255,0.7),0 0 20px rgba(0,229,255,0.3);}
      to{text-shadow:0 0 20px rgba(0,229,255,1),0 0 30px rgba(0,229,255,0.5);}
    }

    /* Winners and MVPs Button */
    .winners-btn-container {
      text-align: center;
      margin: 2rem 0;
    }

    .winners-btn {
      background: linear-gradient(135deg, var(--accent), #0099cc);
      color: #000;
      border: none;
      padding: 1rem 2rem;
      font-size: 1.2rem;
      font-weight: 700;
      border-radius: 50px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 20px rgba(0,229,255,0.4);
      text-transform: uppercase;
      letter-spacing: 1px;
      position: relative;
      overflow: hidden;
    }

    .winners-btn:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 8px 30px rgba(0,229,255,0.7);
      background: linear-gradient(135deg, #00ffff, var(--accent));
    }

    .winners-btn:active {
      transform: translateY(0) scale(1);
    }

    .winners-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s ease;
    }

    .winners-btn:hover::before {
      left: 100%;
    }

    /* ---------- Tournament Cards ---------- */
    .tournaments-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:2rem;margin-top:2rem;}
    .tournament-card{
      background:rgba(0,0,0,0.75);
      border-radius:12px;
      overflow:hidden;
      box-shadow:0 5px 15px rgba(0,229,255,0.25);
      transition:0.4s;
      padding:1.5rem;
      text-align:center;
      opacity:0;
      transform:translateY(30px);
      animation: fadeInUp 1s forwards;
      border: 1px solid rgba(0,229,255,0.2);
    }
    .tournament-card:nth-child(1){animation-delay:0.3s;}
    .tournament-card:nth-child(2){animation-delay:0.6s;}
    .tournament-card:nth-child(3){animation-delay:0.9s;}
    .tournament-card:nth-child(4){animation-delay:1.2s;}

    .tournament-card:hover{
      transform:translateY(-8px) scale(1.03);
      box-shadow:0 10px 25px rgba(0,229,255,0.6);
      border-color: var(--accent);
    }
    .tournament-card h3{color:var(--accent);margin-bottom:1rem;font-size:1.4rem;}
    .tournament-card p{color:#ccc;margin-bottom:0.5rem;font-size:1rem;}
    .tournament-card a{
      display:inline-block;
      margin-top:10px;
      color:var(--accent);
      text-decoration:none;
      font-weight:600;
      border:1px solid var(--accent);
      padding:0.4rem 0.8rem;
      border-radius:6px;
      transition:0.3s;
    }
    .tournament-card a:hover{background:var(--accent);color:#000;box-shadow:0 0 15px rgba(0,229,255,0.7);}

    @keyframes fadeInUp{to{opacity:1;transform:translateY(0);}}

    /* ---------- Footer ---------- */
    footer{background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);color:#fff;padding:1.2rem;text-align:center;margin-top:3rem;border-top:1px solid #111;}
    .footer-logo{font-size:1.4rem;font-weight:800;letter-spacing:2px;margin-bottom:0.5rem;color:var(--accent);}
    .copyright{margin-top:0.5rem;font-size:0.9rem;color:#888;}

    /* ---------- CURSOR BALL ---------- */
    .cursor-ball{position: fixed;top:0;left:0;width: var(--ball-size);height: var(--ball-size);border-radius:50%;background: var(--accent);box-shadow: var(--ball-shadow);transform: translate(-50%, -50%) scale(1);pointer-events: none; z-index: 9999;opacity:0.9; transition: transform 120ms ease, opacity 180ms ease;}

    /* ---------- BOUNCING BALL ---------- */
    .ball-container{position: fixed;bottom: 80px;left: 40px; z-index: 500;}
    @keyframes rotateBall {0%{transform:rotateY(0deg) rotateX(0deg);}100%{transform:rotateY(720deg) rotateX(720deg);}}
    @keyframes bounceBall {0% { transform: translateY(-70px) scale(1,1); } 45% { transform: translateY(70px) scale(1,1); } 50% { transform: translateY(75px) scale(1,0.9); } 100% { transform: translateY(-70px) scale(1,1); }}
    .ball {animation:bounceBall 1.2s infinite;border-radius:50%;height:60px;width:60px;position:relative;}
    .ball::before {background:radial-gradient(circle at 36px 20px,#00e5ff,#004466);border:2px solid #111;border-radius:50%;content:"";height:calc(100% + 6px);left:-6px;position:absolute;top:-3px;width:calc(100% + 6px);}
    .ball .inner {animation:rotateBall 25s linear infinite;border-radius:50%;height:100%;position:absolute;width:100%;}
    .shadow {animation:bounceShadow 1.2s infinite;background:black;filter:blur(2px);border-radius:50%;height:6px;width:54px;transform:translateY(73px);margin:auto;}
    @keyframes bounceShadow {0%,100% {opacity:0.6;transform:translateY(73px) scale(0.5);} 45% {opacity:0.9;transform:translateY(73px) scale(1);}}

    /* ---------- Responsive Design ---------- */
    @media (max-width: 768px){
      .nav-links{display:none;}
      .mobile-nav-toggle{display:block;}
      .mobile-nav{display:block;}
      .navbar{padding:1rem 1.5rem;}
      .logo{font-size:1.5rem;}
      .main-content{padding:0 1rem;}
      .page-title{font-size:1.8rem;}
      .tournaments-grid{grid-template-columns:1fr;gap:1.5rem;}
      .tournament-card{padding:1.2rem;}
      .tournament-card h3{font-size:1.2rem;}
      .winners-btn{padding:0.8rem 1.5rem;font-size:1rem;}
      .ball-container{bottom:20px;left:20px;}
      .ball,.shadow{transform:scale(0.8);}
    }

    @media (max-width: 576px){
      .page-title{font-size:1.6rem;}
      .tournament-card{padding:1rem;}
      .tournament-card h3{font-size:1.1rem;}
      .tournament-card p{font-size:0.9rem;}
      .winners-btn{padding:0.7rem 1.2rem;font-size:0.9rem;}
    }
  </style>
</head>
<body>
  <canvas id="bgParticles"></canvas>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">HehKali Esports</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="game.php">Games</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="gamesheld.php" class="active">Games Held</a></li>
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
    <li><a href="index.php" class="active">Home</a></li>
    <li><a href="game.php">Games</a></li>
    <li><a href="contact.php">Contact</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="gamesheld.php">Games Held</a></li>
  </ul>
</div>

  <!-- Main Content -->
  <main class="main-content">
    <h1 class="page-title">Ongoing Tournaments</h1>

    <!-- Winners and MVPs Button -->
    <div class="winners-btn-container">
      <button class="winners-btn" onclick="window.location.href='winnersandmvps.php'">
        <i class="fas fa-trophy"></i> Winners and MVPs
      </button>
    </div>

    <div class="tournaments-grid">
      <!-- Free Fire Tournament -->
      <div class="tournament-card">
        <h3>🔥 Free Fire Tournament</h3>
        <p>Date: September 30, 2025</p>
        <p>Mode: Squad (4 Players)</p>
        <a href="freefire_standings.php">View Standings</a>
      </div>

      <!-- Valorant Tournament -->
      <div class="tournament-card">
        <h3>🎯 Valorant Tournament</h3>
        <p>Date: October 15, 2025</p>
        <p>Mode: 5v5</p>
        <a href="valo_tiesheet.php">look the stages</a>
      </div>

      <!-- Mobile Legends Tournament -->
      <div class="tournament-card">
        <h3>🛡️ MLBB Tournament</h3>
        <p>Date: October 25, 2025</p>
        <p>Mode: Team</p>
        <a href="">Comming Soon</a>
      </div>
      <div class="tournament-card">
        <h3>🛡️ PUBG Tournament</h3>
        <p>Date: October 25, 2025</p>
        <p>Mode: Team</p>
        <a href="pubg_standings.php">View Standings</a>
      </div>
    </div>
  </main>

  <!-- Bouncing Ball -->
  <div class="ball-container">
    <div class="ball"><div class="inner"></div></div>
    <div class="shadow"></div>
  </div>

  <!-- Footer -->
  <footer>
    <p class="footer-logo">HehKali Esports</p>
    <p class="copyright">&copy; 2023 All rights reserved.</p>
  </footer>

  <!-- Cursor Ball -->
  <div class="cursor-ball" id="cursorBall" aria-hidden="true"></div>

  <script>
    const cursorBall = document.getElementById('cursorBall');
    const mobileNavToggle = document.getElementById('mobileNavToggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileNavOverlay = document.getElementById('mobileNavOverlay');

    // Cursor tracking
    document.addEventListener('mousemove',e=>{
      cursorBall.style.transform=`translate(${e.clientX}px,${e.clientY}px) scale(1)`;
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

    /* -------- YOUTUBE-STYLE PARTICLE BACKGROUND -------- */
    const canvas=document.getElementById('bgParticles');
    const ctx=canvas.getContext('2d');
    let particlesArray = [];
    canvas.width=window.innerWidth;
    canvas.height=window.innerHeight;

    window.addEventListener('resize',()=>{
      canvas.width=window.innerWidth;
      canvas.height=window.innerHeight;
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