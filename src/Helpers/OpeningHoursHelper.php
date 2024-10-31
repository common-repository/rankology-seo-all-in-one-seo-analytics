<?php

namespace Rankology\Helpers;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class OpeningHoursHelper {
    public static function getDays() {
        return [
            esc_html__('Monday', 'wp-rankology'),
            esc_html__('Tuesday', 'wp-rankology'),
            esc_html__('Wednesday', 'wp-rankology'),
            esc_html__('Thursday', 'wp-rankology'),
            esc_html__('Friday', 'wp-rankology'),
            esc_html__('Saturday', 'wp-rankology'),
            esc_html__('Sunday', 'wp-rankology'),
        ];
    }

    public static function getHours() {
        return ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'];
    }

    public static function getMinutes() {
        return ['00', '15', '30', '45', '59'];
    }
}
