<?php
// about.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GameHub - About Us</title>
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
      display:flex;
      flex-direction:column;
      min-height:100vh;
      overflow-x:hidden;
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
    .logo{font-size:1.8rem;font-weight:800;color:var(--accent);text-shadow:0 0 8px rgba(0,229,255,0.7);}
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

    /* small animated car in navbar */
    .car {position:absolute;top:0;left:-100px;font-size:1.5rem;color:#ffcc00;animation:drive 8s linear infinite;}
    @keyframes drive {0%{left:-100px;}100%{left:110%;}}

    /* ---------- MAIN CONTENT ---------- */
    main{flex:1;max-width:900px;margin:3rem auto;padding:0 1rem;}
    .about-section{position:relative;background:rgba(0,0,0,0.75);border-radius:10px;padding:2rem;box-shadow:0 5px 15px rgba(0,229,255,0.3);overflow:hidden;opacity:0;transform:translateY(50px);animation:fadeInUp 1s forwards;}

    @keyframes fadeInUp{to{opacity:1;transform:translateY(0);}}

    .about-section::before{
      content:"";
      position:absolute;
      top:50%;
      left:50%;
      transform:translate(-50%,-50%);
      background:url("A_circular_logo_features_ALIENFROMSOUTH_ESPORTS_.png") no-repeat center;
      background-size:300px;
      opacity:0.08;
      width:100%;
      height:100%;
      z-index:1;
    }

    .about-section h1,.about-section p{position:relative;z-index:2;}
    .about-section h1{color:var(--accent);margin-bottom:1.5rem;text-align:center;text-shadow:0 0 12px rgba(0,229,255,0.7);}
    .about-section p{color:#ddd;margin-bottom:1rem;line-height:1.6;font-size:1.05rem;text-align:justify;}

    /* Game Icon Animations */
    .game-icons{display:flex;justify-content:center;flex-wrap:wrap;gap:2rem;margin-top:2rem;z-index:2;position:relative;}
    .game-icon{
      font-size:3rem;
      color:#fff;
      transition:0.3s;
      animation:popIn 1s ease forwards;
    }
    .game-icon:hover{
      color:var(--accent);
      transform:scale(1.3) rotate(15deg);
      text-shadow:0 0 15px var(--accent);
    }
    @keyframes popIn{0%{transform:scale(0);opacity:0;}100%{transform:scale(1);opacity:1;}}

    /* Footer */
    footer{background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);color:#fff;text-align:center;padding:1.2rem;margin-top:3rem;border-top:1px solid #111;}
    .footer-logo{font-size:1.4rem;font-weight:800;letter-spacing:2px;margin-bottom:0.5rem;color:var(--accent);}
    .copyright{margin-top:0.5rem;font-size:0.9rem;color:#888;}

    /* ---------- CURSOR BALL ---------- */
    .cursor-ball{
      position:fixed;top:0;left:0;width:var(--ball-size);height:var(--ball-size);
      border-radius:50%;background:var(--accent);box-shadow:var(--ball-shadow);
      transform:translate(-50%,-50%) scale(1);pointer-events:none;z-index:9999;opacity:0.9;
      transition:transform 120ms ease, opacity 180ms ease;
    }

    /* ---------- BOUNCING BALL ---------- */
    .ball-container{position:fixed;bottom:80px;right:40px;z-index:500;}
    @keyframes rotateBall {0%{transform:rotateY(0deg) rotateX(0deg);}100%{transform:rotateY(720deg) rotateX(720deg);}}
    @keyframes bounceBall{0%{transform:translateY(-70px) scale(1,1);}45%{transform:translateY(70px) scale(1,1);}50%{transform:translateY(75px) scale(1,0.9);}100%{transform:translateY(-70px) scale(1,1);}}
    .ball{animation:bounceBall 1.2s infinite;border-radius:50%;height:60px;width:60px;position:relative;}
    .ball::before{background:radial-gradient(circle at 36px 20px,#00e5ff,#004466);border:2px solid #111;border-radius:50%;content:"";height:calc(100% + 6px);left:-6px;position:absolute;top:-3px;width:calc(100% + 6px);}
    .ball .inner{animation:rotateBall 25s linear infinite;border-radius:50%;height:100%;position:absolute;width:100%;}
    .shadow{animation:bounceShadow 1.2s infinite;background:black;filter:blur(2px);border-radius:50%;height:6px;width:54px;transform:translateY(73px);margin:auto;}
    @keyframes bounceShadow{0%,100%{opacity:0.6;transform:translateY(73px) scale(0.5);}45%{opacity:0.9;transform:translateY(73px) scale(1);}}

    /* ---------- Responsive Design ---------- */
    @media (max-width: 768px){
      .nav-links{display:none;}
      .mobile-nav-toggle{display:block;}
      .mobile-nav{display:block;}
      .navbar{padding:1rem 1.5rem;}
      .logo{font-size:1.5rem;}
      main{margin:2rem 1rem;padding:0 0.5rem;}
      .about-section{padding:1.5rem;}
      .about-section::before{background-size:180px;}
      .about-section h1{font-size:1.8rem;}
      .about-section p{font-size:1rem;text-align:left;}
      .game-icons{gap:1.5rem;}
      .game-icon{font-size:2.5rem;}
      .ball-container{bottom:20px;right:20px;}
      .ball,.shadow{transform:scale(0.8);}
    }

    @media (max-width: 576px){
      .about-section{padding:1.2rem;}
      .about-section h1{font-size:1.6rem;}
      .game-icons{gap:1rem;}
      .game-icon{font-size:2rem;}
      .footer-logo{font-size:1.2rem;}
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">HehBa</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="game.php">Games</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="about.php" class="active">About</a></li>
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

  <!-- About Section -->
  <main>
    <section class="about-section">
      <h1>About Us</h1>
      <p>Welcome to <strong>HeHBa</strong>, the ultimate destination for gamers who share a passion for fun, strategy, and competition. Since our launch in 2023, we've been working hard to create a space where players of all levels feel at home.</p>
      <p>Our mission is simple: to connect gamers from around the world, provide exciting tournaments, and celebrate the spirit of esports and gaming culture.</p>
      <p>We host multiple events, tournaments, and challenges for various games, bringing together a community that thrives on both casual and competitive play.</p>
      <p>Whether you are here to compete, learn, or just make new friends, GameHub is the right place for you. We are continuously evolving to make the platform better every day.</p>
      <p>Thank you for being a part of our journey. Together, we build not just a gaming hub, but a family.</p>

      <!-- Game Icons -->
      <div class="game-icons">
        <i class="fas fa-gamepad game-icon"></i>
        <i class="fas fa-dice game-icon"></i>
        <i class="fas fa-trophy game-icon"></i>
        <i class="fas fa-bolt game-icon"></i>
        <i class="fas fa-fire game-icon"></i>
      </div>
    </section>
  </main>

  <!-- Bouncing Ball -->
  <div class="ball-container">
    <div class="ball"><div class="inner"></div></div>
    <div class="shadow"></div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="footer-logo">HeHBa</div>
    <p>Gaming excellence since 2023</p>
    <p class="copyright">&copy; 2023 All rights reserved.</p>
  </footer>

  <!-- Cursor Ball -->
  <div class="cursor-ball" id="cursorBall" aria-hidden="true"></div>

  <script>
    // Cursor tracking
    const cursorBall = document.getElementById('cursorBall');
    const mobileNavToggle = document.getElementById('mobileNavToggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileNavOverlay = document.getElementById('mobileNavOverlay');

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

    // Stagger game icons animation
    const icons = document.querySelectorAll('.game-icon');
    icons.forEach((icon,i)=>{
      icon.style.animationDelay = `${i*0.2}s`;
    });
  </script>
</body>
</html>