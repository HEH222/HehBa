<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Valorant Group Stage</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --accent: #00e5ff; /* neon cyan */
      --ball-size: 10px;
      --ball-shadow: 0 6px 18px rgba(0,229,255,0.3);
    }

    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

    body {
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      color: #fff;
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      animation: fadeIn 1s ease;
      overflow-x: hidden;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* ---------- NAV ---------- */
    .navbar {
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      border-bottom: 1px solid #111;
      padding: 1.2rem 2rem;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .nav-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
    }
    .logo {
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--accent);
      text-shadow: 0 0 8px rgba(0,229,255,0.7);
    }
    .nav-links { display: flex; list-style: none; }
    .nav-links li { margin-left: 2.5rem; position: relative; }
    .nav-links a {
      text-decoration: none;
      color: #fff;
      font-weight: 500;
      transition: color 0.3s;
      font-size: 1.1rem;
    }
    .nav-links a:hover { color: var(--accent); }
    .nav-links a.active { color: var(--accent); }
    .nav-links a.active::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 100%;
      height: 2px;
      background-color: var(--accent);
    }
    .car {
      position: absolute;
      top: 0;
      left: -100px;
      font-size: 1.5rem;
      color: #ffcc00;
      animation: drive 8s linear infinite;
    }
    @keyframes drive { 0%{left:-100px;} 100%{left:110%;} }

    /* Tabs */
    .tabs { text-align: center; margin-top: 20px; }
    .tabs a { margin: 0 20px; text-decoration: none; color: #fff; font-weight: bold; transition: 0.3s; }
    .tabs a:hover { color: var(--accent); }
    .tabs a.active { text-decoration: underline; color: var(--accent); }

    /* Main layout */
    .wrapper { display: flex; align-items: flex-start; padding: 30px 50px; flex: 1; }
    .groups { flex: 3; }

    .group { margin-bottom: 40px; }
    .group h3 {
      margin-bottom: 10px;
      color: var(--accent);
      font-size: 18px;
      text-shadow: 0 0 6px rgba(0,229,255,0.7);
    }

    .match { display: flex; align-items: center; margin-bottom: 20px; }
    .team-box {
      border: 1px solid #00e5ff55;
      padding: 5px 15px;
      width: 100px;
      text-align: center;
      margin: 2px 0;
      background: rgba(0,229,255,0.08);
      border-radius: 5px;
      transition: transform 0.2s, background 0.3s, box-shadow 0.3s;
    }
    .team-box:hover { transform: scale(1.05); background: rgba(0,229,255,0.2); box-shadow: 0 0 10px rgba(0,229,255,0.6); }

    .connector { width: 40px; height: 2px; background: #00e5ff44; margin: 0 10px; }

    .next-box {
      border: 1px solid #00e5ff55;
      padding: 10px;
      width: 120px;
      text-align: center;
      background: rgba(0,229,255,0.08);
      border-radius: 5px;
    }
    .next-box .line { height: 2px; background: #00e5ff33; margin: 5px 0; }

    .qualified {
      border: 1px solid #00e5ff88;
      padding: 10px;
      margin-left: 10px;
      width: 100px;
      text-align: center;
      background: rgba(0,229,255,0.25);
      border-radius: 5px;
      font-weight: bold;
      box-shadow: 0 0 10px rgba(0,229,255,0.5);
    }

    /* Sidebar */
    .sidebar {
      flex: 1;
      margin-left: 50px;
      padding: 20px;
      background: rgba(0,0,0,0.6);
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,229,255,0.2);
    }
    .sidebar section { margin-bottom: 30px; }
    .sidebar section h4 {
      border-bottom: 1px solid #00e5ff55;
      padding-bottom: 8px;
      margin-bottom: 15px;
      font-size: 16px;
      color: var(--accent);
      text-shadow: 0 0 6px rgba(0,229,255,0.7);
    }
    .sidebar .match-card,
    .latest-match-card {
      background: rgba(0,0,0,0.75);
      padding: 12px;
      margin-bottom: 12px;
      border-radius: 5px;
      text-align: center;
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
      border: 1px solid #00e5ff33;
    }
    .sidebar .match-card:hover,
    .latest-match-card:hover {
      transform: scale(1.05);
      box-shadow: 0 0 15px var(--accent);
    }
    .latest-match-card .vs { color: var(--accent); font-weight: bold; }

    .score-box {
      background: #111;
      color: #fff;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: bold;
      min-width: 40px;
      text-align: center;
      border: 2px solid var(--accent);
    }

    /* Footer */
    footer {
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      color: #fff;
      padding: 1.2rem;
      text-align: center;
      border-top: 1px solid #111;
      margin-top: 2rem;
    }

    /* Cursor Ball (mouse tracker) */
    .cursor-ball {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--ball-size);
      height: var(--ball-size);
      border-radius: 50%;
      background: var(--accent);
      box-shadow: var(--ball-shadow);
      pointer-events: none;
      z-index: 9999;
      opacity: 0.9;
      transform: translate(-50%, -50%);
      transition: transform 0.15s ease-out;
    }

    /* ---------- BOUNCING BALL ---------- */
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
    .ball { animation:bounceBall 1.2s infinite; border-radius:50%; height:60px; width:60px; position:relative; }
    .ball::before { background:radial-gradient(circle at 36px 20px,#00e5ff,#004466); border:2px solid #111; border-radius:50%; content:""; height:calc(100% + 6px); left:-6px; position:absolute; top:-3px; width:calc(100% + 6px); }
    .ball .inner { animation:rotateBall 25s linear infinite; border-radius:50%; height:100%; position:absolute; width:100%; }
    .shadow { animation:bounceShadow 1.2s infinite; background:black; filter:blur(2px); border-radius:50%; height:6px; width:54px; transform:translateY(73px); margin:auto; }
    @keyframes bounceShadow {
      0%,100% { opacity:0.6; transform:translateY(73px) scale(0.5); }
      45% { opacity:0.9; transform:translateY(73px) scale(1); }
    }

    @media (max-width:768px){ .wrapper{ padding:20px; } .sidebar{ margin-left:20px; } }
  </style>
</head>
<body>

  <!-- Mouse Tracker Ball -->
  <div class="cursor-ball"></div>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">HehKali Esports</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="game.php" class="active">Games</a></li>
        <li><a href="contact.php">Contact us</a></li>
        <li><a href="about.php">About us</a></li>
        <li><a href="gamesheld.php">Games held</a></li>
      </ul>
    </div>
    <div class="car">🚗💨</div>
  </nav>

  <!-- Go Back Button -->
  <div style="padding: 15px 50px;">
    <a href="gamesheld.php"
       style="display:inline-block;background:#00e5ff;color:#000;padding:8px 15px;text-decoration:none;border-radius:5px;font-weight:bold;box-shadow:0 0 10px rgba(0,229,255,0.6);">
      ← Go Back
    </a>
  </div>

  <!-- Tabs -->
  <div class="tabs">
    <a href="ml_tiesheet.php" class="active">Group Stage</a>
    <a href="mlplayoff.php">PlayOffs</a>
  </div>

  <div class="wrapper">

    <!-- Groups Section -->
    <div class="groups">
      <!-- Group A -->
      <div class="group">
        <h3>Group A</h3>
        <div class="match">
          <div>
            <div class="team-box">TEAM 1</div>
            <div class="team-box">TEAM 2</div><br>
            <div class="team-box">TEAM 3</div>
            <div class="team-box">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">TEAM 1</div>
            <div class="line"></div>
            <div class="team-bottom">TEAM 2</div>
          </div>
          <div class="connector"></div>
          <div class="qualified">Qualified</div>
        </div>
        <div class="match">
          <div>
            <div class="team-box">TEAM 2</div>
            <div class="team-box">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">TEAM 2</div>
            <div class="line"></div>
            <div class="team-bottom">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">Winner 1</div>
            <div class="line"></div>
            <div class="team-bottom">Winner 2</div>
          </div>
          <div class="connector"></div>
          <div class="qualified">Qualified</div>
        </div>
      </div>

      <!-- Group B -->
      <div class="group">
        <h3>Group B</h3>
        <div class="match">
          <div>
            <div class="team-box">TEAM 1</div>
            <div class="team-box">TEAM 2</div><br>
            <div class="team-box">TEAM 3</div>
            <div class="team-box">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">TEAM 1</div>
            <div class="line"></div>
            <div class="team-bottom">TEAM 2</div>
          </div>
          <div class="qualified">Qualified</div>
        </div>
        <div class="match">
          <div>
            <div class="team-box">TEAM 2</div>
            <div class="team-box">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">TEAM 2</div>
            <div class="line"></div>
            <div class="team-bottom">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">Winner 1</div>
            <div class="line"></div>
            <div class="team-bottom">Winner 2</div>
          </div>
          <div class="connector"></div>
          <div class="qualified">Qualified</div>
        </div>
      </div>

      <!-- Group C -->
      <div class="group">
        <h3>Group C</h3>
        <div class="match">
          <div>
            <div class="team-box">TEAM 1</div>
            <div class="team-box">TEAM 2</div><br>
            <div class="team-box">TEAM 3</div>
            <div class="team-box">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">TEAM 1</div>
            <div class="line"></div>
            <div class="team-bottom">TEAM 2</div>
          </div>
          <div class="qualified">Qualified</div>
        </div>
        <div class="match">
          <div>
            <div class="team-box">TEAM 2</div>
            <div class="team-box">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">TEAM 2</div>
            <div class="line"></div>
            <div class="team-bottom">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">Winner 1</div>
            <div class="line"></div>
            <div class="team-bottom">Winner 2</div>
          </div>
          <div class="connector"></div>
          <div class="qualified">Qualified</div>
        </div>
      </div>

      <!-- Group D -->
      <div class="group">
        <h3>Group D</h3>
        <div class="match">
          <div>
            <div class="team-box">TEAM 1</div>
            <div class="team-box">TEAM 2</div><br>
            <div class="team-box">TEAM 3</div>
            <div class="team-box">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">TEAM 1</div>
            <div class="line"></div>
            <div class="team-bottom">TEAM 2</div>
          </div>
          <div class="qualified">Qualified</div>
        </div>
        <div class="match">
          <div>
            <div class="team-box">TEAM 2</div>
            <div class="team-box">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">TEAM 2</div>
            <div class="line"></div>
            <div class="team-bottom">TEAM 4</div>
          </div>
          <div class="connector"></div>
          <div class="next-box">
            <div class="team-top">Winner 1</div>
            <div class="line"></div>
            <div class="team-bottom">Winner 2</div>
          </div>
          <div class="connector"></div>
          <div class="qualified">Qualified</div>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <section>
        <h4>Latest Match</h4>
        <div class="latest-match-card">
          <div class="teams">
            <span>TEAM 1</span>
            <div class="score-box">13</div>
          </div>
          <div class="vs">VS</div>
          <div class="teams">
            <span>TEAM 2</span>
            <div class="score-box">10</div>
          </div>
          <div class="time">Finished • Today</div>
        </div>
      </section>
      <section>
        <h4>Upcoming Matches</h4>
        <div class="match-card"><div class="teams">TEAM 3 vs TEAM 4</div><div class="time">Today • 7:00 PM</div></div>
        <div class="match-card"><div class="teams">TEAM A vs TEAM B</div><div class="time">Tomorrow • 3:00 PM</div></div>
        <div class="match-card"><div class="teams">TEAM C vs TEAM D</div><div class="time">Tomorrow • 6:00 PM</div></div>
      </section>
    </div>

  </div>

  <!-- Bouncing Ball -->
  <div class="ball-container">
    <div class="ball"><div class="inner"></div></div>
    <div class="shadow"></div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="footer-logo">GameHub</div>
    <p class="copyright">© 2025 GameHub. All rights reserved.</p>
  </footer>

  <script>
    // Tracker ball movement
    const cursorBall = document.querySelector('.cursor-ball');
    document.addEventListener('mousemove', e => {
      cursorBall.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
    });
  </script>
</body>
</html>
