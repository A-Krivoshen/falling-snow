document.addEventListener('DOMContentLoaded', function () {
    if (typeof snowColor === 'undefined' || typeof snowIntensity === 'undefined') {
        console.warn('Snow color or intensity is undefined. Check plugin settings.');
        return;
    }

    const container = document.getElementById('snowflakes-container');

    for (let i = 0; i < snowIntensity; i++) {
        const snowflake = document.createElement('div');
        snowflake.classList.add('snow');

        // Случайное начальное положение по оси X
        const startX = Math.random() * window.innerWidth;
        snowflake.style.left = `${startX}px`;

        // Случайная длительность падения и задержка
        const fallDuration = Math.random() * 10 + 5; // От 5 до 15 секунд
        const fallDelay = Math.random() * 5; // Задержка до 5 секунд
        snowflake.style.animationDuration = `${fallDuration}s`;
        snowflake.style.animationDelay = `${fallDelay}s`;

        // Случайный размер снежинки
        const size = Math.random() * 10 + 5; // От 5 до 15 пикселей
        snowflake.style.width = `${size}px`;
        snowflake.style.height = `${size}px`;

        // Устанавливаем цвет снежинки
        snowflake.style.backgroundColor = snowColor;

        container.appendChild(snowflake);
    }
});
