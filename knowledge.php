<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Drift - Cyber Racing</title>
    <style>
        body {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            background: #000;
            font-family: 'Courier New', monospace;
            overflow: hidden;
            color: #00ffff;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
            -webkit-tap-highlight-color: transparent;
        }

        #gameContainer {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: radial-gradient(ellipse at center, #001122 0%, #000000 100%);
        }

        #gameCanvas {
            display: block;
            background: transparent;
        }

        #ui {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }

        #hud {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .hud-panel {
            background: rgba(0, 255, 255, 0.1);
            border: 1px solid #00ffff;
            padding: 10px 15px;
            border-radius: 5px;
            backdrop-filter: blur(5px);
        }

        .hud-value {
            font-size: 18px;
            font-weight: bold;
            color: #00ffff;
            text-shadow: 0 0 10px #00ffff;
        }

        .hud-label {
            font-size: 12px;
            color: #66cccc;
            margin-bottom: 5px;
        }

        #stabilityBar {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            width: 300px;
            height: 20px;
            background: rgba(255, 0, 0, 0.3);
            border: 2px solid #ff0000;
            border-radius: 10px;
            overflow: hidden;
        }

        #stabilityFill {
            height: 100%;
            background: linear-gradient(90deg, #ff0000, #ffff00, #00ff00);
            transition: width 0.1s ease;
            border-radius: 8px;
        }

        #instructions {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            color: #66cccc;
            font-size: 14px;
        }

        #gameOver {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.9);
            border: 2px solid #00ffff;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            display: none;
            pointer-events: all;
        }

        #gameOver h2 {
            color: #00ffff;
            margin-top: 0;
            text-shadow: 0 0 20px #00ffff;
        }

        #restartBtn {
            background: linear-gradient(45deg, #00ffff, #0088ff);
            border: none;
            color: #000;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        #restartBtn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px #00ffff;
        }

        .boost-indicator {
            position: absolute;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            color: #ffff00;
            font-size: 16px;
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.3s ease;
            text-shadow: 0 0 10px #ffff00;
        }

        .boost-indicator.active {
            opacity: 1;
        }

        #objectGuide {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 30px;
            background: rgba(0, 0, 0, 0.8);
            padding: 15px 25px;
            border-radius: 10px;
            border: 1px solid #00ffff;
        }

        .guide-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #00ffff;
            font-size: 14px;
            font-weight: bold;
        }

        .guide-icon {
            width: 30px;
            height: 20px;
            border-radius: 3px;
            position: relative;
        }

        .firewall-icon {
            background: linear-gradient(45deg, #ff0000, #ff4444);
            border: 2px solid #ff4444;
        }

        .firewall-icon::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            right: 2px;
            bottom: 2px;
            background: repeating-linear-gradient(
                45deg,
                #ffff00,
                #ffff00 2px,
                transparent 2px,
                transparent 4px
            );
        }

        .buffer-icon {
            background: #00ff88;
            border: 2px solid #88ffaa;
            transform: rotate(45deg);
        }

        #backBtn {
            background: rgba(0, 255, 255, 0.2);
            border: 1px solid #00ffff;
            color: #00ffff;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 8px;
            transition: all 0.3s ease;
            pointer-events: all;
        }

        #backBtn:hover {
            background: rgba(0, 255, 255, 0.4);
            transform: scale(1.05);
        }

        #educationModal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.95);
            border: 2px solid #00ffff;
            padding: 30px;
            border-radius: 15px;
            max-width: 600px;
            width: 90%;
            text-align: center;
            display: none;
            pointer-events: all;
            z-index: 100;
        }

        #educationModal h2 {
            color: #00ffff;
            margin-top: 0;
            text-shadow: 0 0 20px #00ffff;
            font-size: 24px;
        }

        #educationContent {
            color: #66cccc;
            font-size: 16px;
            line-height: 1.6;
            margin: 20px 0;
        }

        #educationMotivation {
            color: #ffff00;
            font-style: italic;
            font-size: 14px;
            margin: 15px 0;
            padding: 15px;
            background: rgba(255, 255, 0, 0.1);
            border-radius: 8px;
            border-left: 4px solid #ffff00;
        }

        #continueBtn {
            background: linear-gradient(45deg, #00ff88, #00ccaa);
            border: none;
            color: #000;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        #continueBtn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px #00ff88;
        }

        #levelIndicator {
            position: absolute;
            top: 120px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 255, 255, 0.1);
            border: 1px solid #00ffff;
            padding: 10px 20px;
            border-radius: 8px;
            color: #00ffff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="gameContainer">
        <canvas id="gameCanvas"></canvas>
        
        <div id="ui">
            <div id="hud">
                <div class="hud-panel">
                    <div class="hud-label">TIME</div>
                    <div class="hud-value" id="timeDisplay">0.0s</div>
                    <button id="backBtn" onclick="window.location.href='gamesh.php'">← BACK</button>
                </div>
                <div class="hud-panel">
                    <div class="hud-label">SCORE</div>
                    <div class="hud-value" id="scoreDisplay">0</div>
                </div>
                <div class="hud-panel">
                    <div class="hud-label">BUFFERS</div>
                    <div class="hud-value" id="buffersDisplay">0</div>
                </div>
                <div class="hud-panel">
                    <div class="hud-label">MULTIPLIER</div>
                    <div class="hud-value" id="multiplierDisplay">1.0x</div>
                </div>
            </div>

            <div id="stabilityBar">
                <div id="stabilityFill"></div>
            </div>

            <div class="boost-indicator" id="boostIndicator">BOOST ACTIVE</div>

            <div id="objectGuide">
                <div class="guide-item">
                    <div class="guide-icon firewall-icon"></div>
                    <span>FIREWALL - AVOID</span>
                </div>
                <div class="guide-item">
                    <div class="guide-icon buffer-icon"></div>
                    <span>BUFFER - COLLECT</span>
                </div>
            </div>

            <div id="instructions">
                ARROW KEYS: Steer | SPACE: Boost (drains stability)
            </div>

            <div id="levelIndicator">
                Level <span id="currentLevelDisplay">0</span> - <span id="levelTitle">Starting Point</span>
            </div>

            <div id="educationModal">
                <h2 id="educationTitle">Welcome to Data Drift!</h2>
                <div id="educationContent">Loading...</div>
                <div id="educationMotivation">Get ready to learn!</div>
                <button id="continueBtn">Continue Journey</button>
            </div>

            <div id="gameOver">
                <h2>Data Transfer Complete!</h2>
                <div id="finalStats"></div>
                <button id="restartBtn">Restart Transmission</button>
            </div>
        </div>
    </div>

    <script>
        // Page protection - disable right-click, F12, and other developer tools
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        document.addEventListener('keydown', function(e) {
            // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U, Ctrl+S
            if (e.keyCode === 123 || 
                (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74)) ||
                (e.ctrlKey && (e.keyCode === 85 || e.keyCode === 83))) {
                e.preventDefault();
                return false;
            }
        });

        // Disable text selection
        document.onselectstart = function() {
            return false;
        };

        // Disable drag
        document.ondragstart = function() {
            return false;
        };

        // Clear console periodically
        setInterval(function() {
            console.clear();
        }, 1000);

        // Detect developer tools
        let devtools = {
            open: false,
            orientation: null
        };

        const threshold = 160;

        setInterval(function() {
            if (window.outerHeight - window.innerHeight > threshold || 
                window.outerWidth - window.innerWidth > threshold) {
                if (!devtools.open) {
                    devtools.open = true;
                    // Redirect away if dev tools detected
                    window.location.href = 'about:blank';
                }
            } else {
                devtools.open = false;
            }
        }, 500);

        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');
        
        // Set canvas size
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        // Educational content for finishing lines
        const educationalContent = [
            {
                title: "Welcome to Data Drift!",
                content: "You are a data packet traveling through the internet! Your mission is to reach your destination safely while avoiding security threats and collecting helpful resources.",
                motivation: "Every click, every message, every video - they all travel as data packets just like you!"
            },
            {
                title: "What is a Firewall?",
                content: "Firewalls are security systems that monitor and control network traffic. They act like digital guards, blocking suspicious or unauthorized data from entering a network.",
                motivation: "Just like security guards at a building, firewalls protect computers from cyber threats!"
            },
            {
                title: "Network Protocols - TCP/IP",
                content: "TCP/IP is the foundation of internet communication. TCP ensures reliable delivery while IP handles addressing and routing. Together they make sure your data gets where it needs to go.",
                motivation: "Without TCP/IP, there would be no internet as we know it - it's the universal language of networks!"
            },
            {
                title: "Data Packets & Routing",
                content: "Large files are broken into small packets that travel independently through the network, then reassembled at the destination. Routers help find the best path.",
                motivation: "It's like sending a puzzle through multiple mail routes - all pieces arrive and get put back together!"
            },
            {
                title: "Network Security Basics",
                content: "Networks use encryption, authentication, and monitoring to protect data. Security is like having locks, ID checks, and security cameras for your digital information.",
                motivation: "Your personal data deserves protection - security keeps your digital life safe!"
            },
            {
                title: "Internet Infrastructure",
                content: "The internet is a network of networks connected by fiber optic cables, satellites, and wireless signals spanning the globe. Data centers store and process information.",
                motivation: "You're part of the largest machine humanity has ever built - the global internet!"
            },
            {
                title: "DNS - Domain Name System",
                content: "DNS translates human-readable domain names (like google.com) into IP addresses that computers understand. It's like the internet's phone book.",
                motivation: "Without DNS, you'd have to remember IP addresses like 172.217.164.110 instead of google.com!"
            },
            {
                title: "HTTP vs HTTPS",
                content: "HTTP transfers web pages, while HTTPS adds encryption for security. The 'S' stands for Secure - look for the lock icon in your browser!",
                motivation: "Always use HTTPS for sensitive information - it protects your passwords and personal data from eavesdroppers!"
            },
            {
                title: "Network Topologies",
                content: "Networks can be arranged in different patterns: star (central hub), mesh (interconnected), ring (circular), or bus (linear). Each has advantages for different situations.",
                motivation: "Understanding network design helps you appreciate why some connections are faster and more reliable than others!"
            },
            {
                title: "Wireless Networks - WiFi",
                content: "WiFi uses radio waves to connect devices without cables. Different standards (802.11a/b/g/n/ac/ax) offer varying speeds and ranges.",
                motivation: "WiFi freed us from cables and enabled mobile computing - imagine life without wireless internet!"
            },
            {
                title: "Network Switches & Hubs",
                content: "Switches intelligently forward data only to intended recipients, while older hubs broadcast to all connected devices. Switches are more secure and efficient.",
                motivation: "Smart networking equipment makes the internet faster and more secure for everyone!"
            },
            {
                title: "VPN - Virtual Private Networks",
                content: "VPNs create secure, encrypted tunnels over public networks. They protect your privacy and allow secure remote access to private networks.",
                motivation: "VPNs are essential for privacy and security, especially on public WiFi - they're your digital invisibility cloak!"
            },
            {
                title: "Cybersecurity Threats",
                content: "Common threats include malware, phishing, DDoS attacks, and social engineering. Understanding these helps you stay safe online.",
                motivation: "Knowledge is your best defense - recognizing threats protects you and others from cybercriminals!"
            },
            {
                title: "Encryption & Cryptography",
                content: "Encryption scrambles data so only authorized parties can read it. Public key cryptography allows secure communication without sharing secret keys.",
                motivation: "Encryption protects everything from your messages to your bank transactions - it's the foundation of digital trust!"
            },
            {
                title: "Network Monitoring & Analysis",
                content: "Network administrators use tools like Wireshark to monitor traffic, detect problems, and ensure security. It's like having X-ray vision for networks.",
                motivation: "Network analysis skills are highly valued in IT careers - you become a digital detective!"
            },
            {
                title: "Cloud Computing Networks",
                content: "Cloud services rely on massive networks connecting data centers worldwide. Your data might travel thousands of miles in milliseconds.",
                motivation: "The cloud revolutionized computing - understanding it opens doors to modern IT careers!"
            },
            {
                title: "Internet of Things (IoT)",
                content: "IoT connects everyday objects to the internet - from smart thermostats to industrial sensors. This creates new opportunities and security challenges.",
                motivation: "IoT is transforming how we live and work - billions of connected devices are creating a smarter world!"
            },
            {
                title: "Network Performance & QoS",
                content: "Quality of Service (QoS) prioritizes important traffic like video calls over less critical data. It ensures smooth performance for time-sensitive applications.",
                motivation: "QoS makes video calls clear and games responsive - it's why your Netflix doesn't buffer during peak hours!"
            },
            {
                title: "Network Redundancy & Failover",
                content: "Critical networks have backup paths and systems. If one route fails, traffic automatically switches to alternatives, ensuring continuous connectivity.",
                motivation: "Redundancy keeps the internet running 24/7 - it's why you rarely lose connection completely!"
            },
            {
                title: "Software-Defined Networking (SDN)",
                content: "SDN separates network control from hardware, allowing centralized management and programmable networks. It makes networks more flexible and efficient.",
                motivation: "SDN is revolutionizing networking - it's like having a smart traffic control system for data!"
            },
            {
                title: "Network Virtualization",
                content: "Virtual networks run multiple logical networks on the same physical infrastructure. It's like having multiple highways on the same road.",
                motivation: "Virtualization maximizes efficiency and enables cloud computing - it's the foundation of modern data centers!"
            },
            {
                title: "5G & Mobile Networks",
                content: "5G offers ultra-fast speeds, low latency, and massive device connectivity. It enables new applications like autonomous vehicles and remote surgery.",
                motivation: "5G is enabling the next generation of technology - from smart cities to augmented reality!"
            },
            {
                title: "Network Automation",
                content: "Modern networks use automation to configure, monitor, and troubleshoot themselves. AI and machine learning help predict and prevent problems.",
                motivation: "Network automation reduces errors and frees IT professionals to focus on innovation rather than routine tasks!"
            },
            {
                title: "Edge Computing",
                content: "Edge computing processes data closer to where it's generated, reducing latency and bandwidth usage. It's crucial for real-time applications.",
                motivation: "Edge computing enables instant responses for autonomous vehicles and AR/VR - bringing computation to where it's needed!"
            },
            {
                title: "Network Security Architecture",
                content: "Defense in depth uses multiple security layers: perimeter firewalls, internal segmentation, endpoint protection, and monitoring. No single point of failure.",
                motivation: "Layered security is like having multiple locks on your house - if one fails, others protect you!"
            },
            {
                title: "Zero Trust Networks",
                content: "Zero Trust assumes no user or device is trustworthy by default. Every access request is verified, regardless of location or previous authentication.",
                motivation: "Zero Trust is the future of security - 'never trust, always verify' protects against modern threats!"
            },
            {
                title: "Network Forensics",
                content: "Digital forensics investigates network incidents, tracking attackers and understanding breaches. It's like CSI for cybercrimes.",
                motivation: "Network forensics helps catch cybercriminals and prevent future attacks - you could be a digital detective!"
            },
            {
                title: "Quantum Networking",
                content: "Quantum networks use quantum mechanics for ultra-secure communication. Quantum key distribution makes eavesdropping physically impossible.",
                motivation: "Quantum networking represents the future of secure communication - it's like having unbreakable codes!"
            },
            {
                title: "Network Career Paths",
                content: "Network careers include network engineer, security analyst, cloud architect, and cybersecurity specialist. The field offers excellent growth and salary potential.",
                motivation: "Networking skills are in high demand - you could build a rewarding career protecting and connecting the digital world!"
            },
            {
                title: "Congratulations, Network Master!",
                content: "You've completed an epic journey through computer networking! From basic packets to quantum networks, you now understand how our connected world works.",
                motivation: "You're now a networking expert! Use this knowledge to pursue IT careers, make better technology decisions, and help build the future of connectivity!"
            }
        ];

        // Game state
        let gameState = {
            player: {
                x: canvas.width / 2,
                y: canvas.height * 0.8,
                speed: 0,
                maxSpeed: 8,
                stability: 100,
                maxStability: 100,
                size: 15,
                trail: []
            },
            camera: {
                zoom: 1,
                targetZoom: 1,
                shake: 0
            },
            obstacles: [],
            buffers: [],
            particles: [],
            tunnel: {
                segments: [],
                width: 400,
                position: 0
            },
            finishLines: [],
            currentLevel: 0,
            levelDistance: 8000,
            distanceTraveled: 0,
            score: 0,
            time: 0,
            bufferCount: 0,
            multiplier: 1.0,
            multiplierTimer: 0,
            gameRunning: true,
            keys: {},
            boosting: false,
            showingEducation: false,
            educationTimer: 0
        };

        // Input handling
        document.addEventListener('keydown', (e) => {
            gameState.keys[e.code] = true;
            if (e.code === 'Space') {
                e.preventDefault();
                gameState.boosting = true;
            }
        });

        document.addEventListener('keyup', (e) => {
            gameState.keys[e.code] = false;
            if (e.code === 'Space') {
                gameState.boosting = false;
            }
        });

        // Generate tunnel segments
        function generateTunnelSegment(y) {
            return {
                y: y,
                leftWall: canvas.width / 2 - gameState.tunnel.width / 2 + Math.sin(y * 0.01) * 100,
                rightWall: canvas.width / 2 + gameState.tunnel.width / 2 + Math.sin(y * 0.01) * 100,
                glow: Math.random() * 0.5 + 0.5
            };
        }

        // Initialize tunnel
        for (let i = 0; i < 50; i++) {
            gameState.tunnel.segments.push(generateTunnelSegment(i * 20));
        }

        // Generate finish lines
        function generateFinishLine(level) {
            return {
                y: -level * gameState.levelDistance,
                level: level,
                crossed: false,
                particles: []
            };
        }

        // Initialize finish lines
        for (let i = 0; i <= 30; i++) {
            gameState.finishLines.push(generateFinishLine(i));
        }

        // Spawn obstacle
        function spawnObstacle() {
            if (Math.random() < 0.02) {
                const segment = gameState.tunnel.segments[Math.floor(Math.random() * 20)];
                gameState.obstacles.push({
                    x: segment.leftWall + Math.random() * (segment.rightWall - segment.leftWall - 60) + 30,
                    y: -50,
                    width: 60,
                    height: 30,
                    type: 'firewall',
                    glow: 1
                });
            }
        }

        // Spawn buffer
        function spawnBuffer() {
            if (Math.random() < 0.015) {
                const segment = gameState.tunnel.segments[Math.floor(Math.random() * 20)];
                gameState.buffers.push({
                    x: segment.leftWall + Math.random() * (segment.rightWall - segment.leftWall - 20) + 10,
                    y: -30,
                    size: 20,
                    rotation: 0,
                    collected: false
                });
            }
        }

        // Create particles
        function createParticles(x, y, count, color, speed = 2) {
            for (let i = 0; i < count; i++) {
                gameState.particles.push({
                    x: x + (Math.random() - 0.5) * 20,
                    y: y + (Math.random() - 0.5) * 20,
                    vx: (Math.random() - 0.5) * speed * 2,
                    vy: (Math.random() - 0.5) * speed * 2,
                    color: color,
                    life: 1,
                    decay: 0.02 + Math.random() * 0.02,
                    size: Math.random() * 4 + 2
                });
            }
        }

        // Check collision
        function checkCollision(rect1, rect2) {
            return rect1.x < rect2.x + rect2.width &&
                   rect1.x + rect1.width > rect2.x &&
                   rect1.y < rect2.y + rect2.height &&
                   rect1.y + rect1.height > rect2.y;
        }

        // Update game
        function update(deltaTime) {
            if (!gameState.gameRunning) return;

            gameState.time += deltaTime;

            // Player movement
            const player = gameState.player;
            
            // Steering
            if (gameState.keys['ArrowLeft'] || gameState.keys['KeyA']) {
                player.x -= 5;
            }
            if (gameState.keys['ArrowRight'] || gameState.keys['KeyD']) {
                player.x += 5;
            }

            // Boosting
            if (gameState.boosting && player.stability > 0) {
                player.speed = Math.min(player.speed + 0.5, player.maxSpeed * 1.8);
                player.stability -= 60 * deltaTime;
                gameState.camera.targetZoom = 1.3;
                
                // Boost particles
                if (Math.random() < 0.3) {
                    createParticles(player.x, player.y + 10, 2, '#ffff00', 3);
                }
            } else {
                player.speed = Math.min(player.speed + 0.2, player.maxSpeed);
                player.stability = Math.min(player.stability + 30 * deltaTime, player.maxStability);
                gameState.camera.targetZoom = 1;
            }

            // Update boost indicator
            const boostIndicator = document.getElementById('boostIndicator');
            boostIndicator.classList.toggle('active', gameState.boosting && player.stability > 0);

            // Camera zoom
            gameState.camera.zoom += (gameState.camera.targetZoom - gameState.camera.zoom) * 0.1;

            // Move everything down
            const scrollSpeed = player.speed;
            gameState.distanceTraveled += scrollSpeed;
            
            // Update tunnel
            gameState.tunnel.segments.forEach(segment => {
                segment.y += scrollSpeed;
            });

            // Update finish lines
            gameState.finishLines.forEach(finishLine => {
                finishLine.y += scrollSpeed;
                
                // Check if player crossed finish line
                if (!finishLine.crossed && finishLine.y >= player.y - 50 && finishLine.y <= player.y + 50) {
                    finishLine.crossed = true;
                    gameState.currentLevel = finishLine.level;
                    
                    // Create celebration particles
                    createParticles(canvas.width / 2, finishLine.y, 20, '#00ff88', 5);
                    
                    // Show education content
                    if (finishLine.level < educationalContent.length) {
                        showEducation(finishLine.level);
                    }
                    
                    // Bonus points for reaching checkpoint
                    gameState.score += 1000 * (finishLine.level + 1);
                }
            });

            // Remove old segments and add new ones
            gameState.tunnel.segments = gameState.tunnel.segments.filter(segment => segment.y < canvas.height + 100);
            while (gameState.tunnel.segments.length < 50) {
                const lastY = gameState.tunnel.segments[gameState.tunnel.segments.length - 1]?.y || 0;
                gameState.tunnel.segments.push(generateTunnelSegment(lastY - 20));
            }

            // Update obstacles
            gameState.obstacles.forEach(obstacle => {
                obstacle.y += scrollSpeed;
                obstacle.glow = Math.sin(gameState.time * 0.01) * 0.3 + 0.7;
            });

            // Update buffers
            gameState.buffers.forEach(buffer => {
                buffer.y += scrollSpeed;
                buffer.rotation += 0.1;
            });

            // Update particles
            gameState.particles.forEach(particle => {
                particle.x += particle.vx;
                particle.y += particle.vy;
                particle.life -= particle.decay;
            });

            // Remove old objects
            gameState.obstacles = gameState.obstacles.filter(obstacle => obstacle.y < canvas.height + 50);
            gameState.buffers = gameState.buffers.filter(buffer => buffer.y < canvas.height + 50 && !buffer.collected);
            gameState.particles = gameState.particles.filter(particle => particle.life > 0);

            // Spawn new objects
            spawnObstacle();
            spawnBuffer();

            // Collision detection
            const playerRect = {
                x: player.x - player.size,
                y: player.y - player.size,
                width: player.size * 2,
                height: player.size * 2
            };

            // Check obstacle collisions
            gameState.obstacles.forEach(obstacle => {
                const obstacleRect = {
                    x: obstacle.x - obstacle.width / 2,
                    y: obstacle.y - obstacle.height / 2,
                    width: obstacle.width,
                    height: obstacle.height
                };

                if (checkCollision(playerRect, obstacleRect)) {
                    // Hit obstacle
                    player.stability -= 40;
                    gameState.camera.shake = 10;
                    createParticles(player.x, player.y, 8, '#ff4444', 4);
                    
                    // Remove obstacle
                    obstacle.y = canvas.height + 100;
                }
            });

            // Check buffer collisions
            gameState.buffers.forEach(buffer => {
                if (!buffer.collected) {
                    const distance = Math.sqrt(
                        Math.pow(player.x - buffer.x, 2) + 
                        Math.pow(player.y - buffer.y, 2)
                    );

                    if (distance < player.size + buffer.size / 2) {
                        buffer.collected = true;
                        gameState.bufferCount++;
                        gameState.score += 100 * gameState.multiplier;
                        player.stability = Math.min(player.stability + 20, player.maxStability);
                        createParticles(buffer.x, buffer.y, 6, '#00ff88', 3);
                    }
                }
            });

            // Check tunnel collisions (walls)
            const currentSegment = gameState.tunnel.segments.find(segment => 
                Math.abs(segment.y - player.y) < 20
            );

            if (currentSegment) {
                if (player.x < currentSegment.leftWall + player.size || 
                    player.x > currentSegment.rightWall - player.size) {
                    player.stability -= 80 * deltaTime;
                    gameState.camera.shake = Math.max(gameState.camera.shake, 5);
                    
                    if (Math.random() < 0.1) {
                        createParticles(player.x, player.y, 3, '#ff8800', 2);
                    }
                }
            }

            // Update multiplier
            if (gameState.multiplierTimer > 0) {
                gameState.multiplierTimer -= deltaTime;
                gameState.multiplier = Math.max(1, gameState.multiplierTimer * 0.1 + 1);
            } else {
                gameState.multiplier = 1;
            }

            // Add score over time
            gameState.score += Math.floor(player.speed * gameState.multiplier * deltaTime);

            // Camera shake decay
            gameState.camera.shake *= 0.9;

            // Check game over
            if (player.stability <= 0) {
                gameState.gameRunning = false;
                showGameOver();
            }

            // Update UI
            updateUI();
        }

        // Render game
        function render() {
            // Clear canvas
            ctx.fillStyle = '#000011';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Apply camera effects
            ctx.save();
            
            // Camera shake
            if (gameState.camera.shake > 0) {
                ctx.translate(
                    (Math.random() - 0.5) * gameState.camera.shake,
                    (Math.random() - 0.5) * gameState.camera.shake
                );
            }

            // Camera zoom
            const zoom = gameState.camera.zoom;
            ctx.translate(canvas.width / 2, canvas.height / 2);
            ctx.scale(zoom, zoom);
            ctx.translate(-canvas.width / 2, -canvas.height / 2);

            // Render tunnel
            ctx.strokeStyle = '#00ffff';
            ctx.lineWidth = 3;
            ctx.shadowColor = '#00ffff';
            ctx.shadowBlur = 10;

            for (let i = 0; i < gameState.tunnel.segments.length - 1; i++) {
                const segment = gameState.tunnel.segments[i];
                const nextSegment = gameState.tunnel.segments[i + 1];

                // Left wall
                ctx.beginPath();
                ctx.moveTo(segment.leftWall, segment.y);
                ctx.lineTo(nextSegment.leftWall, nextSegment.y);
                ctx.globalAlpha = segment.glow;
                ctx.stroke();

                // Right wall
                ctx.beginPath();
                ctx.moveTo(segment.rightWall, segment.y);
                ctx.lineTo(nextSegment.rightWall, nextSegment.y);
                ctx.stroke();
            }

            ctx.globalAlpha = 1;
            ctx.shadowBlur = 0;

            // Render obstacles (firewalls)
            gameState.obstacles.forEach(obstacle => {
                ctx.fillStyle = `rgba(255, 0, 0, ${obstacle.glow})`;
                ctx.strokeStyle = '#ff4444';
                ctx.lineWidth = 2;
                ctx.shadowColor = '#ff0000';
                ctx.shadowBlur = 15;

                ctx.fillRect(
                    obstacle.x - obstacle.width / 2,
                    obstacle.y - obstacle.height / 2,
                    obstacle.width,
                    obstacle.height
                );

                ctx.strokeRect(
                    obstacle.x - obstacle.width / 2,
                    obstacle.y - obstacle.height / 2,
                    obstacle.width,
                    obstacle.height
                );

                // Firewall pattern
                ctx.fillStyle = '#ffff00';
                for (let i = 0; i < 3; i++) {
                    for (let j = 0; j < 2; j++) {
                        ctx.fillRect(
                            obstacle.x - obstacle.width / 2 + i * 20 + 5,
                            obstacle.y - obstacle.height / 2 + j * 15 + 5,
                            10,
                            5
                        );
                    }
                }
            });

            // Render buffers
            gameState.buffers.forEach(buffer => {
                if (!buffer.collected) {
                    ctx.save();
                    ctx.translate(buffer.x, buffer.y);
                    ctx.rotate(buffer.rotation);

                    ctx.fillStyle = '#00ff88';
                    ctx.strokeStyle = '#88ffaa';
                    ctx.lineWidth = 2;
                    ctx.shadowColor = '#00ff88';
                    ctx.shadowBlur = 10;

                    // Diamond shape
                    ctx.beginPath();
                    ctx.moveTo(0, -buffer.size / 2);
                    ctx.lineTo(buffer.size / 2, 0);
                    ctx.lineTo(0, buffer.size / 2);
                    ctx.lineTo(-buffer.size / 2, 0);
                    ctx.closePath();
                    ctx.fill();
                    ctx.stroke();

                    ctx.restore();
                }
            });

            // Render finish lines
            gameState.finishLines.forEach(finishLine => {
                if (finishLine.y > -100 && finishLine.y < canvas.height + 100) {
                    const segment = gameState.tunnel.segments.find(s => Math.abs(s.y - finishLine.y) < 50);
                    if (segment) {
                        // Finish line glow effect
                        ctx.strokeStyle = finishLine.crossed ? '#00ff88' : '#ffff00';
                        ctx.lineWidth = 8;
                        ctx.shadowColor = finishLine.crossed ? '#00ff88' : '#ffff00';
                        ctx.shadowBlur = 20;
                        
                        // Draw finish line
                        ctx.beginPath();
                        ctx.moveTo(segment.leftWall, finishLine.y);
                        ctx.lineTo(segment.rightWall, finishLine.y);
                        ctx.stroke();
                        
                        // Level number
                        ctx.fillStyle = finishLine.crossed ? '#00ff88' : '#ffff00';
                        ctx.font = 'bold 24px Courier New';
                        ctx.textAlign = 'center';
                        ctx.fillText(
                            `LEVEL ${finishLine.level}`,
                            (segment.leftWall + segment.rightWall) / 2,
                            finishLine.y - 10
                        );
                        
                        // Animated particles on finish line
                        if (!finishLine.crossed) {
                            for (let i = 0; i < 5; i++) {
                                const x = segment.leftWall + (segment.rightWall - segment.leftWall) * (i / 4);
                                const sparkle = Math.sin(gameState.time * 0.01 + i) * 0.5 + 0.5;
                                ctx.fillStyle = `rgba(255, 255, 0, ${sparkle})`;
                                ctx.beginPath();
                                ctx.arc(x, finishLine.y, 4, 0, Math.PI * 2);
                                ctx.fill();
                            }
                        }
                    }
                }
            });

            // Render particles
            gameState.particles.forEach(particle => {
                ctx.fillStyle = particle.color;
                ctx.globalAlpha = particle.life;
                ctx.shadowColor = particle.color;
                ctx.shadowBlur = 5;

                ctx.beginPath();
                ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
                ctx.fill();
            });

            ctx.globalAlpha = 1;
            ctx.shadowBlur = 0;

            // Render player
            const player = gameState.player;
            ctx.save();
            ctx.translate(player.x, player.y);

            // Player glow
            ctx.shadowColor = '#00ffff';
            ctx.shadowBlur = 20;

            // Main body
            ctx.fillStyle = gameState.boosting ? '#ffff00' : '#00ffff';
            ctx.beginPath();
            ctx.arc(0, 0, player.size, 0, Math.PI * 2);
            ctx.fill();

            // Core
            ctx.fillStyle = '#ffffff';
            ctx.beginPath();
            ctx.arc(0, 0, player.size * 0.6, 0, Math.PI * 2);
            ctx.fill();

            // Data streams
            ctx.strokeStyle = gameState.boosting ? '#ffff00' : '#00ffff';
            ctx.lineWidth = 3;
            for (let i = 0; i < 4; i++) {
                const angle = (gameState.time * 0.01 + i * Math.PI / 2);
                const x1 = Math.cos(angle) * player.size * 0.8;
                const y1 = Math.sin(angle) * player.size * 0.8;
                const x2 = Math.cos(angle) * player.size * 1.3;
                const y2 = Math.sin(angle) * player.size * 1.3;

                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
            }

            ctx.restore();
            ctx.restore();
        }

        // Show education content
        function showEducation(level) {
            if (level >= educationalContent.length) return;
            
            const content = educationalContent[level];
            gameState.showingEducation = true;
            gameState.gameRunning = false;
            
            document.getElementById('educationTitle').textContent = content.title;
            document.getElementById('educationContent').textContent = content.content;
            document.getElementById('educationMotivation').textContent = content.motivation;
            document.getElementById('educationModal').style.display = 'block';
        }

        // Continue from education
        document.getElementById('continueBtn').addEventListener('click', () => {
            gameState.showingEducation = false;
            gameState.gameRunning = true;
            document.getElementById('educationModal').style.display = 'none';
        });

        // Update UI
        function updateUI() {
            document.getElementById('timeDisplay').textContent = gameState.time.toFixed(1) + 's';
            document.getElementById('scoreDisplay').textContent = Math.floor(gameState.score).toLocaleString();
            document.getElementById('buffersDisplay').textContent = gameState.bufferCount;
            document.getElementById('multiplierDisplay').textContent = gameState.multiplier.toFixed(1) + 'x';
            document.getElementById('currentLevelDisplay').textContent = gameState.currentLevel;
            
            // Update level title
            if (gameState.currentLevel < educationalContent.length) {
                document.getElementById('levelTitle').textContent = educationalContent[gameState.currentLevel].title;
            } else {
                document.getElementById('levelTitle').textContent = 'Network Master!';
            }

            const stabilityPercent = (gameState.player.stability / gameState.player.maxStability) * 100;
            document.getElementById('stabilityFill').style.width = stabilityPercent + '%';
        }

        // Show game over
        function showGameOver() {
            const finalScore = Math.floor(gameState.score);
            const timeBonus = Math.floor(1000 / Math.max(gameState.time, 1));
            const bufferBonus = gameState.bufferCount * 500;
            const totalScore = finalScore + timeBonus + bufferBonus;

            document.getElementById('finalStats').innerHTML = `
                <div style="margin: 15px 0; color: #66cccc;">
                    <div>Base Score: ${finalScore.toLocaleString()}</div>
                    <div>Time Bonus: ${timeBonus.toLocaleString()}</div>
                    <div>Buffer Bonus: ${bufferBonus.toLocaleString()}</div>
                    <div style="border-top: 1px solid #00ffff; margin-top: 10px; padding-top: 10px; color: #00ffff; font-size: 18px;">
                        Total Score: ${totalScore.toLocaleString()}
                    </div>
                </div>
            `;

            document.getElementById('gameOver').style.display = 'block';
        }

        // Restart game
        document.getElementById('restartBtn').addEventListener('click', () => {
            // Reset game state
            gameState = {
                player: {
                    x: canvas.width / 2,
                    y: canvas.height * 0.8,
                    speed: 0,
                    maxSpeed: 8,
                    stability: 100,
                    maxStability: 100,
                    size: 15,
                    trail: []
                },
                camera: {
                    zoom: 1,
                    targetZoom: 1,
                    shake: 0
                },
                obstacles: [],
                buffers: [],
                particles: [],
                tunnel: {
                    segments: [],
                    width: 400,
                    position: 0
                },
                finishLines: [],
                currentLevel: 0,
                levelDistance: 8000,
                distanceTraveled: 0,
                score: 0,
                time: 0,
                bufferCount: 0,
                multiplier: 1.0,
                multiplierTimer: 0,
                gameRunning: true,
                keys: {},
                boosting: false,
                showingEducation: false,
                educationTimer: 0
            };

            // Regenerate tunnel
            for (let i = 0; i < 50; i++) {
                gameState.tunnel.segments.push(generateTunnelSegment(i * 20));
            }

            // Regenerate finish lines
            for (let i = 0; i <= 30; i++) {
                gameState.finishLines.push(generateFinishLine(i));
            }

            document.getElementById('gameOver').style.display = 'none';
            document.getElementById('educationModal').style.display = 'none';
        });

        // Game loop
        let lastTime = 0;
        function gameLoop(currentTime) {
            const deltaTime = (currentTime - lastTime) / 1000;
            lastTime = currentTime;

            update(deltaTime);
            render();

            requestAnimationFrame(gameLoop);
        }

        // Show initial education
        setTimeout(() => {
            showEducation(0);
        }, 1000);

        // Start game
        requestAnimationFrame(gameLoop);
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'98f5c83cf62c8e57',t:'MTc2MDU5OTEwNi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
