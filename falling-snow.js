document.addEventListener('DOMContentLoaded', function () {
    const snowflakes = document.querySelectorAll('.snow');

    snowflakes.forEach(snowflake => {
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
        if (typeof snowColor !== 'undefined') {
            snowflake.style.backgroundColor = snowColor;
        }
    });
});
