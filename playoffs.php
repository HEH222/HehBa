<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Valorant PlayOffs</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --accent: #00e5ff; /* neon cyan */
      --ball-size: 10px;
      --ball-shadow: 0 6px 18px rgba(0,229,255,0.3);
    }
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
    body{background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);color:#fff;line-height:1.6;min-height:100vh;display:flex;flex-direction:column;animation:fadeIn 1s ease;overflow-x:hidden;}
    @keyframes fadeIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}

    /* NAV */
    .navbar{background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);border-bottom:1px solid #111;padding:1.2rem 2rem;position:sticky;top:0;z-index:100;overflow:hidden;}
    .nav-container{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;}
    .logo{font-size:1.8rem;font-weight:800;color:var(--accent);text-shadow:0 0 8px rgba(0,229,255,0.7);}
    .nav-links{display:flex;list-style:none;}
    .nav-links li{margin-left:2.5rem;position:relative;}
    .nav-links a{text-decoration:none;color:#fff;font-weight:500;transition:color .3s;font-size:1.1rem;}
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

    .car{position:absolute;top:0;left:-100px;font-size:1.5rem;color:#ffcc00;animation:drive 8s linear infinite;}
    @keyframes drive{0%{left:-100px;}100%{left:110%;}}

    /* Tabs */
    .tabs{text-align:center;margin-top:20px;padding:0 20px;}
    .tabs a{margin:0 15px;text-decoration:none;color:#fff;font-weight:bold;transition:.3s;font-size:1.1rem;}
    .tabs a:hover{color:var(--accent);}
    .tabs a.active{text-decoration:underline;color:var(--accent);}

    /* Header Section */
    .page-header{display:flex;justify-content:space-between;align-items:center;padding:15px 50px;}
    .go-back-btn{display:inline-block;background:#00e5ff;color:#000;padding:8px 15px;text-decoration:none;border-radius:5px;font-weight:bold;box-shadow:0 0 10px rgba(0,229,255,0.6);transition:all 0.3s;}
    .go-back-btn:hover{background:#00b8cc;transform:translateY(-2px);}
    .page-title{flex:1;text-align:center;color:#00e5ff;font-size:1.8rem;font-weight:bold;margin:0;text-shadow:0 0 12px rgba(0,229,255,0.7);}

    /* Layout */
    .wrapper{display:flex;align-items:flex-start;padding:30px 20px;flex:1;flex-wrap:wrap;}
    .bracket-container{flex:3;min-width:300px;position:relative;}
    .sidebar{flex:1;margin-left:30px;padding:20px;background:rgba(0,0,0,0.6);border-radius:8px;box-shadow:0 5px 15px rgba(0,229,255,0.2);min-width:280px;}

    /* Bracket Styles */
    .bracket{padding:20px;position:relative;overflow:auto;}
    .columns{display:flex;gap:40px;align-items:flex-start;position:relative;min-width:1200px;}
    .column{display:flex;flex-direction:column;gap:30px;align-items:flex-start;min-width:200px;}
    .col-title{font-size:14px;margin-bottom:6px;color:var(--accent);font-weight:700;text-transform:uppercase;}

    .match{
      width:200px;
      border:1px solid #00e5ff33;
      background:rgba(0,0,0,0.6);
      border-radius:8px;
      overflow:hidden;
      animation: fadeInUp 0.8s ease both;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .match:hover{transform:scale(1.03);box-shadow:0 6px 15px rgba(0,229,255,0.5);}
    .team-row{display:flex;align-items:center;gap:10px;padding:8px 10px;font-size:13px;color:#fff;}
    .team-row + .team-row{border-top:1px solid #00e5ff22;}
    .time{font-size:12px;color:#ddd;padding:6px 10px 10px;}

    /* SVG overlay */
    #connectors{position:absolute;left:0;top:0;width:100%;height:100%;pointer-events:none;z-index:0;}
    #connectors path{fill:none;stroke-linejoin:round;stroke-linecap:round;opacity:.9;stroke-dasharray:600;stroke-dashoffset:600;animation:drawLine 2.2s ease forwards;}

    /* Animations */
    @keyframes fadeInUp{0%{opacity:0;transform:translateY(20px);}100%{opacity:1;transform:translateY(0);} }
    @keyframes drawLine{from{stroke-dasharray:600;stroke-dashoffset:600;}to{stroke-dashoffset:0;}}

    /* Sidebar cards */
    .side-title{background:rgba(255,255,255,0.1);padding:8px 10px;font-weight:700;margin:-20px -20px 12px -20px;text-transform:uppercase;font-size:13px;border-bottom:1px solid #333;}
    .match-card{background:rgba(0,0,0,0.5);padding:10px;border:1px solid #00e5ff33;border-radius:6px;margin-bottom:12px;transition:.3s;animation:fadeInUp .9s ease both;}
    .match-card:hover{transform:translateY(-5px) scale(1.02);box-shadow:0 6px 14px rgba(0,229,255,0.5);}
    .match-card .time{color:#ccc;font-size:12px;}

    /* Section Headings */
    .section-heading {
      font-size: 18px;
      color: var(--accent);
      margin-bottom: 20px;
      font-weight: bold;
      text-transform: uppercase;
      text-shadow: 0 0 6px rgba(0,229,255,0.7);
    }

    footer{background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);color:#fff;padding:1.2rem;text-align:center;border-top:1px solid #111;margin-top:2rem;}
    .cursor-ball{position:fixed;top:0;left:0;width:var(--ball-size);height:var(--ball-size);border-radius:50%;background:var(--accent);box-shadow:var(--ball-shadow);pointer-events:none;z-index:9999;opacity:.9;transform:translate(-50%,-50%);transition:transform .15s ease-out;}
    .ball-container{position:fixed;bottom:80px;right:40px;z-index:500;}
    @keyframes rotateBall{0%{transform:rotateY(0) rotateX(0);}100%{transform:rotateY(720deg) rotateX(720deg);}}
    @keyframes bounceBall{0%{transform:translateY(-70px) scale(1,1);}45%{transform:translateY(70px) scale(1,1);}50%{transform:translateY(75px) scale(1,.9);}100%{transform:translateY(-70px) scale(1,1);}}
    .ball{animation:bounceBall 1.2s infinite;border-radius:50%;height:60px;width:60px;position:relative;}
    .ball::before{background:radial-gradient(circle at 36px 20px,#00e5ff,#004466);border:2px solid #111;border-radius:50%;content:"";height:calc(100% + 6px);left:-6px;position:absolute;top:-3px;width:calc(100% + 6px);}
    .ball .inner{animation:rotateBall 25s linear infinite;border-radius:50%;height:100%;position:absolute;width:100%;}
    .shadow{animation:bounceShadow 1.2s infinite;background:black;filter:blur(2px);border-radius:50%;height:6px;width:54px;transform:translateY(73px);margin:auto;}
    @keyframes bounceShadow{0%,100%{opacity:.6;transform:translateY(73px) scale(.5);}45%{opacity:.9;transform:translateY(73px) scale(1);}}

    /* Loading indicator */
    .loading {
      text-align: center;
      padding: 20px;
      color: var(--accent);
    }

    /* Responsive Design */
    @media (max-width: 768px){
      .nav-links{display:none;}
      .mobile-nav-toggle{display:block;}
      .mobile-nav{display:block;}
      .navbar{padding:1rem 1.5rem;}
      .logo{font-size:1.5rem;}
      
      .page-header{padding:15px 20px;flex-direction:column;gap:15px;}
      .page-title{font-size:1.5rem;order:-1;}
      
      .wrapper{padding:20px 15px;flex-direction:column;}
      .sidebar{margin-left:0;margin-top:30px;width:100%;}
      
      .bracket-container{
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: var(--accent) transparent;
        position: relative;
      }
      
      .bracket-container::-webkit-scrollbar {
        height: 8px;
      }
      
      .bracket-container::-webkit-scrollbar-track {
        background: transparent;
      }
      
      .bracket-container::-webkit-scrollbar-thumb {
        background-color: var(--accent);
        border-radius: 4px;
      }
      
      /* Fix for connectors in mobile view */
      #connectors {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        min-width: 1200px;
      }
      
      .bracket {
        position: relative;
      }
      
      .columns {
        min-width: 1000px;
        gap: 30px;
      }
      
      .match {
        width: 180px;
      }
      
      .team-row {
        font-size: 12px;
        padding: 6px 8px;
      }
      
      .time {
        font-size: 11px;
        padding: 4px 8px 8px;
      }
      
      .col-title {
        font-size: 12px;
      }
      
      .section-heading {
        font-size: 16px;
      }
      
      .tabs a{margin:0 10px;font-size:1rem;}
      
      .ball-container{bottom:20px;right:20px;}
      .ball,.shadow{transform:scale(0.8);}
    }

    @media (max-width: 576px){
      .page-title{font-size:1.4rem;}
      .section-heading{font-size:1.2rem;}
      
      .columns {
        min-width: 900px;
        gap: 25px;
      }
      
      .match {
        width: 160px;
      }
      
      .team-row {
        font-size: 11px;
        padding: 5px 6px;
      }
      
      .time {
        font-size: 10px;
        padding: 3px 6px 6px;
      }
      
      .col-title {
        font-size: 11px;
      }
      
      .sidebar{padding:15px;}
      .tabs a{display:inline-block;margin:0 10px;}
    }

    @media (max-width: 480px){
      .columns {
        min-width: 800px;
        gap: 20px;
      }
      
      .match {
        width: 150px;
      }
      
      .team-row {
        font-size: 10px;
        padding: 4px 5px;
      }
      
      .time {
        font-size: 9px;
        padding: 2px 5px 5px;
      }
      
      .match {
        padding: 12px 0;
        gap: 0;
      }
    }
  </style>
</head>
<body>
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
      <li><a href="game.php" class="active">Games</a></li>
      <li><a href="contact.php">Contact us</a></li>
      <li><a href="about.php">About us</a></li>
      <li><a href="gamesheld.php">Games held</a></li>
    </ul>
  </div>

  <!-- Go Back Button + Title -->
  <div class="page-header">
    <a href="valo_tiesheet.php" class="go-back-btn">
      <i class="fas fa-arrow-left"></i> Go Back
    </a>
    <h1 class="page-title">Valorant PlayOffs</h1>
    <div style="width:80px;"></div> <!-- Spacer for alignment -->
  </div>

  <!-- Tabs -->
  <div class="tabs">
    <a href="valo_tiesheet.php">Group Stage</a>
    <a href="playoffs.php" class="active">PlayOffs</a>
  </div>
  
  <!-- Wrapper -->
  <div class="wrapper">
    <!-- Bracket Container -->
    <div class="bracket-container">
      <div class="bracket" id="bracket">
        <svg id="connectors" xmlns="http://www.w3.org/2000/svg"></svg>

        <!-- Upper Bracket -->
        <div class="section-heading">Upper Bracket</div>
        <div class="columns" id="upperBracket">
          <div class="loading">Loading bracket data...</div>
        </div>

        <!-- Lower Bracket -->
        <div class="section-heading">Lower Bracket</div>
        <div class="columns" id="lowerBracket">
          <div class="loading">Loading bracket data...</div>
        </div>
      </div>
    </div>
    
    <!-- Sidebar -->
    <div class="sidebar">
      <section>
        <h4 class="side-title">Upcoming Matches</h4>
        <div id="upcomingMatches">
          <div class="loading">Loading upcoming matches...</div>
        </div>
      </section>
    </div>
  </div>

  <!-- Bouncing Ball -->
  <div class="ball-container">
    <div class="ball"><div class="inner"></div></div>
    <div class="shadow"></div>
  </div>

  <footer>
    <div class="footer-logo">HehKali Esports</div>
    <p class="copyright">© 2023 HehKali Esports. All rights reserved.</p>
  </footer>

  <!-- Firebase + Data injection -->
  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js";
    import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-database.js";

    // Mobile navigation functionality
    const mobileNavToggle = document.getElementById('mobileNavToggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileNavOverlay = document.getElementById('mobileNavOverlay');

    mobileNavToggle.addEventListener('click', () => {
      mobileNav.classList.toggle('active');
      mobileNavOverlay.classList.toggle('active');
    });

    mobileNavOverlay.addEventListener('click', () => {
      mobileNav.classList.remove('active');
      mobileNavOverlay.classList.remove('active');
    });

    document.querySelectorAll('.mobile-nav a').forEach(link => {
      link.addEventListener('click', () => {
        mobileNav.classList.remove('active');
        mobileNavOverlay.classList.remove('active');
      });
    });

    // Your Firebase configuration
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
    const app = initializeApp(firebaseConfig);
    const db = getDatabase(app);
    
    // References to database locations
    const upperBracketRef = ref(db, "valorant-playoffs/upperBracket");
    const lowerBracketRef = ref(db, "valorant-playoffs/lowerBracket");
    const upcomingMatchesRef = ref(db, "valorant-playoffs/upcomingMatches");
    
    // DOM elements
    const upperBracketDiv = document.getElementById("upperBracket");
    const lowerBracketDiv = document.getElementById("lowerBracket");
    const upcomingMatchesDiv = document.getElementById("upcomingMatches");

    // Match IDs for connectors (must match the original IDs)
    const matchIds = {
      quarterfinals: ['qf1', 'qf2', 'qf3', 'qf4'],
      semifinals: ['sf1', 'sf2'],
      upperFinal: ['uf'],
      grandFinal: ['gf'],
      lowerR1: ['lr1', 'lr2'],
      lowerR2: ['lr3', 'lr4'],
      lowerR3: ['lr5'],
      lowerFinal: ['lf']
    };

    // Load upper bracket data
    onValue(upperBracketRef, (snapshot) => {
      const data = snapshot.val();
      upperBracketDiv.innerHTML = "";

      if (!data) {
        upperBracketDiv.innerHTML = "<div class='loading'>No upper bracket data available</div>";
        return;
      }

      // Quarterfinals Column
      const quarterfinalsCol = document.createElement("div");
      quarterfinalsCol.className = "column";
      quarterfinalsCol.innerHTML = `<div class="col-title">Quarterfinals</div>`;
      
      const quarterfinals = Object.values(data.quarterfinals || {});
      quarterfinals.forEach((match, index) => {
        const matchDiv = document.createElement("div");
        matchDiv.className = "match";
        matchDiv.id = matchIds.quarterfinals[index];
        matchDiv.innerHTML = `
          <div class="team-row">${match.team1 || "TBD"}</div>
          <div class="team-row">${match.team2 || "TBD"}</div>
          <div class="time">${match.time || "TBD"}</div>
        `;
        quarterfinalsCol.appendChild(matchDiv);
      });
      upperBracketDiv.appendChild(quarterfinalsCol);

      // Semifinals Column
      const semifinalsCol = document.createElement("div");
      semifinalsCol.className = "column";
      semifinalsCol.innerHTML = `<div class="col-title">Semifinals</div>`;
      
      const semifinals = Object.values(data.semifinals || {});
      semifinals.forEach((match, index) => {
        const matchDiv = document.createElement("div");
        matchDiv.className = "match";
        matchDiv.id = matchIds.semifinals[index];
        matchDiv.innerHTML = `
          <div class="team-row">${match.team1 || "TBD"}</div>
          <div class="team-row">${match.team2 || "TBD"}</div>
          <div class="time">${match.time || "TBD"}</div>
        `;
        semifinalsCol.appendChild(matchDiv);
      });
      upperBracketDiv.appendChild(semifinalsCol);

      // Upper Final Column
      const upperFinalCol = document.createElement("div");
      upperFinalCol.className = "column";
      upperFinalCol.innerHTML = `<div class="col-title">Upper Final</div>`;
      
      if (data.upperFinal) {
        const matchDiv = document.createElement("div");
        matchDiv.className = "match";
        matchDiv.id = matchIds.upperFinal[0];
        matchDiv.innerHTML = `
          <div class="team-row">${data.upperFinal.team1 || "TBD"}</div>
          <div class="team-row">${data.upperFinal.team2 || "TBD"}</div>
          <div class="time">${data.upperFinal.time || "TBD"}</div>
        `;
        upperFinalCol.appendChild(matchDiv);
      }
      upperBracketDiv.appendChild(upperFinalCol);

      // Grand Final Column
      const grandFinalCol = document.createElement("div");
      grandFinalCol.className = "column";
      grandFinalCol.innerHTML = `<div class="col-title">Grand Final</div>`;
      
      if (data.grandFinal) {
        const matchDiv = document.createElement("div");
        matchDiv.className = "match";
        matchDiv.id = matchIds.grandFinal[0];
        matchDiv.innerHTML = `
          <div class="team-row">${data.grandFinal.team1 || "TBD"}</div>
          <div class="team-row">${data.grandFinal.team2 || "TBD"}</div>
          <div class="time">${data.grandFinal.time || "TBD"}</div>
        `;
        grandFinalCol.appendChild(matchDiv);
      }
      upperBracketDiv.appendChild(grandFinalCol);

      // Redraw connectors after data loads
      setTimeout(drawConnectors, 100);
    });

    // Load lower bracket data
    onValue(lowerBracketRef, (snapshot) => {
      const data = snapshot.val();
      lowerBracketDiv.innerHTML = "";

      if (!data) {
        lowerBracketDiv.innerHTML = "<div class='loading'>No lower bracket data available</div>";
        return;
      }

      // Lower R1 Column
      const lowerR1Col = document.createElement("div");
      lowerR1Col.className = "column";
      lowerR1Col.innerHTML = `<div class="col-title">Lower R1</div>`;
      
      const lowerR1 = Object.values(data.lowerR1 || {});
      lowerR1.forEach((match, index) => {
        const matchDiv = document.createElement("div");
        matchDiv.className = "match";
        matchDiv.id = matchIds.lowerR1[index];
        matchDiv.innerHTML = `
          <div class="team-row">${match.team1 || "TBD"}</div>
          <div class="team-row">${match.team2 || "TBD"}</div>
          <div class="time">${match.time || "TBD"}</div>
        `;
        lowerR1Col.appendChild(matchDiv);
      });
      lowerBracketDiv.appendChild(lowerR1Col);

      // Lower R2 Column
      const lowerR2Col = document.createElement("div");
      lowerR2Col.className = "column";
      lowerR2Col.innerHTML = `<div class="col-title">Lower R2</div>`;
      
      const lowerR2 = Object.values(data.lowerR2 || {});
      lowerR2.forEach((match, index) => {
        const matchDiv = document.createElement("div");
        matchDiv.className = "match";
        matchDiv.id = matchIds.lowerR2[index];
        matchDiv.innerHTML = `
          <div class="team-row">${match.team1 || "TBD"}</div>
          <div class="team-row">${match.team2 || "TBD"}</div>
          <div class="time">${match.time || "TBD"}</div>
        `;
        lowerR2Col.appendChild(matchDiv);
      });
      lowerBracketDiv.appendChild(lowerR2Col);

      // Lower R3 Column
      const lowerR3Col = document.createElement("div");
      lowerR3Col.className = "column";
      lowerR3Col.innerHTML = `<div class="col-title">Lower R3</div>`;
      
      if (data.lowerR3) {
        const lowerR3 = Object.values(data.lowerR3 || {});
        lowerR3.forEach((match, index) => {
          const matchDiv = document.createElement("div");
          matchDiv.className = "match";
          matchDiv.id = matchIds.lowerR3[index];
          matchDiv.innerHTML = `
            <div class="team-row">${match.team1 || "TBD"}</div>
            <div class="team-row">${match.team2 || "TBD"}</div>
            <div class="time">${match.time || "TBD"}</div>
          `;
          lowerR3Col.appendChild(matchDiv);
        });
      }
      lowerBracketDiv.appendChild(lowerR3Col);

      // Lower Final Column
      const lowerFinalCol = document.createElement("div");
      lowerFinalCol.className = "column";
      lowerFinalCol.innerHTML = `<div class="col-title">Lower Final</div>`;
      
      if (data.lowerFinal) {
        const matchDiv = document.createElement("div");
        matchDiv.className = "match";
        matchDiv.id = matchIds.lowerFinal[0];
        matchDiv.innerHTML = `
          <div class="team-row">${data.lowerFinal.team1 || "TBD"}</div>
          <div class="team-row">${data.lowerFinal.team2 || "TBD"}</div>
          <div class="time">${data.lowerFinal.time || "TBD"}</div>
        `;
        lowerFinalCol.appendChild(matchDiv);
      }
      lowerBracketDiv.appendChild(lowerFinalCol);

      // Redraw connectors after data loads
      setTimeout(drawConnectors, 100);
    });

    // Load upcoming matches data
    onValue(upcomingMatchesRef, (snapshot) => {
      const data = snapshot.val();
      upcomingMatchesDiv.innerHTML = "";
      
      if (!data) {
        upcomingMatchesDiv.innerHTML = "<div class='loading'>No upcoming matches</div>";
        return;
      }
      
      Object.values(data).forEach(match => {
        const matchCard = document.createElement("div");
        matchCard.className = "match-card";
        matchCard.innerHTML = `
          <div style="font-weight:700">${match.teams || "TBD vs TBD"}</div>
          <div class="time">${match.time || "TBD"}</div>
        `;
        upcomingMatchesDiv.appendChild(matchCard);
      });
    });

    // DRAW CONNECTORS - UPDATED FOR MOBILE
    function drawConnectors(){
      const container = document.getElementById('bracket');
      const svg = document.getElementById('connectors');
      
      // Define all connections between matches
      const connections = [
        // Upper bracket connections
        ['qf1','sf1'],['qf2','sf1'],
        ['qf3','sf2'],['qf4','sf2'],
        ['sf1','uf'],['sf2','uf'],
        ['uf','gf'],
        
        // Lower bracket connections
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
      
      function clearSVG(){
        while(svg.firstChild) svg.removeChild(svg.firstChild);
      }
      
      // Get the actual visible container dimensions
      const containerRect = container.getBoundingClientRect();
      const scrollLeft = container.scrollLeft;
      
      // Set SVG dimensions to match the full scrollable width
      svg.setAttribute('width', container.scrollWidth);
      svg.setAttribute('height', containerRect.height);
      clearSVG();
      
      connections.forEach(([fromId,toId])=>{
        const from = document.getElementById(fromId);
        const to = document.getElementById(toId);
        
        if(!from || !to) return;
        
        const f = from.getBoundingClientRect();
        const t = to.getBoundingClientRect();
        
        // Calculate positions relative to the container, accounting for scroll
        const sx = f.right - containerRect.left + scrollLeft;
        const sy = (f.top + f.bottom) / 2 - containerRect.top;
        const ex = t.left - containerRect.left + scrollLeft;
        const ey = (t.top + t.bottom) / 2 - containerRect.top;
        
        const midX = sx + Math.max(40, (ex - sx) / 2);
        const d = `M${sx},${sy} L${midX},${sy} L${midX},${ey} L${ex},${ey}`;
        
        const color = toId.startsWith("lr") || toId === "lf" ? "var(--accent)" : 
                     (toId === "gf" ? "var(--accent)" : "var(--accent)");
        
        const path = createEl('path', {
          d: d,
          stroke: color,
          'stroke-width': 2,
          'stroke-dasharray': 600,
          'stroke-dashoffset': 600
        });
        
        svg.appendChild(path);
        
        // Animate the path drawing
        setTimeout(() => {
          path.style.strokeDashoffset = "0";
        }, 100);
      });
    }

    // Redraw connectors on load and resize
    window.addEventListener('load', () => setTimeout(drawConnectors, 500));
    window.addEventListener('resize', () => setTimeout(drawConnectors, 100));

    // ADD SCROLL EVENT LISTENER TO REDRAW CONNECTORS ON SCROLL
    const bracketContainer = document.querySelector('.bracket-container');
    if (bracketContainer) {
      bracketContainer.addEventListener('scroll', () => {
        setTimeout(drawConnectors, 50);
      });
    }

    // Cursor animation
    const cursorBall = document.querySelector('.cursor-ball');
    document.addEventListener('mousemove', e => {
      cursorBall.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
    });
  </script>
</body>
</html>