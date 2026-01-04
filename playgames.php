<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solar System Explorer</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(ellipse at center, #1a1a2e 0%, #0f0f23 100%);
            overflow: hidden;
            color: white;
        }
        
        #gameContainer {
            position: relative;
            width: 100vw;
            height: 100vh;
        }
        
        #canvas {
            display: block;
            cursor: grab;
        }
        
        #canvas:active {
            cursor: grabbing;
        }
        
        .ui-panel {
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 20px;
            color: white;
            font-size: 14px;
            max-width: 300px;
        }
        
        #infoPanel {
            top: 20px;
            left: 20px;
        }
        
        #controlsPanel {
            bottom: 20px;
            left: 20px;
        }
        
        #statsPanel {
            top: 20px;
            right: 20px;
        }
        
        .panel-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #64ffda;
        }
        
        .control-group {
            margin-bottom: 15px;
        }
        
        .control-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .control-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            color: white;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .btn.active {
            background: linear-gradient(135deg, #64ffda 0%, #4fc3f7 100%);
            color: #000;
        }
        
        .speed-control {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .speed-slider {
            flex: 1;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            outline: none;
            -webkit-appearance: none;
        }
        
        .speed-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            background: #64ffda;
            border-radius: 50%;
            cursor: pointer;
        }
        
        .celestial-info {
            background: rgba(100, 255, 218, 0.1);
            border: 1px solid rgba(100, 255, 218, 0.3);
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }
        
        .celestial-name {
            font-size: 16px;
            font-weight: 600;
            color: #64ffda;
            margin-bottom: 10px;
        }
        
        .celestial-stats {
            display: grid;
            gap: 8px;
        }
        
        .stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stat-label {
            font-weight: 500;
            opacity: 0.8;
        }
        
        .stat-value {
            font-weight: 600;
            color: #64ffda;
        }
        
        .stars {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle 3s infinite;
        }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }
        
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-size: 18px;
            color: #64ffda;
        }
    </style>
