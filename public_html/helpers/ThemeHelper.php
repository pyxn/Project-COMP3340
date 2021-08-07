<?php

class ThemeHelper {
    public static function get_css_theme(String $theme_color) {
        if ($theme_color == 'blue') {
            return '<link rel="stylesheet" href="styles/theme_blue.css" />';
        } else if ($theme_color == 'pink') {
            return '<link rel="stylesheet" href="styles/theme_pink.css" />';
        } else if ($theme_color == 'yellow') {
            return '<link rel="stylesheet" href="styles/theme_yellow.css" />';
        } else {
            return '';
        }
    }
}
