<?php
// contact.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GameHub - Contact Us</title>
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
  min-height:100vh;
  display:flex;
  flex-direction:column;
  overflow-x: hidden;
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
.logo{font-size:1.8rem;font-weight:800;color:var(--accent);letter-spacing:0;text-shadow:0 0 8px rgba(0,229,255,0.7);}
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

/* small animated car */
.car{position:absolute;top:0;left:-100px;font-size:1.5rem;color:#ffcc00;animation:drive 8s linear infinite;}
@keyframes drive{0%{left:-100px;}100%{left:110%;}}

/* ---------- MAIN CONTENT ---------- */
.main-content{flex:1;max-width:800px;margin:3rem auto;padding:0 1rem;width:100%;}
.page-title{font-size:2.5rem;margin-bottom:2rem;color:var(--accent);text-align:center;font-weight:700;text-shadow:0 0 12px rgba(0,229,255,0.7);text-transform:uppercase;animation:fadeInDown 1s ease;}

.contact-section{
  background: rgba(0,0,0,0.7);
  padding:2rem;
  border-radius:10px;
  text-align:center;
  box-shadow:0 5px 15px rgba(0,229,255,0.3);
  animation:fadeInUp 1s ease;
  transition: transform 0.3s;
}
.contact-section:hover{transform:scale(1.02);}
.contact-section h1{color:var(--accent);margin-bottom:1rem;font-size:2rem;}
.contact-section p{color:#ccc;margin-bottom:2rem;font-size:1.1rem;}

/* Social icons */
.social-icons{
  display:flex;
  justify-content:center;
  gap:2rem;
  flex-wrap:wrap;
}
.social-icons a{
  font-size:2rem;
  color:#fff;
  transition:0.3s transform, 0.3s color;
}
.social-icons a:hover{
  color:var(--accent);
  transform:scale(1.3) rotate(-10deg);
}

/* Footer */
footer{
  background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
  color:#fff;
  padding:1.2rem;
  text-align:center;
  border-top:1px solid #111;
}
.footer-logo{font-size:1.4rem;font-weight:800;color:var(--accent);margin-bottom:0.5rem;}
.copyright{color:#888;font-size:0.9rem;margin-top:0.5rem;}

/* ---------- Bouncing Ball ---------- */
.ball-container{
  position:fixed;
  bottom:80px;
  left:40px;
  z-index:500;
}
.ball{
  width:60px;
  height:60px;
  border-radius:50%;
  position:relative;
  animation:bounceBall 1.2s infinite;
}
.ball::before{
  content:"";
  position:absolute;
  top:-3px; left:-3px;
  width:66px; height:66px;
  border-radius:50%;
  border:2px solid #111;
  background:radial-gradient(circle at 36px 20px,#00e5ff,#004466);
}
.ball .inner{
  position:absolute;
  width:100%;
  height:100%;
  border-radius:50%;
  animation:rotateBall 25s linear infinite;
}
.shadow{
  width:54px;
  height:6px;
  border-radius:50%;
  background:black;
  filter:blur(2px);
  margin:auto;
  transform:translateY(73px);
  animation:bounceShadow 1.2s infinite;
}
@keyframes bounceBall{
  0%{transform:translateY(-70px) scale(1,1);}
  45%{transform:translateY(70px) scale(1,1);}
  50%{transform:translateY(75px) scale(1,0.9);}
  100%{transform:translateY(-70px) scale(1,1);}
}
@keyframes rotateBall{0%{transform:rotateY(0deg) rotateX(0deg);}100%{transform:rotateY(720deg) rotateX(720deg);}}
@keyframes bounceShadow{0%,100%{opacity:0.6;transform:translateY(73px) scale(0.5);}45%{opacity:0.9;transform:translateY(73px) scale(1);}}

/* ---------- Cursor Tracker ---------- */
.cursor-ball{
  position:fixed;
  top:0; left:0;
  width:var(--ball-size);
  height:var(--ball-size);
  border-radius:50%;
  background:var(--accent);
  box-shadow:var(--ball-shadow);
  transform:translate(-50%, -50%) scale(1);
  pointer-events:none;
  z-index:9999;
  opacity:0.9;
  transition: transform 120ms ease, opacity 180ms ease;
}

/* ---------- Animations ---------- */
@keyframes fadeInUp{0%{opacity:0;transform:translateY(40px);}100%{opacity:1;transform:translateY(0);}}
@keyframes fadeInDown{0%{opacity:0;transform:translateY(-40px);}100%{opacity:1;transform:translateY(0);}}

/* ---------- Responsive Design ---------- */
@media (max-width: 768px){
  .nav-links{display:none;}
  .mobile-nav-toggle{display:block;}
  .mobile-nav{display:block;}
  .navbar{padding:1rem 1.5rem;}
  .logo{font-size:1.5rem;}
  .main-content{padding:0 1rem;margin:2rem auto;}
  .page-title{font-size:2rem;}
  .contact-section{padding:1.5rem;}
  .contact-section h1{font-size:1.6rem;}
  .social-icons{gap:1.5rem;}
  .social-icons a{font-size:1.8rem;}
  .ball-container{bottom:20px;left:20px;}
  .ball,.shadow{transform:scale(0.8);}
}

@media (max-width: 576px){
  .page-title{font-size:1.8rem;}
  .contact-section{padding:1.2rem;}
  .contact-section h1{font-size:1.4rem;}
  .contact-section p{font-size:1rem;}
  .social-icons{gap:1rem;}
  .social-icons a{font-size:1.6rem;}
  .footer-logo{font-size:1.2rem;}
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="nav-container">
    <div class="logo">HehKali Esports</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="game.php">Games</a></li>
      <li><a href="contact.php" class="active">Contact</a></li>
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

<!-- Main Content -->
<main class="main-content">
  <h1 class="page-title">Contact Us</h1>
  <section class="contact-section">
    <h1>Stay Connected</h1>
    <p>Join our gaming community via social media and stay up-to-date with events and tournaments!</p>
    <div class="social-icons">
      <a href="https://www.tiktok.com/@alienfromsouthesports?is_from_webapp=1&sender_device=pc" target="_blank"><i class="fab fa-tiktok"></i></a>
      <a href="https://www.instagram.com/alienfromsouthh/?utm_source=ig_web_button_share_sheet" target="_blank"><i class="fab fa-instagram"></i></a>
      <a href="mailto:alienfromsouthesports@gmail.com"><i class="fas fa-envelope"></i></a>
      <a href="https://discord.gg/PbFF7rSs" target="_blank"><i class="fab fa-discord"></i></a>
      <a href="https://www.youtube.com/@gulashimoto" target="_blank"><i class="fab fa-youtube"></i></a>
      <a href="https://wa.me/9779818070497" target="_blank"><i class="fab fa-whatsapp"></i></a>
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
  <div class="footer-logo">HehKali Esports</div>
  <p>Gaming excellence since 2023</p>
  <p class="copyright">&copy; 2023 All rights reserved.</p>
</footer>

<!-- Cursor Tracker -->
<div class="cursor-ball" id="cursorBall"></div>

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