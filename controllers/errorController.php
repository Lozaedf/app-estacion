<?php
require_once(__DIR__ . "/../env.php");

$tpl = new Palta("error", "error");

$content = '
    <div class="error-container">
        <div class="error-icon">❌</div>
        <h1 class="error-title">Página No Encontrada</h1>
        <p class="error-message">La página que estás buscando no existe o ha sido movida.</p>
        <div class="error-actions">
            <a href="?slug=landing" class="btn btn-primary">Ir al Inicio</a>
            <a href="?slug=panel" class="btn btn-secondary">Panel Principal</a>
        </div>
    </div>
    <style>
        .error-container {
            text-align: center;
            padding: 50px 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .error-icon {
            font-size: 72px;
            margin-bottom: 20px;
        }
        .error-title {
            font-size: 36px;
            color: #e74c3c;
            margin-bottom: 20px;
        }
        .error-message {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }
        .error-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }
    </style>
';

$tpl->assign([
    'ERROR_CONTENT' => $content,
    'TITLE' => 'Error - ' . APP_NAME,
    'HEADER_TITLE' => 'Página No Encontrada',
    'HEADER_SUBTITLE' => '<p>La página que buscas no existe</p>',
    "APP_SECTION" => "error",
]);
$tpl->printToScreen();
?>