<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hack Run - Terminal Infiltration</title>
    <style>
        body {
            box-sizing: border-box;
            margin: 0;
            padding: 40px;
            font-family: 'Courier New', monospace;
            background: #000;
            color: #00ffff;
            overflow-x: hidden;
            position: relative;
            min-height: 100vh;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* Matrix Rain Background */
        .matrix-rain {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .rain-column {
            position: absolute;
            top: -100px;
            font-size: 14px;
            line-height: 14px;
            animation: rain-fall linear infinite;
            opacity: 0.3;
            color: #ff00ff;
        }

        @keyframes rain-fall {
            to {
                transform: translateY(100vh);
            }
        }

        /* Main Game Container */
        .game-container {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            background: rgba(0, 0, 0, 0.9);
            border-radius: 20px;
            border: 2px solid #00ffff;
            box-shadow: 0 0 50px rgba(0, 255, 255, 0.3);
            animation: containerGlow 3s ease-in-out infinite alternate;
        }

        @keyframes containerGlow {
            from { box-shadow: 0 0 30px rgba(0, 255, 255, 0.2); }
            to { box-shadow: 0 0 60px rgba(0, 255, 255, 0.4); }
        }

        /* Header */
        .header {
            padding: 30px;
            border-bottom: 2px solid #00ffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 20, 0.9);
            border-radius: 20px 20px 0 0;
        }

        .nav-controls {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .nav-btn {
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #888;
            color: #888;
            padding: 10px 20px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-weight: bold;
        }

        .nav-btn:hover {
            background: rgba(136, 136, 136, 0.1);
            box-shadow: 0 0 15px #888;
            border-color: #aaa;
            transform: translateY(-2px);
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            text-shadow: 0 0 10px #00ffff;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 0 0 10px #00ffff; }
            to { text-shadow: 0 0 20px #00ffff, 0 0 30px #ff00ff; }
        }

        .stats {
            display: flex;
            gap: 30px;
            font-size: 14px;
        }

        .stat {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-label {
            color: #888;
            font-size: 12px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: bold;
        }

        /* Timer */
        .timer {
            font-size: 20px;
            color: #ff0066;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        /* Challenge Panel */
        .challenge-panel {
            width: 100%;
            max-width: 600px;
            background: rgba(0, 0, 20, 0.95);
            border: 2px solid #00ffff;
            border-radius: 20px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.2);
            animation: panelFloat 4s ease-in-out infinite alternate;
            backdrop-filter: blur(10px);
        }

        @keyframes panelFloat {
            from { transform: translateY(0px); }
            to { transform: translateY(-5px); }
        }

        .challenge-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            color: #ff00ff;
            text-shadow: 0 0 15px #ff00ff;
            animation: titlePulse 2s ease-in-out infinite alternate;
        }

        @keyframes titlePulse {
            from { text-shadow: 0 0 15px #ff00ff; }
            to { text-shadow: 0 0 25px #ff00ff, 0 0 35px #ff00ff; }
        }

        .challenge-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .challenge-description {
            font-size: 16px;
            color: #00ffff;
            text-align: center;
            margin-bottom: 10px;
        }

        .challenge-prompt {
            font-size: 20px;
            color: #00ffff;
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 12px;
            border: 1px solid #00ffff;
            animation: promptGlow 3s ease-in-out infinite alternate;
        }

        @keyframes promptGlow {
            from { box-shadow: 0 0 10px rgba(0, 255, 255, 0.3); }
            to { box-shadow: 0 0 20px rgba(0, 255, 255, 0.5); }
        }

        /* Input Field */
        .input-container {
            position: relative;
            margin: 20px 0;
        }

        .hack-input {
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #00ffff;
            color: #00ffff;
            padding: 20px;
            font-family: 'Courier New', monospace;
            font-size: 18px;
            border-radius: 12px;
            outline: none;
            box-sizing: border-box;
            text-align: center;
            transition: all 0.3s ease;
        }

        .hack-input:focus {
            box-shadow: 0 0 25px #00ffff;
            border-color: #ff00ff;
            transform: scale(1.02);
        }

        .hack-input::placeholder {
            color: #666;
            text-align: center;
        }

        /* Progress Bar */
        .progress-container {
            margin: 25px 0;
        }

        .progress-label {
            font-size: 14px;
            margin-bottom: 10px;
            color: #888;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .progress-bar {
            width: 100%;
            height: 30px;
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #00ffff;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #00ffff, #ff00ff, #00ffff);
            background-size: 200% 100%;
            width: 0%;
            transition: width 0.5s ease;
            animation: progressShimmer 2s linear infinite;
        }

        @keyframes progressShimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Buttons */
        .btn {
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #00ffff;
            color: #00ffff;
            padding: 15px 30px;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-weight: bold;
            margin: 5px;
        }

        .btn:hover {
            background: rgba(0, 255, 255, 0.1);
            box-shadow: 0 0 20px #00ffff;
            transform: translateY(-2px);
            border-color: #ff00ff;
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-danger {
            border-color: #ff0066;
            color: #ff0066;
        }

        .btn-danger:hover {
            background: rgba(255, 0, 102, 0.1);
            box-shadow: 0 0 20px #ff0066;
            border-color: #ff0066;
        }

        .btn-secondary {
            border-color: #888;
            color: #888;
        }

        .btn-secondary:hover {
            background: rgba(136, 136, 136, 0.1);
            box-shadow: 0 0 15px #888;
            border-color: #aaa;
        }

        /* Challenge Types */
        .puzzle-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin: 15px 0;
        }

        .puzzle-cell {
            aspect-ratio: 1;
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #00ffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .puzzle-cell:hover {
            background: rgba(0, 255, 255, 0.1);
            box-shadow: 0 0 15px #00ffff;
        }

        .puzzle-cell.active {
            background: rgba(255, 0, 255, 0.2);
            color: #ff00ff;
            border-color: #ff00ff;
        }

        /* Glitch Effects */
        .glitch {
            animation: glitch 0.3s infinite;
        }

        @keyframes glitch {
            0% { transform: translate(0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(-2px, -2px); }
            60% { transform: translate(2px, 2px); }
            80% { transform: translate(2px, -2px); }
            100% { transform: translate(0); }
        }

        /* Button Controls */
        .button-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .game-over-panel {
            text-align: center;
            padding: 30px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 15px;
            border: 2px solid #ff0066;
            margin-top: 20px;
            animation: gameOverGlow 1s ease-in-out infinite alternate;
        }

        @keyframes gameOverGlow {
            from { box-shadow: 0 0 20px rgba(255, 0, 102, 0.3); }
            to { box-shadow: 0 0 40px rgba(255, 0, 102, 0.5); }
        }

        .game-over-title {
            font-size: 24px;
            color: #ff0066;
            margin-bottom: 15px;
            text-shadow: 0 0 15px #ff0066;
        }

        .final-score {
            font-size: 18px;
            color: #00ffff;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            .game-container {
                border-radius: 15px;
            }
            
            .header {
                flex-direction: column;
                gap: 20px;
                padding: 25px;
            }
            
            .stats {
                gap: 20px;
            }

            .main-content {
                padding: 25px;
            }

            .challenge-panel {
                padding: 25px;
                border-radius: 15px;
            }

            .challenge-title {
                font-size: 24px;
            }

            .challenge-prompt {
                font-size: 18px;
                padding: 15px;
            }

            .btn {
                padding: 15px 25px;
                font-size: 14px;
            }

            .hack-input {
                padding: 18px;
                font-size: 16px;
            }

            .nav-btn {
                padding: 8px 15px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Matrix Rain Background -->
    <div class="matrix-rain" id="matrixRain"></div>

    <div class="game-container">
        <!-- Header -->
        <header class="header">
            <div class="nav-controls">
                <button class="nav-btn" onclick="goBack()">← GO BACK</button>
            </div>
            <div class="title">HACK RUN</div>
            <div class="stats">
                <div class="stat">
                    <div class="stat-label">BITS</div>
                    <div class="stat-value" id="bits">0</div>
                </div>
                <div class="stat">
                    <div class="stat-label">LEVEL</div>
                    <div class="stat-value" id="level">1</div>
                </div>
                <div class="stat">
                    <div class="stat-label">TIME</div>
                    <div class="stat-value timer" id="timer">30</div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Challenge Panel -->
            <div class="challenge-panel">
                <div class="challenge-title" id="challengeTitle">PASSWORD CRACK</div>
                <div class="challenge-content" id="challengeContent">
                    <div class="challenge-description">Decode the access sequence:</div>
                    <div class="challenge-prompt" id="challengePrompt">
                        BINARY: 01001000 01000001 01000011 01001011
                    </div>
                    <div class="input-container">
                        <input type="text" class="hack-input" id="hackInput" placeholder="Enter decoded message..." autocomplete="off">
                    </div>
                    <div class="progress-container">
                        <div class="progress-label">INFILTRATION PROGRESS</div>
                        <div class="progress-bar">
                            <div class="progress-fill" id="progressFill"></div>
                        </div>
                    </div>
                    <div class="button-controls">
                        <button class="btn" id="submitBtn" onclick="submitAnswer()">EXECUTE HACK</button>
                    </div>
                    <div id="gameOverPanel" class="game-over-panel" style="display: none;">
                        <div class="game-over-title">SYSTEM LOCKDOWN</div>
                        <div class="final-score" id="finalScore">FINAL SCORE: 0 bits | Level 1</div>
                        <button class="btn btn-danger" onclick="resetGame()">RESET SYSTEM</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Security Protection
        (function() {
            // Disable right-click context menu
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                return false;
            });

            // Disable F12, Ctrl+Shift+I, Ctrl+U, Ctrl+S
            document.addEventListener('keydown', function(e) {
                // F12 or Ctrl+Shift+I (Developer Tools)
                if (e.keyCode === 123 || (e.ctrlKey && e.shiftKey && e.keyCode === 73)) {
                    e.preventDefault();
                    return false;
                }
                // Ctrl+U (View Source)
                if (e.ctrlKey && e.keyCode === 85) {
                    e.preventDefault();
                    return false;
                }
                // Ctrl+S (Save Page)
                if (e.ctrlKey && e.keyCode === 83) {
                    e.preventDefault();
                    return false;
                }
                // Ctrl+A (Select All)
                if (e.ctrlKey && e.keyCode === 65) {
                    e.preventDefault();
                    return false;
                }
                // Ctrl+P (Print)
                if (e.ctrlKey && e.keyCode === 80) {
                    e.preventDefault();
                    return false;
                }
            });

            // Disable text selection
            document.addEventListener('selectstart', function(e) {
                e.preventDefault();
                return false;
            });

            // Disable drag and drop
            document.addEventListener('dragstart', function(e) {
                e.preventDefault();
                return false;
            });

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
                        document.body.innerHTML = '<div style="color: red; font-size: 24px; text-align: center; margin-top: 50px;">ACCESS DENIED - DEVELOPER TOOLS DETECTED</div>';
                    }
                }
            }, 500);
        })();

        // Game State
        let gameState = {
            bits: 0,
            level: 1,
            timeLeft: 30,
            currentChallenge: 0,
            progress: 0,
            isActive: true,
            timer: null
        };

        // Challenge Types
        const challenges = [
            {
                type: 'binary',
                title: 'PASSWORD CRACK',
                prompt: 'BINARY: 01001000 01000001 01000011 01001011',
                answer: 'HACK',
                description: 'Decode the access sequence:'
            },
            {
                type: 'cipher',
                title: 'ENCRYPTION BYPASS',
                prompt: 'CAESAR CIPHER (+3): DFFHVV JUDQWHG',
                answer: 'ACCESS GRANTED',
                description: 'Decrypt the security message:'
            },
            {
                type: 'sequence',
                title: 'FIREWALL BREACH',
                prompt: 'SEQUENCE: 2, 4, 8, 16, ?',
                answer: '32',
                description: 'Complete the pattern to bypass firewall:'
            },
            {
                type: 'typing',
                title: 'RAPID INJECTION',
                prompt: 'SELECT * FROM users WHERE admin=1; DROP TABLE logs;',
                answer: 'SELECT * FROM users WHERE admin=1; DROP TABLE logs;',
                description: 'Type the SQL injection exactly:'
            },
            {
                type: 'hex',
                title: 'HEX DECODER',
                prompt: 'HEX: 524F4F54',
                answer: 'ROOT',
                description: 'Convert hexadecimal to text:'
            },
            {
                type: 'math',
                title: 'ALGORITHM CRACK',
                prompt: 'SOLVE: 7 * 9 + 15 - 8 = ?',
                answer: '70',
                description: 'Calculate the security key:'
            },
            {
                type: 'binary',
                title: 'SYSTEM ACCESS',
                prompt: 'BINARY: 01000001 01000100 01001101 01001001 01001110',
                answer: 'ADMIN',
                description: 'Decode administrator credentials:'
            },
            {
                type: 'cipher',
                title: 'REVERSE CIPHER',
                prompt: 'REVERSE: TNARG SSECCA',
                answer: 'ACCESS GRANT',
                description: 'Reverse the encrypted message:'
            },
            {
                type: 'sequence',
                title: 'PORT SCANNER',
                prompt: 'FIBONACCI: 1, 1, 2, 3, 5, 8, ?',
                answer: '13',
                description: 'Find the next port number:'
            },
            {
                type: 'base64',
                title: 'DATA EXTRACTION',
                prompt: 'BASE64: U0VDVVJJVFk=',
                answer: 'SECURITY',
                description: 'Decode the base64 string:'
            },
            {
                type: 'logic',
                title: 'LOGIC GATE',
                prompt: 'IF password = "CYBER" AND user = "HACKER", OUTPUT = ?',
                answer: 'TRUE',
                description: 'Solve the boolean logic:'
            },
            {
                type: 'hex',
                title: 'MEMORY DUMP',
                prompt: 'HEX: 4841434B4552',
                answer: 'HACKER',
                description: 'Extract data from memory:'
            },
            {
                type: 'math',
                title: 'ENCRYPTION KEY',
                prompt: 'CALCULATE: (25 * 4) - (18 + 7) = ?',
                answer: '75',
                description: 'Generate the encryption key:'
            },
            {
                type: 'binary',
                title: 'NETWORK BREACH',
                prompt: 'BINARY: 01000100 01000001 01010100 01000001',
                answer: 'DATA',
                description: 'Intercept network packet:'
            },
            {
                type: 'cipher',
                title: 'SUBSTITUTION CIPHER',
                prompt: 'A=1, B=2, C=3... : 3 15 4 5',
                answer: 'CODE',
                description: 'Decode the substitution cipher:'
            },
            {
                type: 'sequence',
                title: 'PRIME NUMBERS',
                prompt: 'PRIMES: 2, 3, 5, 7, 11, ?',
                answer: '13',
                description: 'Find the next prime number:'
            },
            {
                type: 'logic',
                title: 'ACCESS CONTROL',
                prompt: 'IF level > 5 AND clearance = HIGH, ACCESS = ?',
                answer: 'GRANTED',
                description: 'Determine access permission:'
            },
            {
                type: 'hex',
                title: 'VIRUS SIGNATURE',
                prompt: 'HEX: 56495255533A20',
                answer: 'VIRUS: ',
                description: 'Identify the virus signature:'
            },
            {
                type: 'math',
                title: 'HASH FUNCTION',
                prompt: 'COMPUTE: 144 / 12 + 8 * 3 = ?',
                answer: '36',
                description: 'Calculate hash value:'
            },
            {
                type: 'binary',
                title: 'KERNEL ACCESS',
                prompt: 'BINARY: 01001011 01000101 01010010 01001110 01000101 01001100',
                answer: 'KERNEL',
                description: 'Access system kernel:'
            },
            {
                type: 'cipher',
                title: 'ROT13 CIPHER',
                prompt: 'ROT13: FRPHEVGL',
                answer: 'SECURITY',
                description: 'Decrypt ROT13 message:'
            },
            {
                type: 'sequence',
                title: 'GEOMETRIC SERIES',
                prompt: 'SERIES: 3, 9, 27, 81, ?',
                answer: '243',
                description: 'Complete the geometric sequence:'
            },
            {
                type: 'logic',
                title: 'FIREWALL RULES',
                prompt: 'IF port = 80 OR port = 443, STATUS = ?',
                answer: 'OPEN',
                description: 'Check firewall configuration:'
            },
            {
                type: 'hex',
                title: 'PAYLOAD ANALYSIS',
                prompt: 'HEX: 50415353574F5244',
                answer: 'PASSWORD',
                description: 'Analyze malicious payload:'
            },
            {
                type: 'math',
                title: 'CRYPTOGRAPHIC KEY',
                prompt: 'SOLVE: 2^6 + 3^3 - 5 = ?',
                answer: '86',
                description: 'Generate cryptographic key:'
            },
            {
                type: 'binary',
                title: 'BUFFER OVERFLOW',
                prompt: 'BINARY: 01000010 01010101 01000110 01000110 01000101 01010010',
                answer: 'BUFFER',
                description: 'Exploit buffer overflow:'
            },
            {
                type: 'cipher',
                title: 'ATBASH CIPHER',
                prompt: 'ATBASH (A=Z, B=Y...): HXIVH',
                answer: 'CYBER',
                description: 'Decode Atbash cipher:'
            },
            {
                type: 'sequence',
                title: 'SQUARE NUMBERS',
                prompt: 'SQUARES: 1, 4, 9, 16, 25, ?',
                answer: '36',
                description: 'Find the next square number:'
            },
            {
                type: 'logic',
                title: 'AUTHENTICATION',
                prompt: 'IF username = "admin" AND password = "123", LOGIN = ?',
                answer: 'SUCCESS',
                description: 'Verify authentication:'
            },
            {
                type: 'hex',
                title: 'SHELLCODE ANALYSIS',
                prompt: 'HEX: 5348454C4C',
                answer: 'SHELL',
                description: 'Analyze shellcode:'
            },
            {
                type: 'binary',
                title: 'TROJAN DETECTION',
                prompt: 'BINARY: 01010100 01010010 01001111 01001010 01000001 01001110',
                answer: 'TROJAN',
                description: 'Identify malware signature:'
            },
            {
                type: 'cipher',
                title: 'VIGENERE CIPHER',
                prompt: 'VIGENERE (KEY=ABC): BDF',
                answer: 'ACE',
                description: 'Decrypt Vigenere cipher:'
            },
            {
                type: 'math',
                title: 'MODULAR ARITHMETIC',
                prompt: 'CALCULATE: 47 MOD 7 = ?',
                answer: '5',
                description: 'Solve modular equation:'
            },
            {
                type: 'sequence',
                title: 'TRIANGULAR NUMBERS',
                prompt: 'TRIANGULAR: 1, 3, 6, 10, 15, ?',
                answer: '21',
                description: 'Find next triangular number:'
            },
            {
                type: 'hex',
                title: 'EXPLOIT CODE',
                prompt: 'HEX: 4558504C4F4954',
                answer: 'EXPLOIT',
                description: 'Decode exploit signature:'
            },
            {
                type: 'logic',
                title: 'NETWORK PROTOCOL',
                prompt: 'IF protocol = TCP AND port = 22, SERVICE = ?',
                answer: 'SSH',
                description: 'Identify network service:'
            },
            {
                type: 'binary',
                title: 'MALWARE ANALYSIS',
                prompt: 'BINARY: 01001101 01000001 01001100 01010111 01000001 01010010 01000101',
                answer: 'MALWARE',
                description: 'Analyze malicious code:'
            },
            {
                type: 'cipher',
                title: 'MORSE CODE',
                prompt: 'MORSE: .... .- -.-. -.- . .-.',
                answer: 'HACKER',
                description: 'Decode morse transmission:'
            },
            {
                type: 'math',
                title: 'XOR OPERATION',
                prompt: 'XOR: 1010 XOR 1100 = ?',
                answer: '0110',
                description: 'Calculate XOR result:'
            },
            {
                type: 'sequence',
                title: 'POWERS OF 2',
                prompt: 'POWERS: 1, 2, 4, 8, 16, 32, ?',
                answer: '64',
                description: 'Continue power sequence:'
            },
            {
                type: 'hex',
                title: 'BACKDOOR CODE',
                prompt: 'HEX: 4241434B444F4F52',
                answer: 'BACKDOOR',
                description: 'Detect backdoor signature:'
            },
            {
                type: 'logic',
                title: 'ENCRYPTION STATUS',
                prompt: 'IF algorithm = AES AND keysize = 256, STRENGTH = ?',
                answer: 'HIGH',
                description: 'Evaluate encryption strength:'
            },
            {
                type: 'binary',
                title: 'ROOTKIT SCAN',
                prompt: 'BINARY: 01010010 01001111 01001111 01010100 01001011 01001001 01010100',
                answer: 'ROOTKIT',
                description: 'Scan for rootkit presence:'
            },
            {
                type: 'cipher',
                title: 'PLAYFAIR CIPHER',
                prompt: 'PLAYFAIR DECODE: BMODZBXDNABEKUDMUIXMMOUVIF',
                answer: 'ATTACKATDAWN',
                description: 'Decrypt Playfair message:'
            },
            {
                type: 'math',
                title: 'PRIME FACTORIZATION',
                prompt: 'FACTORS OF 35: ? × ?',
                answer: '5 7',
                description: 'Find prime factors:'
            },
            {
                type: 'sequence',
                title: 'CATALAN NUMBERS',
                prompt: 'CATALAN: 1, 1, 2, 5, 14, ?',
                answer: '42',
                description: 'Find next Catalan number:'
            },
            {
                type: 'hex',
                title: 'RANSOMWARE DETECT',
                prompt: 'HEX: 52414E534F4D57415245',
                answer: 'RANSOMWARE',
                description: 'Identify ransomware signature:'
            },
            {
                type: 'logic',
                title: 'INTRUSION DETECTION',
                prompt: 'IF attempts > 3 AND time < 60s, ALERT = ?',
                answer: 'TRIGGERED',
                description: 'Check intrusion rules:'
            },
            {
                type: 'binary',
                title: 'SPYWARE ANALYSIS',
                prompt: 'BINARY: 01010011 01010000 01011001 01010111 01000001 01010010 01000101',
                answer: 'SPYWARE',
                description: 'Analyze spyware code:'
            },
            {
                type: 'cipher',
                title: 'RAIL FENCE CIPHER',
                prompt: 'RAIL FENCE (3 RAILS): HOREL LCWOD',
                answer: 'HELLO WORLD',
                description: 'Decrypt rail fence cipher:'
            }
        ];

        // Initialize Matrix Rain
        function createMatrixRain() {
            const matrixRain = document.getElementById('matrixRain');
            const chars = '01アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン';
            
            for (let i = 0; i < 50; i++) {
                const column = document.createElement('div');
                column.className = 'rain-column';
                column.style.left = Math.random() * 100 + '%';
                column.style.animationDuration = (Math.random() * 3 + 2) + 's';
                column.style.animationDelay = Math.random() * 2 + 's';
                
                let columnText = '';
                for (let j = 0; j < 20; j++) {
                    columnText += chars[Math.floor(Math.random() * chars.length)] + '<br>';
                }
                column.innerHTML = columnText;
                
                matrixRain.appendChild(column);
            }
        }

        // Add terminal message
        function addTerminalMessage(message, type = '') {
            const terminal = document.getElementById('terminalContent');
            const line = document.createElement('div');
            line.className = `terminal-line ${type}`;
            line.innerHTML = message;
            terminal.appendChild(line);
            terminal.scrollTop = terminal.scrollHeight;
        }

        // Update progress
        function updateProgress(amount) {
            gameState.progress = Math.min(100, gameState.progress + amount);
            document.getElementById('progressFill').style.width = gameState.progress + '%';
        }

        // Load challenge
        function loadChallenge() {
            const challenge = challenges[gameState.currentChallenge % challenges.length];
            document.getElementById('challengeTitle').textContent = challenge.title;
            document.getElementById('challengePrompt').textContent = challenge.prompt;
            document.querySelector('.challenge-description').textContent = challenge.description;
            document.getElementById('hackInput').value = '';
            document.getElementById('hackInput').focus();
            document.getElementById('gameOverPanel').style.display = 'none';
        }

        // Submit answer
        function submitAnswer() {
            if (!gameState.isActive) return;
            
            const input = document.getElementById('hackInput').value.trim().toUpperCase();
            const challenge = challenges[gameState.currentChallenge % challenges.length];
            
            if (input === challenge.answer.toUpperCase()) {
                // Correct answer
                const bitsEarned = Math.floor(gameState.timeLeft * gameState.level);
                gameState.bits += bitsEarned;
                gameState.progress = 100;
                
                // Add glitch effect
                document.querySelector('.challenge-panel').classList.add('glitch');
                setTimeout(() => {
                    document.querySelector('.challenge-panel').classList.remove('glitch');
                }, 500);
                
                // Check if all challenges completed
                if (gameState.currentChallenge + 1 >= challenges.length) {
                    // Victory condition - all 50 questions answered
                    setTimeout(() => {
                        gameState.isActive = false;
                        document.getElementById('submitBtn').disabled = true;
                        document.getElementById('hackInput').disabled = true;
                        document.querySelector('.game-over-title').textContent = 'VICTORY ACHIEVED!';
                        document.querySelector('.game-over-title').style.color = '#00ff00';
                        document.getElementById('finalScore').textContent = `CONGRATULATIONS! ALL 50 CHALLENGES COMPLETED! | FINAL SCORE: ${gameState.bits} bits`;
                        document.getElementById('gameOverPanel').style.display = 'block';
                        clearInterval(gameState.timer);
                    }, 1000);
                } else {
                    // Level up
                    setTimeout(() => {
                        gameState.level++;
                        gameState.currentChallenge++;
                        gameState.timeLeft = Math.max(20, 35 - gameState.level);
                        gameState.progress = 0;
                        
                        updateDisplay();
                        loadChallenge();
                    }, 1000);
                }
                
            } else {
                // Wrong answer
                gameState.timeLeft = Math.max(0, gameState.timeLeft - 5);
                
                // Shake effect
                document.getElementById('hackInput').style.animation = 'glitch 0.5s';
                setTimeout(() => {
                    document.getElementById('hackInput').style.animation = '';
                }, 500);
            }
            
            updateProgress(25);
            updateDisplay();
        }

        // Update display
        function updateDisplay() {
            document.getElementById('bits').textContent = gameState.bits;
            document.getElementById('level').textContent = gameState.level;
            document.getElementById('timer').textContent = gameState.timeLeft;
            document.getElementById('progressFill').style.width = gameState.progress + '%';
        }

        // Game timer
        function startTimer() {
            if (gameState.timer) {
                clearInterval(gameState.timer);
            }
            
            gameState.timer = setInterval(() => {
                if (!gameState.isActive) {
                    clearInterval(gameState.timer);
                    return;
                }
                
                gameState.timeLeft--;
                updateDisplay();
                
                if (gameState.timeLeft <= 0) {
                    gameState.isActive = false;
                    document.getElementById('submitBtn').disabled = true;
                    document.getElementById('hackInput').disabled = true;
                    document.getElementById('finalScore').textContent = `FINAL SCORE: ${gameState.bits} bits | Level ${gameState.level}`;
                    document.getElementById('gameOverPanel').style.display = 'block';
                    clearInterval(gameState.timer);
                }
            }, 1000);
        }

        // Handle Enter key
        document.getElementById('hackInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && gameState.isActive) {
                submitAnswer();
            }
        });

        // Initialize game
        function initGame() {
            createMatrixRain();
            loadChallenge();
            startTimer();
            updateDisplay();
            
            addTerminalMessage(`<span class="prompt">root@hackrun:~$</span> Welcome to HACK RUN`);
            addTerminalMessage(`<span class="success">Objective: Complete hacking challenges before time runs out</span>`, 'success');
        }

        // Reset Game Function
        function resetGame() {
            // Clear existing timer
            if (gameState.timer) {
                clearInterval(gameState.timer);
            }
            
            // Reset game state
            gameState = {
                bits: 0,
                level: 1,
                timeLeft: 30,
                currentChallenge: 0,
                progress: 0,
                isActive: true,
                timer: null
            };
            
            // Reset UI elements
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('hackInput').disabled = false;
            document.getElementById('gameOverPanel').style.display = 'none';
            document.getElementById('progressFill').style.width = '0%';
            
            // Restart the game
            loadChallenge();
            startTimer();
            updateDisplay();
            
            // Add restart message effect
            document.querySelector('.challenge-panel').classList.add('glitch');
            setTimeout(() => {
                document.querySelector('.challenge-panel').classList.remove('glitch');
            }, 500);
        }

        // Go Back Function
        function goBack() {
            window.location.href = 'gamesh.php';
        }

        // Start the game
        initGame();
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'98f588ce021c8e57',t:'MTc2MDU5NjUwOC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
