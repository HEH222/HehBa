<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Winners & MVPs - HehBa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Firebase SDK -->
  <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-database-compat.js"></script>

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
      transition: margin-left 0.5s ease;
      user-select: none;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
    }

    body.panel-open {
      margin-left: 280px;
    }

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
      overflow:hidden;
      transition: margin-left 0.5s ease;
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

    /* ---------- HAMBURGER BUTTON ---------- */
    .menu-btn{
      position:sticky;
      top:70px;
      left:20px;
      z-index:200;
      background:rgba(0,0,0,0.7);
      border:2px solid var(--accent);
      width:45px;
      height:45px;
      border-radius:10px;
      display:flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      transition:transform 0.3s ease;
    }
    .menu-btn:hover{transform:scale(1.1) rotate(5deg);}
    .menu-btn i{
      font-size:1.3rem;
      color:var(--accent);
      transition:transform 0.4s ease;
    }
    .menu-btn.active i{
      transform:rotate(180deg);
      color:#fff;
    }

    /* ---------- SLIDING PANEL ---------- */
    .side-panel{
      position:fixed;
      top:0;
      left:-320px;
      width:280px;
      height:100vh;
      background:rgba(10,20,30,0.98);
      backdrop-filter:blur(15px);
      border-right:2px solid var(--accent);
      box-shadow:0 0 30px rgba(0,229,255,0.5);
      z-index:150;
      overflow-y:auto;
      transform:translateX(-100%);
      transition:all 0.5s cubic-bezier(0.68,-0.55,0.27,1.55);
      opacity:0;
    }
    .side-panel.active{
      left:0;
      transform:translateX(0);
      opacity:1;
    }

    .side-panel h3{
      color:var(--accent);
      text-align:center;
      margin:1.5rem 0;
      font-size:1.4rem;
      border-bottom:1px solid var(--accent);
      padding-bottom:0.8rem;
      text-shadow: 0 0 10px rgba(0,229,255,0.7);
    }
    .side-panel .panel-content{
      padding:1.5rem;
      display:flex;
      flex-direction:column;
      gap:1.5rem;
    }
    .side-panel .panel-content p, .side-panel ul li{
      color:#ddd;
      font-size:0.95rem;
    }
    .side-panel ul{list-style:none;padding-left:0.5rem;}
    .side-panel ul li{
      margin-bottom: 0.8rem;
      padding: 0.5rem;
      border-radius: 5px;
      transition: background-color 0.3s;
    }
    .side-panel ul li:hover{
      background-color: rgba(0,229,255,0.1);
    }
    .side-panel ul li::before{
      content:'🎮 ';
      color:var(--accent);
    }
    .side-panel a {
      color: var(--accent);
      text-decoration: none;
      transition: color 0.3s;
    }
    .side-panel a:hover {
      color: #fff;
      text-shadow: 0 0 8px rgba(0,229,255,0.7);
    }

    /* Overlay when panel is open */
    .panel-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(3px);
      z-index: 140;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s, visibility 0.3s;
    }
    
    .panel-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    /* ---------- MAIN CONTENT ---------- */
    .main-content{
      flex:1;
      max-width:1200px;
      margin:2rem auto;
      padding:0 2rem;
      width:100%;
      transition: margin-left 0.5s ease;
      position: relative;
      z-index: 10;
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

    /* Loading State */
    .loading {
      text-align: center;
      padding: 2rem;
      color: var(--accent);
      font-size: 1.2rem;
    }

    .loading i {
      animation: spin 1s linear infinite;
      margin-right: 10px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Winners Section */
    .winners-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .game-winner-card {
      background: rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 2rem;
      border: 1px solid rgba(0,229,255,0.2);
      box-shadow: 0 8px 32px rgba(0,229,255,0.1);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .game-winner-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0,229,255,0.2);
    }

    .game-winner-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: var(--accent);
    }

    .game-logo {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .game-logo-img {
      width: 80px;
      height: 80px;
      object-fit: contain;
      border-radius: 10px;
      margin: 0 auto 1rem;
      display: block;
      background: rgba(255,255,255,0.1);
      padding: 10px;
    }

    .game-title {
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
      color: var(--accent);
      text-shadow: 0 0 10px rgba(0,229,255,0.5);
    }

    .winner-info {
      margin-bottom: 1.5rem;
      padding: 1rem;
      background: rgba(0,229,255,0.1);
      border-radius: 10px;
    }

    .winner-name {
      font-size: 1.3rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
      color: #fff;
    }

    .winner-team {
      font-size: 1rem;
      color: #ccc;
    }

    .mvp-info {
      padding: 1rem;
      background: rgba(255,215,0,0.1);
      border-radius: 10px;
      border: 1px solid rgba(255,215,0,0.3);
    }

    .mvp-title {
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
      color: #ffd700;
    }

    .mvp-name {
      font-size: 1.2rem;
      font-weight: bold;
      color: #ffd700;
    }

    /* Celebration Section */
    .celebration-section {
      text-align: center;
      margin: 3rem 0;
      padding: 2rem;
      background: rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      border: 1px solid rgba(0,229,255,0.2);
    }

    .celebration-title {
      font-size: 2rem;
      margin-bottom: 1.5rem;
      color: var(--accent);
      text-shadow: 0 0 10px rgba(0,229,255,0.5);
    }

    .celebration-message {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      color: #fff;
    }

    /* Fireworks Canvas */
    #fireworks {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 5;
      pointer-events: none;
    }

    footer{
      background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      color:#fff;
      padding:1.5rem;
      text-align:center;
      margin-top:3rem;
      border-top:1px solid #111;
      transition: margin-left 0.5s ease;
      position: relative;
      z-index: 10;
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
      body.panel-open {
        margin-left: 0;
      }
      
      .side-panel {
        width: 280px;
      }
      
      .nav-links li {
        margin-left: 1.5rem;
      }
      
      .winners-section {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <canvas id="bgParticles"></canvas>
  <canvas id="fireworks"></canvas>

  <!-- Overlay for when panel is open -->
  <div class="panel-overlay" id="panelOverlay"></div>

  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">HehBa</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="game.php">Games</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="gamesheld.php">Games Held</a></li>
       
      </ul>
    </div>
    <div class="car">🚗💨</div>
  </nav>

  <!-- HAMBURGER BUTTON -->
  <div class="menu-btn" id="menuBtn"><i class="fa-solid fa-bars"></i></div>

  <!-- SIDE PANEL -->
  <aside class="side-panel" id="sidePanel">
    <h3>HehBa</h3>
    <div class="panel-content">
      <p><strong>🔥 Top Players:</strong></p>
      <ul>
        <li>ShadowStrike - 890 pts</li>
        <li>NovaSniper - 850 pts</li>
        <li>RageX - 810 pts</li>
      </ul>
      <p><strong>⚔ Upcoming Tournaments:</strong></p>
      <ul>
        <li>Valorant Showdown - Oct 12</li>
        <li>PUBG Arena Clash - Oct 15</li>
        <li>CS:GO Domination - Oct 20</li>
      </ul>
      <p><strong>🔗 Quick Links:</strong></p>
      <ul>
        <li><a href="game.php">Join Tournament</a></li>
        <li><a href="gamesheld.php">Leaderboard</a></li>
        <li><a href="shop.php">Merch Store</a></li>
      </ul>
    </div>
  </aside>

  <main class="main-content">
    <h1 class="page-title">Winners & MVPs</h1>
    
    <!-- Celebration Section -->
    <section class="celebration-section">
      <h2 class="celebration-title">Congratulations to Our Champions!</h2>
      <p class="celebration-message">Celebrating the incredible skill and dedication of our tournament winners and MVPs.</p>
    </section>
    
    <!-- Loading State -->
    <div class="loading" id="loadingState">
      <i class="fas fa-spinner"></i> Loading winners data...
    </div>
    
    <!-- Winners Section -->
    <section class="winners-section" id="winnersSection" style="display: none;">
      <!-- Winners cards will be populated by JavaScript -->
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
    firebase.initializeApp(firebaseConfig);
    const database = firebase.database();

    // Security measures (silent - no messages shown)
    (function() {
      // Disable right-click context menu
      document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
      });
      
      // Disable text selection
      document.addEventListener('selectstart', function(e) {
        e.preventDefault();
        return false;
      });
      
      // Disable drag and drop
      document.addEventListener('dragstart', function(e) {
        e.preventDefault();
        return false;
      });
      
      // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
      document.addEventListener('keydown', function(e) {
        if (
          e.key === 'F12' ||
          (e.ctrlKey && e.shiftKey && e.key === 'I') ||
          (e.ctrlKey && e.shiftKey && e.key === 'J') ||
          (e.ctrlKey && e.key === 'U') ||
          (e.ctrlKey && e.key === 'S') ||
          (e.ctrlKey && e.key === 'C') ||
          (e.metaKey && e.altKey && e.key === 'I')
        ) {
          e.preventDefault();
          return false;
        }
      });
    })();

    const cursorBall = document.getElementById('cursorBall');
    const menuBtn = document.getElementById('menuBtn');
    const sidePanel = document.getElementById('sidePanel');
    const panelOverlay = document.getElementById('panelOverlay');
    const body = document.body;
    const winnersSection = document.getElementById('winnersSection');
    const loadingState = document.getElementById('loadingState');

    document.addEventListener('mousemove', e => {
      cursorBall.style.transform = `translate(${e.clientX}px,${e.clientY}px) scale(1)`;
    });

    menuBtn.addEventListener('click', () => {
      sidePanel.classList.toggle('active');
      menuBtn.classList.toggle('active');
      panelOverlay.classList.toggle('active');
      body.classList.toggle('panel-open');
    });

    // Close panel when clicking on overlay
    panelOverlay.addEventListener('click', () => {
      sidePanel.classList.remove('active');
      menuBtn.classList.remove('active');
      panelOverlay.classList.remove('active');
      body.classList.remove('panel-open');
    });

