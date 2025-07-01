<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class TestController extends ResourceController
{
    use ResponseTrait;

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return $this->respond([
            'status'  => 200,
            'message' => 'This is a public API endpoint.',
        ]);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function protected()
    {
        return $this->respond([
            'status'  => 200,
            'message' => 'This is a protected API endpoint. You are authenticated!',
        ]);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function adminOnly()
    {
        if (! auth()->user()->inGroup('admin')) {
            return $this->failUnauthorized('You are not authorized to access this resource.');
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'This is an admin-only API endpoint. You are an admin!',
        ]);
    }
}
