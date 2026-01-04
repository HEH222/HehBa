<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirror Maze - Complete Adventure</title>
    <style>
        body {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #0a0a0a, #1a1a2e, #16213e);
            font-family: 'Arial', sans-serif;
            overflow-x: hidden;
            color: white;
            min-height: 100vh;
        }

        .game-container {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .game-container {
                padding: 10px;
                justify-content: flex-start;
            }
            
            .game-layout {
                flex-direction: column;
                gap: 10px;
            }
            
            .instructions-panel {
                width: 100%;
                max-height: 200px;
                order: 2;
            }
            
            .game-area {
                order: 1;
                min-height: 300px;
            }
            
            .level-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
            
            .level-button {
                padding: 15px 10px;
                font-size: 14px;
            }
            
            .game-title {
                flex-direction: column;
                gap: 10px;
                padding: 10px 15px;
            }
            
            .game-title h1 {
                font-size: 20px;
            }
            
            .maze {
                transform: translate(-50%, -50%) scale(0.25);
            }
            
            .hud {
                font-size: 12px;
                padding: 8px;
            }
            
            .minimap {
                width: 150px;
                height: 100px;
            }
            
            .minimap-content {
                width: 130px;
                height: 80px;
            }
            
            .level-select {
                margin-top: 20px;
                padding: 20px;
            }
            
            .level-select h1 {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .level-select h1 {
                font-size: 24px;
            }
            
            .level-grid {
                grid-template-columns: 1fr;
            }
            
            .maze {
                transform: translate(-50%, -50%) scale(0.2);
            }
            
            .instructions-panel {
                max-height: 150px;
            }
        }

        .level-select {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.1), rgba(255, 0, 255, 0.1));
            backdrop-filter: blur(10px);
            border: 2px solid #00ffff;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 255, 255, 0.2);
            max-width: 800px;
            width: 100%;
            margin-top: 40px;
        }

        .level-select h1 {
            margin: 0 0 20px 0;
            font-size: 36px;
            background: linear-gradient(45deg, #00ffff, #ff00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
        }

        .level-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin: 30px 0;
        }

        .level-button {
            background: linear-gradient(45deg, #00ffff, #0099cc);
            border: none;
            padding: 20px;
            border-radius: 15px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .level-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 255, 255, 0.5);
        }

        .level-button.locked {
            background: linear-gradient(45deg, #666, #444);
            cursor: not-allowed;
            opacity: 0.5;
        }

        .level-button.completed {
            background: linear-gradient(45deg, #00ff00, #00cc00);
        }

        .level-info {
            font-size: 12px;
            margin-top: 5px;
            opacity: 0.8;
        }

        .game-title {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.1), rgba(255, 0, 255, 0.1));
            backdrop-filter: blur(10px);
            border: 2px solid #00ffff;
            border-radius: 20px;
            padding: 15px 30px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 255, 255, 0.2);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 1400px;
        }

        .game-title h1 {
            margin: 0;
            font-size: 28px;
            background: linear-gradient(45deg, #00ffff, #ff00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
        }

        .game-title .subtitle {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #cccccc;
            opacity: 0.8;
        }

        .title-content {
            text-align: center;
            flex: 1;
        }

        .game-layout {
            display: flex;
            gap: 20px;
            width: 100%;
            max-width: 1400px;
            flex: 1;
        }

        .instructions-panel {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.9), rgba(26, 26, 46, 0.9));
            backdrop-filter: blur(10px);
            border: 2px solid #00ffff;
            border-radius: 15px;
            padding: 15px;
            width: 250px;
            box-shadow: 0 8px 32px rgba(0, 255, 255, 0.2);
            max-height: 500px;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .game-area {
            display: flex;
            flex-direction: column;
            flex: 1;
            position: relative;
        }

        .go-back-btn {
            background: linear-gradient(45deg, #ff4757, #ff3742);
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);
        }

        .go-back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 71, 87, 0.5);
        }

        .hud {
            background: rgba(0, 0, 0, 0.7);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #00ffff;
        }

        .instructions-panel h3 {
            margin: 0 0 15px 0;
            color: #00ffff;
            font-size: 18px;
            text-align: center;
            text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        }

        .instruction-item {
            display: flex;
            align-items: center;
            margin: 12px 0;
            padding: 8px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            border-left: 3px solid #00ffff;
        }

        .instruction-icon {
            width: 24px;
            height: 24px;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(45deg, #00ffff, #0099cc);
            border-radius: 50%;
            font-size: 12px;
            font-weight: bold;
        }

        .instruction-text {
            flex: 1;
            font-size: 13px;
            line-height: 1.4;
        }

        .objective-box {
            background: linear-gradient(45deg, rgba(255, 215, 0, 0.1), rgba(255, 140, 0, 0.1));
            border: 2px solid #ffd700;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            text-align: center;
        }

        .objective-box .objective-title {
            color: #ffd700;
            font-weight: bold;
            margin-bottom: 8px;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        .maze-viewport {
            position: relative;
            flex: 1;
            overflow: hidden;
            background: radial-gradient(circle at center, #0f1419, #000);
            border: 3px solid #00ffff;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.3);
            min-height: 500px;
            width: 100%;
        }

        .maze {
            position: absolute;
            width: 1800px;
            height: 1200px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) scale(0.45);
            transition: transform 0.1s ease-out;
        }

        .wall {
            position: absolute;
            background: linear-gradient(45deg, #2a4a6b, #1e3a5f);
            border: 2px solid #00ccff;
            box-shadow: 0 0 20px rgba(0, 204, 255, 0.3);
            animation: wallShimmer 3s ease-in-out infinite alternate;
        }

        @keyframes wallShimmer {
            0% { box-shadow: 0 0 20px rgba(0, 204, 255, 0.3); }
            100% { box-shadow: 0 0 30px rgba(0, 204, 255, 0.6); }
        }

        .mirror-zone {
            position: absolute;
            background: rgba(255, 0, 255, 0.1);
            border: 2px dashed #ff00ff;
            border-radius: 10px;
        }

        .teleporter {
            position: absolute;
            background: radial-gradient(circle, #9932cc, #4b0082);
            border: 3px solid #9932cc;
            border-radius: 50%;
            animation: teleporterPulse 2s ease-in-out infinite;
        }

        @keyframes teleporterPulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 20px #9932cc; }
            50% { transform: scale(1.2); box-shadow: 0 0 40px #9932cc; }
        }

        .moving-platform {
            position: absolute;
            background: linear-gradient(45deg, #ff6b35, #f7931e);
            border: 2px solid #ff6b35;
            border-radius: 10px;
            transition: all 0.5s ease;
        }

        .ice-zone {
            position: absolute;
            background: rgba(173, 216, 230, 0.2);
            border: 2px dashed #87ceeb;
            border-radius: 10px;
        }

        .speed-boost {
            position: absolute;
            background: radial-gradient(circle, #ffff00, #ffa500);
            border: 3px solid #ffff00;
            border-radius: 50%;
            animation: speedBoostPulse 1s ease-in-out infinite;
        }

        @keyframes speedBoostPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }

        .laser-gate {
            position: absolute;
            width: 4px;
            background: linear-gradient(to bottom, transparent, #ff0000, transparent);
            box-shadow: 0 0 15px #ff0000;
            transition: all 0.3s ease;
        }

        .laser-gate.open {
            background: linear-gradient(to bottom, transparent, #00ff00, transparent);
            box-shadow: 0 0 15px #00ff00;
        }

        .orb {
            position: absolute;
            width: 24px;
            height: 24px;
            background: radial-gradient(circle, #ffffff 20%, #00ffff 60%, #0088cc 100%);
            border-radius: 50%;
            box-shadow: 0 0 40px #00ffff, 0 0 20px #ffffff, inset 0 0 10px rgba(255, 255, 255, 0.5);
            transition: none;
            z-index: 100;
            border: 2px solid rgba(255, 255, 255, 0.8);
            display: block !important;
            visibility: visible !important;
        }

        .trail {
            position: absolute;
            width: 8px;
            height: 8px;
            background: radial-gradient(circle, #00ffff, transparent);
            border-radius: 50%;
            pointer-events: none;
            animation: trailFade 0.8s ease-out forwards;
        }

        @keyframes trailFade {
            0% { opacity: 0.8; transform: scale(1); }
            100% { opacity: 0; transform: scale(0.3); }
        }

        .puzzle-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 200;
        }

        .puzzle-content {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            padding: 30px;
            border-radius: 15px;
            border: 2px solid #00ffff;
            text-align: center;
            max-width: 500px;
        }

        .puzzle-button {
            background: linear-gradient(45deg, #00ffff, #0099cc);
            border: none;
            padding: 12px 24px;
            margin: 10px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .puzzle-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 255, 255, 0.4);
        }

        .minimap {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.9);
            border: 2px solid #00ffff;
            border-radius: 8px;
            padding: 6px;
            z-index: 100;
            width: 100px;
            height: 80px;
        }

        .minimap-title {
            color: #00ffff;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
            text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        }

        .minimap-content {
            position: relative;
            width: 88px;
            height: 56px;
            background: linear-gradient(135deg, #0a0a0a, #1a1a2e);
            border: 1px solid #333;
            border-radius: 4px;
            overflow: hidden;
        }

        .minimap-walls {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(90deg, #00ccff 0px, transparent 1px),
                linear-gradient(0deg, #00ccff 0px, transparent 1px);
            background-size: 16px 10px;
            opacity: 0.3;
        }

        .minimap-orb {
            position: absolute;
            width: 8px;
            height: 8px;
            background: radial-gradient(circle, #ffffff, #00ffff);
            border-radius: 50%;
            box-shadow: 0 0 8px #00ffff;
            z-index: 3;
            transition: all 0.1s ease;
        }

        .minimap-goal {
            position: absolute;
            width: 10px;
            height: 10px;
            background: radial-gradient(circle, #ffff00, #ffd700);
            border-radius: 50%;
            box-shadow: 0 0 10px #ffd700;
            z-index: 2;
            animation: minimapGoalPulse 2s ease-in-out infinite;
        }

        @keyframes minimapGoalPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }

        .goal {
            position: absolute;
            width: 50px;
            height: 50px;
            background: radial-gradient(circle, #ffff00 20%, #ffd700 60%, #ff8800 100%);
            border-radius: 50%;
            box-shadow: 0 0 50px #ffff00, 0 0 25px #ffd700, inset 0 0 15px rgba(255, 255, 255, 0.3);
            animation: goalPulse 2s ease-in-out infinite;
            border: 3px solid rgba(255, 215, 0, 0.8);
        }

        @keyframes goalPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        .level-complete {
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.2), rgba(255, 215, 0, 0.2));
            border: 3px solid #00ff00;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            max-width: 500px;
        }

        .level-complete h2 {
            color: #00ff00;
            font-size: 32px;
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
        }

        .stats {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .next-level-btn {
            background: linear-gradient(45deg, #00ff00, #00cc00);
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 255, 0, 0.3);
            margin: 10px;
        }

        .next-level-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 255, 0, 0.5);
        }

        .hidden {
            display: none;
        }

        .control-btn {
            background: linear-gradient(45deg, #00ffff, #0099cc);
            border: 2px solid #00ffff;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
            touch-action: manipulation;
        }

        .control-btn:hover, .control-btn:active {
            background: linear-gradient(45deg, #00cccc, #0077aa);
            transform: scale(0.95);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
        }
        
        /* Back button in level selection */
        .level-select-header {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            position: relative;
            margin-bottom: 20px;
        }
        
        .back-to-game-btn {
            position: absolute;
            left: 0;
            background: linear-gradient(45deg, #ff4757, #ff3742);
            border: none;
            padding: 10px 15px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);
        }
        
        .back-to-game-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 71, 87, 0.5);
        }
    </style>
</head>
<body>
    <!-- Level Selection Screen -->
    <div id="levelSelect" class="game-container">
        <div class="level-select">
            <div class="level-select-header">
                <button class="back-to-game-btn" onclick="goToGamePage()">← Back to Game</button>
                <h1>🌟 MIRROR MAZE ADVENTURE 🌟</h1>
            </div>
            <p>Navigate through 10 increasingly challenging levels with unique mechanics!</p>
            
            <div class="level-grid" id="levelGrid">
                <!-- Levels will be generated here -->
            </div>
            
            <div style="margin-top: 30px;">
                <button class="puzzle-button" onclick="resetProgress()">🔄 Reset All Progress</button>
            </div>
        </div>
    </div>

    <!-- Game Screen -->
    <div id="gameScreen" class="game-container hidden">
        <div class="game-title">
            <button class="go-back-btn" onclick="goToLevelSelect()">← Level Select</button>
            <div class="title-content">
                <h1 id="gameTitle">🌟 MIRROR MAZE 🌟</h1>
                <div class="subtitle" id="gameSubtitle">Level 1 - Basic Navigation</div>
            </div>
            <div style="width: 120px;"></div>
        </div>

        <div class="game-layout">
            <div class="instructions-panel">
                <div class="objective-box">
                    <div class="objective-title">🎯 OBJECTIVE</div>
                    <div id="levelObjective">Guide the glowing orb to the golden goal!</div>
                </div>

                <h3>📋 Level Features</h3>
                <div id="levelFeatures">
                    <!-- Features will be populated based on level -->
                </div>

                <div class="instruction-item">
                    <div class="instruction-icon">🎮</div>
                    <div class="instruction-text">
                        <strong>Controls:</strong> Arrow keys or WASD to move
                    </div>
                </div>

                <div class="mobile-controls" id="mobileControls" style="display: none;">
                    <div style="text-align: center; margin: 10px 0; color: #00ffff; font-weight: bold;">Touch Controls</div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 5px; max-width: 150px; margin: 0 auto;">
                        <div></div>
                        <button class="control-btn" data-direction="up">↑</button>
                        <div></div>
                        <button class="control-btn" data-direction="left">←</button>
                        <button class="control-btn" data-direction="down">↓</button>
                        <button class="control-btn" data-direction="right">→</button>
                    </div>
                </div>

                <div class="minimap" id="minimap" style="position: relative; top: 0; left: 0; margin: 15px 0; width: 220px; height: 140px;">
                    <div class="minimap-title">📍 MINIMAP</div>
                    <div class="minimap-content" style="width: 200px; height: 120px;">
                        <div class="minimap-orb" id="minimapOrb"></div>
                        <div class="minimap-goal" id="minimapGoal"></div>
                        <div class="minimap-walls"></div>
                    </div>
                </div>
            </div>

            <div class="game-area">
                <div class="hud" style="position: absolute; top: 10px; right: 10px; z-index: 100;">
                    <div>Level: <span id="currentLevel">1</span>/10</div>
                    <div>Speed: <span id="speed">0</span></div>
                    <div>Time: <span id="timer">0:00</span></div>
                    <div id="gatesCounter" class="hidden">Gates: <span id="gates">0</span>/<span id="totalGates">0</span></div>
                </div>

                <div class="maze-viewport">
                    <div class="maze" id="maze">
                        <!-- Maze content will be generated -->
                        <div class="orb" id="orb"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Level Complete Screen -->
    <div id="levelCompleteScreen" class="game-container hidden">
        <div class="level-complete">
            <h2 id="completeTitle">🎉 LEVEL COMPLETE! 🎉</h2>
            <div class="stats" id="levelStats">
                <!-- Stats will be populated -->
            </div>
            <button class="next-level-btn" id="nextLevelBtn" onclick="nextLevel()">Next Level →</button>
            <button class="puzzle-button" onclick="goToLevelSelect()">Level Select</button>
        </div>
    </div>

    <!-- Puzzle Modal -->
    <div class="puzzle-modal" id="puzzleModal" style="display: none;">
        <div class="puzzle-content">
            <h2 id="puzzleTitle">Puzzle Challenge</h2>
            <p id="puzzleQuestion">Solve this puzzle to continue!</p>
            <div id="puzzleButtons">
                <!-- Puzzle buttons will be generated -->
            </div>
        </div>
    </div>

    <script>
        // Security measures
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', e => {
            if (e.key === 'F12' || 
                (e.ctrlKey && e.shiftKey && e.key === 'I') ||
                (e.ctrlKey && e.shiftKey && e.key === 'C') ||
                (e.ctrlKey && e.key === 'U')) {
                e.preventDefault();
                return false;
            }
        });
        
        // Disable text selection
        document.onselectstart = () => false;
        document.ondragstart = () => false;
        
        // Clear console periodically
        setInterval(() => {
            console.clear();
            console.log('%cAccess Denied', 'color: red; font-size: 50px; font-weight: bold;');
        }, 1000);

        // Game state
        let currentLevelNum = 1;
        let gameActive = false;
        let startTime = 0;
        let completedLevels = JSON.parse(localStorage.getItem('mazeCompletedLevels') || '[]');
        let levelStats = JSON.parse(localStorage.getItem('mazeLevelStats') || '{}');

        // Game objects
        let orb, maze, orbPosition, velocity, isInMirrorZone, gatesPassed, currentGate;
        let walls, mirrorZones, laserGates, teleporters, movingPlatforms, iceZones, speedBoosts;
        let gameTimer, onIce = false, speedBoostActive = false;

        // Level configurations
        const levelConfigs = {
            1: {
                title: "Basic Navigation",
                objective: "Learn the basics - reach the golden goal!",
                features: ["🎯 Simple maze layout", "⚡ Physics-based movement", "💥 Wall collisions"],
                walls: [
                    { x: 0, y: 0, width: 1800, height: 20 },
                    { x: 0, y: 1180, width: 1800, height: 20 },
                    { x: 0, y: 0, width: 20, height: 1200 },
                    { x: 1780, y: 0, width: 20, height: 1200 },
                    { x: 300, y: 200, width: 20, height: 400 },
                    { x: 600, y: 300, width: 300, height: 20 },
                    { x: 1000, y: 400, width: 20, height: 300 },
                    { x: 1200, y: 600, width: 400, height: 20 }
                ],
                goal: { x: 1500, y: 900 },
                startPos: { x: 50, y: 50 }
            },
            2: {
                title: "Mirror Zones",
                objective: "Navigate through purple mirror zones that reverse your controls!",
                features: ["🟣 Mirror zones reverse controls", "🎯 More complex layout", "⚡ Momentum physics"],
                walls: [
                    { x: 0, y: 0, width: 1800, height: 20 },
                    { x: 0, y: 1180, width: 1800, height: 20 },
                    { x: 0, y: 0, width: 20, height: 1200 },
                    { x: 1780, y: 0, width: 20, height: 1200 },
                    { x: 200, y: 100, width: 20, height: 300 },
                    { x: 400, y: 200, width: 300, height: 20 },
                    { x: 800, y: 100, width: 20, height: 400 },
                    { x: 1200, y: 300, width: 20, height: 300 },
                    { x: 1400, y: 500, width: 300, height: 20 }
                ],
                mirrorZones: [
                    { x: 250, y: 150, width: 120, height: 120 },
                    { x: 650, y: 450, width: 200, height: 100 },
                    { x: 1100, y: 350, width: 150, height: 150 }
                ],
                goal: { x: 1500, y: 800 },
                startPos: { x: 50, y: 50 }
            },
            3: {
                title: "Laser Gates",
                objective: "Solve puzzles to open laser gates blocking your path!",
                features: ["🔴 Laser gates with puzzles", "🧮 Math and logic challenges", "🟣 Mirror zones"],
                walls: [
                    { x: 0, y: 0, width: 1800, height: 20 },
                    { x: 0, y: 1180, width: 1800, height: 20 },
                    { x: 0, y: 0, width: 20, height: 1200 },
                    { x: 1780, y: 0, width: 20, height: 1200 },
                    { x: 300, y: 150, width: 20, height: 200 },
                    { x: 600, y: 250, width: 200, height: 20 },
                    { x: 900, y: 400, width: 20, height: 300 },
                    { x: 1200, y: 200, width: 300, height: 20 },
                    { x: 1500, y: 500, width: 20, height: 400 }
                ],
                mirrorZones: [
                    { x: 450, y: 300, width: 100, height: 100 },
                    { x: 1100, y: 600, width: 150, height: 120 }
                ],
                laserGates: [
                    { x: 350, y: 200, width: 4, height: 100 },
                    { x: 750, y: 350, width: 4, height: 120 },
                    { x: 1150, y: 450, width: 4, height: 100 }
                ],
                goal: { x: 1600, y: 950 },
                startPos: { x: 50, y: 50 }
            },
            4: {
                title: "Teleporters",
                objective: "Use purple teleporters to instantly travel across the maze!",
                features: ["🌀 Teleporter pairs", "🔴 Laser gate puzzles", "🟣 Mirror zones", "⚡ Complex physics"],
                walls: [
                    { x: 0, y: 0, width: 1800, height: 20 },
                    { x: 0, y: 1180, width: 1800, height: 20 },
                    { x: 0, y: 0, width: 20, height: 1200 },
                    { x: 1780, y: 0, width: 20, height: 1200 },
                    { x: 400, y: 100, width: 20, height: 400 },
                    { x: 800, y: 200, width: 300, height: 20 },
                    { x: 1200, y: 400, width: 20, height: 300 },
                    { x: 600, y: 700, width: 400, height: 20 },
                    { x: 1400, y: 600, width: 20, height: 300 }
                ],
                mirrorZones: [
                    { x: 250, y: 200, width: 120, height: 100 },
                    { x: 1050, y: 500, width: 130, height: 150 }
                ],
                laserGates: [
                    { x: 650, y: 300, width: 4, height: 100 },
                    { x: 1050, y: 250, width: 4, height: 120 }
                ],
                teleporters: [
                    { x: 500, y: 300, width: 40, height: 40, target: { x: 1300, y: 500 } },
                    { x: 1300, y: 500, width: 40, height: 40, target: { x: 500, y: 300 } }
                ],
                goal: { x: 1500, y: 1000 },
                startPos: { x: 50, y: 50 }
            },
            5: {
                title: "Moving Platforms",
                objective: "Time your movements with orange moving platforms!",
                features: ["🟠 Moving platforms", "🌀 Teleporters", "🔴 Laser gates", "🟣 Mirror zones"],
                walls: [
                    { x: 0, y: 0, width: 1800, height: 20 },
                    { x: 0, y: 1180, width: 1800, height: 20 },
                    { x: 0, y: 0, width: 20, height: 1200 },
                    { x: 1780, y: 0, width: 20, height: 1200 },
                    { x: 300, y: 200, width: 20, height: 300 },
                    { x: 700, y: 150, width: 200, height: 20 },
                    { x: 1100, y: 300, width: 20, height: 400 },
                    { x: 1400, y: 500, width: 300, height: 20 }
                ],
                mirrorZones: [
                    { x: 450, y: 250, width: 100, height: 100 },
                    { x: 1200, y: 600, width: 150, height: 120 }
                ],
                laserGates: [
                    { x: 550, y: 200, width: 4, height: 100 },
                    { x: 950, y: 400, width: 4, height: 120 }
                ],
                teleporters: [
                    { x: 350, y: 400, width: 40, height: 40, target: { x: 1200, y: 200 } },
                    { x: 1200, y: 200, width: 40, height: 40, target: { x: 350, y: 400 } }
                ],
                movingPlatforms: [
                    { x: 600, y: 400, width: 80, height: 20, startX: 600, endX: 800, speed: 2 },
                    { x: 1000, y: 700, width: 80, height: 20, startX: 1000, endX: 1200, speed: 1.5 }
                ],
                goal: { x: 1600, y: 900 },
                startPos: { x: 50, y: 50 }
            },
            6: {
                title: "Ice Zones",
                objective: "Slide carefully through slippery ice zones!",
                features: ["🧊 Slippery ice zones", "🟠 Moving platforms", "🌀 Teleporters", "🔴 Laser gates"],
                walls: [
                    { x: 0, y: 0, width: 1800, height: 20 },
                    { x: 0, y: 1180, width: 1800, height: 20 },
                    { x: 0, y: 0, width: 20, height: 1200 },
                    { x: 1780, y: 0, width: 20, height: 1200 },
                    { x: 400, y: 150, width: 20, height: 250 },
                    { x: 800, y: 200, width: 200, height: 20 },
                    { x: 1200, y: 350, width: 20, height: 300 },
                    { x: 600, y: 600, width: 300, height: 20 }
                ],
                mirrorZones: [
                    { x: 250, y: 250, width: 120, height: 100 }
                ],
                laserGates: [
                    { x: 650, y: 300, width: 4, height: 100 },
                    { x: 1050, y: 450, width: 4, height: 120 }
                ],
                teleporters: [
                    { x: 500, y: 450, width: 40, height: 40, target: { x: 1300, y: 250 } },
                    { x: 1300, y: 250, width: 40, height: 40, target: { x: 500, y: 450 } }
                ],
                movingPlatforms: [
                    { x: 700, y: 500, width: 80, height: 20, startX: 700, endX: 900, speed: 2 }
                ],
                iceZones: [
                    { x: 450, y: 500, width: 200, height: 150 },
                    { x: 1100, y: 700, width: 250, height: 120 }
                ],
                goal: { x: 1500, y: 1000 },
                startPos: { x: 50, y: 50 }
            },
            7: {
                title: "Speed Boosts",
                objective: "Collect yellow speed boosts for temporary acceleration!",
                features: ["⚡ Speed boost pickups", "🧊 Ice zones", "🟠 Moving platforms", "🌀 Teleporters"],
                walls: [
                    { x: 0, y: 0, width: 1800, height: 20 },
                    { x: 0, y: 1180, width: 1800, height: 20 },
                    { x: 0, y: 0, width: 20, height: 1200 },
                    { x: 1780, y: 0, width: 20, height: 1200 },
                    { x: 350, y: 100, width: 20, height: 300 },
                    { x: 700, y: 250, width: 250, height: 20 },
                    { x: 1100, y: 400, width: 20, height: 250 },
                    { x: 1400, y: 600, width: 200, height: 20 }
                ],
                mirrorZones: [
                    { x: 500, y: 350, width: 150, height: 100 }
                ],
                laserGates: [
                    { x: 600, y: 150, width: 4, height: 100 },
                    { x: 1000, y: 500, width: 4, height: 120 }
                ],
                teleporters: [
                    { x: 400, y: 450, width: 40, height: 40, target: { x: 1200, y: 300 } },
                    { x: 1200, y: 300, width: 40, height: 40, target: { x: 400, y: 450 } }
                ],
                movingPlatforms: [
                    { x: 800, y: 500, width: 80, height: 20, startX: 800, endX: 1000, speed: 2.5 }
                ],
                iceZones: [
                    { x: 650, y: 700, width: 200, height: 150 }
                ],
                speedBoosts: [
                    { x: 550, y: 200, width: 30, height: 30 },
                    { x: 1250, y: 500, width: 30, height: 30 },
                    { x: 750, y: 800, width: 30, height: 30 }
                ],
                goal: { x: 1600, y: 950 },
                startPos: { x: 50, y: 50 }
            },
            8: {
                title: "Chaos Mode",
                objective: "Navigate through a maze with all mechanics combined!",
                features: ["🌪️ All mechanics active", "⚡ Speed boosts", "🧊 Ice zones", "🟠 Moving platforms", "🌀 Teleporters"],
                walls: [
                    { x: 0, y: 0, width: 1800, height: 20 },
                    { x: 0, y: 1180, width: 1800, height: 20 },
                    { x: 0, y: 0, width: 20, height: 1200 },
                    { x: 1780, y: 0, width: 20, height: 1200 },
                    { x: 300, y: 150, width: 20, height: 200 },
                    { x: 600, y: 200, width: 150, height: 20 },
                    { x: 900, y: 350, width: 20, height: 200 },
                    { x: 1200, y: 250, width: 200, height: 20 },
                    { x: 1500, y: 400, width: 20, height: 300 }
                ],
                mirrorZones: [
                    { x: 350, y: 250, width: 100, height: 100 },
                    { x: 1050, y: 450, width: 120, height: 150 }
                ],
                laserGates: [
                    { x: 550, y: 250, width: 4, height: 100 },
                    { x: 850, y: 400, width: 4, height: 120 },
                    { x: 1350, y: 350, width: 4, height: 100 }
                ],
                teleporters: [
                    { x: 450, y: 400, width: 40, height: 40, target: { x: 1100, y: 200 } },
                    { x: 1100, y: 200, width: 40, height: 40, target: { x: 450, y: 400 } }
                ],
                movingPlatforms: [
                    { x: 700, y: 450, width: 80, height: 20, startX: 700, endX: 850, speed: 3 },
                    { x: 1300, y: 600, width: 80, height: 20, startX: 1300, endX: 1450, speed: 2 }
                ],
                iceZones: [
                    { x: 500, y: 600, width: 180, height: 120 },
                    { x: 1200, y: 800, width: 200, height: 150 }
                ],
                speedBoosts: [
                    { x: 400, y: 300, width: 30, height: 30 },
                    { x: 950, y: 550, width: 30, height: 30 },
                    { x: 1400, y: 750, width: 30, height: 30 }
                ],
                goal: { x: 1600, y: 1000 },
                startPos: { x: 50, y: 50 }
            },
            9: {
                title: "Master Challenge",
                objective: "Prove your mastery with the most complex maze yet!",
                features: ["🏆 Master difficulty", "🌪️ All mechanics", "⏱️ Time pressure", "🎯 Precision required"],
                walls: [
                    { x: 0, y: 0, width: 1800, height: 20 },
                    { x: 0, y: 1180, width: 1800, height: 20 },
                    { x: 0, y: 0, width: 20, height: 1200 },
                    { x: 1780, y: 0, width: 20, height: 1200 },
                    { x: 250, y: 100, width: 20, height: 150 },
                    { x: 400, y: 180, width: 120, height: 20 },
                    { x: 650, y: 120, width: 20, height: 200 },
                    { x: 800, y: 250, width: 150, height: 20 },
                    { x: 1100, y: 150, width: 20, height: 250 },
                    { x: 1300, y: 300, width: 200, height: 20 },
                    { x: 1600, y: 200, width: 20, height: 400 }
                ],
                mirrorZones: [
                    { x: 300, y: 300, width: 80, height: 80 },
                    { x: 700, y: 400, width: 100, height: 120 },
                    { x: 1200, y: 500, width: 150, height: 100 }
                ],
                laserGates: [
                    { x: 450, y: 220, width: 4, height: 80 },
                    { x: 750, y: 350, width: 4, height: 100 },
                    { x: 1050, y: 250, width: 4, height: 120 },
                    { x: 1450, y: 450, width: 4, height: 100 }
                ],
                teleporters: [
                    { x: 350, y: 450, width: 40, height: 40, target: { x: 950, y: 200 } },
                    { x: 950, y: 200, width: 40, height: 40, target: { x: 1400, y: 600 } },
                    { x: 1400, y: 600, width: 40, height: 40, target: { x: 350, y: 450 } }
                ],
                movingPlatforms: [
                    { x: 500, y: 500, width: 60, height: 20, startX: 500, endX: 650, speed: 4 },
                    { x: 900, y: 600, width: 60, height: 20, startX: 900, endX: 1050, speed: 3.5 },
                    { x: 1250, y: 700, width: 60, height: 20, startX: 1250, endX: 1400, speed: 3 }
                ],
                iceZones: [
                    { x: 400, y: 650, width: 150, height: 100 },
                    { x: 800, y: 750, width: 200, height: 120 },
                    { x: 1300, y: 850, width: 180, height: 100 }
                ],
                speedBoosts: [
                    { x: 320, y: 350, width: 25, height: 25 },
                    { x: 720, y: 300, width: 25, height: 25 },
                    { x: 1150, y: 400, width: 25, height: 25 },
                    { x: 850, y: 700, width: 25, height: 25 }
                ],
                goal: { x: 1650, y: 1050 },
                startPos: { x: 50, y: 50 }
            },
            10: {
                title: "Ultimate Maze",
                objective: "The final challenge - can you conquer the ultimate maze?",
                features: ["👑 Ultimate difficulty", "🌪️ Maximum chaos", "⚡ All mechanics", "🏆 Final boss level"],
                walls: [
                    { x: 0, y: 0, width: 1800, height: 20 },
                    { x: 0, y: 1180, width: 1800, height: 20 },
                    { x: 0, y: 0, width: 20, height: 1200 },
                    { x: 1780, y: 0, width: 20, height: 1200 },
                    { x: 200, y: 80, width: 20, height: 120 },
                    { x: 350, y: 150, width: 100, height: 20 },
                    { x: 550, y: 100, width: 20, height: 180 },
                    { x: 700, y: 200, width: 120, height: 20 },
                    { x: 900, y: 120, width: 20, height: 200 },
                    { x: 1050, y: 250, width: 150, height: 20 },
                    { x: 1300, y: 150, width: 20, height: 250 },
                    { x: 1450, y: 300, width: 180, height: 20 },
                    { x: 1700, y: 200, width: 20, height: 300 }
                ],
                mirrorZones: [
                    { x: 250, y: 250, width: 70, height: 70 },
                    { x: 450, y: 350, width: 80, height: 100 },
                    { x: 750, y: 300, width: 90, height: 80 },
                    { x: 1100, y: 400, width: 120, height: 90 },
                    { x: 1400, y: 500, width: 100, height: 120 }
                ],
                laserGates: [
                    { x: 320, y: 200, width: 4, height: 80 },
                    { x: 520, y: 300, width: 4, height: 100 },
                    { x: 720, y: 250, width: 4, height: 90 },
                    { x: 970, y: 350, width: 4, height: 120 },
                    { x: 1220, y: 300, width: 4, height: 100 },
                    { x: 1520, y: 450, width: 4, height: 110 }
                ],
                teleporters: [
                    { x: 280, y: 400, width: 35, height: 35, target: { x: 800, y: 150 } },
                    { x: 800, y: 150, width: 35, height: 35, target: { x: 1150, y: 350 } },
                    { x: 1150, y: 350, width: 35, height: 35, target: { x: 1500, y: 250 } },
                    { x: 1500, y: 250, width: 35, height: 35, target: { x: 280, y: 400 } }
                ],
                movingPlatforms: [
                    { x: 400, y: 500, width: 50, height: 15, startX: 400, endX: 520, speed: 5 },
                    { x: 650, y: 450, width: 50, height: 15, startX: 650, endX: 770, speed: 4.5 },
                    { x: 950, y: 550, width: 50, height: 15, startX: 950, endX: 1070, speed: 4 },
                    { x: 1200, y: 600, width: 50, height: 15, startX: 1200, endX: 1320, speed: 5.5 },
                    { x: 1450, y: 700, width: 50, height: 15, startX: 1450, endX: 1570, speed: 4 }
                ],
                iceZones: [
                    { x: 350, y: 600, width: 120, height: 80 },
                    { x: 600, y: 700, width: 140, height: 90 },
                    { x: 900, y: 750, width: 160, height: 100 },
                    { x: 1200, y: 800, width: 150, height: 120 },
                    { x: 1500, y: 850, width: 180, height: 100 }
                ],
                speedBoosts: [
                    { x: 270, y: 300, width: 20, height: 20 },
                    { x: 480, y: 250, width: 20, height: 20 },
                    { x: 680, y: 350, width: 20, height: 20 },
                    { x: 880, y: 400, width: 20, height: 20 },
                    { x: 1080, y: 300, width: 20, height: 20 },
                    { x: 1280, y: 450, width: 20, height: 20 },
                    { x: 1480, y: 600, width: 20, height: 20 }
                ],
                goal: { x: 1700, y: 1100 },
                startPos: { x: 50, y: 50 }
            }
        };

        // Puzzle sets for different levels
        const puzzleSets = {
            basic: [
                { question: "What is 5 + 3?", answers: [7, 8, 9], correct: 8 },
                { question: "What is 4 × 2?", answers: [6, 8, 10], correct: 8 },
                { question: "What is 12 ÷ 3?", answers: [3, 4, 5], correct: 4 },
                { question: "What is 9 - 4?", answers: [4, 5, 6], correct: 5 },
                { question: "What is 6 + 7?", answers: [12, 13, 14], correct: 13 },
                { question: "What is 15 ÷ 5?", answers: [2, 3, 4], correct: 3 }
            ],
            intermediate: [
                { question: "What is 7 × 8?", answers: [54, 56, 58], correct: 56 },
                { question: "What comes next: 2, 4, 8, 16, ?", answers: [24, 32, 36], correct: 32 },
                { question: "What is the square root of 144?", answers: [11, 12, 13], correct: 12 },
                { question: "What is 15% of 60?", answers: [8, 9, 10], correct: 9 },
                { question: "Complete: 1, 4, 9, 16, ?", answers: [20, 25, 30], correct: 25 },
                { question: "What is 8² (8 squared)?", answers: [56, 64, 72], correct: 64 },
                { question: "If a triangle has angles 60°, 60°, what's the third?", answers: ["50°", "60°", "70°"], correct: "60°" }
            ],
            advanced: [
                { question: "If 2x + 5 = 17, what is x?", answers: [5, 6, 7], correct: 6 },
                { question: "What is 25% of 80?", answers: [15, 20, 25], correct: 20 },
                { question: "Complete: 3, 7, 15, 31, ?", answers: [63, 67, 71], correct: 63 },
                { question: "What is the area of a circle with radius 3? (π ≈ 3.14)", answers: ["28.26", "18.84", "9.42"], correct: "28.26" },
                { question: "Solve: 3x - 7 = 14", answers: [6, 7, 8], correct: 7 },
                { question: "What is log₂(32)?", answers: [4, 5, 6], correct: 5 },
                { question: "Complete the pattern: 2, 6, 18, 54, ?", answers: [108, 162, 216], correct: 162 }
            ],
            expert: [
                { question: "What is 9! ÷ 7! (factorial)?", answers: [56, 72, 90], correct: 72 },
                { question: "Binary: What is 1011 in decimal?", answers: [9, 11, 13], correct: 11 },
                { question: "What comes next: A, D, G, J, ?", answers: ["L", "M", "N"], correct: "M" },
                { question: "What is the derivative of x³?", answers: ["2x²", "3x²", "x²"], correct: "3x²" },
                { question: "Hexadecimal: What is FF in decimal?", answers: [255, 256, 257], correct: 255 },
                { question: "What is the sum of angles in a pentagon?", answers: ["540°", "720°", "900°"], correct: "540°" },
                { question: "Complete: 1, 1, 2, 3, 5, 8, ?", answers: [11, 13, 15], correct: 13 },
                { question: "What is √(169)?", answers: [12, 13, 14], correct: 13 }
            ]
        };

        // Initialize the game
        function init() {
            generateLevelSelect();
            setupEventListeners();
        }

        function generateLevelSelect() {
            const levelGrid = document.getElementById('levelGrid');
            levelGrid.innerHTML = '';

            for (let i = 1; i <= 10; i++) {
                const button = document.createElement('button');
                button.className = 'level-button';
                
                const isCompleted = completedLevels.includes(i);
                const isLocked = i > 1 && !completedLevels.includes(i - 1);
                
                if (isCompleted) {
                    button.classList.add('completed');
                } else if (isLocked) {
                    button.classList.add('locked');
                }

                const config = levelConfigs[i];
                button.innerHTML = `
                    <div style="font-size: 24px; margin-bottom: 5px;">Level ${i}</div>
                    <div style="font-size: 14px; font-weight: normal;">${config.title}</div>
                    <div class="level-info">
                        ${isCompleted ? '✅ Completed' : isLocked ? '🔒 Locked' : '▶️ Available'}
                    </div>
                `;

                if (!isLocked) {
                    button.onclick = () => startLevel(i);
                }

                levelGrid.appendChild(button);
            }
        }

        function startLevel(levelNum) {
            currentLevelNum = levelNum;
            const config = levelConfigs[levelNum];
            
            // Hide level select, show game
            document.getElementById('levelSelect').classList.add('hidden');
            document.getElementById('gameScreen').classList.remove('hidden');
            
            // Update UI
            document.getElementById('gameTitle').textContent = `🌟 MIRROR MAZE 🌟`;
            document.getElementById('gameSubtitle').textContent = `Level ${levelNum} - ${config.title}`;
            document.getElementById('levelObjective').textContent = config.objective;
            document.getElementById('currentLevel').textContent = levelNum;
            
            // Update features
            const featuresContainer = document.getElementById('levelFeatures');
            featuresContainer.innerHTML = '';
            config.features.forEach(feature => {
                const item = document.createElement('div');
                item.className = 'instruction-item';
                item.innerHTML = `
                    <div class="instruction-icon">✨</div>
                    <div class="instruction-text">${feature}</div>
                `;
                featuresContainer.appendChild(item);
            });
            
            // Initialize game state
            initializeLevel(config);
            startTimer();
            gameActive = true;
            gameLoop();
        }

        function initializeLevel(config) {
            // Get maze element
            maze = document.getElementById('maze');
            
            // Clear maze but keep orb
            maze.innerHTML = '';
            
            // Create orb element
            const orbElement = document.createElement('div');
            orbElement.className = 'orb';
            orbElement.id = 'orb';
            maze.appendChild(orbElement);
            
            // Set up game objects
            orb = document.getElementById('orb');
            orbPosition = { ...config.startPos };
            velocity = { x: 0, y: 0 };
            isInMirrorZone = false;
            onIce = false;
            speedBoostActive = false;
            gatesPassed = 0;
            currentGate = null;
            
            // Create walls
            walls = config.walls || [];
            walls.forEach(wall => {
                const wallElement = document.createElement('div');
                wallElement.className = 'wall';
                wallElement.style.left = wall.x + 'px';
                wallElement.style.top = wall.y + 'px';
                wallElement.style.width = wall.width + 'px';
                wallElement.style.height = wall.height + 'px';
                maze.appendChild(wallElement);
            });
            
            // Create mirror zones
            mirrorZones = config.mirrorZones || [];
            mirrorZones.forEach(zone => {
                const zoneElement = document.createElement('div');
                zoneElement.className = 'mirror-zone';
                zoneElement.style.left = zone.x + 'px';
                zoneElement.style.top = zone.y + 'px';
                zoneElement.style.width = zone.width + 'px';
                zoneElement.style.height = zone.height + 'px';
                maze.appendChild(zoneElement);
            });
            
            // Create laser gates
            laserGates = (config.laserGates || []).map((gate, index) => {
                const gateElement = document.createElement('div');
                gateElement.className = 'laser-gate';
                gateElement.id = `gate${index}`;
                gateElement.style.left = gate.x + 'px';
                gateElement.style.top = gate.y + 'px';
                gateElement.style.height = gate.height + 'px';
                maze.appendChild(gateElement);
                return { ...gate, element: gateElement };
            });
            
            // Update gates counter
            if (laserGates.length > 0) {
                document.getElementById('gatesCounter').classList.remove('hidden');
                document.getElementById('totalGates').textContent = laserGates.length;
                document.getElementById('gates').textContent = '0';
            } else {
                document.getElementById('gatesCounter').classList.add('hidden');
            }
            
            // Create teleporters
            teleporters = config.teleporters || [];
            teleporters.forEach(teleporter => {
                const teleElement = document.createElement('div');
                teleElement.className = 'teleporter';
                teleElement.style.left = teleporter.x + 'px';
                teleElement.style.top = teleporter.y + 'px';
                teleElement.style.width = teleporter.width + 'px';
                teleElement.style.height = teleporter.height + 'px';
                maze.appendChild(teleElement);
            });
            
            // Create moving platforms
            movingPlatforms = (config.movingPlatforms || []).map(platform => {
                const platformElement = document.createElement('div');
                platformElement.className = 'moving-platform';
                platformElement.style.left = platform.x + 'px';
                platformElement.style.top = platform.y + 'px';
                platformElement.style.width = platform.width + 'px';
                platformElement.style.height = platform.height + 'px';
                maze.appendChild(platformElement);
                return { ...platform, element: platformElement, direction: 1 };
            });
            
            // Create ice zones
            iceZones = config.iceZones || [];
            iceZones.forEach(zone => {
                const iceElement = document.createElement('div');
                iceElement.className = 'ice-zone';
                iceElement.style.left = zone.x + 'px';
                iceElement.style.top = zone.y + 'px';
                iceElement.style.width = zone.width + 'px';
                iceElement.style.height = zone.height + 'px';
                maze.appendChild(iceElement);
            });
            
            // Create speed boosts
            speedBoosts = (config.speedBoosts || []).map(boost => {
                const boostElement = document.createElement('div');
                boostElement.className = 'speed-boost';
                boostElement.style.left = boost.x + 'px';
                boostElement.style.top = boost.y + 'px';
                boostElement.style.width = boost.width + 'px';
                boostElement.style.height = boost.height + 'px';
                maze.appendChild(boostElement);
                return { ...boost, element: boostElement, collected: false };
            });
            
            // Create goal
            const goalElement = document.createElement('div');
            goalElement.className = 'goal';
            goalElement.style.left = config.goal.x + 'px';
            goalElement.style.top = config.goal.y + 'px';
            maze.appendChild(goalElement);
            
            updateOrbPosition();
            updateMinimap();
        }

        function updateOrbPosition() {
            if (!orb) return;
            
            orb.style.left = orbPosition.x + 'px';
            orb.style.top = orbPosition.y + 'px';
            orb.style.display = 'block';
            orb.style.visibility = 'visible';
            
            // Update camera to follow orb
            const offsetX = Math.max(-450, Math.min(450, orbPosition.x - 900));
            const offsetY = Math.max(-300, Math.min(300, orbPosition.y - 600));
            maze.style.transform = `translate(${-50 - offsetX/40}%, ${-50 - offsetY/40}%) scale(0.45)`;
            
            updateMinimap();
        }

        function updateMinimap() {
            const minimapWidth = 200;
            const minimapHeight = 120;
            const mazeWidth = 1800;
            const mazeHeight = 1200;
            
            // Orb position on minimap
            const orbMinimapX = (orbPosition.x / mazeWidth) * minimapWidth - 4; // Center the orb
            const orbMinimapY = (orbPosition.y / mazeHeight) * minimapHeight - 4;
            document.getElementById('minimapOrb').style.left = Math.max(0, Math.min(minimapWidth - 8, orbMinimapX)) + 'px';
            document.getElementById('minimapOrb').style.top = Math.max(0, Math.min(minimapHeight - 8, orbMinimapY)) + 'px';
            
            // Goal position on minimap
            const config = levelConfigs[currentLevelNum];
            const goalMinimapX = (config.goal.x / mazeWidth) * minimapWidth - 5; // Center the goal
            const goalMinimapY = (config.goal.y / mazeHeight) * minimapHeight - 5;
            document.getElementById('minimapGoal').style.left = Math.max(0, Math.min(minimapWidth - 10, goalMinimapX)) + 'px';
            document.getElementById('minimapGoal').style.top = Math.max(0, Math.min(minimapHeight - 10, goalMinimapY)) + 'px';
        }

        function startTimer() {
            startTime = Date.now();
            gameTimer = setInterval(() => {
                if (gameActive) {
                    const elapsed = Math.floor((Date.now() - startTime) / 1000);
                    const minutes = Math.floor(elapsed / 60);
                    const seconds = elapsed % 60;
                    document.getElementById('timer').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                }
            }, 1000);
        }

        function checkCollisions() {
            const orbRect = {
                left: orbPosition.x,
                right: orbPosition.x + 20,
                top: orbPosition.y,
                bottom: orbPosition.y + 20
            };

            // Wall collisions
            for (let wall of walls) {
                if (orbRect.right > wall.x && 
                    orbRect.left < wall.x + wall.width && 
                    orbRect.bottom > wall.y && 
                    orbRect.top < wall.y + wall.height) {
                    
                    const overlapX = Math.min(orbRect.right - wall.x, wall.x + wall.width - orbRect.left);
                    const overlapY = Math.min(orbRect.bottom - wall.y, wall.y + wall.height - orbRect.top);
                    
                    if (overlapX < overlapY) {
                        if (orbPosition.x < wall.x) {
                            orbPosition.x = wall.x - 20;
                        } else {
                            orbPosition.x = wall.x + wall.width;
                        }
                        velocity.x *= -0.5;
                    } else {
                        if (orbPosition.y < wall.y) {
                            orbPosition.y = wall.y - 20;
                        } else {
                            orbPosition.y = wall.y + wall.height;
                        }
                        velocity.y *= -0.5;
                    }
                    return true;
                }
            }

            // Moving platform collisions
            for (let platform of movingPlatforms) {
                if (orbRect.right > platform.x && 
                    orbRect.left < platform.x + platform.width && 
                    orbRect.bottom > platform.y && 
                    orbRect.top < platform.y + platform.height) {
                    
                    // Move orb with platform
                    orbPosition.x += platform.speed * platform.direction;
                    return false;
                }
            }

            return false;
        }

        function checkSpecialZones() {
            const orbCenter = {
                x: orbPosition.x + 10,
                y: orbPosition.y + 10
            };

            // Mirror zones
            let inMirror = false;
            for (let zone of mirrorZones) {
                if (orbCenter.x > zone.x && orbCenter.x < zone.x + zone.width && 
                    orbCenter.y > zone.y && orbCenter.y < zone.y + zone.height) {
                    inMirror = true;
                    break;
                }
            }
            isInMirrorZone = inMirror;

            // Ice zones
            onIce = false;
            for (let zone of iceZones) {
                if (orbCenter.x > zone.x && orbCenter.x < zone.x + zone.width && 
                    orbCenter.y > zone.y && orbCenter.y < zone.y + zone.height) {
                    onIce = true;
                    break;
                }
            }

            // Teleporters
            for (let teleporter of teleporters) {
                if (orbCenter.x > teleporter.x && orbCenter.x < teleporter.x + teleporter.width && 
                    orbCenter.y > teleporter.y && orbCenter.y < teleporter.y + teleporter.height) {
                    orbPosition.x = teleporter.target.x;
                    orbPosition.y = teleporter.target.y;
                    velocity.x *= 0.5;
                    velocity.y *= 0.5;
                    break;
                }
            }

            // Speed boosts
            for (let boost of speedBoosts) {
                if (!boost.collected && 
                    orbCenter.x > boost.x && orbCenter.x < boost.x + boost.width && 
                    orbCenter.y > boost.y && orbCenter.y < boost.y + boost.height) {
                    boost.collected = true;
                    boost.element.style.display = 'none';
                    speedBoostActive = true;
                    setTimeout(() => { speedBoostActive = false; }, 3000);
                    break;
                }
            }
        }

        function checkLaserGates() {
            for (let i = 0; i < laserGates.length; i++) {
                const gate = laserGates[i];
                if (gate.element.classList.contains('open')) continue;
                
                if (orbPosition.x + 20 > gate.x && 
                    orbPosition.x < gate.x + gate.width && 
                    orbPosition.y + 20 > gate.y && 
                    orbPosition.y < gate.y + gate.height) {
                    
                    currentGate = gate;
                    showPuzzle(i);
                    return;
                }
            }
        }

        function checkGoal() {
            const config = levelConfigs[currentLevelNum];
            const goalX = config.goal.x;
            const goalY = config.goal.y;
            const goalSize = 50;

            if (orbPosition.x + 20 > goalX && 
                orbPosition.x < goalX + goalSize && 
                orbPosition.y + 20 > goalY && 
                orbPosition.y < goalY + goalSize) {
                
                completeLevel();
            }
        }

        function showPuzzle(gateIndex) {
            gameActive = false;
            
            let puzzleSet;
            if (currentLevelNum <= 3) puzzleSet = puzzleSets.basic;
            else if (currentLevelNum <= 6) puzzleSet = puzzleSets.intermediate;
            else if (currentLevelNum <= 8) puzzleSet = puzzleSets.advanced;
            else puzzleSet = puzzleSets.expert;
            
            const puzzle = puzzleSet[gateIndex % puzzleSet.length];
            
            document.getElementById('puzzleTitle').textContent = `Gate ${gateIndex + 1} Puzzle`;
            document.getElementById('puzzleQuestion').textContent = puzzle.question;
            
            const buttonsContainer = document.getElementById('puzzleButtons');
            buttonsContainer.innerHTML = '';
            puzzle.answers.forEach(answer => {
                const btn = document.createElement('button');
                btn.className = 'puzzle-button';
                btn.textContent = answer;
                btn.onclick = () => answerPuzzle(answer, puzzle.correct);
                buttonsContainer.appendChild(btn);
            });
            
            document.getElementById('puzzleModal').style.display = 'flex';
        }

        function answerPuzzle(answer, correct) {
            document.getElementById('puzzleModal').style.display = 'none';
            
            if (answer === correct) {
                currentGate.element.classList.add('open');
                gatesPassed++;
                document.getElementById('gates').textContent = gatesPassed;
            } else {
                // Wrong answer - bounce back
                velocity.x = -velocity.x * 2;
                velocity.y = -velocity.y * 2;
            }
            
            gameActive = true;
        }

        function updateMovingPlatforms() {
            for (let platform of movingPlatforms) {
                platform.x += platform.speed * platform.direction;
                
                if (platform.x <= platform.startX || platform.x >= platform.endX) {
                    platform.direction *= -1;
                }
                
                platform.element.style.left = platform.x + 'px';
            }
        }

        function gameLoop() {
            if (!gameActive) {
                requestAnimationFrame(gameLoop);
                return;
            }

            // Apply friction (less on ice)
            const friction = onIce ? 0.98 : 0.95;
            velocity.x *= friction;
            velocity.y *= friction;

            // Update position
            orbPosition.x += velocity.x;
            orbPosition.y += velocity.y;

            // Boundary checks
            orbPosition.x = Math.max(20, Math.min(1760, orbPosition.x));
            orbPosition.y = Math.max(20, Math.min(1160, orbPosition.y));

            // Update moving platforms
            updateMovingPlatforms();

            // Check all interactions
            checkCollisions();
            checkSpecialZones();
            checkLaserGates();
            checkGoal();

            // Update display
            updateOrbPosition();
            
            // Update speed display
            const speed = Math.sqrt(velocity.x * velocity.x + velocity.y * velocity.y);
            document.getElementById('speed').textContent = Math.round(speed * 10) / 10;

            requestAnimationFrame(gameLoop);
        }

        function completeLevel() {
            gameActive = false;
            clearInterval(gameTimer);
            
            const completionTime = Math.floor((Date.now() - startTime) / 1000);
            
            // Save progress
            if (!completedLevels.includes(currentLevelNum)) {
                completedLevels.push(currentLevelNum);
                localStorage.setItem('mazeCompletedLevels', JSON.stringify(completedLevels));
            }
            
            // Save stats
            levelStats[currentLevelNum] = {
                time: completionTime,
                date: new Date().toLocaleDateString()
            };
            localStorage.setItem('mazeLevelStats', JSON.stringify(levelStats));
            
            // Show completion screen
            document.getElementById('gameScreen').classList.add('hidden');
            document.getElementById('levelCompleteScreen').classList.remove('hidden');
            
            const minutes = Math.floor(completionTime / 60);
            const seconds = completionTime % 60;
            
            document.getElementById('completeTitle').textContent = 
                currentLevelNum === 10 ? '👑 MAZE MASTER! 👑' : '🎉 LEVEL COMPLETE! 🎉';
            
            document.getElementById('levelStats').innerHTML = `
                <div><strong>Level ${currentLevelNum} Complete!</strong></div>
                <div>Time: ${minutes}:${seconds.toString().padStart(2, '0')}</div>
                <div>Gates Solved: ${gatesPassed}</div>
                ${currentLevelNum === 10 ? '<div style="color: #ffd700; margin-top: 15px;"><strong>🏆 Congratulations! You have mastered all 10 levels! 🏆</strong></div>' : ''}
            `;
            
            const nextBtn = document.getElementById('nextLevelBtn');
            if (currentLevelNum < 10) {
                nextBtn.style.display = 'inline-block';
                nextBtn.textContent = `Level ${currentLevelNum + 1} →`;
            } else {
                nextBtn.style.display = 'none';
            }
        }

        function nextLevel() {
            if (currentLevelNum < 10) {
                startLevel(currentLevelNum + 1);
                document.getElementById('levelCompleteScreen').classList.add('hidden');
            }
        }

        function goToLevelSelect() {
            gameActive = false;
            if (gameTimer) clearInterval(gameTimer);
            
            document.getElementById('gameScreen').classList.add('hidden');
            document.getElementById('levelCompleteScreen').classList.add('hidden');
            document.getElementById('levelSelect').classList.remove('hidden');
            
            generateLevelSelect();
        }

        function goToGamePage() {
            // Redirect to game.php
            window.location.href = 'game.php';
        }

        function resetProgress() {
            if (confirm('Are you sure you want to reset all progress? This cannot be undone.')) {
                completedLevels = [];
                levelStats = {};
                localStorage.removeItem('mazeCompletedLevels');
                localStorage.removeItem('mazeLevelStats');
                generateLevelSelect();
            }
        }

        function setupEventListeners() {
            // Detect mobile device
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || window.innerWidth <= 768;
            
            if (isMobile) {
                document.getElementById('mobileControls').style.display = 'block';
            }

            // Keyboard controls
            const keys = {};
            
            document.addEventListener('keydown', (e) => {
                keys[e.key.toLowerCase()] = true;
                e.preventDefault();
            });
            
            document.addEventListener('keyup', (e) => {
                keys[e.key.toLowerCase()] = false;
                e.preventDefault();
            });

            // Touch controls for mobile
            const controlButtons = document.querySelectorAll('.control-btn');
            controlButtons.forEach(btn => {
                const direction = btn.dataset.direction;
                
                btn.addEventListener('touchstart', (e) => {
                    e.preventDefault();
                    keys[direction] = true;
                });
                
                btn.addEventListener('touchend', (e) => {
                    e.preventDefault();
                    keys[direction] = false;
                });
                
                btn.addEventListener('mousedown', (e) => {
                    e.preventDefault();
                    keys[direction] = true;
                });
                
                btn.addEventListener('mouseup', (e) => {
                    e.preventDefault();
                    keys[direction] = false;
                });
            });

            // Movement function
            function handleMovement() {
                if (!gameActive || !orb) return;

                const baseAcceleration = 0.8;
                const acceleration = speedBoostActive ? baseAcceleration * 1.5 : baseAcceleration;
                const maxSpeed = speedBoostActive ? 8 : (onIce ? 6 : 5);

                let moveX = 0;
                let moveY = 0;

                // Check all possible key combinations
                if (keys['arrowup'] || keys['w'] || keys['up']) moveY = -1;
                if (keys['arrowdown'] || keys['s'] || keys['down']) moveY = 1;
                if (keys['arrowleft'] || keys['a'] || keys['left']) moveX = -1;
                if (keys['arrowright'] || keys['d'] || keys['right']) moveX = 1;

                // Apply mirror zone inversion
                if (isInMirrorZone) {
                    moveX *= -1;
                    moveY *= -1;
                }

                // Apply acceleration
                if (moveX !== 0 || moveY !== 0) {
                    velocity.x += moveX * acceleration;
                    velocity.y += moveY * acceleration;

                    // Limit speed
                    velocity.x = Math.max(-maxSpeed, Math.min(maxSpeed, velocity.x));
                    velocity.y = Math.max(-maxSpeed, Math.min(maxSpeed, velocity.y));
                }
            }

            // Movement loop
            function movementLoop() {
                handleMovement();
                requestAnimationFrame(movementLoop);
            }
            movementLoop();
        }

        // Initialize the game when page loads
        init();
    </script>
</body>
</html>