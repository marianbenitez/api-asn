<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Cross-Origin Resource Sharing (CORS) Configuration
 */
class Cors extends BaseConfig
{
    /**
     * The default CORS configuration.
     */
    public array $default = [
        /**
         * Origins permitidos para CORS
         */
        'allowedOrigins' => [
            'http://localhost:4321',    // Puerto por defecto de Astro dev
            'http://localhost:3000',    // Puerto alternativo
            'http://127.0.0.1:4321',
            'http://127.0.0.1:3000',
        ],

        /**
         * Patrones de origen permitidos
         */
        'allowedOriginsPatterns' => [
            'https://.*\.vercel\.app',  // Para producción en Vercel
            'https://.*\.netlify\.app', // Para producción en Netlify
        ],

        /**
         * Permitir credenciales
         */
        'supportsCredentials' => true,

        /**
         * Headers permitidos
         */
        'allowedHeaders' => [
            'Authorization',
            'Content-Type',
            'X-Requested-With',
            'Accept',
            'Origin',
            'Access-Control-Request-Method',
            'Access-Control-Request-Headers',
        ],

        /**
         * Headers expuestos
         */
        'exposedHeaders' => [
            'Authorization',
            'Content-Type',
        ],

        /**
         * Métodos HTTP permitidos
         */
        'allowedMethods' => [
            'GET',
            'POST',
            'PUT',
            'DELETE',
            'OPTIONS',
            'PATCH',
        ],

        /**
         * Tiempo de cache para preflight requests
         */
        'maxAge' => 7200,
    ];
}