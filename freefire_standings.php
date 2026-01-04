<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Free Fire - Overall Standings</title>
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
      color:#fff;line-height:1.6;min-height:100vh;
      display:flex;flex-direction:column;overflow-x:hidden;position:relative;
    }

    canvas#bgParticles{position:fixed;top:0;left:0;width:100%;height:100%;z-index:-1;}

    .navbar{background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      border-bottom:1px solid #111;padding:1.2rem 2rem;
      position:sticky;top:0;z-index:100;overflow:hidden;}
    .nav-container{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;}
    .logo{font-size:1.8rem;font-weight:800;color:var(--accent);text-shadow:0 0 8px rgba(0,229,255,0.7);}
    .nav-links{display:flex;list-style:none;}
    .nav-links li{margin-left:2.5rem;position:relative;}
    .nav-links a{text-decoration:none;color:#fff;font-weight:500;transition:0.3s;font-size:1.1rem;}
    .nav-links a:hover{color:var(--accent);font-weight:600;}
    .nav-links a.active{color:var(--accent);}
    .nav-links a.active::after{content:'';position:absolute;bottom:-5px;left:0;width:100%;height:2px;background-color:var(--accent);}
    .car {position:absolute;top:0;left:-100px;font-size:1.5rem;color:#ffcc00;animation:drive 8s linear infinite;}
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

    .main-content{flex:1;max-width:1200px;margin:2rem auto;padding:0 2rem;width:100%;}
    .page-title{font-size:2.5rem;margin-bottom:2rem;color:var(--accent);text-align:center;font-weight:700;text-transform:uppercase;text-shadow:0 0 12px rgba(0,229,255,0.7);animation:glow 2s infinite alternate;}
    @keyframes glow{from{text-shadow:0 0 12px rgba(0,229,255,0.7);}to{text-shadow:0 0 20px rgba(0,229,255,1);}}

    .button-group{text-align:center;margin-bottom:2rem;}
    .button-group button{
      background:var(--accent);color:#000;font-weight:600;
      border:none;padding:0.7rem 1.5rem;margin:0 0.5rem;
      border-radius:5px;cursor:pointer;transition:0.3s;
      box-shadow: 0 4px 15px rgba(0,229,255,0.3);
    }
    .button-group button:hover{background:#00bcd4;color:#fff;transform: translateY(-2px);}
    .button-group button.active{background:#0097a7;color: white;}
    .button-group button.init-btn{background:#4CAF50; display: none;}

    .stage-info {
      text-align: center;
      margin-bottom: 1rem;
      color: var(--accent);
      font-size: 1.2rem;
      font-weight: 600;
    }

    table.standings{width:100%;border-collapse:collapse;margin-top:1rem;background:rgba(0,0,0,0.7);border-radius:10px;overflow:hidden;box-shadow: 0 8px 25px rgba(0,0,0,0.5);}
    table.standings th,table.standings td{padding:12px 15px;text-align:center;border:1px solid #333;}
    table.standings th{background-color:var(--accent);color:#000;font-weight:700;}
    table.standings tr:nth-child(even){background:rgba(255,255,255,0.05);}
    table.standings tr:hover{background:rgba(0,229,255,0.1);}
    
    .rank-1 {background: linear-gradient(90deg, rgba(255,215,0,0.2), transparent) !important;}
    .rank-2 {background: linear-gradient(90deg, rgba(192,192,192,0.2), transparent) !important;}
    .rank-3 {background: linear-gradient(90deg, rgba(205,127,50,0.2), transparent) !important;}
    
    /* Animation for standings rows */
    .standings tr {
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 0.6s forwards;
    }
    
    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    /* Stagger the animation for each row */
    .standings tr:nth-child(1) { animation-delay: 0.1s; }
    .standings tr:nth-child(2) { animation-delay: 0.15s; }
    .standings tr:nth-child(3) { animation-delay: 0.2s; }
    .standings tr:nth-child(4) { animation-delay: 0.25s; }
    .standings tr:nth-child(5) { animation-delay: 0.3s; }
    .standings tr:nth-child(6) { animation-delay: 0.35s; }
    .standings tr:nth-child(7) { animation-delay: 0.4s; }
    .standings tr:nth-child(8) { animation-delay: 0.45s; }
    .standings tr:nth-child(9) { animation-delay: 0.5s; }
    .standings tr:nth-child(10) { animation-delay: 0.55s; }
    .standings tr:nth-child(11) { animation-delay: 0.6s; }
    .standings tr:nth-child(12) { animation-delay: 0.65s; }
    .standings tr:nth-child(13) { animation-delay: 0.7s; }
    .standings tr:nth-child(14) { animation-delay: 0.75s; }
    .standings tr:nth-child(15) { animation-delay: 0.8s; }
    .standings tr:nth-child(16) { animation-delay: 0.85s; }
    .standings tr:nth-child(17) { animation-delay: 0.9s; }
    .standings tr:nth-child(18) { animation-delay: 0.95s; }
    .standings tr:nth-child(19) { animation-delay: 1s; }
    .standings tr:nth-child(20) { animation-delay: 1.05s; }
    .standings tr:nth-child(21) { animation-delay: 1.1s; }
    .standings tr:nth-child(22) { animation-delay: 1.15s; }
    .standings tr:nth-child(23) { animation-delay: 1.2s; }
    .standings tr:nth-child(24) { animation-delay: 1.25s; }
    .standings tr:nth-child(25) { animation-delay: 1.3s; }
    .standings tr:nth-child(26) { animation-delay: 1.35s; }
    .standings tr:nth-child(27) { animation-delay: 1.4s; }
    .standings tr:nth-child(28) { animation-delay: 1.45s; }
    .standings tr:nth-child(29) { animation-delay: 1.5s; }
    .standings tr:nth-child(30) { animation-delay: 1.55s; }
    .standings tr:nth-child(31) { animation-delay: 1.6s; }
    .standings tr:nth-child(32) { animation-delay: 1.65s; }
    
    footer{background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);color:#fff;padding:1.2rem;text-align:center;margin-top:3rem;border-top:1px solid #111;}
    .copyright{margin-top:0.5rem;font-size:0.9rem;color:#888;}

    .cursor-ball{position:fixed;top:0;left:0;width:var(--ball-size);height:var(--ball-size);border-radius:50%;background:var(--accent);box-shadow:var(--ball-shadow);transform:translate(-50%,-50%);pointer-events:none;z-index:9999;opacity:0.9;}

    .ball-container{position:fixed;bottom:80px;left:40px;z-index:500;}
    @keyframes bounceBall{0%{transform:translateY(-70px);}50%{transform:translateY(75px);}100%{transform:translateY(-70px);}}
    .ball{animation:bounceBall 1.2s infinite;border-radius:50%;height:60px;width:60px;position:relative;}
    .ball::before{background:radial-gradient(circle at 36px 20px,#00e5ff,#004466);border:2px solid #111;border-radius:50%;content:"";height:calc(100% + 6px);left:-6px;position:absolute;top:-3px;width:calc(100% + 6px);}
    .shadow{animation:bounceShadow 1.2s infinite;background:black;filter:blur(2px);border-radius:50%;height:6px;width:54px;transform:translateY(73px);margin:auto;}
    @keyframes bounceShadow{0%,100%{opacity:0.6;transform:scale(0.5);}50%{opacity:0.9;transform:scale(1);}}

    .loading {text-align: center; padding: 2rem; color: var(--accent);}
    .success-message {
      background: rgba(76, 175, 80, 0.2);
      border: 1px solid #4CAF50;
      color: #4CAF50;
      padding: 1rem;
      border-radius: 5px;
      margin: 1rem 0;
      text-align: center;
    }
    .error-message {
      background: rgba(244, 67, 54, 0.2);
      border: 1px solid #f44336;
      color: #f44336;
      padding: 1rem;
      border-radius: 5px;
      margin: 1rem 0;
      text-align: center;
    }
    .auto-init-message {
      background: rgba(33, 150, 243, 0.2);
      border: 1px solid #2196F3;
      color: #2196F3;
      padding: 1rem;
      border-radius: 5px;
      margin: 1rem 0;
      text-align: center;
    }
    
    /* ---------- Responsive Design ---------- */
    @media (max-width: 768px){
      .nav-links{display:none;}
      .mobile-nav-toggle{display:block;}
      .mobile-nav{display:block;}
      .navbar{padding:1rem 1.5rem;}
      .logo{font-size:1.5rem;}
      .main-content{padding:0 1rem;margin:1.5rem auto;}
      .page-title{font-size:2rem;}
      .button-group{display:flex;flex-wrap:wrap;justify-content:center;gap:0.5rem;}
      .button-group button{margin:0.25rem;padding:0.6rem 1rem;font-size:0.9rem;}
      .stage-info{font-size:1rem;}
      table.standings{font-size:0.85rem;}
      table.standings th, table.standings td{padding:8px 10px;}
      .ball-container{bottom:20px;left:20px;}
      .ball,.shadow{transform:scale(0.8);}
    }

    @media (max-width: 576px){
      .page-title{font-size:1.8rem;}
      .button-group button{width:100%;margin:0.2rem 0;}
      table.standings{font-size:0.75rem;}
      table.standings th, table.standings td{padding:6px 8px;}
      .stage-info{font-size:0.9rem;}
      .footer-logo{font-size:1.2rem;}
    }
    
    /* Responsive table for very small screens */
    @media (max-width: 480px) {
      table.standings {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
      }
    }
  </style>
</head>
<body>
  <canvas id="bgParticles"></canvas>

  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">HehKali Esports</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="game.php">Games</a></li>
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
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="game.php">Games</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="gamesheld.php">Games Held</a></li>
    </ul>
  </div>

  <main class="main-content">
    <h1 class="page-title">Free Fire Overall Standings</h1>

    <div id="message"></div>

    <div class="button-group">
      <button onclick="filterStage('all', this)" class="active">All Teams (32)</button>
      <button onclick="filterStage('semifinal', this)">Semifinal (24)</button>
      <button onclick="filterStage('final', this)">Final (16)</button>
      <button onclick="initializeDatabase()" class="init-btn" id="initBtn">
        <i class="fas fa-database"></i> Initialize Database
      </button>
    </div>

    <div class="stage-info" id="stageInfo">Loading standings...</div>

    <table class="standings">
      <thead>
        <tr>
          <th>Rank</th>
          <th>Team</th>
          <th>Matches</th>
          <th>Booyah</th>
          <th>Kills</th>
          <th>Pos. Points</th>
          <th>Score</th>
        </tr>
      </thead>
      <tbody id="standingsBody">
        <tr><td colspan="7" class="loading">Loading teams...</td></tr>
      </tbody>
    </table>
  </main>

  <div class="ball-container"><div class="ball"></div><div class="shadow"></div></div>

  <footer>
    <p>Gaming excellence since 2023</p>
    <p class="copyright">&copy; 2023 All rights reserved.</p>
  </footer>

  <div class="cursor-ball" id="cursorBall" aria-hidden="true"></div>

  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>

  <script>
    // Mobile navigation functionality
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

    // Firebase Configuration
    const firebaseConfig = {
      apiKey: "AIzaSyB9p9Hg5H1bKZw-oNCn88MIAF4C95cR4Tw",
      authDomain: "hehba-3f0d2.firebaseapp.com",
      databaseURL: "https://hehba-3f0d2-default-rtdb.asia-southeast1.firebasedatabase.app",
      projectId: "hehba-3f0d2",
      storageBucket: "hehba-3f0d2.firebasestorage.app",
      messagingSenderId: "469771387147",
      appId: "1:469771387147:web:fe648ba1c1ab6c334d220e",
      measurementId: "G-3J0Q20GKK5"
    };

    // Initialize Firebase
    let db;
    try {
      firebase.initializeApp(firebaseConfig);
      db = firebase.database();
    } catch (error) {
      console.error('Firebase initialization error:', error);
    }

    let currentStage = 'all';
    let allTeams = [];

    // Function to show messages
    function showMessage(message, type = 'success') {
      const messageDiv = document.getElementById('message');
      messageDiv.innerHTML = `<div class="${type}-message">${message}</div>`;
    }

    // Sample teams data
    const sampleTeams = [
      { rank: 1, team: "Team Alpha", matches: 12, booyahs: 4, kills: 78, posPoints: 120, score: 198 },
      { rank: 2, team: "Team Bravo", matches: 12, booyahs: 3, kills: 72, posPoints: 90, score: 162 },
      { rank: 3, team: "Team Charlie", matches: 12, booyahs: 2, kills: 68, posPoints: 80, score: 148 },
      { rank: 4, team: "Team Delta", matches: 12, booyahs: 2, kills: 65, posPoints: 75, score: 140 },
      { rank: 5, team: "Team Echo", matches: 12, booyahs: 1, kills: 62, posPoints: 70, score: 132 },
      { rank: 6, team: "Team Foxtrot", matches: 12, booyahs: 1, kills: 60, posPoints: 65, score: 125 },
      { rank: 7, team: "Team Golf", matches: 12, booyahs: 1, kills: 58, posPoints: 60, score: 118 },
      { rank: 8, team: "Team Hotel", matches: 12, booyahs: 1, kills: 55, posPoints: 55, score: 110 },
      { rank: 9, team: "Team India", matches: 12, booyahs: 0, kills: 52, posPoints: 50, score: 102 },
      { rank: 10, team: "Team Juliet", matches: 12, booyahs: 0, kills: 50, posPoints: 45, score: 95 },
      { rank: 11, team: "Team Kilo", matches: 12, booyahs: 0, kills: 48, posPoints: 40, score: 88 },
      { rank: 12, team: "Team Lima", matches: 12, booyahs: 0, kills: 45, posPoints: 35, score: 80 },
      { rank: 13, team: "Team Mike", matches: 12, booyahs: 0, kills: 42, posPoints: 30, score: 72 },
      { rank: 14, team: "Team November", matches: 12, booyahs: 0, kills: 40, posPoints: 25, score: 65 },
      { rank: 15, team: "Team Oscar", matches: 12, booyahs: 0, kills: 38, posPoints: 20, score: 58 },
      { rank: 16, team: "Team Papa", matches: 12, booyahs: 0, kills: 35, posPoints: 15, score: 50 },
      { rank: 17, team: "Team Quebec", matches: 12, booyahs: 0, kills: 32, posPoints: 12, score: 44 },
      { rank: 18, team: "Team Romeo", matches: 12, booyahs: 0, kills: 30, posPoints: 10, score: 40 },
      { rank: 19, team: "Team Sierra", matches: 12, booyahs: 0, kills: 28, posPoints: 8, score: 36 },
      { rank: 20, team: "Team Tango", matches: 12, booyahs: 0, kills: 25, posPoints: 6, score: 31 },
      { rank: 21, team: "Team Uniform", matches: 12, booyahs: 0, kills: 22, posPoints: 4, score: 26 },
      { rank: 22, team: "Team Victor", matches: 12, booyahs: 0, kills: 20, posPoints: 2, score: 22 },
      { rank: 23, team: "Team Whiskey", matches: 12, booyahs: 0, kills: 18, posPoints: 1, score: 19 },
      { rank: 24, team: "Team Xray", matches: 12, booyahs: 0, kills: 15, posPoints: 0, score: 15 },
      { rank: 25, team: "Team Yankee", matches: 12, booyahs: 0, kills: 12, posPoints: 0, score: 12 },
      { rank: 26, team: "Team Zulu", matches: 12, booyahs: 0, kills: 10, posPoints: 0, score: 10 },
      { rank: 27, team: "Team Ace", matches: 12, booyahs: 0, kills: 8, posPoints: 0, score: 8 },
      { rank: 28, team: "Team King", matches: 12, booyahs: 0, kills: 6, posPoints: 0, score: 6 },
      { rank: 29, team: "Team Queen", matches: 12, booyahs: 0, kills: 4, posPoints: 0, score: 4 },
      { rank: 30, team: "Team Jack", matches: 12, booyahs: 0, kills: 3, posPoints: 0, score: 3 },
      { rank: 31, team: "Team Ten", matches: 12, booyahs: 0, kills: 2, posPoints: 0, score: 2 },
      { rank: 32, team: "Team Nine", matches: 12, booyahs: 0, kills: 1, posPoints: 0, score: 1 }
    ];

    // Function to initialize database with 32 teams
    async function initializeDatabase() {
      try {
        showMessage('🔄 Auto-initializing database...', 'auto-init-message');
        
        // Test write permission first
        await db.ref("test_write").set({ test: true });
        await db.ref("test_write").remove();
        
        // Clear existing data
        await db.ref("freefire_standings").remove();
        
        // Add new teams
        const promises = sampleTeams.map(team => 
          db.ref("freefire_standings/" + team.rank).set(team)
        );
        
        await Promise.all(promises);
        showMessage('✅ Database auto-initialized with 32 teams!', 'success');
        loadStandings();
      } catch (error) {
        console.error('Error initializing database:', error);
        if (error.code === 'PERMISSION_DENIED') {
          showMessage('❌ Permission denied. Please update Firebase rules.', 'error');
          document.getElementById('initBtn').style.display = 'inline-block';
        } else {
          showMessage('❌ Error: ' + error.message, 'error');
        }
      }
    }

    // Function to load standings from Firebase
    function loadStandings() {
      db.ref("freefire_standings").orderByChild("rank").once("value")
        .then(snapshot => {
          const tbody = document.getElementById("standingsBody");
          
          if (!snapshot.exists()) {
            // If no data exists, auto-initialize
            showMessage('🔄 No data found. Auto-initializing database...', 'auto-init-message');
            initializeDatabase();
            return;
          }
          
          allTeams = [];
          snapshot.forEach(child => {
            allTeams.push(child.val());
          });
          
          // Sort by rank to ensure proper order
          allTeams.sort((a, b) => a.rank - b.rank);
          
          showMessage('✅ Standings loaded successfully!', 'success');
          displayStandings('all'); // Use displayStandings instead of filterStage for initial load
        })
        .catch(error => {
          console.error("Error loading data:", error);
          if (error.code === 'PERMISSION_DENIED') {
            showMessage('❌ Permission denied. Please update Firebase rules.', 'error');
            document.getElementById('initBtn').style.display = 'inline-block';
          } else {
            showMessage('❌ Error loading standings: ' + error.message, 'error');
          }
        });
    }

    // Function to filter teams by stage (for button clicks)
    function filterStage(stage, buttonElement) {
      currentStage = stage;
      
      // Update active button
      document.querySelectorAll('.button-group button').forEach(btn => {
        btn.classList.remove('active');
      });
      if (buttonElement) {
        buttonElement.classList.add('active');
      }
      
      displayStandings(stage);
    }

    // Function to display standings (without event handling)
    function displayStandings(stage) {
      const tbody = document.getElementById("standingsBody");
      tbody.innerHTML = "";
      
      let filteredTeams = [];
      let stageText = "";
      
      switch(stage) {
        case 'all':
          filteredTeams = allTeams;
          stageText = "Showing all 32 teams";
          break;
        case 'semifinal':
          filteredTeams = allTeams.slice(0, 24);
          stageText = "Showing top 24 teams (Semifinal)";
          break;
        case 'final':
          filteredTeams = allTeams.slice(0, 16);
          stageText = "Showing top 16 teams (Final)";
          break;
      }
      
      document.getElementById("stageInfo").textContent = stageText;
      
      if (filteredTeams.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7">No teams found</td></tr>`;
        return;
      }
      
      filteredTeams.forEach(team => {
        const row = document.createElement('tr');
        if (team.rank <= 3) {
          row.classList.add(`rank-${team.rank}`);
        }
        
        row.innerHTML = `
          <td>${team.rank}</td>
          <td>${team.team}</td>
          <td>${team.matches}</td>
          <td>${team.booyahs}</td>
          <td>${team.kills}</td>
          <td>${team.posPoints}</td>
          <td><strong>${team.score}</strong></td>
        `;
        tbody.appendChild(row);
      });
    }

    // Auto-initialize when page loads
    document.addEventListener('DOMContentLoaded', () => {
      if (db) {
        showMessage('🔄 Loading standings...', 'auto-init-message');
        loadStandings();
      } else {
        showMessage('❌ Firebase initialization failed', 'error');
      }
    });
  </script>
</body>
</html>