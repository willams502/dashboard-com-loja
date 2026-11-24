<?php
/**
 * Funções de segurança: autenticação, validação de upload e sanitização.
 */
function require_auth(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit;
    }
}

function validate_image_upload(array $file, string $destDir): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || empty($file['tmp_name'])) {
        return null;
    }
    if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
        throw new RuntimeException("Imagem excede o limite de 5MB.");
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    if (!in_array($ext, $allowed, true)) {
        throw new RuntimeException("Formato de imagem inválido.");
    }
    $info = @getimagesize($file['tmp_name']);
    if ($info === false) {
        throw new RuntimeException("Arquivo enviado não é uma imagem válida.");
    }
    if (!is_dir($destDir)) {
        mkdir($destDir, 0775, true);
    }
    $newName = bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], rtrim($destDir, '/\\') . '/' . $newName)) {
        throw new RuntimeException("Falha ao salvar imagem.");
    }
    return $newName;
}

function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
