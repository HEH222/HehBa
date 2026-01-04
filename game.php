<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GameHub - Games</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root{
      --accent: #00e5ff;
      --ball-size: 8px;
      --ball-shadow: 0 6px 18px rgba(0,229,255,0.25);
    }

    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}

    body{
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      color:#fff;
      line-height:1.6;
      min-height:100vh;
      display:flex;
      flex-direction:column;
      overflow-x: hidden;
    }

    /* Navbar */
    .navbar{
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      border-bottom:1px solid #111;
      padding:1.2rem 2rem;
      position:sticky;
      top:0;
      z-index:100;
    }
    .nav-container{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;}
    .logo{font-size:1.8rem;font-weight:800;color:#fff;letter-spacing:0px;}
    .nav-links{display:flex;list-style:none;}
    .nav-links li{margin-left:2.5rem;position:relative;}
    .nav-links a{text-decoration:none;color:#fff;font-weight:500;transition:color 0.3s;font-size:1.1rem;}
    .nav-links a:hover{color:var(--accent);}
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

    /* Play Games Button */
    .play-games-btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: linear-gradient(135deg, var(--accent), #0099cc);
      color: #000;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 700;
      font-size: 1.1rem;
      box-shadow: 0 4px 15px rgba(0,229,255,0.4);
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
    }
    
    .play-games-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,229,255,0.6);
    }

    /* Main content */
    .main-content{flex:1;max-width:1200px;margin:2rem auto;padding:0 2rem;width:100%;}
    
    /* Title and button container */
    .title-section {
      display: flex;
      align-items: center;
      margin-bottom: 2rem;
      position: relative;
    }
    
    .page-title{
      font-size:2.5rem;
      color:#fff;
      font-weight:700;
      text-transform:uppercase;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    /* Games grid */
    .games-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
      gap: 2rem;
      margin-top: 2rem;
    }

    .game-card {
      background: rgba(0,0,0,0.8);
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,229,255,0.25);
      transition: 0.3s;
      display: flex;
      flex-direction: column;

      /* Animation setup */
      opacity: 0;
      animation: bounceIn 0.8s forwards;
    }

    .game-image {
      height: 200px;
      overflow: hidden;
    }

    .game-card:hover{transform:translateY(-5px);box-shadow:0 8px 25px rgba(0,229,255,0.35);}
    .game-image img{width:100%;height:100%;object-fit:cover;transition:transform 0.5s;}
    .game-card:hover .game-image img{transform:scale(1.05);}
    .game-content{padding:1.5rem;flex:1;display:flex;flex-direction:column;}
    .game-title{font-size:1.4rem;margin-bottom:1rem;color:#fff;font-weight:600;}
    .game-desc{color:#aaa;margin-bottom:1.5rem;flex:1;font-size:0.95rem;line-height:1.5;}
    .view-more{
      display:inline-block;
      background-color:var(--accent);
      color:black;
      padding:0.6rem 1.5rem;
      border-radius:4px;
      text-decoration:none;
      font-weight:600;
      text-align:center;
      transition:background-color 0.3s;
    }
    .view-more:hover{background-color:#00bcd4;color:#fff;}

    /* Footer */
    footer{background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);color:#fff;padding:1.5rem 2rem;text-align:center;margin-top:3rem;border-top:1px solid #111;}
    .footer-content{max-width:1200px;margin:0 auto;}
    .footer-text{font-size:0.9rem;color:#888;}

    /* Bouncing Ball (right side above footer) */
    .ball-container {
      position: fixed;
      bottom: 80px;
      right: 40px;
      z-index: 500;
    }
    @keyframes rotateBall {0%{transform:rotateY(0deg) rotateX(0deg);}100%{transform:rotateY(720deg) rotateX(720deg);}}
    @keyframes bounceBall {
      0% { transform: translateY(-70px) scale(1,1); }
      45% { transform: translateY(70px) scale(1,1); }
      50% { transform: translateY(75px) scale(1,0.9); }
      100% { transform: translateY(-70px) scale(1,1); }
    }
    .ball {animation:bounceBall 1.2s infinite;border-radius:50%;height:60px;width:60px;position:relative;}
    .ball::before {background:radial-gradient(circle at 36px 20px,#00e5ff,#004d66);border:2px solid #111;border-radius:50%;content:"";height:calc(100% + 6px);left:-6px;position:absolute;top:-3px;width:calc(100% + 6px);}
    .ball .inner {animation:rotateBall 25s linear infinite;border-radius:50%;height:100%;position:absolute;width:100%;}
    .shadow {animation:bounceShadow 1.2s infinite;background:black;filter:blur(2px);border-radius:50%;height:6px;width:54px;transform:translateY(73px);margin:auto;}
    @keyframes bounceShadow {
      0%,100% {opacity:0.6;transform:translateY(73px) scale(0.5);}
      45% {opacity:0.9;transform:translateY(73px) scale(1);}
    }

    /* Cursor Ball */
    .cursor-ball {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--ball-size);
      height: var(--ball-size);
      border-radius: 50%;
      background: var(--accent);
      box-shadow: var(--ball-shadow);
      transform: translate(-50%, -50%) scale(1);
      pointer-events: none;
      z-index: 9999;
      opacity: 0.9;
      transition: transform 120ms ease, opacity 180ms ease;
    }

    /* Bounce-in animation for cards */
    @keyframes bounceIn {
      0% { transform: scale(0.3); opacity: 0; }
      50% { transform: scale(1.1); opacity: 1; }
      70% { transform: scale(0.9); }
      100% { transform: scale(1); opacity: 1; }
    }

    /* Staggered delays */
    .game-card:nth-child(1) { animation-delay: 0.2s; }
    .game-card:nth-child(2) { animation-delay: 0.4s; }
    .game-card:nth-child(3) { animation-delay: 0.6s; }
    .game-card:nth-child(4) { animation-delay: 0.8s; }

    /* Responsive Design */
    @media (max-width: 768px){
      .nav-links{display:none;}
      .mobile-nav-toggle {
        display: block;
      }
      .mobile-nav {
        display: block;
      }
      .games-grid{grid-template-columns:1fr;}
      .page-title{font-size:2rem;}
      .title-section {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }
      .page-title {
        position: static;
        transform: none;
        text-align: left;
      }
      .navbar {
        padding: 1rem 1.5rem;
      }
      .logo {
        font-size: 1.5rem;
      }
      .main-content {
        padding: 0 1rem;
      }
      .ball-container {
        bottom: 20px;
        right: 20px;
      }
      .ball, .shadow {
        transform: scale(0.8);
      }
    }

    @media (max-width: 576px) {
      .page-title {
        font-size: 1.8rem;
      }
      .game-card {
        margin: 0 0.5rem;
      }
      .play-games-btn {
        padding: 10px 20px;
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">HeHBa</div>
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
    <!-- Title and Button Section -->
    <div class="title-section">
      <button class="play-games-btn" onclick="window.location.href='gamesh.php'">
        <i class="fas fa-gamepad"></i> Play Games
      </button>
      <h1 class="page-title">Tournament Games</h1>
    </div>
    
    <div class="games-grid">
      <!-- Game 1 -->
      <div class="game-card">
       <div class="game-image">
  <img src="images/valorant.jpg" alt="Tatical Shooting">
</div>
        <div class="game-content">
          <h3 class="game-title">Valorant</h3>
          <p class="game-desc">Tactical 5v5 shooter with unique agents and abilities.</p>
          <a href="view more.php" class="view-more">View More</a>
        </div>
      </div>

      <!-- Game 2 -->
      <div class="game-card">
        <div class="game-image">
         <div class="game-image">
  <img src="images/pubg.jpg" alt="Battle Royale">
</div>
        </div>
        <div class="game-content">
          <h3 class="game-title">PUBG</h3>
          <p class="game-desc"> Battle royale where 100 players fight to be the last one standing.</p>
          <a href="pubg.php" class="view-more">View More</a>
        </div>
      </div>

      <!-- Game 3 -->
      <div class="game-card">
        <div class="game-image">
          <div class="game-image">
  <img src="images/freefire.jpg" alt="Survival Shooter">
</div>
        </div>
        <div class="game-content">
          <h3 class="game-title">FreeFire</h3>
          <p class="game-desc">Fast 10-minute mobile battle royale with special characters.</p>
          <a href="freefire.php" class="view-more">View More</a>
        </div>
      </div>

      <!-- Game 4 -->
      <div class="game-card">
        <div class="game-image">
          <div class="game-image">
  <img src="images/mlbb.jpg" alt="Battle Arena">
</div>
        </div>
        <div class="game-content">
          <h3 class="game-title">Mobile Legends</h3>
          <p class="game-desc">5v5 MOBA game where heroes battle to destroy enemy bases.</p>
          <a href="" class="view-more">Comming Soon</a>
        </div>
      </div>
    </div>
  </main>

  <!-- Bouncing Ball (right side above footer) -->
  <div class="ball-container">
    <div class="ball"><div class="inner"></div></div>
    <div class="shadow"></div>
  </div>

  <!-- Footer -->
  <!-- Footer -->
  <footer>
    <div class="footer-logo">HeHBa</div>
    <p>Gaming excellence since 2023</p>
    <p class="copyright">&copy; 2023 All rights reserved.</p>
  </footer>

  <!-- Cursor Ball -->
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
  </script>
</body>
</html>