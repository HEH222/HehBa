<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GameHub - Home</title>
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
      transition: margin-left 0.5s ease;
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
    .nav-container{
      display:flex;
      justify-content:space-between;
      align-items:center;
      max-width:1200px;
      margin:0 auto;
    }
    .logo{font-size:1.8rem;font-weight:800;color:var(--accent);letter-spacing:0px;text-shadow:0 0 8px rgba(0,229,255,0.7);}
    
    .nav-links{
      display:flex;
      list-style:none;
    }
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
    
    .car {position:absolute;top:0;left:-100px;font-size:1.5rem;color:#ffcc00;animation: drive 8s linear infinite;}
    @keyframes drive {0% { left:-100px; } 100% { left:110%; }}
/* Mobile Nav Logo */
.mobile-nav-logo {
  text-align: center;
  padding: 1.5rem 1rem;
  border-bottom: 1px solid rgba(0,229,255,0.3);
  margin-bottom: 1rem;
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

@keyframes neonGlow {
  from {
    text-shadow: 
      0 0 8px rgba(0,229,255,0.7),
      0 0 15px rgba(255,255,255,0.5),
      0 0 20px rgba(255,255,255,0.3);
  }
  to {
    text-shadow: 
      0 0 12px rgba(0,229,255,0.9),
      0 0 20px rgba(255,255,255,0.7),
      0 0 30px rgba(255,255,255,0.5),
      0 0 40px rgba(0,229,255,0.4);
  }
}

/* Adjust padding for mobile nav to accommodate logo */
.mobile-nav {
  padding: 0 1.5rem 2rem; /* Changed from 5rem 1.5rem 2rem */
}

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

    /* Transparent About Section */
    .about-section{
      background:rgba(0,0,0,0.3);
      backdrop-filter: blur(10px);
      border-radius:15px;
      padding:2.5rem;
      margin-bottom:3rem;
      border: 1px solid rgba(0,229,255,0.2);
      box-shadow:0 8px 32px rgba(0,229,255,0.1);
      opacity:0;
      transform:translateY(30px);
      animation: fadeInUp 1s forwards 0.3s;
    }
    .about-section h2{
      font-size:2.2rem;
      margin-bottom:1.5rem;
      color:var(--accent);
      text-align:center;
      text-shadow: 0 0 15px rgba(0,229,255,0.5);
    }
    .about-content{
      display:flex;
      align-items:center;
      gap:2.5rem;
      flex-wrap:wrap;
    }
    .about-text{
      flex:1;
    }
    .about-text p{
      margin-bottom:1.2rem;
      color:#e0e0e0;
      font-size: 1.1rem;
      line-height: 1.7;
    }
    .about-image{
      flex: 0 0 200px; /* Fixed smaller size */
      border-radius:12px;
      overflow:hidden;
      animation: float 3s ease-in-out infinite;
      border: 2px solid rgba(0,229,255,0.3);
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px;
      background: rgba(0,0,0,0.2);
    }
    .about-image img{
      width: 100%;
      max-width: 150px; /* Smaller logo size */
      height: auto;
      display:block;
      border-radius:10px;
      transition: transform 0.5s ease;
    }
    .about-image:hover img {
      transform: scale(1.05);
    }
    @keyframes fadeInUp{to{opacity:1;transform:translateY(0);}}
    @keyframes float{0%,100%{transform:translateY(0);}50%{transform:translateY(-12px);}}

    /* Game Cards that run away from cursor */
    .games-container {
      position: relative;
      height: 550px;
      margin-top: 2rem;
      width: 100%;
      border: 1px dashed rgba(0,229,255,0.3);
      border-radius: 15px;
      overflow: hidden;
      background: rgba(0,0,0,0.2);
      backdrop-filter: blur(5px);
    }
    
    .game-card{
      background:rgba(0,0,0,0.85);
      border-radius:12px;
      overflow:hidden;
      box-shadow:0 8px 25px rgba(0,229,255,0.4);
      transition: all 0.3s ease;
      opacity:0;
      animation: fadeInUp 1s forwards;
      position: absolute;
      width: 200px;
      height: 260px;
      cursor: pointer;
      border: 2px solid var(--accent);
      z-index: 5;
    }
    
    .game-card:nth-child(1){animation-delay:0.3s; left: 15%; top: 20%;}
    .game-card:nth-child(2){animation-delay:0.6s; left: 45%; top: 30%;}
    .game-card:nth-child(3){animation-delay:0.9s; left: 75%; top: 20%;}
    
    .game-image{
      height:120px;
      overflow:hidden;
      position:relative;
    }
    
    .game-image img{
      width:100%;
      height:100%;
      object-fit:cover;
      transition:transform 0.5s;
    }
    
    .game-content{
      padding:1rem;
      height: 140px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    
    .game-title{
      font-size:1.2rem;
      margin-bottom:0.5rem;
      color:var(--accent);
      text-align: center;
      text-shadow: 0 0 8px rgba(0,229,255,0.5);
    }
    
    .game-desc{
      color:#ccc;
      margin-bottom:0.8rem;
      font-size:0.85rem;
      line-height: 1.4;
      text-align: center;
    }
    
    .game-meta{
      display:flex;
      justify-content:space-between;
      color:var(--accent);
      font-size:0.8rem;
    }

    .game-card.running {
      box-shadow: 0 12px 35px rgba(0,229,255,0.8);
      transform: scale(1.08);
      z-index: 10;
    }

    footer{
      background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      color:#fff;
      padding:1.5rem;
      text-align:center;
      margin-top:3rem;
      border-top:1px solid #111;
      transition: margin-left 0.5s ease;
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
    @media (max-width: 1024px) {
      .game-card {
        width: 180px;
        height: 240px;
      }
      
      .game-card:nth-child(1) { left: 10%; }
      .game-card:nth-child(2) { left: 40%; }
      .game-card:nth-child(3) { left: 70%; }
      
      .about-image {
        flex: 0 0 180px;
      }
      
      .about-image img {
        max-width: 130px;
      }
    }
    
    @media (max-width: 768px) {
      body.panel-open {
        margin-left: 0;
      }
      
      .side-panel {
        width: 280px;
      }
      
      .nav-links {
        display: none;
      }
      
      .mobile-nav-toggle {
        display: block;
      }
      
      .mobile-nav {
        display: block;
      }
      
      .navbar {
        padding: 1rem 1.5rem;
      }
      
      .about-content {
        flex-direction: column;
        text-align: center;
      }
      
      .about-section {
        padding: 1.5rem;
      }
      
      .about-image {
        flex: 0 0 150px;
        order: -1; /* Move image above text on mobile */
        margin: 0 auto;
      }
      
      .about-image img {
        max-width: 120px;
      }
      
      .game-card {
        width: 160px;
        height: 220px;
      }
      
      .game-image {
        height: 100px;
      }
      
      .game-content {
        height: 120px;
        padding: 0.8rem;
      }
      
      .game-title {
        font-size: 1.1rem;
      }
      
      .game-desc {
        font-size: 0.8rem;
      }
      
      .games-container {
        height: 450px;
      }
      
      .game-card:nth-child(1) { left: 5%; top: 15%; }
      .game-card:nth-child(2) { left: 35%; top: 25%; }
      .game-card:nth-child(3) { left: 65%; top: 15%; }
      
      .page-title {
        font-size: 2rem;
      }
      
      .about-section h2 {
        font-size: 1.8rem;
      }
      
      .ball-container {
        bottom: 20px;
        left: 20px;
      }
      
      .ball, .shadow {
        transform: scale(0.8);
      }
    }
    
    @media (max-width: 576px) {
      .main-content {
        padding: 0 1rem;
      }
      
      .game-card {
        width: 140px;
        height: 200px;
      }
      
      .game-image {
        height: 90px;
      }
      
      .game-content {
        height: 110px;
        padding: 0.6rem;
      }
      
      .game-title {
        font-size: 1rem;
      }
      
      .game-desc {
        font-size: 0.75rem;
      }
      
      .games-container {
        height: 400px;
      }
      
      .game-card:nth-child(1) { left: 3%; top: 10%; }
      .game-card:nth-child(2) { left: 33%; top: 20%; }
      .game-card:nth-child(3) { left: 63%; top: 10%; }
      
      .page-title {
        font-size: 1.8rem;
      }
      
      .about-section h2 {
        font-size: 1.6rem;
      }
      
      .logo {
        font-size: 1.5rem;
      }
      
      .about-image {
        flex: 0 0 120px;
      }
      
      .about-image img {
        max-width: 100px;
      }
    }
  </style>
</head>
<body>
  <canvas id="bgParticles"></canvas>

  <!-- Overlay for when panel is open -->
  <div class="panel-overlay" id="panelOverlay"></div>

  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">HehBa</div>
      <ul class="nav-links">
        <li><a href="index.php" class="active">Home</a></li>
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

  <!-- HAMBURGER BUTTON -->
  <div class="menu-btn" id="menuBtn"><i class="fa-solid fa-bars"></i></div>

  <!-- SIDE PANEL -->
  <aside class="side-panel" id="sidePanel">
    <h3>HehBa</h3>
    <div class="panel-content">
      <p><strong>🔥 Top Players:</strong></p>
      <ul>
        <li>TBA - TBA pts</li>
        <li>TBA - TBA pts</li>
        <li>TBA - TBA pts</li>
      </ul>
      <p><strong>⚔ Upcoming Tournaments:</strong></p>
      <ul>
        <li>Valorant Tournament -TBA </li>
        <li>PUBG Tournament -TBA </li>
        <li>Freefire Tournament -TBA</li>
      </ul>
      <p><strong>🔗 Quick Links:</strong></p>
      <ul>
        <li><a href="game.php">Join Tournament</a></li>
        <li><a href="gamesheld.php">Leaderboard</a></li>
        <li><a href="shop.php">Merch Store..Comming Soon</a></li>
      </ul>
    </div>
  </aside>

  <main class="main-content">
    <h1 class="page-title">HehBa</h1>
    <section class="about-section">
      <h2>About Us</h2>
      <div class="about-content">
        <div class="about-text">
          <p>Welcome to <strong>HehBa</strong> — HEHBA is an exciting esports platform dedicated to hosting competitive gaming tournaments with top-notch facilities. It offers players and teams a professional environment to showcase their skills across popular games, with smooth registration, real-time updates, and fair play management. HEHBA brings gamers together from all levels, providing opportunities to compete, connect, and win amazing rewards — making it the ultimate destination for esports enthusiasts.</p>
          <p>Stay tuned for upcoming matches, player rankings, and exciting news. Whether you're a casual or pro gamer, this is your home.</p>
        </div>
        <div class="about-image">
          <img src="images/logo.jpg" alt="HehBa Logo">
        </div>
      </div>
    </section>

    <div class="games-container">
      <div class="game-card" id="card1">
        <div class="game-image">
  <img src="images/valorant.jpg" alt="Game 1">
</div>
        <div class="game-content">
          <h3 class="game-title">Valorant Cup</h3>
          <p class="game-desc"> Tactical shooter Game(5v5).</p>
          <div class="game-meta"><span class="game-date">TBA</span><span class="game-rating">⭐ 4.5</span></div>
        </div>
      </div>
      <div class="game-card" id="card2">
       <div class="game-image">
  <img src="images/pubg.jpg" alt="Game 2">
</div>
        <div class="game-content">
          <h3 class="game-title">PubG Mobile</h3>
          <p class="game-desc"> Face off of teams in intense battles.</p>
          <div class="game-meta"><span class="game-date">TBA</span><span class="game-rating">⭐ 4.7</span></div>
        </div>
      </div>
      <div class="game-card" id="card3">
       <div class="game-image">
  <img src="images/freefire.jpg" alt="Game 3">
</div>
        <div class="game-content">
          <h3 class="game-title">Freefire</h3>
          <p class="game-desc">Survive and conquer in the ultimate battle royale.</p>
          <div class="game-meta"><span class="game-date">TBA</span><span class="game-rating">⭐ 4.6</span></div>
        </div>
      </div>
    </div>
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
    const menuBtn = document.getElementById('menuBtn');
    const sidePanel = document.getElementById('sidePanel');
    const panelOverlay = document.getElementById('panelOverlay');
    const body = document.body;
    const mobileNavToggle = document.getElementById('mobileNavToggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileNavOverlay = document.getElementById('mobileNavOverlay');

    // Cursor ball effect
    document.addEventListener('mousemove', e => {
      cursorBall.style.transform = `translate(${e.clientX}px,${e.clientY}px) scale(1)`;
    });

    // Side panel toggle
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

    // Game cards that run away from cursor
    const gameCards = document.querySelectorAll('.game-card');
    const gamesContainer = document.querySelector('.games-container');
    
    // Store card states
    const cardStates = {};
    let animationFrame;
    
    // Initialize card states
    gameCards.forEach((card, index) => {
      const rect = card.getBoundingClientRect();
      cardStates[card.id] = {
        x: parseFloat(card.style.left) || (index * 30 + 15),
        y: parseFloat(card.style.top) || 20,
        vx: 0,
        vy: 0,
        isRunning: false,
        runAwayTimer: 0,
        originalX: parseFloat(card.style.left) || (index * 30 + 15),
        originalY: parseFloat(card.style.top) || 20
      };
    });
    
    // Mouse position
    let mouseX = 0;
    let mouseY = 0;
    
    // Update mouse position
    document.addEventListener('mousemove', (e) => {
      const containerRect = gamesContainer.getBoundingClientRect();
      mouseX = ((e.clientX - containerRect.left) / containerRect.width) * 100;
      mouseY = ((e.clientY - containerRect.top) / containerRect.height) * 100;
    });
    
    // Animation loop for card movement
    function animateCards() {
      gameCards.forEach(card => {
        const state = cardStates[card.id];
        const cardWidth = 20; // 200px is 20% of 1000px container
        const cardHeight = 26; // 260px is 26% of 1000px container
        
        // Calculate distance to mouse
        const dx = mouseX - state.x;
        const dy = mouseY - state.y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        
        // If mouse is close, run away!
        if (distance < 18) {
          state.isRunning = true;
          state.runAwayTimer = 30; // frames to keep running
          
          // Calculate run direction (away from mouse)
          const angle = Math.atan2(dy, dx);
          const runSpeed = 2.2;
          
          // Set velocity away from mouse
          state.vx = -Math.cos(angle) * runSpeed;
          state.vy = -Math.sin(angle) * runSpeed;
        }
        
        // If running, continue movement
        if (state.isRunning) {
          state.runAwayTimer--;
          
          // Apply velocity
          state.x += state.vx;
          state.y += state.vy;
          
          // Add some randomness to make it harder to catch
          state.vx += (Math.random() - 0.5) * 0.6;
          state.vy += (Math.random() - 0.5) * 0.6;
          
          // Slow down over time
          state.vx *= 0.93;
          state.vy *= 0.93;
          
          // Stop running after timer expires
          if (state.runAwayTimer <= 0) {
            state.isRunning = false;
          }
          
          card.classList.add('running');
        } else {
          // Return to original position slowly
          const returnSpeed = 0.08;
          state.x += (state.originalX - state.x) * returnSpeed;
          state.y += (state.originalY - state.y) * returnSpeed;
          
          // Stop movement when close enough
          if (Math.abs(state.x - state.originalX) < 0.5 && Math.abs(state.y - state.originalY) < 0.5) {
            state.x = state.originalX;
            state.y = state.originalY;
            state.vx = 0;
            state.vy = 0;
          }
          
          card.classList.remove('running');
        }
        
        // Boundary checking - keep cards in container
        state.x = Math.max(cardWidth/2, Math.min(100 - cardWidth/2, state.x));
        state.y = Math.max(cardHeight/2, Math.min(100 - cardHeight/2, state.y));
        
        // Apply position
        card.style.left = `${state.x}%`;
        card.style.top = `${state.y}%`;
        
        // Add rotation effect when running
        if (state.isRunning) {
          const rotation = (state.vx * 5);
          card.style.transform = `rotate(${rotation}deg) scale(1.08)`;
        } else {
          card.style.transform = 'rotate(0deg) scale(1)';
        }
      });
      
      animationFrame = requestAnimationFrame(animateCards);
    }
    
    // Start animation
    animateCards();

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