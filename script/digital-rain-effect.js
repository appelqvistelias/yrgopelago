const canvas = document.getElementById('matrix-drops');
const ctx = canvas.getContext('2d');

// Configurera canvas to window size
function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}
resizeCanvas();
window.addEventListener('resize', resizeCanvas);

ctx.fillStyle = '#000000';
ctx.fillRect(0, 0, canvas.width, canvas.height);

// Matrix characters
const chars = "ｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃ1234567890";
const charSize = 14;
const columns = canvas.width / charSize;
const drops = [];

// Initalization drops
for (let i = 0; i < columns; i++) {
    drops[i] = Math.floor(Math.random() * -canvas.height);
}

function draw() {
    // Semi transparent black background for fading effect
    ctx.fillStyle = 'rgba(22, 22, 22, 0.028)';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Green text
    ctx.fillStyle = '#0F0';
    ctx.font = charSize + 'px monospace';

    // Paint drops
    for (let i = 0; i < drops.length; i++) {
    const char = chars[Math.floor(Math.random() * chars.length)];
    const x = i * charSize;
    const y = drops[i];
    
    ctx.fillText(char, x, y);

    // Reset drops when reaching bottom
    if (y > canvas.height) {
        drops[i] = Math.floor(Math.random() * -100);
    } else {
        drops[i] += charSize;
    }
    }
}

// Animation loop
setInterval(draw, 50);