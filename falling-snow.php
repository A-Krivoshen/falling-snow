<?php
/*
Plugin Name: Falling Snow
Description: Плагин для эффекта падающего снега на сайте с возможностью настройки через админку.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class FallingSnow {
    
    public function __construct() {
        // Инициализация хуков
        add_action('admin_menu', [$this, 'create_admin_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_head', [$this, 'insert_snow_effect']);
    }

    // Создание страницы админки
    public function create_admin_page() {
        add_menu_page(
            'Falling Snow Settings',
            'Falling Snow',
            'manage_options',
            'falling-snow',
            [$this, 'settings_page_content'],
            'dashicons-snow', // Иконка для меню
            80
        );
    }

    // Контент страницы настроек
    public function settings_page_content() {
        ?>
        <div class="wrap">
            <h1>Настройки падающего снега</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('falling_snow_settings');
                do_settings_sections('falling-snow');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    // Регистрация настроек
    public function register_settings() {
        register_setting('falling_snow_settings', 'falling_snow_enabled');
        register_setting('falling_snow_settings', 'falling_snow_intensity');

        add_settings_section(
            'falling_snow_main_section',
            'Основные настройки',
            null,
            'falling-snow'
        );

        add_settings_field(
            'falling_snow_enabled',
            'Включить падающий снег',
            [$this, 'enabled_field_callback'],
            'falling-snow',
            'falling_snow_main_section'
        );

        add_settings_field(
            'falling_snow_intensity',
            'Интенсивность снега',
            [$this, 'intensity_field_callback'],
            'falling-snow',
            'falling_snow_main_section'
        );
    }

    // Поле включения эффекта
    public function enabled_field_callback() {
        $enabled = get_option('falling_snow_enabled', false);
        ?>
        <input type="checkbox" name="falling_snow_enabled" value="1" <?php checked(1, $enabled, true); ?> />
        <?php
    }

    // Поле настройки интенсивности
    public function intensity_field_callback() {
        $intensity = get_option('falling_snow_intensity', 50);
        ?>
        <input type="number" name="falling_snow_intensity" value="<?php echo esc_attr($intensity); ?>" min="10" max="200" />
        <p class="description">Выберите интенсивность снега (10-200).</p>
        <?php
    }

    // Подключение стилей и скриптов
    public function enqueue_scripts() {
        wp_enqueue_style('falling-snow-style', plugin_dir_url(__FILE__) . 'falling-snow.css');
        wp_enqueue_script('falling-snow-script', plugin_dir_url(__FILE__) . 'falling-snow.js', [], null, true);
    }

    // Вставка скрипта снега в `wp_head`
    public function insert_snow_effect() {
        if (get_option('falling_snow_enabled')) {
            $intensity = get_option('falling_snow_intensity', 50);
            echo "<script>var snowIntensity = {$intensity};</script>";
        }
    }
}

// Инициализация плагина
new FallingSnow();
