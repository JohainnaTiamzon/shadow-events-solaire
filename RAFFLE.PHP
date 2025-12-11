<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solaire - Mega Funalo Raffle</title>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    
    <style>
        /* --- CRITICAL FIX: BOX SIZING RESET --- */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        :root {
            --bg-dark: #121212;
            --gold-gradient: linear-gradient(135deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
            --chrome-gradient: linear-gradient(to right, #8e9eab, #eef2f3, #8e9eab);
            --font-display: 'Playfair Display', serif;
            --font-ui: 'Montserrat', sans-serif;
        }

        body {
            font-family: var(--font-ui);
            background-color: var(--bg-dark);
            background-image: radial-gradient(circle at 50% 30%, #3e1c1c 0%, #000000 100%);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
        }

        /* --- MASCOT STYLES --- */
        .mascot-container {
            position: relative;
            z-index: 20;
            margin-bottom: -45px;
            display: flex;
            justify-content: center;
            pointer-events: none;
        }

        .mascot-topper {
            width: 320px;
            height: auto;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.6));
        }

        /* --- MACHINE LOGO STYLES --- */
        .machine-logo {
            display: block;
            margin: 0 auto 25px auto;
            max-width: 260px;
            height: auto;
            filter: drop-shadow(0 0 15px rgba(255, 215, 0, 0.4));
        }

        /* --- BUTTONS --- */
        .btn {
            background: var(--gold-gradient);
            color: #2c3e50;
            border: none;
            padding: 15px 40px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
            transition: all 0.3s ease;
            text-transform: uppercase;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.6);
        }

        /* --- SETUP SCREEN --- */
        #setup-screen {
            background: rgba(20, 20, 20, 0.85);
            backdrop-filter: blur(10px);
            padding: 50px;
            border-radius: 20px;
            border: 1px solid rgba(255, 165, 0, 0.2);
            width: 100%;
            max-width: 700px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        textarea {
            width: 100%;
            height: 200px;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid #b38728;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-family: 'Montserrat', monospace;
            resize: none;
        }

        /* --- GAME SCREEN --- */
        #game-screen {
            display: none;
            flex-direction: column;
            align-items: center;
            position: relative;
            margin-top: 30px;
        }

        .stats-pill {
            background: rgba(0,0,0,0.6);
            border: 1px solid #b38728;
            padding: 8px 25px;
            border-radius: 30px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #d4af37;
        }

        .machine-frame {
            position: relative;
            padding: 35px 25px 25px 25px;
            background: #1a0505;
            border-radius: 30px;
            box-shadow: 
                0 0 0 8px #2a0a0a,
                0 0 0 12px #b38728,
                0 0 80px rgba(255, 69, 0, 0.3);
        }

        .slot-machine {
            position: relative;
            width: 700px;
            height: 350px;
            background: #000;
            border: 4px solid #444;
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reel li {
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 4rem;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 4px 10px rgba(0,0,0,0.8);
            background: linear-gradient(to bottom, #111, #222 50%, #111);
            border-bottom: 2px solid #000;
        }

        /* --- LEVER --- */
        .lever-group {
            position: absolute;
            right: -80px;
            top: 100px;
            width: 60px;
            height: 250px;
        }
        .lever-housing {
            position: absolute;
            right: 20px;
            top: 60px;
            width: 40px;
            height: 100px;
            background: #222;
            border-radius: 0 10px 10px 0;
            border: 1px solid #444;
        }
        .lever-arm {
            position: absolute;
            bottom: 70px;
            left: 10px;
            width: 14px;
            height: 160px;
            background: var(--chrome-gradient);
            border-radius: 10px;
            transform-origin: bottom center;
            transition: transform 0.6s cubic-bezier(0.5, 0, 0.5, 1);
            z-index: 1;
            cursor: pointer;
        }
        .lever-knob {
            position: absolute;
            top: -40px;
            left: -18px;
            width: 50px;
            height: 50px;
            background: radial-gradient(circle at 30% 30%, #ffeb3b, #fbc02d, #f57f17);
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.4);
        }
        .lever-group.active .lever-arm { transform: rotateX(160deg); }

        /* --- MODAL --- */
        #winner-modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.95);
            z-index: 100;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        #winner-modal.visible { opacity: 1; }

        .winner-card {
            background: #111;
            padding: 50px;
            border: 2px solid #b38728;
            border-radius: 10px;
            text-align: center;
            transform: scale(0.8);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 0 80px rgba(255, 165, 0, 0.15);
        }
        #winner-modal.visible .winner-card { transform: scale(1); }
        
        .winner-name {
            font-family: var(--font-display);
            font-size: 64px;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 20px 0 40px 0;
        }
        
        .blur-motion { filter: blur(5px); }
    </style>
</head>
<body>

    <div id="setup-screen">
        <img src="logo.png" alt="Solaire Logo" style="max-width: 200px; margin-bottom: 20px;">
        <h2 style="letter-spacing: 2px; text-transform: uppercase; color: #b38728;">Raffle Setup</h2>
        <p style="color: #ccc; margin-top: 5px;">Paste employee list below</p>
        <textarea id="name-input" placeholder="Start typing names..."></textarea>
        <button class="btn" onclick="initializeRaffle()">Load Machine</button>
    </div>

    <div id="game-screen">
        
        <div class="mascot-container">
            <img src="mascot.png" alt="Mega Funalo" class="mascot-topper" onerror="this.style.display='none';">
        </div>

        <div class="machine-frame">
            
            <img src="logo.png" alt="Solaire Online" class="machine-logo" onerror="this.style.display='none';">

            <div class="slot-machine">
                <div style="position: absolute; left: 0; right: 0; top: 50%; height: 4px; background: rgba(255, 69, 0, 0.4); transform: translateY(-50%); z-index: 5; box-shadow: 0 0 15px rgba(255, 69, 0, 0.5); pointer-events: none;"></div>
                
                <div class="reel-container" style="width: 100%; height: 100%; position: relative;">
                    <ul class="reel" id="reel">
                        <li><span style="color: #b38728;">READY</span></li>
                    </ul>
                </div>
            </div>

            <div class="lever-group" id="lever-group" onclick="spin()">
                <div class="lever-housing"></div>
                <div class="lever-arm">
                    <div class="lever-knob"></div>
                </div>
            </div>
        </div>
        
        <div class="stats-pill" style="margin-top: 30px;">
            Candidates: <span id="count-display">0</span>
        </div>
    </div>

    <div id="winner-modal">
        <div class="winner-card">
            <div style="color: #888; letter-spacing: 3px; text-transform: uppercase; font-size: 14px;">The Winner Is</div>
            <div class="winner-name" id="modal-winner-name">NAME HERE</div>
            <div style="display: flex; justify-content: center; gap: 15px;">
                <button class="btn" onclick="closeModal(false)">Keep & Spin Again</button>
                <button class="btn" style="background: transparent; border: 1px solid #666; color: #ccc;" onclick="closeModal(true)">Remove & Next</button>
            </div>
        </div>
    </div>

    <script>
        let participants = [];
        let isSpinning = false;
        let currentWinnerIndex = -1;

        // --- AUDIO SETUP ---
        // Ensure you have these files in the same folder
        const audioPull = new Audio('pull.mp3');
        const audioSpin = new Audio('spin.mp3');
        const audioWin = new Audio('win.mp3'); // Fanfare

        // Configure Loop & Volume
        audioSpin.loop = true;
        audioPull.volume = 0.5;
        audioSpin.volume = 0.5;
        audioWin.volume = 0.6;

        function initializeRaffle() {
            const input = document.getElementById('name-input').value;
            participants = input.split('\n').map(n => n.trim()).filter(n => n !== '');
            if (participants.length < 2) { alert("Please add at least 2 names."); return; }

            document.getElementById('setup-screen').style.display = 'none';
            document.getElementById('game-screen').style.display = 'flex';
            updateCount();
        }

        function updateCount() {
            document.getElementById('count-display').innerText = participants.length.toLocaleString();
        }

        function spin() {
            if (isSpinning || participants.length === 0) return;
            isSpinning = true;

            // 1. Play Pull Sound
            audioPull.play().catch(e => console.log("Audio autoplay blocked:", e));

            // 2. Play Spin Sound (Reset to start in case of repeat spins)
            audioSpin.currentTime = 0;
            audioSpin.play().catch(e => console.log("Audio error:", e));

            const lever = document.getElementById('lever-group');
            lever.classList.add('active');
            setTimeout(() => lever.classList.remove('active'), 1000);

            // Winner Logic
            currentWinnerIndex = Math.floor(Math.random() * participants.length);
            const winnerName = participants[currentWinnerIndex];

            // Visual Logic
            const reel = document.getElementById('reel');
            reel.innerHTML = '';
            let visualList = [];
            
            // Generate visual buffer (45 items + winner)
            for(let i=0; i<45; i++) {
                visualList.push(participants[Math.floor(Math.random() * participants.length)]);
            }
            visualList.push(winnerName);

            visualList.forEach(name => {
                const li = document.createElement('li');
                li.innerText = name;
                reel.appendChild(li);
            });

            // Ensure reflow
            reel.style.transition = 'none';
            reel.style.transform = 'translateY(0)';
            reel.classList.add('blur-motion');
            reel.offsetHeight;

            // Height Calculation
            const itemHeight = 350;
            const targetY = -(itemHeight * (visualList.length - 1));

            // Spin for 5 seconds
            reel.style.transition = 'transform 5s cubic-bezier(0.15, 0.9, 0.35, 1)';
            reel.style.transform = `translateY(${targetY}px)`;

            setTimeout(() => {
                // STOP SPIN SOUND
                audioSpin.pause();
                
                // PLAY WIN SOUND
                audioWin.currentTime = 0;
                audioWin.play().catch(e => console.log("Win audio error:", e));

                reel.classList.remove('blur-motion');
                showWinner(winnerName);
                isSpinning = false;
            }, 5100);
        }

        function showWinner(name) {
            document.getElementById('modal-winner-name').innerText = name;
            const modal = document.getElementById('winner-modal');
            modal.style.display = 'flex';
            setTimeout(() => { modal.classList.add('visible'); triggerConfetti(); }, 100);
        }

        function triggerConfetti() {
            var duration = 3000;
            var end = Date.now() + duration;
            (function frame() {
                confetti({ particleCount: 5, angle: 60, spread: 55, origin: { x: 0 }, colors: ['#FFD700', '#FFFFFF', '#e65100'] });
                confetti({ particleCount: 5, angle: 120, spread: 55, origin: { x: 1 }, colors: ['#FFD700', '#FFFFFF', '#e65100'] });
                if (Date.now() < end) requestAnimationFrame(frame);
            }());
        }

        function closeModal(shouldRemove) {
            // Stop win sound if still playing
            audioWin.pause();
            audioWin.currentTime = 0;

            const modal = document.getElementById('winner-modal');
            modal.classList.remove('visible');
            setTimeout(() => {
                modal.style.display = 'none';
                if (shouldRemove && currentWinnerIndex > -1) {
                    participants.splice(currentWinnerIndex, 1);
                    updateCount();
                }
                const reel = document.getElementById('reel');
                reel.style.transition = 'none';
                reel.innerHTML = '<li><span style="color: #b38728;">READY</span></li>';
                reel.style.transform = 'translateY(0)';
            }, 500);
        }
    </script>
</body>
</html>