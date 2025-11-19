<?php

require_once __DIR__ . '/Database.php';

class UserModel extends DBAbstract
{
    public function create($token, $email, $nombres, $contraseña, $token_action = null)
    {
        $email = $this->db->real_escape_string($email);
        $nombres = $this->db->real_escape_string($nombres);
        $token = $this->db->real_escape_string($token);

        // Hashear la contraseña antes de guardarla
        $hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);
        $contraseña = $this->db->real_escape_string($hashed_password);

        $token_action = $token_action ? "'" . $this->db->real_escape_string($token_action) . "'" : 'NULL';

        $sql = "INSERT INTO `app-estacion` (token, email, nombres, contraseña, token_action, add_date, update_date)
                VALUES ('$token', '$email', '$nombres', '$contraseña', $token_action, NOW(), NOW())";
        return $this->ejecutar($sql);
    }

    public function getByEmail($email)
    {
        $email = $this->db->real_escape_string($email);
        $sql = "SELECT * FROM `app-estacion` WHERE email = '$email'";
        $result = $this->consultar($sql);
        return $result[0] ?? null;
    }

    public function getByToken($token)
    {
        $token = $this->db->real_escape_string($token);
        $sql = "SELECT * FROM `app-estacion` WHERE token = '$token'";
        $result = $this->consultar($sql);
        return $result[0] ?? null;
    }

    public function getByTokenAction($token_action)
    {
        $token_action = $this->db->real_escape_string($token_action);
        $sql = "SELECT * FROM `app-estacion` WHERE token_action = '$token_action'";

        $result = $this->consultar($sql);

        return $result[0] ?? null;
    }

    public function resetPassword($token_action, $newPassword)
    {
        $token_action = $this->db->real_escape_string($token_action);

        // Primero obtener el usuario para saber su token
        $user = $this->getByTokenAction($token_action);
        if (!$user) {
            return false;
        }

        // Hashear la nueva contraseña antes de guardarla
        $hashed_password = password_hash($newPassword, PASSWORD_BCRYPT);
        $newPassword = $this->db->real_escape_string($hashed_password);

        // Actualizar contraseña y limpiar token_action, desactivar recupero y bloqueado
        $sql = "UPDATE `app-estacion`
                  SET contraseña = '$newPassword',
                      token_action = NULL,
                      recuperado = 0,
                      bloqueado = 0,
                      update_date = NOW()
                  WHERE token_action = '$token_action'";

        $resultado = $this->ejecutar($sql);

        return $resultado;
    }

    public function activate($token)
    {
        $token = $this->db->real_escape_string($token);
        $sql = "UPDATE `app-estacion`
                SET activo = 1,
                    active_date = NOW(),
                    token_action = NULL,
                    update_date = NOW()
                WHERE token = '$token' AND activo = 0";
        return $this->ejecutar($sql);
    }

    public function block($token)
    {
        $token = $this->db->real_escape_string($token);
        $sql = "UPDATE `app-estacion`
                SET bloqueado = 1,
                    blocked_date = IF(bloqueado = 0, NOW(), blocked_date),
                    update_date = NOW()
                WHERE token = '$token'";
        return $this->ejecutar($sql);
    }

    public function setRecoveryTokenAfterBlock($token, $token_action)
    {
        $token = $this->db->real_escape_string($token);
        $token_action = $this->db->real_escape_string($token_action);
        $sql = "UPDATE `app-estacion`
                SET token_action = '$token_action',
                    recuperado = 1,
                    recover_date = NOW(),
                    update_date = NOW()
                WHERE token = '$token'";
        return $this->ejecutar($sql);
    }

    public function setRecoveryToken($token, $token_action)
    {
        $token = $this->db->real_escape_string($token);
        $token_action = $this->db->real_escape_string($token_action);
        $sql = "UPDATE `app-estacion`
                SET token_action = '$token_action',
                    recuperado = 1,
                    recover_date = NOW(),
                    update_date = NOW()
                WHERE token = '$token'";
        return $this->ejecutar($sql);
    }

}
?>