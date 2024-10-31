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
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #333;
        }
        canvas {
            background-color: #111;
            border: 1px solid #222;
        }
    </style>
</head>
<body>
    <canvas id="gameCanvas" width="400" height="400"></canvas>
    
    <script>
        const canvas = document.getElementById("gameCanvas");
        const ctx = canvas.getContext("2d");

        const boxSize = 20;
        let snake = [{ x: 9 * boxSize, y: 9 * boxSize }];
        let direction = "RIGHT";
        let food = {
            x: Math.floor(Math.random() * 20) * boxSize,
            y: Math.floor(Math.random() * 20) * boxSize
        };
        let score = 0;

        document.addEventListener("keydown", (event) => {
            if (event.key === "ArrowUp" && direction !== "DOWN") direction = "UP";
            else if (event.key === "ArrowDown" && direction !== "UP") direction = "DOWN";
            else if (event.key === "ArrowLeft" && direction !== "RIGHT") direction = "LEFT";
            else if (event.key === "ArrowRight" && direction !== "LEFT") direction = "RIGHT";
        });

        function drawGame() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Dibujar comida
            ctx.fillStyle = "red";
            ctx.fillRect(food.x, food.y, boxSize, boxSize);

            // Dibujar víbora
            ctx.fillStyle = "lime";
            for (let i = 0; i < snake.length; i++) {
                ctx.fillRect(snake[i].x, snake[i].y, boxSize, boxSize);
            }

            // Posición de la cabeza de la víbora
            let snakeX = snake[0].x;
            let snakeY = snake[0].y;

            if (direction === "UP") snakeY -= boxSize;
            if (direction === "DOWN") snakeY += boxSize;
            if (direction === "LEFT") snakeX -= boxSize;
            if (direction === "RIGHT") snakeX += boxSize;

            if (snakeX === food.x && snakeY === food.y) {
                score++;
                food = {
                    x: Math.floor(Math.random() * 20) * boxSize,
                    y: Math.floor(Math.random() * 20) * boxSize
                };
            } else {
                snake.pop();
            }

            const newHead = { x: snakeX, y: snakeY };

            if (snake.some((segment) => segment.x === newHead.x && segment.y === newHead.y) ||
                snakeX < 0 || snakeX >= canvas.width || snakeY < 0 || snakeY >= canvas.height) {
                clearInterval(gameInterval);
                alert("Game Over! Puntuación: " + score);
                return;
            }

            snake.unshift(newHead);
        }

        const gameInterval = setInterval(drawGame, 100);
    </script>
</body>
</html>
