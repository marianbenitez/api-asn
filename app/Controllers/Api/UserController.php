<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Authentication\Authenticators\Session; // Import Session authenticator

class UserController extends ResourceController
{
    use ResponseTrait;

    /**
     * Listar todos los usuarios.
     * Requiere autenticación con token.
     *
     * @return CodeIgniter\HTTP\ResponseInterface
     */
    public function index()
    {
        $users = model(UserModel::class);
        return $this->respond($users->findAll());
    }

    /**
     * Crear un nuevo usuario.
     * Requiere autenticación con token.
     *
     * @return CodeIgniter\HTTP\ResponseInterface
     */
    public function create()
    {
        $rules = [
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ];

        if (! $this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $users = model(UserModel::class);

        $data = [
            'email'    => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
        ];

        $user = $users->new($data);

        if (! $users->save($user)) {
            return $this->fail($users->errors());
        }

        return $this->respondCreated(['message' => 'User created successfully', 'id' => $user->id]);
    }

    /**
     * Iniciar sesión y obtener un token de acceso.
     *
     * @return CodeIgniter\HTTP\ResponseInterface
     */
    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $credentials = [
            'email'    => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
        ];

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        if (! $authenticator->attempt($credentials)) {
            return $this->failUnauthorized('Invalid login credentials.');
        }

        $user = $authenticator->getUser();

        // Generate a new access token
        $token = $user->generateAccessToken('API Token');

        return $this->respond([
            'message' => 'Login successful',
            'token'   => $token->raw_token,
        ]);
    }
}
