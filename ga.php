<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeuroLink - Mind Game</title>
    <style>
        body {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Courier New', monospace;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #16213e 100%);
            color: #ffffffff;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }

        .neon-text {
            text-shadow: 0 0 5px #00ffff, 0 0 10px #00ffff, 0 0 15px #00ffff, 0 0 20px #00ffff;
            animation: textGlow 2s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            from { text-shadow: 0 0 5px #00ffff, 0 0 10px #00ffff, 0 0 15px #00ffff, 0 0 20px #00ffff; }
            to { text-shadow: 0 0 10px #00ffff, 0 0 20px #00ffff, 0 0 30px #00ffff, 0 0 40px #00ffff; }
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 3rem;
            margin: 0;
            background: linear-gradient(45deg, #00ffff, #ff00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1.2rem;
            margin: 10px 0;
            opacity: 0.8;
        }

        .game-stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-item {
            background: rgba(0, 255, 255, 0.1);
            border: 2px solid #00ffff;
            border-radius: 10px;
            padding: 15px 25px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 30px rgba(0, 255, 255, 0.5);
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.7;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .game-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .game-card {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.1), rgba(255, 0, 255, 0.1));
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .game-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #416666ff, #59dbe2ff, #1b9e9aff, #1d87aaff);
            border-radius: 15px;
            z-index: -1;
            animation: borderGlow 3s linear infinite;
        }

        @keyframes borderGlow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .game-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 255, 255, 0.4);
        }

        .game-card h3 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #fdfdfdff;
        }

        .game-card p {
            opacity: 0.8;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .btn {
            background: linear-gradient(45deg, #00ffff, #0080ff);
            border: none;
            color: #000;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 255, 255, 0.4);
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 10px 25px rgba(0, 255, 255, 0.4); }
            50% { box-shadow: 0 10px 35px rgba(0, 255, 255, 0.6); }
            100% { box-shadow: 0 10px 25px rgba(0, 255, 255, 0.4); }
        }

        .game-area {
            display: none;
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #00ffff;
            border-radius: 20px;
            padding: 40px;
            margin-top: 30px;
            box-shadow: 0 0 50px rgba(0, 255, 255, 0.3);
        }

        .game-area.active {
            display: block;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .game-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .game-title {
            font-size: 2rem;
            color: #ff00ff;
        }

        .game-controls {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .timer {
            font-size: 1.5rem;
            color: #ffff00;
            font-weight: bold;
        }

        .pattern-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            max-width: 400px;
            margin: 0 auto 30px;
        }

        .pattern-cell {
            aspect-ratio: 1;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid #333;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .pattern-cell:hover {
            border-color: #00ffff;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
        }

        .pattern-cell.active {
            background: #00ffff;
            color: #000;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.8);
            animation: cellPulse 0.5s ease;
        }

        @keyframes cellPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .sequence-display {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .sequence-item {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .color-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .color-btn {
            width: 80px;
            height: 80px;
            border: 3px solid #fff;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .color-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
        }

        .color-btn.red { background: #ff0040; }
        .color-btn.blue { background: #0080ff; }
        .color-btn.green { background: #00ff80; }
        .color-btn.yellow { background: #ffff00; }
        .color-btn.purple { background: #ff00ff; }
        .color-btn.orange { background: #ff8000; }

        .progress-bar {
            width: 100%;
            height: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            margin: 20px 0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #00ffff, #ff00ff);
            border-radius: 5px;
            transition: width 0.3s ease;
            width: 0%;
        }

        .message {
            text-align: center;
            font-size: 1.2rem;
            margin: 20px 0;
            padding: 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .message.success {
            background: rgba(0, 255, 0, 0.2);
            border: 2px solid #00ff00;
            color: #00ff00;
        }

        .message.error {
            background: rgba(255, 0, 0, 0.2);
            border: 2px solid #ff0040;
            color: #ff0040;
        }

        .back-btn {
            background: linear-gradient(45deg, #ff00ff, #ff0040);
            margin-right: 15px;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .game-stats {
                gap: 15px;
            }
            
            .stat-item {
                padding: 10px 15px;
            }
            
            .pattern-grid {
                grid-template-columns: repeat(3, 1fr);
                max-width: 300px;
            }
            
            .color-buttons {
                gap: 10px;
            }
            
            .color-btn {
                width: 60px;
                height: 60px;
            }
            
            .game-header {
                flex-direction: column;
                text-align: center;
            }
        }

        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #00ffff;
            border-radius: 50%;
            animation: float 6s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10px) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="floating-particles" id="particles"></div>
    
    <div class="container">
        <header class="header">
            <h1 class="neon-text">NEUROLINK</h1>
            <p>Advanced Cognitive Enhancement Protocol</p>
        </header>

        <div class="game-stats">
            <div class="stat-item">
                <div class="stat-label">Neural Score</div>
                <div class="stat-value" id="totalScore">0</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Cognitive Level</div>
                <div class="stat-value" id="overallLevel">1</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Synapses Fired</div>
                <div class="stat-value" id="totalGames">0</div>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 30px;">
            <button class="btn back-btn" onclick="history.back()" style="background: linear-gradient(45deg, #666, #999); margin: 0;">
                ← Go Back
            </button>
        </div>

        <main class="game-menu" id="gameMenu">
            <div class="game-card" onclick="startGame('pattern')">
                <h3>Pattern Matrix</h3>
                <p>Analyze and replicate complex neural patterns. Test your visual processing and pattern recognition capabilities.</p>
                <button class="btn">Initialize Protocol</button>
            </div>
            
            <div class="game-card" onclick="startGame('sequence')">
                <h3>Sequence Memory</h3>
                <p>Store and recall sequential data streams. Challenge your working memory and attention span.</p>
                <button class="btn">Begin Sequence</button>
            </div>
            
            <div class="game-card" onclick="startGame('color')">
                <h3>Color Logic</h3>
                <p>Process chromatic algorithms and logical deductions. Enhance your reasoning and decision-making speed.</p>
                <button class="btn">Activate Logic</button>
            </div>
        </main>

        <!-- Pattern Game -->
        <div class="game-area" id="patternGame">
            <div class="game-header">
                <h2 class="game-title">Pattern Matrix</h2>
                <div class="game-controls">
                    <div class="timer" id="patternTimer">30</div>
                    <button class="btn back-btn" onclick="backToMenu()">Exit</button>
                </div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="patternProgress"></div>
            </div>
            <div class="message" id="patternMessage">Study the pattern, then recreate it</div>
            <div class="pattern-grid" id="patternGrid"></div>
            <button class="btn" id="patternSubmit" onclick="submitPattern()" style="display: none;">Submit Pattern</button>
        </div>

        <!-- Sequence Game -->
        <div class="game-area" id="sequenceGame">
            <div class="game-header">
                <h2 class="game-title">Sequence Memory</h2>
                <div class="game-controls">
                    <div class="timer" id="sequenceTimer">30</div>
                    <button class="btn back-btn" onclick="backToMenu()">Exit</button>
                </div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="sequenceProgress"></div>
            </div>
            <div class="message" id="sequenceMessage">Watch the sequence carefully</div>
            <div class="sequence-display" id="sequenceDisplay"></div>
            <div class="color-buttons" id="sequenceButtons" style="display: none;"></div>
        </div>

        <!-- Color Logic Game -->
        <div class="game-area" id="colorGame">
            <div class="game-header">
                <h2 class="game-title">Color Logic</h2>
                <div class="game-controls">
                    <div class="timer" id="colorTimer">45</div>
                    <button class="btn back-btn" onclick="backToMenu()">Exit</button>
                </div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="colorProgress"></div>
            </div>
            <div class="message" id="colorMessage">Find the logical pattern in the sequence</div>
            <div class="sequence-display" id="colorSequence"></div>
            <div class="color-buttons" id="colorButtons"></div>
        </div>
    </div>

    <script>
        // Game state
        let gameState = {
            currentGame: null,
            level: 1,
            score: 0,
            totalScore: parseInt(localStorage.getItem('neurolink_score') || '0'),
            totalGames: parseInt(localStorage.getItem('neurolink_games') || '0'),
            overallLevel: parseInt(localStorage.getItem('neurolink_level') || '1'),
            timer: null,
            timeLeft: 0
        };

        // Pattern game state
        let patternState = {
            pattern: [],
            userPattern: [],
            gridSize: 4,
            patternLength: 4,
            showingPattern: false
        };

        // Sequence game state
        let sequenceState = {
            sequence: [],
            userSequence: [],
            colors: ['red', 'blue', 'green', 'yellow', 'purple', 'orange'],
            sequenceLength: 3,
            showingSequence: false,
            currentStep: 0
        };

        // Color logic game state
        let colorState = {
            sequence: [],
            pattern: null,
            answer: null,
            colors: ['red', 'blue', 'green', 'yellow', 'purple', 'orange']
        };

        // Initialize particles
        function createParticles() {
            const container = document.getElementById('particles');
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
                container.appendChild(particle);
            }
        }

        // Update UI
        function updateStats() {
            document.getElementById('totalScore').textContent = gameState.totalScore;
            document.getElementById('overallLevel').textContent = gameState.overallLevel;
            document.getElementById('totalGames').textContent = gameState.totalGames;
        }

        // Save progress
        function saveProgress() {
            localStorage.setItem('neurolink_score', gameState.totalScore.toString());
            localStorage.setItem('neurolink_games', gameState.totalGames.toString());
            localStorage.setItem('neurolink_level', gameState.overallLevel.toString());
        }

        // Timer functions
        function startTimer(duration, elementId, callback) {
            gameState.timeLeft = duration;
            const timerElement = document.getElementById(elementId);
            
            gameState.timer = setInterval(() => {
                timerElement.textContent = gameState.timeLeft;
                gameState.timeLeft--;
                
                if (gameState.timeLeft < 0) {
                    clearInterval(gameState.timer);
                    callback();
                }
            }, 1000);
        }

        function stopTimer() {
            if (gameState.timer) {
                clearInterval(gameState.timer);
                gameState.timer = null;
            }
        }

        // Game navigation
        function startGame(gameType) {
            gameState.currentGame = gameType;
            gameState.level = 1;
            gameState.score = 0;
            
            document.getElementById('gameMenu').style.display = 'none';
            
            switch (gameType) {
                case 'pattern':
                    document.getElementById('patternGame').classList.add('active');
                    initPatternGame();
                    break;
                case 'sequence':
                    document.getElementById('sequenceGame').classList.add('active');
                    initSequenceGame();
                    break;
                case 'color':
                    document.getElementById('colorGame').classList.add('active');
                    initColorGame();
                    break;
            }
        }

        function backToMenu() {
            stopTimer();
            document.querySelectorAll('.game-area').forEach(area => {
                area.classList.remove('active');
            });
            document.getElementById('gameMenu').style.display = 'grid';
            gameState.currentGame = null;
        }

        function showMessage(elementId, text, type = '') {
            const element = document.getElementById(elementId);
            element.textContent = text;
            element.className = `message ${type}`;
        }

        function updateProgress(elementId, percentage) {
            document.getElementById(elementId).style.width = percentage + '%';
        }

        // Pattern Game
        function initPatternGame() {
            patternState.gridSize = Math.min(4 + Math.floor(gameState.level / 3), 6);
            patternState.patternLength = Math.min(4 + gameState.level, 12);
            
            createPatternGrid();
            generatePattern();
            showPattern();
            
            startTimer(30 + gameState.level * 5, 'patternTimer', () => {
                showMessage('patternMessage', 'Time\'s up! Try again.', 'error');
                setTimeout(() => initPatternGame(), 2000);
            });
        }

        function createPatternGrid() {
            const grid = document.getElementById('patternGrid');
            grid.innerHTML = '';
            grid.style.gridTemplateColumns = `repeat(${patternState.gridSize}, 1fr)`;
            
            for (let i = 0; i < patternState.gridSize * patternState.gridSize; i++) {
                const cell = document.createElement('div');
                cell.className = 'pattern-cell';
                cell.dataset.index = i;
                cell.addEventListener('click', () => togglePatternCell(i));
                grid.appendChild(cell);
            }
        }

        function generatePattern() {
            patternState.pattern = [];
            patternState.userPattern = [];
            
            while (patternState.pattern.length < patternState.patternLength) {
                const index = Math.floor(Math.random() * (patternState.gridSize * patternState.gridSize));
                if (!patternState.pattern.includes(index)) {
                    patternState.pattern.push(index);
                }
            }
        }

        function showPattern() {
            patternState.showingPattern = true;
            showMessage('patternMessage', 'Study this pattern carefully...');
            
            patternState.pattern.forEach((index, i) => {
                setTimeout(() => {
                    const cell = document.querySelector(`[data-index="${index}"]`);
                    cell.classList.add('active');
                }, i * 300);
            });
            
            setTimeout(() => {
                document.querySelectorAll('.pattern-cell').forEach(cell => {
                    cell.classList.remove('active');
                });
                patternState.showingPattern = false;
                showMessage('patternMessage', 'Now recreate the pattern!');
                document.getElementById('patternSubmit').style.display = 'block';
            }, patternState.pattern.length * 300 + 2000);
        }

        function togglePatternCell(index) {
            if (patternState.showingPattern) return;
            
            const cell = document.querySelector(`[data-index="${index}"]`);
            const isActive = cell.classList.contains('active');
            
            if (isActive) {
                cell.classList.remove('active');
                patternState.userPattern = patternState.userPattern.filter(i => i !== index);
            } else {
                cell.classList.add('active');
                patternState.userPattern.push(index);
            }
        }

        function submitPattern() {
            const correct = patternState.pattern.length === patternState.userPattern.length &&
                           patternState.pattern.every(index => patternState.userPattern.includes(index));
            
            if (correct) {
                gameState.score += gameState.level * 10;
                gameState.level++;
                showMessage('patternMessage', `Perfect! Level ${gameState.level}`, 'success');
                updateProgress('patternProgress', Math.min((gameState.level - 1) * 10, 100));
                
                setTimeout(() => {
                    document.getElementById('patternSubmit').style.display = 'none';
                    initPatternGame();
                }, 1500);
            } else {
                showMessage('patternMessage', 'Incorrect pattern. Try again!', 'error');
                setTimeout(() => {
                    document.querySelectorAll('.pattern-cell').forEach(cell => {
                        cell.classList.remove('active');
                    });
                    patternState.userPattern = [];
                    showMessage('patternMessage', 'Recreate the pattern');
                }, 1500);
            }
        }

        // Sequence Game
        function initSequenceGame() {
            sequenceState.sequenceLength = Math.min(3 + gameState.level, 8);
            sequenceState.sequence = [];
            sequenceState.userSequence = [];
            sequenceState.currentStep = 0;
            
            generateSequence();
            showSequence();
            
            startTimer(20 + gameState.level * 3, 'sequenceTimer', () => {
                showMessage('sequenceMessage', 'Time\'s up! Try again.', 'error');
                setTimeout(() => initSequenceGame(), 2000);
            });
        }

        function generateSequence() {
            for (let i = 0; i < sequenceState.sequenceLength; i++) {
                sequenceState.sequence.push(
                    sequenceState.colors[Math.floor(Math.random() * sequenceState.colors.length)]
                );
            }
        }

        function showSequence() {
            const display = document.getElementById('sequenceDisplay');
            const buttons = document.getElementById('sequenceButtons');
            
            display.innerHTML = '';
            buttons.style.display = 'none';
            
            showMessage('sequenceMessage', 'Watch the sequence...');
            
            sequenceState.sequence.forEach((color, index) => {
                const item = document.createElement('div');
                item.className = 'sequence-item';
                item.style.backgroundColor = getColorValue(color);
                item.style.opacity = '0.3';
                display.appendChild(item);
                
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        item.style.transform = 'scale(1)';
                    }, 300);
                }, index * 600);
            });
            
            setTimeout(() => {
                showMessage('sequenceMessage', 'Now repeat the sequence!');
                createSequenceButtons();
                buttons.style.display = 'flex';
            }, sequenceState.sequence.length * 600 + 1000);
        }

        function createSequenceButtons() {
            const buttons = document.getElementById('sequenceButtons');
            buttons.innerHTML = '';
            
            sequenceState.colors.forEach(color => {
                const button = document.createElement('div');
                button.className = `color-btn ${color}`;
                button.addEventListener('click', () => selectSequenceColor(color));
                buttons.appendChild(button);
            });
        }

        function selectSequenceColor(color) {
            sequenceState.userSequence.push(color);
            
            if (sequenceState.userSequence[sequenceState.currentStep] === sequenceState.sequence[sequenceState.currentStep]) {
                sequenceState.currentStep++;
                
                if (sequenceState.currentStep === sequenceState.sequence.length) {
                    gameState.score += gameState.level * 15;
                    gameState.level++;
                    showMessage('sequenceMessage', `Excellent! Level ${gameState.level}`, 'success');
                    updateProgress('sequenceProgress', Math.min((gameState.level - 1) * 10, 100));
                    
                    setTimeout(() => initSequenceGame(), 2000);
                }
            } else {
                showMessage('sequenceMessage', 'Wrong sequence! Try again.', 'error');
                setTimeout(() => initSequenceGame(), 2000);
            }
        }

        // Color Logic Game
        function initColorGame() {
            colorState.sequence = [];
            generateColorLogicPuzzle();
            displayColorPuzzle();
            
            startTimer(45 + gameState.level * 5, 'colorTimer', () => {
                showMessage('colorMessage', 'Time\'s up! Try again.', 'error');
                setTimeout(() => initColorGame(), 2000);
            });
        }

        function generateColorLogicPuzzle() {
            const patterns = ['alternating', 'increment', 'fibonacci', 'prime'];
            colorState.pattern = patterns[Math.floor(Math.random() * patterns.length)];
            
            const baseLength = 4 + gameState.level;
            
            switch (colorState.pattern) {
                case 'alternating':
                    for (let i = 0; i < baseLength; i++) {
                        colorState.sequence.push(colorState.colors[i % 2]);
                    }
                    colorState.answer = colorState.colors[(baseLength) % 2];
                    break;
                    
                case 'increment':
                    for (let i = 0; i < baseLength; i++) {
                        colorState.sequence.push(colorState.colors[i % colorState.colors.length]);
                    }
                    colorState.answer = colorState.colors[baseLength % colorState.colors.length];
                    break;
                    
                case 'fibonacci':
                    const fib = [0, 1];
                    for (let i = 2; i < baseLength; i++) {
                        fib.push((fib[i-1] + fib[i-2]) % colorState.colors.length);
                    }
                    colorState.sequence = fib.map(n => colorState.colors[n]);
                    const nextFib = (fib[fib.length-1] + fib[fib.length-2]) % colorState.colors.length;
                    colorState.answer = colorState.colors[nextFib];
                    break;
                    
                case 'prime':
                    const primes = [2, 3, 5, 7, 11, 13, 17, 19];
                    for (let i = 0; i < baseLength; i++) {
                        colorState.sequence.push(colorState.colors[primes[i] % colorState.colors.length]);
                    }
                    colorState.answer = colorState.colors[primes[baseLength] % colorState.colors.length];
                    break;
            }
        }

        function displayColorPuzzle() {
            const display = document.getElementById('colorSequence');
            const buttons = document.getElementById('colorButtons');
            
            display.innerHTML = '';
            buttons.innerHTML = '';
            
            showMessage('colorMessage', 'Find the pattern and select the next color');
            
            colorState.sequence.forEach((color, index) => {
                const item = document.createElement('div');
                item.className = 'sequence-item';
                item.style.backgroundColor = getColorValue(color);
                item.textContent = index + 1;
                display.appendChild(item);
            });
            
            // Add question mark for next item
            const questionItem = document.createElement('div');
            questionItem.className = 'sequence-item';
            questionItem.style.backgroundColor = '#333';
            questionItem.style.border = '3px dashed #00ffff';
            questionItem.textContent = '?';
            display.appendChild(questionItem);
            
            // Create answer buttons
            colorState.colors.forEach(color => {
                const button = document.createElement('div');
                button.className = `color-btn ${color}`;
                button.addEventListener('click', () => selectColorAnswer(color));
                buttons.appendChild(button);
            });
        }

        function selectColorAnswer(selectedColor) {
            if (selectedColor === colorState.answer) {
                gameState.score += gameState.level * 20;
                gameState.level++;
                showMessage('colorMessage', `Brilliant! Level ${gameState.level}`, 'success');
                updateProgress('colorProgress', Math.min((gameState.level - 1) * 10, 100));
                
                setTimeout(() => initColorGame(), 2000);
            } else {
                showMessage('colorMessage', 'Incorrect! Study the pattern again.', 'error');
                setTimeout(() => initColorGame(), 2000);
            }
        }

        function getColorValue(colorName) {
            const colors = {
                red: '#ff0040',
                blue: '#0080ff',
                green: '#00ff80',
                yellow: '#ffff00',
                purple: '#ff00ff',
                orange: '#ff8000'
            };
            return colors[colorName];
        }

        // Game completion
        function completeGame() {
            stopTimer();
            gameState.totalScore += gameState.score;
            gameState.totalGames++;
            
            if (gameState.totalScore > gameState.overallLevel * 1000) {
                gameState.overallLevel++;
            }
            
            saveProgress();
            updateStats();
            backToMenu();
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            createParticles();
            updateStats();
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'98f52ce941af8e57',t:'MTc2MDU5Mjc0NC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
