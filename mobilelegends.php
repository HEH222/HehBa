<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Valorant Tournament - View More</title>

  <!-- Firebase -->
  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root{
      --accent: #00e5ff; /* Neon Cyan */
      --ball-size: 8px;
      --ball-shadow: 0 6px 18px rgba(0,229,255,0.20);
    }

    *{margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}

    body{
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364); /* Dark gradient like home */
      color:#fff;
      line-height:1.6;
      min-height:100vh;
      display:flex;
      flex-direction:column;
    }

    /* Navbar */
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
    .nav-links a{text-decoration:none;color:#fff;font-weight:500;transition:color 0.3s;font-size:1.1rem;}
    .nav-links a:hover{color:var(--accent);}
    .nav-links a.active{color:var(--accent);}
    .nav-links a.active::after{content:'';position:absolute;bottom:-5px;left:0;width:100%;height:2px;background-color:var(--accent);}

    .car {
      position:absolute;
      top:0;
      left:-100px;
      font-size:1.5rem;
      color:#ffcc00;
      animation: drive 8s linear infinite;
    }
    @keyframes drive {
      0% { left:-100px; }
      100% { left:110%; }
    }

    /* Main */
    .main-content{flex:1;max-width:1000px;margin:2rem auto;padding:0 2rem;width:100%;}
    .page-title{font-size:2.5rem;margin-bottom:2rem;color:var(--accent);text-align:center;font-weight:700;text-transform:uppercase;text-shadow:0 0 12px rgba(0,229,255,0.7);}

    .go-back {
      display:inline-block;
      background:#111;
      color:#fff;
      padding:0.6rem 1.2rem;
      border-radius:4px;
      text-decoration:none;
      font-weight:500;
      margin-bottom:1.5rem;
      transition:background 0.3s;
    }
    .go-back:hover {background:#222;}

     .Register {
      display:inline-block;
      background:#111;
      color:#fff;
      padding:0.6rem 1.2rem;
      border-radius:4px;
      text-decoration:none;
      font-weight:500;
      margin-bottom:1.5rem;
      transition:background 0.3s;
      
    }
    .Register:hover {background:#222;}

    /* Card sections with popup animation */
    .card {
      background:rgba(0,0,0,0.75);
      border-radius:10px;
      padding:2.5rem;
      margin-bottom:3rem;
      box-shadow:0 5px 15px rgba(0,229,255,0.25);
      opacity:0;
      transform: scale(0.9) translateY(30px);
      animation: popup 0.8s forwards;
    }
    .card:nth-child(1){animation-delay:0.2s;}
    .card:nth-child(2){animation-delay:0.4s;}
    .card:nth-child(3){animation-delay:0.6s;}
    .card:nth-child(4){animation-delay:0.8s;}

    @keyframes popup {
      to {
        opacity:1;
        transform: scale(1) translateY(0);
      }
    }

    .card h3{font-size:1.6rem;margin-bottom:1rem;color:var(--accent);}
    .card p, .rules-list li {color:#ccc;line-height:1.7;margin-bottom:0.8rem;}

    .rules-list{list-style:none;padding-left:1rem;}
    .rules-list li{position:relative;padding-left:1.5rem;}
    .rules-list li:before{content:"•";color:var(--accent);font-weight:bold;position:absolute;left:0;}

    .btn {
      display:inline-block;
      background:var(--accent);
      color:#000;
      padding:0.8rem 1.5rem;
      border-radius:6px;
      text-decoration:none;
      font-weight:600;
      margin-top:1rem;
      transition:background 0.3s, transform 0.2s;
    }
    .btn:hover {background:#00b8cc;transform:translateY(-2px);}

    /* Registration */
    .form-title{font-size:1.8rem;margin-bottom:1.5rem;color:var(--accent);text-align:center;text-transform:uppercase;}
    .form-group{margin-bottom:1.5rem;}
    .form-group label{display:block;margin-bottom:0.5rem;color:#fff;font-weight:500;}
    .form-group input, .form-group select{
      width:100%;padding:0.8rem 1rem;border:1px solid #555;border-radius:4px;
      background:#111;color:#fff;font-size:1rem;transition:all 0.3s;
    }
    .form-group input:focus, .form-group select:focus{outline:none;border-color:var(--accent);background:#1a1a1a;}
    .submit-btn{background:var(--accent);color:#000;border:none;padding:1rem 2rem;border-radius:4px;font-size:1.1rem;font-weight:600;cursor:pointer;width:100%;transition:all 0.3s;}
    .submit-btn:hover{background:#00b8cc;transform:translateY(-2px);}
    .success-message{background:#4CAF50;color:#fff;padding:1rem;border-radius:4px;margin-top:1rem;text-align:center;display:none;}

    /* Footer */
    footer{background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);color:#fff;padding:1.2rem;text-align:center;margin-top:3rem;border-top:1px solid #111;}
    .footer-text{font-size:0.9rem;color:#888;}

    /* Bouncing Ball */
    .ball-container {
      position: fixed;
      bottom: 80px;
      left: 40px;
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
    .ball::before {background:radial-gradient(circle at 36px 20px,#00e5ff,#004466);border:2px solid #111;border-radius:50%;content:"";height:calc(100% + 6px);left:-6px;position:absolute;top:-3px;width:calc(100% + 6px);}
    .ball .inner {animation:rotateBall 25s linear infinite;border-radius:50%;height:100%;position:absolute;width:100%;}
    .shadow {animation:bounceShadow 1.2s infinite;background:black;filter:blur(2px);border-radius:50%;height:6px;width:54px;transform:translateY(73px);margin:auto;}
    @keyframes bounceShadow {
      0%,100% {opacity:0.6;transform:translateY(73px) scale(0.5);}
      45% {opacity:0.9;transform:translateY(73px) scale(1);}
    }

    @media(max-width:768px){.nav-links{display:none;}.navbar{padding:1rem;}.page-title{font-size:2rem;}.card{padding:1.5rem;}}
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="nav-container">
    <div class="logo">HehKali Esports</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="game.php" class="active">Games</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="gamesheld.php">Games Held</a></li>
    </ul>
  </div>
  <div class="car">🚗💨</div>
</nav>

<!-- Main -->
<main class="main-content">
  <a href="game.php" class="go-back"><i class="fas fa-arrow-left"></i> Go Back to Games</a>
   <a href="mobilelegends_register.php" class="Register"><i class="fas fa-arrow-right"></i> Register Here!!</a>
  <h1 class="page-title">Mobile Legends Tournament</h1>

  <!-- Tournament Info -->
  <div class="card">
    <h3>How and When It Is Conducted</h3>
    <p>The Valorant Tournament will be held online from October 15–30, 2023. Matches will be scheduled on weekends to allow maximum participation from teams across different time zones.</p>
    <p>This tournament features a double-elimination bracket system, with best-of-three matches in the group stages and best-of-five matches in the playoffs. The grand finals will be streamed live on our official channels.</p>
  </div>

  <div class="card">
    <h3>Tournament Rules</h3>
    <ul class="rules-list">
      <li>All players must be registered with their main Riot ID</li>
      <li>Teams must have at least 5 players and can have up to 2 substitutes</li>
      <li>All matches will be played on the latest version of Valorant</li>
      <li>Standard tournament mode settings will be applied</li>
      <li>Cheating or unauthorized software = disqualification</li>
      <li>Teams must be ready 15 minutes before match time</li>
      <li>Disputes must be raised with admins immediately after match</li>
      <li>Players must maintain sportsmanlike conduct</li>
    </ul>
    <a href="ml_tiesheet.php" class="btn">Go to Schedule / Tiesheet</a>
  </div>

  <div class="card">
    <h3>Prize Pool</h3>
    <ul class="rules-list">
      <li>1st Place: $5,000 + Custom Gaming Peripherals</li>
      <li>2nd Place: $2,500</li>
      <li>3rd Place: $1,000</li>
      <li>4th Place: $500</li>
      <li>MVP: Special Edition Valorant Points</li>
    </ul>
  </div>
  
</main>

<!-- Bouncing Ball -->
<div class="ball-container">
  <div class="ball"><div class="inner"></div></div>
  <div class="shadow"></div>
</div>

<!-- Footer -->
<footer>
  <p class="footer-text">Gaming excellence since 2023</p>
  <p class="footer-text">&copy; 2023 All rights reserved.</p>
</footer>

</body>
</html>
