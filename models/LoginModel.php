<?php

class LoginModel {
    public static function generateToken($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }

    public static function encryptPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public static function generateUrlHash($email, $timestamp, $action = '') {
        return md5($email . $timestamp . $action . 'secret_key');
    }

    public static function validateUrlHash($email, $timestamp, $hash, $action = '', $timeout = 3600) {
        if (time() - $timestamp > $timeout) {
            return false;
        }
        $expectedHash = self::generateUrlHash($email, $timestamp, $action);
        return hash_equals($expectedHash, $hash);
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validatePassword($password) {
        return strlen($password) >= 8;
    }

    public static function cleanInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    // Obtener IP del usuario
    public static function getUserIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return 'Unknown';
    }

    // Obtener información del navegador y SO
    public static function getUserAgentInfo() {
        $browser = 'Unknown';
        $os = 'Unknown';

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $ua = $_SERVER['HTTP_USER_AGENT'];

            // Detectar navegador
            if (preg_match('/Chrome/i', $ua)) {
                $browser = 'Chrome';
            } elseif (preg_match('/Firefox/i', $ua)) {
                $browser = 'Firefox';
            } elseif (preg_match('/Safari/i', $ua)) {
                $browser = 'Safari';
            } elseif (preg_match('/Edge/i', $ua)) {
                $browser = 'Edge';
            } elseif (preg_match('/Opera/i', $ua)) {
                $browser = 'Opera';
            } elseif (preg_match('/MSIE/i', $ua)) {
                $browser = 'Internet Explorer';
            }

            // Detectar sistema operativo
            if (preg_match('/Windows/i', $ua)) {
                $os = 'Windows';
            } elseif (preg_match('/Mac/i', $ua)) {
                $os = 'macOS';
            } elseif (preg_match('/Linux/i', $ua)) {
                $os = 'Linux';
            } elseif (preg_match('/Android/i', $ua)) {
                $os = 'Android';
            } elseif (preg_match('/iOS/i', $ua)) {
                $os = 'iOS';
            }
        }

        return ['browser' => $browser, 'os' => $os];
    }
}

?>