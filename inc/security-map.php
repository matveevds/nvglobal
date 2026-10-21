<?php
/**
 * Слои карты Юго-Восточной Азии (кадр 369×360, Figma 2642:30982): имя файла `img/identity-security-<имя>.svg`
 * и inset в % (top, right, bottom, left). Единое место объявления — карту читают блок Security
 * (template-parts/idv-security-section.php) и Coverage SEA на /identity-verification/.
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('nv_security_map_layers')) {
    function nv_security_map_layers(): array
    {
        return array(
            array('thailand1', 23.55, 64.19, 41.21, 17.9),
            array('indonesia1', 58.58, -1.27, 4.79, 13.9),
            array('laos', 18.66, 60.1, 60.98, 23.94),
            array('cambodia', 37.16, 59.94, 52.77, 28.68),
            array('vietnam', 16.76, 56.18, 48.42, 28.26),
            array('group', 18.87, 60.04, 62.66, 28.2),
            array('myanmar', 3.86, 73.7, 51.47, 6.7),
            array('phippilines', 21.04, 18.48, 39.19, 59.76),
            array('dili', 89.82, 19.77, 8.03, 76.09),
            array('singapore', 68.04, 67.69, 31.48, 31.45),
            array('malaysia', 54.88, 35.55, 30.83, 23.01),
            array('group1', 56.25, 71.79, 41.15, 24.1),
            array('group2', 61.34, 39.22, 30.77, 43.95),
            array('cambodia4', 37.09, 59.88, 52.68, 28.61),
            array('group3', 20.98, 64.13, 61.9, 23.89),
            array('group4', 23.48, 76.05, 51.63, 17.84),
        );
    }
}
