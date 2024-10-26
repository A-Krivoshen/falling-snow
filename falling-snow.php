<?php
/*
Plugin Name: Falling Snow
Description: Плагин для эффекта падающего снега на сайте.
Version: 1.1
Author: Aleksey Krivoshein
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class FallingSnowPlugin {
    
    public function __construct() {
        // Инициализация хуков
        add_action('admin_menu', [$this, 'create_admin_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles_and_scripts']);
        add_action('wp_footer', [$this, 'add_snowflakes']);
    }

    // Создание страницы настроек в админке
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
        register_setting('falling_snow_settings', 'falling_snow_color', [
            'default' => '#ffffff',
        ]);

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
            'falling_snow_color',
            'Цвет снежинок',
            [$this, 'color_field_callback'],
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

    // Поле выбора цвета снежинок
    public function color_field_callback() {
        $color = get_option('falling_snow_color', '#ffffff');
        ?>
        <input type="color" name="falling_snow_color" value="<?php echo esc_attr($color); ?>" />
        <p class="description">Выберите цвет снежинок.</p>
        <?php
    }

    // Подключение стилей и скриптов
    public function enqueue_styles_and_scripts() {
        if (get_option('falling_snow_enabled')) {
            wp_enqueue_style('falling-snow-style', plugin_dir_url(__FILE__) . 'falling-snow.css');
            wp_enqueue_script('falling-snow-script', plugin_dir_url(__FILE__) . 'falling-snow.js', [], null, true);

            // Передаем цвет снежинок в JavaScript
            $snow_color = get_option('falling_snow_color', '#ffffff');
            wp_add_inline_script('falling-snow-script', 'var snowColor = "' . esc_js($snow_color) . '";', 'before');
        }
    }

    // Добавление HTML для снежинок в footer
    public function add_snowflakes() {
        if (get_option('falling_snow_enabled')) {
            echo '<div id="snowflakes-container">';
            for ($i = 0; $i < 100; $i++) {
                echo '<div class="snow"></div>';
            }
            echo '</div>';
        }
    }
}

// Инициализация плагина
new FallingSnowPlugin();
