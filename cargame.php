<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Connect - Memory Matching Ice Breaker</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #ff6b6b, #feca57);
            padding: 30px;
            text-align: center;
            color: white;
        }
        
        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .game-stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .game-area {
            padding: 30px;
        }
        
        .game-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            max-width: 600px;
            margin: 0 auto 30px;
        }
        
        .card {
            aspect-ratio: 1;
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .card.flipped {
            background: white;
            border: 3px solid #74b9ff;
        }
        
        .card.matched {
            background: linear-gradient(135deg, #00b894, #00a085);
            transform: scale(0.95);
        }
        
        .card-back {
            font-size: 2rem;
            color: white;
        }
        
        .card-front {
            font-size: 3rem;
            display: none;
        }
        
        .card.flipped .card-back {
            display: none;
        }
        
        .card.flipped .card-front {
            display: block;
        }
        
        .question-section {
            background: linear-gradient(135deg, #fd79a8, #e84393);
            border-radius: 15px;
            padding: 25px;
            margin-top: 20px;
            color: white;
            text-align: center;
        }
        
        .question-section h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        
        .question {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }
        
        .new-question-btn {
            background: white;
            color: #e84393;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .new-question-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .controls {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-secondary {
            background: #f8f9fa;
            color: #333;
            border: 2px solid #dee2e6;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .celebration {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
            display: none;
            z-index: 1000;
        }
        
        .celebration h2 {
            color: #00b894;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            z-index: 999;
        }
        
        @media (max-width: 768px) {
            .game-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .game-stats {
                gap: 20px;
            }
            
            .controls {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎯 Team Connect</h1>
            <p>Memory Matching Ice Breaker Game</p>
        </div>
        
        <div class="game-stats">
            <div class="stat">
                <div class="stat-number" id="moves">0</div>
                <div class="stat-label">Moves</div>
            </div>
            <div class="stat">
                <div class="stat-number" id="matches">0</div>
                <div class="stat-label">Matches</div>
            </div>
            <div class="stat">
                <div class="stat-number" id="timer">0:00</div>
                <div class="stat-label">Time</div>
            </div>
        </div>
        
        <div class="game-area">
            <div class="game-grid" id="gameGrid"></div>
            
            <div class="question-section">
                <h3>💬 Ice Breaker Question</h3>
                <div class="question" id="currentQuestion">What emoji best describes your morning?</div>
                <button class="new-question-btn" onclick="newQuestion()">New Question</button>
            </div>
            
            <div class="controls">
                <button class="btn btn-primary" onclick="resetGame()">🔄 New Game</button>
                <button class="btn btn-secondary" onclick="showInstructions()">❓ How to Play</button>
            </div>
        </div>
    </div>
    
    <div class="overlay" id="overlay"></div>
    <div class="celebration" id="celebration">
        <h2>🎉 Congratulations!</h2>
        <p>You've completed the memory game!</p>
        <p>Now use the ice breaker questions to connect with your team!</p>
        <button class="btn btn-primary" onclick="hideCelebration()">Continue Connecting</button>
    </div>

    <script>
        // Replace these URLs with your own images
        const imageUrls = [
            'https://via.placeholder.com/150/FF6B6B/FFFFFF?text=Image+1',
            'https://via.placeholder.com/150/4ECDC4/FFFFFF?text=Image+2',
            'https://via.placeholder.com/150/45B7D1/FFFFFF?text=Image+3',
            'https://via.placeholder.com/150/96CEB4/FFFFFF?text=Image+4',
            'https://via.placeholder.com/150/FFEAA7/000000?text=Image+5',
            'https://via.placeholder.com/150/DDA0DD/FFFFFF?text=Image+6'
        ];
        
        const questions = [
            "What image best represents your morning routine?",
            "What's a work skill you're proud of developing?",
            "If you could have any superpower at work, what would it be?",
            "What's your favorite way to celebrate small wins?",
            "What's one thing that always makes you smile during the workday?",
            "If your job was a movie genre, what would it be?",
            "What's the best piece of advice you've received recently?",
            "What's your go-to productivity hack?",
            "If you could learn any new skill instantly, what would it be?",
            "What's something you're looking forward to this week?"
        ];
        
        let gameState = {
            cards: [],
            flippedCards: [],
            matches: 0,
            moves: 0,
            gameStarted: false,
            startTime: null,
            timerInterval: null
        };
        
        function initGame() {
            // Create pairs of images
            const cardImages = [...imageUrls, ...imageUrls];
            
            // Shuffle the cards
            for (let i = cardImages.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [cardImages[i], cardImages[j]] = [cardImages[j], cardImages[i]];
            }
            
            gameState.cards = cardImages;
            gameState.flippedCards = [];
            gameState.matches = 0;
            gameState.moves = 0;
            gameState.gameStarted = false;
            
            renderGame();
            updateStats();
            newQuestion();
        }
        
        function renderGame() {
            const grid = document.getElementById('gameGrid');
            grid.innerHTML = '';
            
            gameState.cards.forEach((imageUrl, index) => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <div class="card-back">🎯</div>
                    <div class="card-front">
                        <img src="${imageUrl}" alt="Memory card" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;" onerror="this.src=''; this.alt='Image failed to load'; this.style.display='none';">
                    </div>
                `;
                card.onclick = () => flipCard(index);
                grid.appendChild(card);
            });
        }
        
        function flipCard(index) {
            if (!gameState.gameStarted) {
                startTimer();
                gameState.gameStarted = true;
            }
            
            const card = document.querySelectorAll('.card')[index];
            
            // Don't flip if already flipped or matched
            if (card.classList.contains('flipped') || card.classList.contains('matched')) {
                return;
            }
            
            // Don't flip if two cards are already flipped
            if (gameState.flippedCards.length >= 2) {
                return;
            }
            
            card.classList.add('flipped');
            gameState.flippedCards.push(index);
            
            if (gameState.flippedCards.length === 2) {
                gameState.moves++;
                updateStats();
                
                setTimeout(() => {
                    checkMatch();
                }, 1000);
            }
        }
        
        function checkMatch() {
            const [first, second] = gameState.flippedCards;
            const cards = document.querySelectorAll('.card');
            
            if (gameState.cards[first] === gameState.cards[second]) {
                // Match found
                cards[first].classList.add('matched');
                cards[second].classList.add('matched');
                gameState.matches++;
                
                if (gameState.matches === imageUrls.length) {
                    // Game completed
                    setTimeout(() => {
                        showCelebration();
                        stopTimer();
                    }, 500);
                }
            } else {
                // No match
                cards[first].classList.remove('flipped');
                cards[second].classList.remove('flipped');
            }
            
            gameState.flippedCards = [];
            updateStats();
        }
        
        function updateStats() {
            document.getElementById('moves').textContent = gameState.moves;
            document.getElementById('matches').textContent = gameState.matches;
        }
        
        function startTimer() {
            gameState.startTime = Date.now();
            gameState.timerInterval = setInterval(() => {
                const elapsed = Math.floor((Date.now() - gameState.startTime) / 1000);
                const minutes = Math.floor(elapsed / 60);
                const seconds = elapsed % 60;
                document.getElementById('timer').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }
        
        function stopTimer() {
            if (gameState.timerInterval) {
                clearInterval(gameState.timerInterval);
                gameState.timerInterval = null;
            }
        }
        
        function resetGame() {
            stopTimer();
            document.getElementById('timer').textContent = '0:00';
            initGame();
        }
        
        function newQuestion() {
            const randomQuestion = questions[Math.floor(Math.random() * questions.length)];
            document.getElementById('currentQuestion').textContent = randomQuestion;
        }
        
        function showCelebration() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('celebration').style.display = 'block';
        }
        
        function hideCelebration() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('celebration').style.display = 'none';
        }
        
        function showInstructions() {
            alert('How to Play Team Connect:\n\n1. Click cards to flip them over\n2. Find matching emoji pairs\n3. Use the ice breaker questions to start conversations\n4. Complete all matches to win!\n\nPerfect for team meetings and getting to know each other!');
        }
        
        // Initialize the game when page loads
        initGame();
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9801f383407911b0',t:'MTc1ODA0MjM1My4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
