// Скрипт для эффекта падающего снега с использованием JavaScript
document.addEventListener('DOMContentLoaded', function () {
    if (typeof snowIntensity === 'undefined') {
        return;
    }

    const totalSnowflakes = snowIntensity;

    for (let i = 0; i < totalSnowflakes; i++) {
        createSnowflake();
    }

    function createSnowflake() {
        const snowflake = document.createElement('div');
        snowflake.classList.add('snow');
        
        // Случайное размещение снежинки
        snowflake.style.left = Math.random() * 100 + 'vw';
        snowflake.style.animationDuration = Math.random() * 10 + 5 + 's'; // Скорость падения
        snowflake.style.width = snowflake.style.height = Math.random() * 10 + 'px'; // Размер снежинки
        snowflake.style.opacity = Math.random() * 0.9 + 0.1;

        // Добавление снежинки на страницу
        document.body.appendChild(snowflake);

        // Удаление снежинки после завершения анимации
        snowflake.addEventListener('animationend', () => {
            snowflake.remove();
        });
    }
});
