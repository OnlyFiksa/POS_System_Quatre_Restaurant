<?php

namespace App\Filters;

use App\Models\ApiKeyModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $apiKey = $request->getHeaderLine('X-API-KEY');

        if (!$apiKey) {
            return service('response')->setJSON([
                'status'  => 'error',
                'message' => 'API Key tidak ditemukan. Sertakan X-API-KEY di header.',
            ])->setStatusCode(401);
        }

        $model = new ApiKeyModel();
        $user  = $model->getUserByKey($apiKey);

        if (!$user) {
            return service('response')->setJSON([
                'status'  => 'error',
                'message' => 'API Key tidak valid.',
            ])->setStatusCode(401);
        }

        // Simpan data user ke dalam config sementara
        config('App')->apiUser = $user;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}