<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\KategoriModel;

class MenuController extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();
        return view('admin/menu/index', [
            'title' => 'Manajemen Menu',
            'menu'  => $menuModel->getMenuWithKategori(),
        ]);
    }

    public function tambah()
    {
        $kategoriModel = new KategoriModel();
        return view('admin/menu/form', [
            'title'    => 'Tambah Menu',
            'kategori' => $kategoriModel->orderBy('urutan')->findAll(),
            'menu'     => null,
        ]);
    }

    public function simpan()
    {
        $menuModel = new MenuModel();

        $gambar = null;
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $gambar = $file->getRandomName();
            $file->move(FCPATH . 'uploads/menu', $gambar);
        }

        $menuModel->insert([
            'kategori_id' => $this->request->getPost('kategori_id'),
            'nama'        => $this->request->getPost('nama'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga'       => (int) str_replace(['.', ','], '', $this->request->getPost('harga')),
            'stok'        => $this->request->getPost('stok') ?: 100,
            'gambar'      => $gambar,
            'tersedia'    => 1,
        ]);

        return redirect()->to('/admin/menu')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menuModel     = new MenuModel();
        $kategoriModel = new KategoriModel();

        return view('admin/menu/form', [
            'title'    => 'Edit Menu',
            'menu'     => $menuModel->find($id),
            'kategori' => $kategoriModel->orderBy('urutan')->findAll(),
        ]);
    }

    public function update($id)
    {
        $menuModel = new MenuModel();
        $existing  = $menuModel->find($id);

        $gambar = $existing['gambar'];
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // hapus lama
            if ($gambar && file_exists(FCPATH . 'uploads/menu/' . $gambar)) {
                unlink(FCPATH . 'uploads/menu/' . $gambar);
            }
            $gambar = $file->getRandomName();
            $file->move(FCPATH . 'uploads/menu', $gambar);
        }

        $menuModel->update($id, [
            'kategori_id' => $this->request->getPost('kategori_id'),
            'nama'        => $this->request->getPost('nama'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga'       => (int) str_replace(['.', ','], '', $this->request->getPost('harga')),
            'stok'        => $this->request->getPost('stok') ?: 100,
            'gambar'      => $gambar,
        ]);

        return redirect()->to('/admin/menu')->with('success', 'Menu berhasil diupdate!');
    }

    public function hapus($id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);
        if ($menu && $menu['gambar']) {
            @unlink(FCPATH . 'uploads/menu/' . $menu['gambar']);
        }
        $menuModel->delete($id);
        return redirect()->to('/admin/menu')->with('success', 'Menu dihapus.');
    }

    public function toggle($id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);
        $menuModel->update($id, ['tersedia' => $menu['tersedia'] ? 0 : 1]);
        return redirect()->to('/admin/menu')->with('success', 'Status menu diubah.');
    }
}