<?php
// pubg_register.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GameHub - PUBG Registration</title>
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
      line-height:1.6;
      min-height:100vh;
      display:flex;
      flex-direction:column;
      overflow-x:hidden;
      position:relative;
    }

    /* ---------- PARTICLE BACKGROUND ---------- */
    canvas#bgParticles{
      position:fixed;
      top:0;
      left:0;
      width:100%;
      height:100%;
      z-index:-2;
    }

    /* ---------- NAV ---------- */
    .navbar{
      background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
      border-bottom:1px solid #111;
      padding:1.2rem 2rem;
      position:sticky;
      top:0;
      z-index:100;
    }
    .nav-container{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;}
    .logo{font-size:1.8rem;font-weight:800;color:var(--accent);text-shadow:0 0 8px rgba(0,229,255,0.7);}
    .nav-links{display:flex;list-style:none;}
    .nav-links li{margin-left:2.5rem;position:relative;}
    .nav-links a{text-decoration:none;color:#fff;font-weight:500;transition:color 0.3s;font-size:1.1rem;}
    .nav-links a:hover{color:var(--accent);font-weight:600;}
    .nav-links a.active{color:var(--accent);}
    .nav-links a.active::after{content:'';position:absolute;bottom:-5px;left:0;width:100%;height:2px;background-color:var(--accent);}

    /* ---------- PAGE TITLE ---------- */
    .main-content{flex:1;max-width:700px;margin:2rem auto;padding:0 2rem;width:100%;}
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
    @keyframes glow{
      from{text-shadow:0 0 12px rgba(0,229,255,0.7),0 0 20px rgba(0,229,255,0.3);}
      to{text-shadow:0 0 20px rgba(0,229,255,1),0 0 30px rgba(0,229,255,0.5);}
    }

    /* ---------- FORM ---------- */
    .registration-form{
      background:rgba(0,0,0,0.75);
      padding:2rem;
      border-radius:10px;
      box-shadow:0 5px 15px rgba(0,229,255,0.3);
      animation: fadeInUp 1s forwards;
    }
    .registration-form label{
      display:block;
      font-weight:500;
      margin-bottom:0.5rem;
      color:#ccc;
      font-size:0.95rem;
    }
    .registration-form input,
    .registration-form select{
      width:100%;
      padding:0.8rem 1rem;
      margin-bottom:1rem;
      border:none;
      border-radius:6px;
      background-color:#222;
      color:#fff;
      font-size:1rem;
    }
    .registration-form input::placeholder{color:#888;}
    .registration-form button{
      width:100%;
      padding:0.8rem 1rem;
      background-color:var(--accent);
      border:none;
      border-radius:6px;
      color:#000;
      font-size:1.1rem;
      font-weight:600;
      cursor:pointer;
      transition:background-color 0.3s;
      margin-top:0.5rem;
    }
    .registration-form button:hover{background-color:#00bcd4;}

    /* ---------- PAYMENT ---------- */
    .payment-section{
      background: #111;
      padding:1rem;
      border-radius:8px;
      text-align:center;
      margin-top:1rem;
      box-shadow:0 3px 10px rgba(0,229,255,0.25);
    }
    .payment-section img{width:180px;margin-bottom:1rem;border-radius:8px;}

    /* ---------- FOOTER ---------- */
    footer{background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);color:#fff;padding:1.2rem;text-align:center;margin-top:3rem;border-top:1px solid #111;}
    .copyright{margin-top:0.5rem;font-size:0.9rem;color:#888;}

    /* ---------- CURSOR BALL ---------- */
    .cursor-ball{position: fixed;top:0;left:0;width: var(--ball-size);height: var(--ball-size);border-radius:50%;background: var(--accent);box-shadow: var(--ball-shadow);transform: translate(-50%, -50%) scale(1);pointer-events: none; z-index: 9999;opacity:0.9;}

    /* ---------- BOUNCING BALL ---------- */
    .ball-container{position: fixed;bottom: 80px;left: 40px; z-index: 500;}
    @keyframes rotateBall {0%{transform:rotateY(0deg) rotateX(0deg);}100%{transform:rotateY(720deg) rotateX(720deg);}}
    @keyframes bounceBall {0% { transform: translateY(-70px) scale(1,1); } 45% { transform: translateY(70px) scale(1,1); } 50% { transform: translateY(75px) scale(1,0.9); } 100% { transform: translateY(-70px) scale(1,1); }}
    .ball {animation:bounceBall 1.2s infinite;border-radius:50%;height:60px;width:60px;position:relative;}
    .ball::before {background:radial-gradient(circle at 36px 20px,#00e5ff,#004466);border:2px solid #111;border-radius:50%;content:"";height:calc(100% + 6px);left:-6px;position:absolute;top:-3px;width:calc(100% + 6px);}
    .ball .inner {animation:rotateBall 25s linear infinite;border-radius:50%;height:100%;position:absolute;width:100%;}
    .shadow {animation:bounceShadow 1.2s infinite;background:black;filter:blur(2px);border-radius:50%;height:6px;width:54px;transform:translateY(73px);margin:auto;}
    @keyframes bounceShadow {0%,100% {opacity:0.6;transform:translateY(73px) scale(0.5);} 45% {opacity:0.9;transform:translateY(73px) scale(1);}}

    /* ---------- GUN BACKGROUND ---------- */
    .gun-bg{
      position:fixed;
      top:0;left:0;
      width:100%;height:100%;
      pointer-events:none;
      z-index:-1;
      overflow:hidden;
    }
    .gun-bg img{
      position:absolute;
      width:200px;
      opacity:0.05;
      animation: floatGun 20s linear infinite;
    }
    .gun1{top:10%;left:-200px;animation-delay:0s;}
    .gun2{bottom:20%;right:-200px;animation-delay:5s;}
    .gun3{top:40%;left:50%;animation-delay:10s;}
    @keyframes floatGun{
      from{transform:translateX(0);}
      to{transform:translateX(120vw);}
    }

.go-back {
  display: inline-block;
  background: #444;
  color: #fff;
  padding: 0.6rem 1.2rem;
  border-radius: 4px;
  text-decoration: none;
  font-weight: 500;
  margin-bottom: 1.5rem;
  transition: background 0.3s;
  
  /* Push fully left */
  position: relative;
  left: -55%; /* adjust this value */
}
.go-back:hover {
  background: #666;
}

  </style>

  <!-- Firebase SDK -->
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-database-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-storage-compat.js"></script>
  <!-- QR Code -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
</head>
<body>
  <canvas id="bgParticles"></canvas>
  <div class="gun-bg">
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6a/AK-47_type_II_Part_DM-ST-89-01131.png" class="gun1">
    <img src="https://upload.wikimedia.org/wikipedia/commons/8/8e/M16A1_Rifle.png" class="gun2">
    <img src="https://upload.wikimedia.org/wikipedia/commons/4/49/Heckler_%26_Koch_MP5_submachine_gun.png" class="gun3">
  </div>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="nav-container">
      <div class="logo">GameHub</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="game.php">Games</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="gamesheld.php">Games Held</a></li>
      </ul>
    </div>
  </nav>

  <!-- Main -->
  <main class="main-content">
    <a href="mobilelegends.php" class="go-back"><i class="fas fa-arrow-left"></i> Go Back to View More</a>
<h1 class="page-title">Mobile Legends Tournament Registration</h1>
 <form id="registrationForm" class="registration-form">
      <label for="team_name">Team Name</label>
      <input type="text" id="team_name" placeholder="Enter your team name" required>

      <label for="leader_name">Team Leader Name</label>
      <input type="text" id="leader_name" placeholder="Enter leader name" required>

      <label for="player2">Player 2 Name</label>
      <input type="text" id="player2" placeholder="Enter player 2 name" required>

      <label for="player3">Player 3 Name</label>
      <input type="text" id="player3" placeholder="Enter player 3 name" required>

      <label for="player4">Player 4 Name</label>
      <input type="text" id="player4" placeholder="Enter player 4 name" required>
          <label for="player4">Player 5 Name</label>
      <input type="text" id="player4" placeholder="Enter player 4 name" required>

      <label for="phone">Contact Phone</label>
      <input type="tel" id="phone" placeholder="Enter contact phone" required>

      <!-- Payment -->
      <div class="payment-section">
        <h3>💳 Pay Registration Fee</h3>
        <canvas id="qrCode"></canvas>
        <p>Scan this QR code to pay online</p>
        <label for="payment_proof">Upload Payment Proof</label>
        <input type="file" id="payment_proof" accept="image/*" required>
      </div>

      <button type="submit">Register Team</button>
    </form>
  </main>

  <!-- Bouncing Ball -->
  <div class="ball-container">
    <div class="ball"><div class="inner"></div></div>
    <div class="shadow"></div>
  </div>

  <!-- Footer -->
  <footer>
    <p>Gaming excellence since 2023</p>
    <p class="copyright">&copy; 2023 All rights reserved.</p>
  </footer>

  <!-- Cursor Ball -->
  <div class="cursor-ball" id="cursorBall"></div>

  <script>
    // Cursor follower
    const cursorBall=document.getElementById('cursorBall');
    document.addEventListener('mousemove',e=>{
      cursorBall.style.transform=`translate(${e.clientX}px,${e.clientY}px) scale(1)`;
    });

    // Particles
    const canvas=document.getElementById('bgParticles');
    const ctx=canvas.getContext('2d');
    let particlesArray;
    canvas.width=window.innerWidth;
    canvas.height=window.innerHeight;
    window.addEventListener('resize',()=>{canvas.width=window.innerWidth;canvas.height=window.innerHeight;initParticles();});
    class Particle{
      constructor(){this.x=Math.random()*canvas.width;this.y=Math.random()*canvas.height;this.size=Math.random()*3+1;this.speedX=Math.random()*1-0.5;this.speedY=Math.random()*1-0.5;}
      update(){this.x+=this.speedX;this.y+=this.speedY;if(this.x<0||this.x>canvas.width){this.speedX*=-1;}if(this.y<0||this.y>canvas.height){this.speedY*=-1;}}
      draw(){ctx.fillStyle='rgba(0,229,255,0.7)';ctx.beginPath();ctx.arc(this.x,this.y,this.size,0,Math.PI*2);ctx.fill();}
    }
    function initParticles(){particlesArray=[];for(let i=0;i<100;i++){particlesArray.push(new Particle());}}
    function animateParticles(){ctx.clearRect(0,0,canvas.width,canvas.height);particlesArray.forEach(p=>{p.update();p.draw();});requestAnimationFrame(animateParticles);}
    initParticles();animateParticles();

    // QR code
    const qr=new QRious({element:document.getElementById('qrCode'),value:'https://esewa.com.np/#/home',size:180,background:'white',foreground:'black',level:'H'});

    // Firebase
    const firebaseConfig={apiKey:"YOUR_API_KEY",authDomain:"YOUR_PROJECT_ID.firebaseapp.com",databaseURL:"https://YOUR_PROJECT_ID-default-rtdb.firebaseio.com",projectId:"YOUR_PROJECT_ID",storageBucket:"YOUR_PROJECT_ID.appspot.com",messagingSenderId:"YOUR_SENDER_ID",appId:"YOUR_APP_ID"};
    firebase.initializeApp(firebaseConfig);
    const database=firebase.database();const storage=firebase.storage();

    // Form submit
    const form=document.getElementById('registrationForm');
    const fileInput=document.getElementById('payment_proof');
    form.addEventListener('submit',e=>{
      e.preventDefault();
      const teamData={team_name:team_name.value,leader_name:leader_name.value,player2:player2.value,player3:player3.value,player4:player4.value,phone:phone.value,timestamp:new Date().toISOString()};
      const file=fileInput.files[0];
      if(file){
        const storageRef=storage.ref('payment_proofs/'+Date.now()+'_'+file.name);
        storageRef.put(file).then(snapshot=>{
          snapshot.ref.getDownloadURL().then(url=>{
            teamData.payment_proof_url=url;
            database.ref('pubg_registrations').push(teamData).then(()=>{alert('Team registered successfully!');form.reset();}).catch(err=>alert('Error: '+err.message));
          });
        });
      } else {alert('Please upload payment proof');}
    });
  </script>
</body>
</html>