</head>
<body>
    <div id="gameContainer">
        <div class="stars" id="stars"></div>
        <canvas id="canvas"></canvas>
        
        <div id="infoPanel" class="ui-panel">
            <div class="panel-title">🚀 Solar System Explorer</div>
            <p>Navigate through space and discover the wonders of our solar system!</p>
            
            <div class="celestial-info" id="selectedBodyInfo" style="display: none;">
                <div class="celestial-name" id="bodyName">Earth</div>
                <div class="celestial-stats">
                    <div class="stat-row">
                        <span class="stat-label">Distance from Sun:</span>
                        <span class="stat-value" id="distanceFromSun">149.6M km</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Orbital Period:</span>
                        <span class="stat-value" id="orbitalPeriod">365.25 days</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Diameter:</span>
                        <span class="stat-value" id="diameter">12,742 km</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Mass:</span>
                        <span class="stat-value" id="mass">5.97 × 10²⁴ kg</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="controlsPanel" class="ui-panel">
            <div class="panel-title">🎮 Controls</div>
            
            <div class="control-group">
                <span class="control-label">Navigation:</span>
                <div class="control-buttons">
                    <button class="btn" id="focusEarth">🌍 Earth</button>
                    <button class="btn" id="focusMoon">🌙 Moon</button>
                    <button class="btn" id="focusMars">🔴 Mars</button>
                    <button class="btn" id="focusSun">☀️ Sun</button>
                </div>
            </div>
            
            <div class="control-group">
                <span class="control-label">View Mode:</span>
                <div class="control-buttons">
                    <button class="btn active" id="freeCamera">Free Camera</button>
                    <button class="btn" id="followMode">Follow Mode</button>
                </div>
            </div>
            
            <div class="control-group">
                <span class="control-label">Time Speed:</span>
                <div class="speed-control">
                    <span>Slow</span>
                    <input type="range" class="speed-slider" id="timeSpeed" min="0.1" max="5" step="0.1" value="1">
                    <span>Fast</span>
                </div>
                <div style="text-align: center; margin-top: 5px; font-size: 12px; opacity: 0.8;">
                    Speed: <span id="speedDisplay">1.0x</span>
                </div>
            </div>
        </div>
        
        <div id="statsPanel" class="ui-panel">
            <div class="panel-title">📊 Real-time Data</div>
            <div class="celestial-stats">
                <div class="stat-row">
                    <span class="stat-label">Camera Distance:</span>
                    <span class="stat-value" id="cameraDistance">1000 km</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Simulation Time:</span>
                    <span class="stat-value" id="simTime">Day 1</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Earth-Moon Distance:</span>
                    <span class="stat-value" id="earthMoonDist">384,400 km</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Earth-Mars Distance:</span>
                    <span class="stat-value" id="earthMarsDist">225M km</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        class SolarSystemExplorer {
            constructor() {
                this.canvas = document.getElementById('canvas');
                this.ctx = this.canvas.getContext('2d');
                this.setupCanvas();
                
                // Camera properties
                this.camera = {
                    x: 0,
                    y: 0,
                    zoom: 1,
                    targetX: 0,
                    targetY: 0,
                    targetZoom: 1,
                    following: null
                };
                
                // Time and physics
                this.time = 0;
                this.timeSpeed = 1;
                this.paused = false;
                
                // Celestial bodies data
                this.bodies = this.initializeBodies();
                this.selectedBody = null;
                
                // Input handling
                this.mouse = { x: 0, y: 0, down: false, lastX: 0, lastY: 0 };
                this.setupEventListeners();
                this.setupUI();
                
                // Start animation
                this.createStarField();
                this.animate();
            }
            
            setupCanvas() {
                this.canvas.width = window.innerWidth;
                this.canvas.height = window.innerHeight;
                
                window.addEventListener('resize', () => {
                    this.canvas.width = window.innerWidth;
                    this.canvas.height = window.innerHeight;
                });
            }
            
            initializeBodies() {
                const AU = 150; // Astronomical Unit in pixels (scaled down)
                
                return {
                    sun: {
                        name: 'Sun',
                        x: 0, y: 0,
                        radius: 20,
                        color: '#FDB813',
                        mass: 1.989e30,
                        realRadius: 696340,
                        distanceFromSun: 0,
                        orbitalPeriod: 0,
                        info: {
                            diameter: '1.39M km',
                            mass: '1.989 × 10³⁰ kg',
                            temperature: '5,778 K'
                        }
                    },
                    earth: {
                        name: 'Earth',
                        x: AU, y: 0,
                        radius: 8,
                        color: '#6B93D6',
                        mass: 5.972e24,
                        realRadius: 6371,
                        distanceFromSun: 149.6e6,
                        orbitalPeriod: 365.25,
                        orbitalSpeed: 0.01,
                        angle: 0,
                        orbitRadius: AU,
                        info: {
                            diameter: '12,742 km',
                            mass: '5.97 × 10²⁴ kg',
                            atmosphere: '78% N₂, 21% O₂'
                        }
                    },
                    moon: {
                        name: 'Moon',
                        x: AU + 30, y: 0,
                        radius: 3,
                        color: '#C0C0C0',
                        mass: 7.342e22,
                        realRadius: 1737,
                        distanceFromEarth: 384400,
                        orbitalPeriod: 27.3,
                        orbitalSpeed: 0.1,
                        angle: 0,
                        orbitRadius: 30,
                        parent: 'earth',
                        info: {
                            diameter: '3,474 km',
                            mass: '7.34 × 10²² kg',
                            gravity: '1.62 m/s²'
                        }
                    },
                    mars: {
                        name: 'Mars',
                        x: AU * 1.5, y: 0,
                        radius: 6,
                        color: '#CD5C5C',
                        mass: 6.39e23,
                        realRadius: 3390,
                        distanceFromSun: 227.9e6,
                        orbitalPeriod: 687,
                        orbitalSpeed: 0.008,
                        angle: Math.PI,
                        orbitRadius: AU * 1.5,
                        info: {
                            diameter: '6,779 km',
                            mass: '6.39 × 10²³ kg',
                            atmosphere: '95% CO₂'
                        }
                    }
                };
            }
            
            setupEventListeners() {
                // Mouse controls
                this.canvas.addEventListener('mousedown', (e) => {
                    this.mouse.down = true;
                    this.mouse.lastX = e.clientX;
                    this.mouse.lastY = e.clientY;
                });
                
                this.canvas.addEventListener('mousemove', (e) => {
                    if (this.mouse.down && !this.camera.following) {
                        const deltaX = e.clientX - this.mouse.lastX;
                        const deltaY = e.clientY - this.mouse.lastY;
                        
                        this.camera.targetX -= deltaX / this.camera.zoom;
                        this.camera.targetY -= deltaY / this.camera.zoom;
                    }
                    
                    this.mouse.lastX = e.clientX;
                    this.mouse.lastY = e.clientY;
                    
                    // Check for body hover
                    this.checkBodyHover(e.clientX, e.clientY);
                });
                
                this.canvas.addEventListener('mouseup', () => {
                    this.mouse.down = false;
                });
                
                this.canvas.addEventListener('wheel', (e) => {
                    e.preventDefault();
                    const zoomFactor = e.deltaY > 0 ? 0.9 : 1.1;
                    this.camera.targetZoom = Math.max(0.1, Math.min(5, this.camera.targetZoom * zoomFactor));
                });
                
                // Click to select bodies
                this.canvas.addEventListener('click', (e) => {
                    this.selectBodyAtPosition(e.clientX, e.clientY);
                });
            }
            
            setupUI() {
                // Focus buttons
                document.getElementById('focusEarth').addEventListener('click', () => this.focusOnBody('earth'));
                document.getElementById('focusMoon').addEventListener('click', () => this.focusOnBody('moon'));
                document.getElementById('focusMars').addEventListener('click', () => this.focusOnBody('mars'));
                document.getElementById('focusSun').addEventListener('click', () => this.focusOnBody('sun'));
                
                // Camera mode buttons
                document.getElementById('freeCamera').addEventListener('click', (e) => {
                    this.camera.following = null;
                    this.updateButtonStates(e.target, 'freeCamera');
                });
                
                document.getElementById('followMode').addEventListener('click', (e) => {
                    if (this.selectedBody) {
                        this.camera.following = this.selectedBody;
                        this.updateButtonStates(e.target, 'followMode');
                    }
                });
                
                // Time speed control
                const speedSlider = document.getElementById('timeSpeed');
                speedSlider.addEventListener('input', (e) => {
                    this.timeSpeed = parseFloat(e.target.value);
                    document.getElementById('speedDisplay').textContent = this.timeSpeed.toFixed(1) + 'x';
                });
            }
            
            updateButtonStates(activeButton, group) {
                const buttons = activeButton.parentElement.querySelectorAll('.btn');
                buttons.forEach(btn => btn.classList.remove('active'));
                activeButton.classList.add('active');
            }
            
            focusOnBody(bodyName) {
                const body = this.bodies[bodyName];
                if (body) {
                    this.camera.targetX = body.x;
                    this.camera.targetY = body.y;
                    this.camera.targetZoom = bodyName === 'sun' ? 0.5 : 2;
                    this.selectedBody = bodyName;
                    this.updateBodyInfo(body);
                }
            }
            
            checkBodyHover(mouseX, mouseY) {
                const worldPos = this.screenToWorld(mouseX, mouseY);
                
                for (const [name, body] of Object.entries(this.bodies)) {
                    const distance = Math.sqrt((worldPos.x - body.x) ** 2 + (worldPos.y - body.y) ** 2);
                    if (distance <= body.radius) {
                        this.canvas.style.cursor = 'pointer';
                        return;
                    }
                }
                
                this.canvas.style.cursor = this.mouse.down ? 'grabbing' : 'grab';
            }
            
            selectBodyAtPosition(mouseX, mouseY) {
                const worldPos = this.screenToWorld(mouseX, mouseY);
                
                for (const [name, body] of Object.entries(this.bodies)) {
                    const distance = Math.sqrt((worldPos.x - body.x) ** 2 + (worldPos.y - body.y) ** 2);
                    if (distance <= body.radius) {
                        this.selectedBody = name;
                        this.updateBodyInfo(body);
                        return;
                    }
                }
            }
            
            updateBodyInfo(body) {
                const infoPanel = document.getElementById('selectedBodyInfo');
                const bodyName = document.getElementById('bodyName');
                const distanceFromSun = document.getElementById('distanceFromSun');
                const orbitalPeriod = document.getElementById('orbitalPeriod');
                const diameter = document.getElementById('diameter');
                const mass = document.getElementById('mass');
                
                bodyName.textContent = body.name;
                distanceFromSun.textContent = body.name === 'Sun' ? '0 km' : 
                    body.name === 'Moon' ? '384,400 km (from Earth)' : 
                    (body.distanceFromSun / 1e6).toFixed(1) + 'M km';
                orbitalPeriod.textContent = body.orbitalPeriod ? body.orbitalPeriod + ' days' : 'N/A';
                diameter.textContent = body.info.diameter;
                mass.textContent = body.info.mass;
                
                infoPanel.style.display = 'block';
            }
            
            screenToWorld(screenX, screenY) {
                const rect = this.canvas.getBoundingClientRect();
                const x = (screenX - rect.left - this.canvas.width / 2) / this.camera.zoom + this.camera.x;
                const y = (screenY - rect.top - this.canvas.height / 2) / this.camera.zoom + this.camera.y;
                return { x, y };
            }
            
            worldToScreen(worldX, worldY) {
                const x = (worldX - this.camera.x) * this.camera.zoom + this.canvas.width / 2;
                const y = (worldY - this.camera.y) * this.camera.zoom + this.canvas.height / 2;
                return { x, y };
            }
            
            updatePhysics() {
                this.time += this.timeSpeed;
                
                // Update Earth's orbit
                const earth = this.bodies.earth;
                earth.angle += earth.orbitalSpeed * this.timeSpeed;
                earth.x = Math.cos(earth.angle) * earth.orbitRadius;
                earth.y = Math.sin(earth.angle) * earth.orbitRadius;
                
                // Update Moon's orbit around Earth
                const moon = this.bodies.moon;
                moon.angle += moon.orbitalSpeed * this.timeSpeed;
                moon.x = earth.x + Math.cos(moon.angle) * moon.orbitRadius;
                moon.y = earth.y + Math.sin(moon.angle) * moon.orbitRadius;
                
                // Update Mars's orbit
                const mars = this.bodies.mars;
                mars.angle += mars.orbitalSpeed * this.timeSpeed;
                mars.x = Math.cos(mars.angle) * mars.orbitRadius;
                mars.y = Math.sin(mars.angle) * mars.orbitRadius;
                
                // Update camera following
                if (this.camera.following) {
                    const followBody = this.bodies[this.camera.following];
                    this.camera.targetX = followBody.x;
                    this.camera.targetY = followBody.y;
                }
                
                // Smooth camera movement
                this.camera.x += (this.camera.targetX - this.camera.x) * 0.1;
                this.camera.y += (this.camera.targetY - this.camera.y) * 0.1;
                this.camera.zoom += (this.camera.targetZoom - this.camera.zoom) * 0.1;
                
                this.updateStats();
            }
            
            updateStats() {
                const earth = this.bodies.earth;
                const moon = this.bodies.moon;
                const mars = this.bodies.mars;
                
                // Calculate distances
                const earthMoonDist = Math.sqrt((earth.x - moon.x) ** 2 + (earth.y - moon.y) ** 2);
                const earthMarsDist = Math.sqrt((earth.x - mars.x) ** 2 + (earth.y - mars.y) ** 2);
                const cameraDistance = Math.sqrt(this.camera.x ** 2 + this.camera.y ** 2);
                
                document.getElementById('cameraDistance').textContent = (cameraDistance * 1000).toFixed(0) + ' km';
                document.getElementById('simTime').textContent = 'Day ' + Math.floor(this.time / 10);
                document.getElementById('earthMoonDist').textContent = (earthMoonDist * 12800).toFixed(0) + ' km';
                document.getElementById('earthMarsDist').textContent = (earthMarsDist * 1.5).toFixed(1) + 'M km';
            }
            
            render() {
                // Clear canvas
                this.ctx.fillStyle = 'rgba(26, 26, 46, 0.1)';
                this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
                
                this.ctx.save();
                
                // Apply camera transform
                this.ctx.translate(this.canvas.width / 2, this.canvas.height / 2);
                this.ctx.scale(this.camera.zoom, this.camera.zoom);
                this.ctx.translate(-this.camera.x, -this.camera.y);
                
                // Draw orbital paths
                this.drawOrbitalPaths();
                
                // Draw celestial bodies
                this.drawBodies();
                
                // Draw connections and labels
                this.drawConnections();
                
                this.ctx.restore();
            }
            
            drawOrbitalPaths() {
                this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.2)';
                this.ctx.lineWidth = 1;
                this.ctx.setLineDash([5, 5]);
                
                // Earth's orbit
                this.ctx.beginPath();
                this.ctx.arc(0, 0, this.bodies.earth.orbitRadius, 0, Math.PI * 2);
                this.ctx.stroke();
                
                // Mars's orbit
                this.ctx.beginPath();
                this.ctx.arc(0, 0, this.bodies.mars.orbitRadius, 0, Math.PI * 2);
                this.ctx.stroke();
                
                // Moon's orbit around Earth
                const earth = this.bodies.earth;
                this.ctx.beginPath();
                this.ctx.arc(earth.x, earth.y, this.bodies.moon.orbitRadius, 0, Math.PI * 2);
                this.ctx.stroke();
                
                this.ctx.setLineDash([]);
            }
            
            drawBodies() {
                for (const [name, body] of Object.entries(this.bodies)) {
                    this.ctx.save();
                    
                    // Glow effect for selected body
                    if (name === this.selectedBody) {
                        this.ctx.shadowColor = body.color;
                        this.ctx.shadowBlur = 20;
                    }
                    
                    // Draw body
                    this.ctx.fillStyle = body.color;
                    this.ctx.beginPath();
                    this.ctx.arc(body.x, body.y, body.radius, 0, Math.PI * 2);
                    this.ctx.fill();
                    
                    // Add surface details for planets
                    if (name === 'earth') {
                        this.ctx.fillStyle = '#4CAF50';
                        this.ctx.beginPath();
                        this.ctx.arc(body.x - 2, body.y - 1, 2, 0, Math.PI);
                        this.ctx.fill();
                        this.ctx.beginPath();
                        this.ctx.arc(body.x + 1, body.y + 2, 1.5, 0, Math.PI);
                        this.ctx.fill();
                    } else if (name === 'mars') {
                        this.ctx.fillStyle = '#8B4513';
                        this.ctx.beginPath();
                        this.ctx.arc(body.x - 1, body.y, 1, 0, Math.PI * 2);
                        this.ctx.fill();
                    } else if (name === 'sun') {
                        // Sun corona effect
                        const gradient = this.ctx.createRadialGradient(body.x, body.y, body.radius * 0.5, body.x, body.y, body.radius * 1.5);
                        gradient.addColorStop(0, 'rgba(253, 184, 19, 0.8)');
                        gradient.addColorStop(1, 'rgba(253, 184, 19, 0)');
                        this.ctx.fillStyle = gradient;
                        this.ctx.beginPath();
                        this.ctx.arc(body.x, body.y, body.radius * 1.5, 0, Math.PI * 2);
                        this.ctx.fill();
                    }
                    
                    this.ctx.restore();
                    
                    // Draw labels
                    if (this.camera.zoom > 0.5) {
                        this.ctx.fillStyle = 'white';
                        this.ctx.font = `${12 / this.camera.zoom}px Inter`;
                        this.ctx.textAlign = 'center';
                        this.ctx.fillText(body.name, body.x, body.y + body.radius + 15 / this.camera.zoom);
                    }
                }
            }
            
            drawConnections() {
                if (this.selectedBody && this.camera.zoom > 1) {
                    const selectedBodyObj = this.bodies[this.selectedBody];
                    
                    // Draw distance lines to other bodies
                    this.ctx.strokeStyle = 'rgba(100, 255, 218, 0.5)';
                    this.ctx.lineWidth = 1;
                    this.ctx.setLineDash([2, 2]);
                    
                    for (const [name, body] of Object.entries(this.bodies)) {
                        if (name !== this.selectedBody) {
                            this.ctx.beginPath();
                            this.ctx.moveTo(selectedBodyObj.x, selectedBodyObj.y);
                            this.ctx.lineTo(body.x, body.y);
                            this.ctx.stroke();
                        }
                    }
                    
                    this.ctx.setLineDash([]);
                }
            }
            
            createStarField() {
                const starsContainer = document.getElementById('stars');
                for (let i = 0; i < 200; i++) {
                    const star = document.createElement('div');
                    star.className = 'star';
                    star.style.left = Math.random() * 100 + '%';
                    star.style.top = Math.random() * 100 + '%';
                    star.style.width = star.style.height = Math.random() * 3 + 1 + 'px';
                    star.style.animationDelay = Math.random() * 3 + 's';
                    starsContainer.appendChild(star);
                }
            }
            
            animate() {
                this.updatePhysics();
                this.render();
                requestAnimationFrame(() => this.animate());
            }
        }
        
        // Initialize the game when the page loads
        window.addEventListener('load', () => {
            new SolarSystemExplorer();
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9801c23254f18749',t:'MTc1ODA0MDMzMy4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
