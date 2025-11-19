<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ TITLE }} - {{ APP_NAME }}</title>
    <link rel="stylesheet" href="views/assets/css/base.css">
    {{ CSS_SECTION_LINK }}
    <style>
        :root {
            /* Variables de aplicación */
            --APP_NAME: '{{ APP_NAME }}';
            --APP_AUTHOR: '{{ APP_AUTHOR }}';
            --APP_DESCRIPTION: '{{ APP_DESCRIPTION }}';
            --APP_BASE_URL: '{{ APP_BASE_URL }}';
            --API_BASE_URL: '{{ API_BASE_URL }}';

            /* Colores principales */
            --COLOR_FONDO_PRINCIPAL: {{ COLOR_FONDO_PRINCIPAL }};
            --COLOR_TEXTO_PRINCIPAL: {{ COLOR_TEXTO_PRINCIPAL }};
            --COLOR_TEXTO_SECUNDARIO: {{ COLOR_TEXTO_SECUNDARIO }};
            --COLOR_ACENTO_CLIMA: {{ COLOR_ACENTO_CLIMA }};
            --COLOR_ACENTO_ALERTA: {{ COLOR_ACENTO_ALERTA }};
            --COLOR_ACENTO_SECUNDARIO: {{ COLOR_ACENTO_SECUNDARIO }};
            --COLOR_BOTON_PRINCIPAL_TEXTO: {{ COLOR_BOTON_PRINCIPAL_TEXTO }};
            --COLOR_BOTON_SECUNDARIO_TEXTO: {{ COLOR_BOTON_SECUNDARIO_TEXTO }};
            --COLOR_HEADER_FONDO: {{ COLOR_HEADER_FONDO }};
            --COLOR_FOOTER_FONDO: {{ COLOR_FOOTER_FONDO }};
            --COLOR_FOOTER_TEXTO: {{ COLOR_FOOTER_TEXTO }};

            /* Colores adicionales para formularios y autenticación */
            --COLOR_BLANCO: {{ COLOR_BLANCO }};
            --COLOR_GRIS_CLARO: {{ COLOR_GRIS_CLARO }};
            --COLOR_GRIS_MEDIO: {{ COLOR_GRIS_MEDIO }};
            --COLOR_BORDE_INPUT: {{ COLOR_BORDE_INPUT }};
            --COLOR_BORDE_INPUT_FOCUS: {{ COLOR_BORDE_INPUT_FOCUS }};
            --COLOR_FONDO_ERROR: {{ COLOR_FONDO_ERROR }};
            --COLOR_FONDO_EXITO: {{ COLOR_FONDO_EXITO }};
            --COLOR_SOMBRA: {{ COLOR_SOMBRA }};

            /* Tipografía */
            --FONT_FAMILY: {{ FONT_FAMILY }};
            --FONT_SIZE_BASE: {{ FONT_SIZE_BASE }};
            --FONT_WEIGHT_NORMAL: {{ FONT_WEIGHT_NORMAL }};
            --FONT_WEIGHT_BOLD: {{ FONT_WEIGHT_BOLD }};

            /* Espaciado */
            --SPACING_XS: {{ SPACING_XS }};
            --SPACING_SM: {{ SPACING_SM }};
            --SPACING_MD: {{ SPACING_MD }};
            --SPACING_LG: {{ SPACING_LG }};
            --SPACING_XL: {{ SPACING_XL }};

            /* Bordes */
            --BORDER_RADIUS_SM: {{ BORDER_RADIUS_SM }};
            --BORDER_RADIUS_MD: {{ BORDER_RADIUS_MD }};
            --BORDER_RADIUS_LG: {{ BORDER_RADIUS_LG }};

            /* Transiciones */
            --TRANSITION_FAST: {{ TRANSITION_FAST }};
            --TRANSITION_MEDIUM: {{ TRANSITION_MEDIUM }};
        }
    </style>
</head>
<body>