// Fetch winners data from Firebase
function fetchWinnersData() {
  const winnersRef = database.ref('winners');
  
  winnersRef.on('value', (snapshot) => {
    const data = snapshot.val();
    console.log('Firebase winners data:', data); // Debug line
    
    if (data) {
      displayWinners(data);
      loadingState.style.display = 'none';
      winnersSection.style.display = 'grid';
    } else {
      // If no data in Firebase, show default data
      displayDefaultWinners();
      loadingState.style.display = 'none';
      winnersSection.style.display = 'grid';
    }
  }, (error) => {
    console.error('Error fetching data:', error);
    // If error, show default data
    displayDefaultWinners();
    loadingState.style.display = 'none';
    winnersSection.style.display = 'grid';
  });
}
    // Display winners from Firebase data
    function displayWinners(data) {
      winnersSection.innerHTML = '';
      
      // Default game data structure in case some fields are missing
      const defaultGames = {
        'pubg': { name: 'PUBG Mobile', logo: '🎯', winner: 'Team Alpha', team: 'ShadowStrike, Phantom, Ghost, Raven', mvp: 'ShadowStrike' },
        'mlbb': { name: 'Mobile Legends', logo: '⚔️', winner: 'Team Titans', team: 'Zephyr, Blaze, Frost, Thunder, Storm', mvp: 'Zephyr' },
        'freefire': { name: 'FreeFire', logo: '🔥', winner: 'Team Inferno', team: 'Inferno, Blaze, Ember, Spark', mvp: 'Inferno' },
        'valorant': { name: 'Valorant', logo: '🎮', winner: 'Team Vanguard', team: 'Viper, Jett, Phoenix, Sage, Cypher', mvp: 'Jett' }
      };
      
      // Process each game
      Object.keys(defaultGames).forEach(gameKey => {
        const gameData = data[gameKey] || defaultGames[gameKey];
        
        const card = document.createElement('div');
        card.className = 'game-winner-card';
        
        // Use logo URL if provided, otherwise use emoji
        const logoContent = gameData.logoUrl ? 
          `<img src="${gameData.logoUrl}" alt="${gameData.name}" class="game-logo-img">` :
          `<div class="game-logo">${gameData.logo || defaultGames[gameKey].logo}</div>`;
        
        card.innerHTML = `
          ${logoContent}
          <h3 class="game-title">${gameData.name || defaultGames[gameKey].name}</h3>
          <div class="winner-info">
            <div class="winner-name">${gameData.winner || defaultGames[gameKey].winner}</div>
            <div class="winner-team">${gameData.team || defaultGames[gameKey].team}</div>
          </div>
          <div class="mvp-info">
            <div class="mvp-title">MVP of the Match</div>
            <div class="mvp-name">${gameData.mvp || defaultGames[gameKey].mvp}</div>
          </div>
        `;
        
        winnersSection.appendChild(card);
      });
    }

    // Display default winners (fallback)
    function displayDefaultWinners() {
      const defaultData = {
        'pubg': { name: 'PUBG Mobile', logo: '🎯', winner: 'Team Alpha', team: 'ShadowStrike, Phantom, Ghost, Raven', mvp: 'ShadowStrike' },
        'mlbb': { name: 'Mobile Legends', logo: '⚔️', winner: 'Team Titans', team: 'Zephyr, Blaze, Frost, Thunder, Storm', mvp: 'Zephyr' },
        'freefire': { name: 'FreeFire', logo: '🔥', winner: 'Team Inferno', team: 'Inferno, Blaze, Ember, Spark', mvp: 'Inferno' },
        'valorant': { name: 'Valorant', logo: '🎮', winner: 'Team Vanguard', team: 'Viper, Jett, Phoenix, Sage, Cypher', mvp: 'Jett' }
      };
      
      displayWinners(defaultData);
    }

    // Initialize the page
    document.addEventListener('DOMContentLoaded', () => {
      fetchWinnersData();
    });

    /* -------- FIREWORKS ANIMATION FROM ALL DIRECTIONS -------- */
    const fireworksCanvas = document.getElementById('fireworks');
    const fctx = fireworksCanvas.getContext('2d');
    fireworksCanvas.width = window.innerWidth;
    fireworksCanvas.height = window.innerHeight;

    window.addEventListener('resize', () => {
      fireworksCanvas.width = window.innerWidth;
      fireworksCanvas.height = window.innerHeight;
    });

    class Particle {
      constructor(x, y, color, velocity) {
        this.x = x;
        this.y = y;
        this.color = color;
        this.velocity = velocity;
        this.alpha = 1;
        this.friction = 0.99;
        this.gravity = 0.01;
        this.size = Math.random() * 2 + 1;
      }

      draw() {
        fctx.save();
        fctx.globalAlpha = this.alpha;
        fctx.beginPath();
        fctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        fctx.fillStyle = this.color;
        fctx.fill();
        fctx.restore();
      }

      update() {
        this.draw();
        this.velocity.x *= this.friction;
        this.velocity.y *= this.friction;
        this.velocity.y += this.gravity;
        this.x += this.velocity.x;
        this.y += this.velocity.y;
        this.alpha -= 0.005;
      }
    }

    class Firework {
      constructor(x, y, direction) {
        this.x = x;
        this.y = y;
        this.color = `hsl(${Math.random() * 360}, 100%, 60%)`;
        this.radius = 2;
        this.direction = direction; // 'top', 'bottom', 'left', 'right'
        this.velocity = this.getInitialVelocity();
        this.gravity = 0.2;
        this.opacity = 1;
        this.particles = [];
        this.exploded = false;
        this.trail = [];
        this.trailLength = 5;
      }

      getInitialVelocity() {
        switch(this.direction) {
          case 'top':
            return { x: Math.random() * 6 - 3, y: Math.random() * 4 + 4 };
          case 'bottom':
            return { x: Math.random() * 6 - 3, y: -(Math.random() * 4 + 4) };
          case 'left':
            return { x: Math.random() * 4 + 4, y: Math.random() * 6 - 3 };
          case 'right':
            return { x: -(Math.random() * 4 + 4), y: Math.random() * 6 - 3 };
          default:
            return { x: Math.random() * 6 - 3, y: Math.random() * 8 + 8 };
        }
      }

      draw() {
        fctx.save();
        fctx.globalAlpha = this.opacity;
        fctx.beginPath();
        fctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        fctx.fillStyle = this.color;
        fctx.fill();
        
        // Draw trail
        if (this.trail.length > 1) {
          fctx.beginPath();
          fctx.moveTo(this.trail[0].x, this.trail[0].y);
          for (let i = 1; i < this.trail.length; i++) {
            fctx.lineTo(this.trail[i].x, this.trail[i].y);
          }
          fctx.strokeStyle = this.color;
          fctx.lineWidth = 1;
          fctx.globalAlpha = this.opacity * 0.5;
          fctx.stroke();
        }
        
        fctx.restore();
      }

      update() {
        this.draw();
        
        // Add current position to trail
        this.trail.push({ x: this.x, y: this.y });
        if (this.trail.length > this.trailLength) {
          this.trail.shift();
        }
        
        if (!this.exploded) {
          // Apply velocity based on direction
          switch(this.direction) {
            case 'top':
              this.velocity.y -= this.gravity;
              this.y += this.velocity.y;
              break;
            case 'bottom':
              this.velocity.y += this.gravity;
              this.y += this.velocity.y;
              break;
            case 'left':
              this.velocity.x -= this.gravity;
              this.x += this.velocity.x;
              break;
            case 'right':
              this.velocity.x += this.gravity;
              this.x += this.velocity.x;
              break;
          }
          
          this.opacity -= 0.005;
          
          // Check if firework should explode
          let shouldExplode = false;
          switch(this.direction) {
            case 'top':
              shouldExplode = this.velocity.y <= 0;
              break;
            case 'bottom':
              shouldExplode = this.velocity.y >= 0;
              break;
            case 'left':
              shouldExplode = this.velocity.x <= 0;
              break;
            case 'right':
              shouldExplode = this.velocity.x >= 0;
              break;
          }
          
          if (shouldExplode) {
            this.exploded = true;
            this.explode();
          }
        }
        
        this.particles.forEach((particle, index) => {
          if (particle.alpha <= 0) {
            this.particles.splice(index, 1);
          } else {
            particle.update();
          }
        });
      }
      
      explode() {
        for (let i = 0; i < 100; i++) {
          const velocity = {
            x: Math.random() * 6 - 3,
            y: Math.random() * 6 - 3
          };
          this.particles.push(new Particle(this.x, this.y, this.color, velocity));
        }
      }
    }

    const fireworks = [];

    function animateFireworks() {
      requestAnimationFrame(animateFireworks);
      fctx.fillStyle = 'rgba(0, 0, 0, 0.1)';
      fctx.fillRect(0, 0, fireworksCanvas.width, fireworksCanvas.height);
      
      // Create new fireworks from all directions randomly
      if (Math.random() < 0.08) {
        const direction = ['top', 'bottom', 'left', 'right'][Math.floor(Math.random() * 4)];
        let x, y;
        
        switch(direction) {
          case 'top':
            x = Math.random() * fireworksCanvas.width;
            y = 0;
            break;
          case 'bottom':
            x = Math.random() * fireworksCanvas.width;
            y = fireworksCanvas.height;
            break;
          case 'left':
            x = 0;
            y = Math.random() * fireworksCanvas.height;
            break;
          case 'right':
            x = fireworksCanvas.width;
            y = Math.random() * fireworksCanvas.height;
            break;
        }
        
        fireworks.push(new Firework(x, y, direction));
      }
      
      fireworks.forEach((firework, index) => {
        if (firework.opacity <= 0 && firework.particles.length === 0) {
          fireworks.splice(index, 1);
        } else {
          firework.update();
        }
      });
    }

    // Start fireworks animation
    animateFireworks();

    /* -------- YOUTUBE-STYLE GEOMETRIC PARTICLE BACKGROUND -------- */
    const canvas = document.getElementById('bgParticles');
    const ctx = canvas.getContext('2d');
    let particlesArray = [];
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    window.addEventListener('resize', () => {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
      fireworksCanvas.width = window.innerWidth;
      fireworksCanvas.height = window.innerHeight;
      initParticles();
    });

    class BgParticle {
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
        particlesArray.push(new BgParticle());
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