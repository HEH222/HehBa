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

    /* Layout */
    .wrapper{display:flex;align-items:flex-start;padding:30px 20px;flex:1;flex-wrap:wrap;}
    .groups{flex:3;min-width:300px;}
    .group{margin-bottom:40px;}
    .group h3{margin-bottom:10px;color:var(--accent);font-size:18px;text-shadow:0 0 6px rgba(0,229,255,0.7);}
    .match{display:flex;align-items:center;margin-bottom:20px;flex-wrap:nowrap;overflow-x:auto;padding:10px 0;}
    .team-box{border:1px solid #00e5ff55;padding:5px 15px;width:100px;text-align:center;margin:2px 0;background:rgba(0,229,255,0.08);border-radius:5px;transition:transform .2s,background .3s,box-shadow .3s;flex-shrink:0;}
    .team-box:hover{transform:scale(1.05);background:rgba(0,229,255,0.2);box-shadow:0 0 10px rgba(0,229,255,0.6);}
    .connector{width:40px;height:2px;background:#00e5ff44;margin:0 10px;flex-shrink:0;}
    .next-box{border:1px solid #00e5ff55;padding:10px;width:120px;text-align:center;background:rgba(0,229,255,0.08);border-radius:5px;flex-shrink:0;}
    .next-box .line{height:2px;background:#00e5ff33;margin:5px 0;}
    .qualified{border:1px solid #00e5ff88;padding:10px;margin-left:10px;width:100px;text-align:center;background:rgba(0,229,255,0.25);border-radius:5px;font-weight:bold;box-shadow:0 0 10px rgba(0,229,255,0.5);flex-shrink:0;}
    .sidebar{flex:1;margin-left:30px;padding:20px;background:rgba(0,0,0,0.6);border-radius:8px;box-shadow:0 5px 15px rgba(0,229,255,0.2);min-width:280px;}
    .sidebar section{margin-bottom:30px;}
    .sidebar section h4{border-bottom:1px solid #00e5ff55;padding-bottom:8px;margin-bottom:15px;font-size:16px;color:var(--accent);text-shadow:0 0 6px rgba(0,229,255,0.7);}
    .sidebar .match-card,.latest-match-card{background:rgba(0,0,0,0.75);padding:12px;margin-bottom:12px;border-radius:5px;text-align:center;transition:transform .3s,box-shadow .3s;cursor:pointer;border:1px solid #00e5ff33;}
    .sidebar .match-card:hover,.latest-match-card:hover{transform:scale(1.05);box-shadow:0 0 15px var(--accent);}
    .latest-match-card .vs{color:var(--accent);font-weight:bold;}
    .score-box{background:#111;color:#fff;padding:6px 12px;border-radius:6px;font-weight:bold;min-width:40px;text-align:center;border:2px solid var(--accent);}
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

    /* Header Section */
    .page-header{display:flex;justify-content:space-between;align-items:center;padding:15px 50px;}
    .go-back-btn{display:inline-block;background:#00e5ff;color:#000;padding:8px 15px;text-decoration:none;border-radius:5px;font-weight:bold;box-shadow:0 0 10px rgba(0,229,255,0.6);transition:all 0.3s;}
    .go-back-btn:hover{background:#00b8cc;transform:translateY(-2px);}
    .page-title{flex:1;text-align:center;color:#00e5ff;font-size:1.8rem;font-weight:bold;margin:0;text-shadow:0 0 12px rgba(0,229,255,0.7);}

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
      
      .match{
        justify-content:flex-start;
        gap:0;
        padding:15px 0;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        scrollbar-width:thin;
        scrollbar-color:var(--accent) transparent;
      }
      
      .match::-webkit-scrollbar {
        height:6px;
      }
      
      .match::-webkit-scrollbar-track {
        background:transparent;
      }
      
      .match::-webkit-scrollbar-thumb {
        background-color:var(--accent);
        border-radius:3px;
      }
      
      .team-box, .next-box, .qualified{
        flex-shrink:0;
      }
      
      .connector{
        flex-shrink:0;
        display:block !important;
      }
      
      .tabs a{margin:0 10px;font-size:1rem;}
      
      .ball-container{bottom:20px;right:20px;}
      .ball,.shadow{transform:scale(0.8);}
    }

    @media (max-width: 576px){
      .page-title{font-size:1.4rem;}
      .group h3{font-size:1.2rem;}
      .team-box, .next-box, .qualified{
        width:90px;
        padding:8px 10px;
        font-size:0.9rem;
      }
      .connector{
        width:30px;
        margin:0 8px;
      }
      .sidebar{padding:15px;}
      .tabs a{display:inline-block;margin:0 10px;}
    }

    @media (max-width: 480px){
      .team-box, .next-box, .qualified{
        width:85px;
        padding:6px 8px;
        font-size:0.85rem;
      }
      .connector{
        width:25px;
        margin:0 6px;
      }
      .match{
        padding:12px 0;
        gap:0;
      }
    }

    @media (max-width: 380px){
      .team-box, .next-box, .qualified{
        width:80px;
        padding:5px 6px;
        font-size:0.8rem;
      }
      .connector{
        width:20px;
        margin:0 4px;
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
    <a href="view more.php" class="go-back-btn">
      <i class="fas fa-arrow-left"></i> Go Back
    </a>
    <h1 class="page-title">Valorant</h1>
    <div style="width:80px;"></div> <!-- Spacer for alignment -->
  </div>

  <!-- Tabs -->
  <div class="tabs">
    <a href="valo_tiesheet.php" class="active">Group Stage</a>
    <a href="playoffs.php">PlayOffs</a>
  </div>
  
  <!-- Wrapper -->
  <div class="wrapper">
    <!-- Groups Section -->
    <div class="groups" id="groups">
      <div class="loading">Loading tournament data...</div>
    </div>
    
    <!-- Sidebar -->
    <div class="sidebar">
      <section>
        <h4>Latest Match</h4>
        <div class="latest-match-card" id="latest-match">
          <div class="loading">Loading latest match...</div>
        </div>
      </section>
      <section>
        <h4>Upcoming Matches</h4>
        <div id="upcoming-matches">
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
    const groupsRef = ref(db, "valorant/groups");
    const latestMatchRef = ref(db, "valorant/latestMatch");
    const upcomingMatchesRef = ref(db, "valorant/upcomingMatches");
    
    // DOM elements
    const groupsDiv = document.getElementById("groups");
    const latestMatchDiv = document.getElementById("latest-match");
    const upcomingMatchesDiv = document.getElementById("upcoming-matches");

    // Load groups data
    onValue(groupsRef, (snapshot) => {
      const data = snapshot.val();
      groupsDiv.innerHTML = "";

      if (!data) {
        groupsDiv.innerHTML = "<div class='loading'>No group data available</div>";
        return;
      }

      for (const groupName in data) {
        const groupData = data[groupName];
        const matches = Object.values(groupData);

        let groupHTML = `<div class="group"><h3>${groupName}</h3>`;

        matches.forEach(match => {
          const teams = match.teams ? Object.values(match.teams) : [];
          const next = match.next ? Object.values(match.next) : ["", ""];
          const qualified = match.qualified || "";

          groupHTML += `
            <div class="match">
              <div>
                ${teams.map(team => `<div class='team-box'>${team}</div>`).join("")}
              </div>
              <div class="connector"></div>
              <div class="next-box">
                <div class="team-top">${next[0] || ""}</div>
                <div class="line"></div>
                <div class="team-bottom">${next[1] || ""}</div>
              </div>
              <div class="connector"></div>
              <div class="qualified">${qualified}</div>
            </div>
          `;
        });

        groupHTML += `</div>`;
        groupsDiv.innerHTML += groupHTML;
      }
    });

    // Load latest match data
    onValue(latestMatchRef, (snapshot) => {
      const data = snapshot.val();
      
      if (!data) {
        latestMatchDiv.innerHTML = "<div class='loading'>No latest match data</div>";
        return;
      }
      
      latestMatchDiv.innerHTML = `
        <div class="teams">
          <span>${data.team1 || "TBD"}</span>
          <div class="score-box">${data.score1 || "0"}</div>
        </div>
        <div class="vs">VS</div>
        <div class="teams">
          <span>${data.team2 || "TBD"}</span>
          <div class="score-box">${data.score2 || "0"}</div>
        </div>
        <div class="time">${data.status || "Finished"} • ${data.date || "Today"}</div>
      `;
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
          <div class="teams">${match.team1 || "TBD"} vs ${match.team2 || "TBD"}</div>
          <div class="time">${match.date || "TBD"} • ${match.time || "TBD"}</div>
        `;
        upcomingMatchesDiv.appendChild(matchCard);
      });
    });

    // Cursor animation
    const cursorBall = document.querySelector('.cursor-ball');
    document.addEventListener('mousemove', e => {
      cursorBall.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
    });
  </script>
</body>
</html>