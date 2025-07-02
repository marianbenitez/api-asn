<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\AccessTokens;
use CodeIgniter\Shield\Exceptions\AuthenticationException;

class AuthTokenFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificar si el header Authorization está presente
        $header = $request->getHeaderLine('Authorization');
        
        if (empty($header)) {
            return $this->unauthorizedResponse('Authorization header is required.');
        }

        // Verificar formato Bearer token
        if (! str_starts_with($header, 'Bearer ')) {
            return $this->unauthorizedResponse('Invalid authorization header format. Use: Bearer <token>');
        }

        // Extraer el token
        $token = substr($header, 7);

        try {
            // Intentar autenticar con el token
            $authenticator = auth('tokens')->getAuthenticator();
            
            if (! $authenticator instanceof AccessTokens) {
                return $this->unauthorizedResponse('Invalid token authenticator.');
            }

            $result = $authenticator->attempt(['token' => $token]);
            
            if (! $result->isOK()) {
                return $this->unauthorizedResponse('Invalid or expired token.');
            }

            // El usuario está autenticado, continuar
            return;
            
        } catch (AuthenticationException $e) {
            return $this->unauthorizedResponse('Authentication failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            log_message('error', 'Token authentication error: ' . $e->getMessage());
            return $this->unauthorizedResponse('Authentication error occurred.');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hay procesamiento posterior necesario
    }

    /**
     * Generar respuesta de no autorizado
     *
     * @param string $message
     * @return ResponseInterface
     */
    private function unauthorizedResponse(string $message): ResponseInterface
    {
        return response()->setJSON([
            'status' => 401,
            'error' => 'Unauthorized',
            'message' => $message
        ])->setStatusCode(401);
    }
}