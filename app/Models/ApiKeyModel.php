<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiKeyModel extends Model
{
    protected $table      = 'api_keys';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'api_key'];
    protected $useTimestamps = false;

    public function generateKey($userId)
    {
        // Hapus key lama kalau ada
        $this->where('user_id', $userId)->delete();

        // Buat key baru
        $key = bin2hex(random_bytes(32));
        $this->insert([
            'user_id' => $userId,
            'api_key' => $key,
        ]);

        return $key;
    }

    public function getUserByKey($key)
    {
        return $this->db->table('api_keys ak')
            ->select('ak.*, u.nama, u.username, u.role')
            ->join('users u', 'u.id = ak.user_id')
            ->where('ak.api_key', $key)
            ->get()->getRowArray();
    }
}