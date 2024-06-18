<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['users.create', 'users.edit'], function ($view) {
            return $view->with(
                'roles',
                Role::select('id', 'name')->get()
            );
        });
  

		View::composer(['mutasis.create', 'mutasis.edit'], function ($view) {
            return $view->with(
                'barangs',
                \App\Models\Barang::select('id', 'nama_barang')->get()
            );
        });

View::composer(['mutasis.create', 'mutasis.edit'], function ($view) {
            return $view->with(
                'ruangans',
                \App\Models\Ruangan::select('id', 'nama_ruangan')->get()
            );
        });

		View::composer(['transaksis.create', 'transaksis.edit'], function ($view) {
            return $view->with(
                'barangs',
                \App\Models\Barang::select('id', 'nama_barang')->get()
            );
        });

View::composer(['transaksis.create', 'transaksis.edit'], function ($view) {
            return $view->with(
                'ruangans',
                \App\Models\Ruangan::select('id', 'nama_ruangan')->get()
            );
        });

		View::composer(['transaks.create', 'transaks.edit'], function ($view) {
            return $view->with(
                'barangs',
                \App\Models\Barang::select('id', 'nama_barang')->get()
            );
        });

View::composer(['transaks.create', 'transaks.edit'], function ($view) {
            return $view->with(
                'ruangans',
                \App\Models\Ruangan::select('id', 'nama_ruangan')->get()
            );
        });

		View::composer(['inventors.create', 'inventors.edit'], function ($view) {
            return $view->with(
                'transaks',
                \App\Models\Transak::select('id', 'barang_id')->get()
            );
        });

		View::composer(['pelaporans.create', 'pelaporans.edit'], function ($view) {
            return $view->with(
                'barangs',
                \App\Models\Barang::select('id', 'nama_barang')->get()
            );
        });

View::composer(['pelaporans.create', 'pelaporans.edit'], function ($view) {
            return $view->with(
                'ruangans',
                \App\Models\Ruangan::select('id', 'nama_ruangan')->get()
            );
        });

		View::composer(['pelaporans.create', 'pelaporans.edit'], function ($view) {
            return $view->with(
                'transaks',
                \App\Models\Transak::select('id', 'barang_id')->get()
            );
        });

		View::composer(['pegawais.create', 'pegawais.edit'], function ($view) {
            return $view->with(
                'users',
                \App\Models\User::select('id', 'name')->get()
            );
        });

	}
}