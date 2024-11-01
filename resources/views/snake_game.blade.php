<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snake Game</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            background-color: #1e1e1e;
            font-family: Arial, sans-serif;
            color: #f4f4f4;
        }
        canvas {
            background-color: #111;
            border: 2px solid #888;
            image-rendering: pixelated;
        }
        .score-board {
            margin-top: 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <canvas id="gameCanvas" width="600" height="600"></canvas>
    <div class="score-board">Score: <span id="score">0</span></div>
    
    <script>
        const canvas = document.getElementById("gameCanvas");
        const ctx = canvas.getContext("2d");

        const boxSize = 20;
        let snake = [{ x: 9 * boxSize, y: 9 * boxSize }];
        let direction = "RIGHT";
        let food = {};
        let score = 0;

        // Load images and sounds
        const snakeImage = new Image();
        snakeImage.src = "/assets/images/snake.png";

        const foodImage = new Image();
        foodImage.src = "/assets/images/food.png";

        const eatSound = new Audio("/assets/sounds/eat.mp3");
        const gameOverSound = new Audio("/assets/sounds/gameover.mp3");

        document.addEventListener("keydown", changeDirection);
        
        function changeDirection(event) {
            const key = event.key;
            if (key === "ArrowUp" && direction !== "DOWN") direction = "UP";
            if (key === "ArrowDown" && direction !== "UP") direction = "DOWN";
            if (key === "ArrowLeft" && direction !== "RIGHT") direction = "LEFT";
            if (key === "ArrowRight" && direction !== "LEFT") direction = "RIGHT";
        }

        function createFood() {
            food = {
                x: Math.floor(Math.random() * 29) * boxSize,
                y: Math.floor(Math.random() * 29) * boxSize
            };
        }
        createFood();

        function drawGame() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw food
            ctx.drawImage(foodImage, food.x, food.y, boxSize, boxSize);

            // Draw snake
            snake.forEach((segment, index) => {
                ctx.drawImage(snakeImage, segment.x, segment.y, boxSize, boxSize);
            });

            // Move snake's head
            let snakeX = snake[0].x;
            let snakeY = snake[0].y;

            if (direction === "UP") snakeY -= boxSize;
            if (direction === "DOWN") snakeY += boxSize;
            if (direction === "LEFT") snakeX -= boxSize;
            if (direction === "RIGHT") snakeX += boxSize;

            // Check if snake eats food
            if (snakeX === food.x && snakeY === food.y) {
                eatSound.play();
                score++;
                document.getElementById("score").innerText = score;
                createFood();
            } else {
                snake.pop();
            }

            // Check for collision
            const newHead = { x: snakeX, y: snakeY };
            if (snake.some(segment => segment.x === newHead.x && segment.y === newHead.y) ||
                snakeX < 0 || snakeX >= canvas.width || snakeY < 0 || snakeY >= canvas.height) {
                gameOverSound.play();
                clearInterval(game);
                alert("Game Over! Your Score: " + score);
                return;
            }

            snake.unshift(newHead);
        }

        const game = setInterval(drawGame, 100);
    </script>
</body>
</html>
