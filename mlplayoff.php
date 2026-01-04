<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Valorant - PlayOffs</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    :root{
      --accent:#00e5ff;       /* Neon cyan highlight */
      --line-upper:#00e5ff;   /* Cyan for upper bracket */
      --line-lower:#00e5ff;   /* Cyan for lower bracket */
      --line-final:#00e5ff;   /* Cyan for final */
      --bg-gradient:linear-gradient(135deg,#0f2027,#203a43,#2c5364); /* Deep blue gradient */
      --card-bg:rgba(255,255,255,0.05);
    }

    html,body{
      height:100%;
      margin:0;
      font-family: Arial, Helvetica, sans-serif;
      background:var(--bg-gradient);
      color:#fff;
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
      right: 0;
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
    .tabs{text-align:center;padding:14px 0;}
    .tabs a{margin:0 14px;font-weight:700;text-decoration:none;color:#fff;font-size:15px;}
    .tabs a.active{text-decoration:underline;color:var(--accent);}

    /* Layout */
    .wrap{display:flex;gap:24px;padding:24px 28px;align-items:flex-start;}
    .content{flex:1;min-width:900px;position:relative;}
    .sidebar{width:320px;background:var(--card-bg);border:1px solid #333;padding:18px;border-radius:8px;}

    /* Bracket */
    .bracket{padding:28px 18px 40px;position:relative;overflow:auto;}
    .columns{display:flex;gap:64px;align-items:flex-start;position:relative;}
    .column{display:flex;flex-direction:column;gap:40px;align-items:flex-start;min-width:220px;}
    .col-title{font-size:14px;margin-bottom:6px;color:var(--accent);font-weight:700;text-transform:uppercase;}

    .match{
      width:220px;
      border:1px solid #00e5ff33;
      background:var(--card-bg);
      border-radius:8px;
      overflow:hidden;
      animation: fadeInUp 0.8s ease both;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .match:hover{transform:scale(1.03);box-shadow:0 6px 15px rgba(0,229,255,0.5);}
    .team-row{display:flex;align-items:center;gap:10px;padding:8px 10px;font-size:13px;color:#fff;}
    .team-row + .team-row{border-top:1px solid #00e5ff22;}
    .time{font-size:12px;color:#ddd;padding:6px 10px 10px;}

    /* Animations */
    @keyframes fadeInUp{0%{opacity:0;transform:translateY(20px);}100%{opacity:1;transform:translateY(0);} }
    @keyframes drawLine{from{stroke-dasharray:600;stroke-dashoffset:600;}to{stroke-dashoffset:0;}}

    /* SVG overlay */
    #connectors{position:absolute;left:0;top:0;width:100%;height:100%;pointer-events:none;z-index:0;}
    #connectors path{fill:none;stroke-linejoin:round;stroke-linecap:round;opacity:.9;stroke-dasharray:600;stroke-dashoffset:600;animation:drawLine 2.2s ease forwards;}

    /* Sidebar cards */
    .side-title{background:rgba(255,255,255,0.1);padding:8px 10px;font-weight:700;margin:-18px -18px 12px -18px;text-transform:uppercase;font-size:13px;border-bottom:1px solid #333;}
    .match-card{background:rgba(0,0,0,0.5);padding:10px;border:1px solid #00e5ff33;border-radius:6px;margin-bottom:12px;transition:.3s;animation:fadeInUp .9s ease both;}
    .match-card:hover{transform:translateY(-5px) scale(1.02);box-shadow:0 6px 14px rgba(0,229,255,0.5);}
    .match-card .time{color:#ccc;font-size:12px;}

    /* Footer */
   footer {
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      color: #fff;
      padding: 1.2rem;
      text-align: center;
      border-top: 1px solid #111;
      margin-top: 2rem;
    }

    /* Bouncing Ball */
    .ball-container{position:fixed;bottom:80px;right:40px;z-index:999;}
    .ball{width:60px;height:60px;border-radius:50%;background:var(--accent);box-shadow:0 6px 18px rgba(0,229,255,0.35);animation:bounceBall 1.2s infinite;position:relative;}
    .ball::before{content:"";position:absolute;top:-3px;left:-3px;width:66px;height:66px;border-radius:50%;border:2px solid #111;background:radial-gradient(circle at 36px 20px,#00e5ff,#004466);}
    .ball .inner{animation:rotateBall 25s linear infinite;border-radius:50%;height:100%;width:100%;position:absolute;}
    .shadow{animation:bounceShadow 1.2s infinite;background:black;filter:blur(2px);border-radius:50%;height:6px;width:54px;transform:translateY(73px);margin:auto;}
    @keyframes bounceBall{0%{transform:translateY(-70px) scale(1,1);}45%{transform:translateY(70px) scale(1,1);}50%{transform:translateY(75px) scale(1,0.9);}100%{transform:translateY(-70px) scale(1,1);}}
    @keyframes rotateBall{0%{transform:rotateY(0deg) rotateX(0deg);}100%{transform:rotateY(720deg) rotateX(720deg);}}
    @keyframes bounceShadow{0%,100%{opacity:0.6;transform:translateY(73px) scale(0.5);}45%{opacity:0.9;transform:translateY(73px) scale(1);}}

    /* Mouse Tracker Ball */
    .tracker-ball{width:10px;height:10px;border-radius:50%;background:var(--accent);position:fixed;pointer-events:none;z-index:9999;box-shadow:0 6px 18px rgba(0,229,255,0.3);}
  </style>
</head>
<body>
  <!-- NAVBAR -->
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

  <!-- BACK BUTTON -->
  <div style="padding:15px 50px;">
    <a href="ml_tiesheet.php" style="display:inline-block;background:var(--accent);color:#000;padding:8px 15px;text-decoration:none;border-radius:5px;font-weight:bold;">
      ← Go Back
    </a>
  </div>

  <!-- TABS -->
  <div class="tabs">
    <a href="valo_tiesheet.php">Group Stage</a>
    <a href="playoffs.php" class="active">PlayOffs</a>
  </div>

  <!-- WRAP -->
  <div class="wrap">
    <div class="content">
      <div class="bracket" id="bracket">
        <svg id="connectors" xmlns="http://www.w3.org/2000/svg"></svg>

        <!-- Upper Bracket -->
        <div class="section-heading">Upper Bracket</div>
        <div class="columns">
          <div class="column">
            <div class="col-title">Quarterfinals</div>
            <div class="match" id="qf1"><div class="team-row">Team A</div><div class="team-row">Team B</div><div class="time">Sep 25</div></div>
            <div class="match" id="qf2"><div class="team-row">Team C</div><div class="team-row">Team D</div><div class="time">Sep 25</div></div>
            <div class="match" id="qf3"><div class="team-row">Team E</div><div class="team-row">Team F</div><div class="time">Sep 26</div></div>
            <div class="match" id="qf4"><div class="team-row">Team G</div><div class="team-row">Team H</div><div class="time">Sep 26</div></div>
          </div>
          <div class="column">
            <div class="col-title">Semifinals</div><br><br>
            <div class="match" id="sf1"><div class="team-row">Winner QF1</div><div class="team-row">Winner QF2</div><div class="time">Sep 28</div></div><br><br><br><br><br>
            <div class="match" id="sf2"><div class="team-row">Winner QF3</div><div class="team-row">Winner QF4</div><div class="time">Sep 28</div></div>
          </div>
          <div class="column">
            <div class="col-title">Upper Final</div>
            <div class="match" id="uf"><div class="team-row">Winner SF1</div><div class="team-row">Winner SF2</div><div class="time">Oct 3</div></div>
          </div>
          <div class="column">
            <div class="col-title">Grand Final</div>
            <div class="match" id="gf"><div class="team-row">Winner UB</div><div class="team-row">Winner LB</div><div class="time">Oct 5</div></div>
          </div>
        </div>

        <!-- Lower Bracket -->
        <br><br> <div class="section-heading">Lower Bracket</div><br><br>
        <div class="columns">
          <div class="column">
            <div class="col-title">Lower R1</div>
            <div class="match" id="lr1"><div class="team-row">Loser QF1</div><div class="team-row">Loser QF2</div><div class="time">Sep 27</div></div>
            <div class="match" id="lr2"><div class="team-row">Loser QF3</div><div class="team-row">Loser QF4</div><div class="time">Sep 27</div></div>
          </div>
          <div class="column">
            <div class="col-title">Lower R2</div>
            <div class="match" id="lr3"><div class="team-row">Winner LR1</div><div class="team-row">Loser SF1</div><div class="time">Sep 29</div></div>
            <div class="match" id="lr4"><div class="team-row">Winner LR2</div><div class="team-row">Loser SF2</div><div class="time">Sep 29</div></div>
          </div>
          <div class="column">
            <div class="col-title">Lower R3</div>
            <div class="match" id="lr5"><div class="team-row">Winner L2 M1</div><div class="team-row">Winner L2 M2</div><div class="time">Oct 3</div></div>
          </div>
          <div class="column">
            <div class="col-title">Lower Final</div>
            <div class="match" id="lf"><div class="team-row">Winner LR3</div><div class="team-row">Loser UF</div><div class="time">Oct 4</div></div>
          </div>
        </div>
      </div>
    </div>


    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="side-title">Upcoming Matches</div>
      <div class="match-card"><div style="font-weight:700">Team Liquid vs EG</div><div class="time">7h 13m</div></div>
      <div class="match-card"><div style="font-weight:700">Xi Lai Gaming vs Sentinels</div><div class="time">10h 13m</div></div>
      <div class="match-card"><div style="font-weight:700">Bilibili vs RRQ</div><div class="time">1d 7h</div></div>
    </aside>
  </div>

  <!-- Bouncing Ball -->
  <div class="ball-container">
    <div class="ball"><div class="inner"></div></div>
    <div class="shadow"></div>
  </div>

  <!-- Mouse Tracker Ball -->
  <div class="tracker-ball" id="tracker"></div>

  <script>
    // DRAW CONNECTORS
    (function(){
      const container = document.getElementById('bracket');
      const svg = document.getElementById('connectors');
      const connections = [
        ['qf1','sf1'],['qf2','sf1'],
        ['qf3','sf2'],['qf4','sf2'],
        ['sf1','uf'],['sf2','uf'],
        ['uf','gf'],
        ['qf1','lr1'],['qf2','lr1'],
        ['qf3','lr2'],['qf4','lr2'],
        ['lr1','lr3'],['sf1','lr3'],
        ['lr2','lr4'],['sf2','lr4'],
        ['lr3','lr5'],['lr4','lr5'],
        ['lr5','lf'],['uf','lf'],
        ['lf','gf']
      ];

      function createEl(tag, attrs){
        const el = document.createElementNS('http://www.w3.org/2000/svg', tag);
        for(const k in attrs) el.setAttribute(k, attrs[k]);
        return el;
      }
      function clearSVG(){while(svg.firstChild) svg.removeChild(svg.firstChild);}
      function draw(){
        const rect = container.getBoundingClientRect();
        svg.setAttribute('width', rect.width);
        svg.setAttribute('height', rect.height);
        clearSVG();
        connections.forEach(([fromId,toId])=>{
          const from=document.getElementById(fromId), to=document.getElementById(toId);
          if(!from||!to) return;
          const f=from.getBoundingClientRect(), t=to.getBoundingClientRect();
          const sx=f.right-rect.left, sy=(f.top+f.bottom)/2-rect.top;
          const ex=t.left-rect.left, ey=(t.top+t.bottom)/2-rect.top;
          const midX=sx+Math.max(40,(ex-sx)/2);
          const d=`M${sx},${sy} L${midX},${sy} L${midX},${ey} L${ex},${ey}`;
          const color = toId.startsWith("lr")||toId==="lf" ? "var(--line-lower)" : (toId==="gf" ? "var(--line-final)" : "var(--line-upper)");
          svg.appendChild(createEl('path',{d,stroke:color,'stroke-width':2}));
        });
      }
      window.addEventListener('load',()=>setTimeout(draw,100));
      window.addEventListener('resize',()=>setTimeout(draw,100));
    })();

    // TRACKER BALL FOLLOW MOUSE
    const tracker = document.getElementById('tracker');
    document.addEventListener('mousemove', e=>{
      tracker.style.transform = `translate(${e.clientX-5}px,${e.clientY-5}px)`;
    });
  </script>
   <!-- Footer -->
  <footer>
    <div class="footer-logo">GameHub</div>
    <p class="copyright">© 2025 GameHub. All rights reserved.</p>
  </footer>
</body>
</html>
