<?php

namespace App\Traits\General;

use App\Helpers\BreadcrumbHelper;

trait BreadcrumbsTrait
{
    public function setBreadcrumbs($page, $method, $routeParams = null)
    {
        return call_user_func([$this, $page], $method, $routeParams);
    }

    private function dashboard($method, $routeParams)
    {
        $breadcrumbs = new BreadcrumbHelper('Dashboard');

        switch ($method) {
            case 'index':
                $breadcrumbs->add('Daftar', route('dashboard.index'));
                return $breadcrumbs->get();

                break;
            default:
                return null;
        }
    }

    private function division($method, $routeParams)
    {
        $breadcrumbs = new BreadcrumbHelper('Divisi');

        switch ($method) {
            case 'index':
                $breadcrumbs->add('Daftar', route('divisions.index'));
                return $breadcrumbs->get();

                break;
            case 'create':
                $breadcrumbs->add('Daftar', route('divisions.index'))->add('Tambah', route('divisions.create'));
                return $breadcrumbs->get();

                break;
            case 'edit':
                $breadcrumbs->add('Daftar', route('divisions.index'))->add('Edit', route('divisions.edit', $routeParams->id))->add($routeParams->name);
                return $breadcrumbs->get();

                break;
            default:
                return null;
        }
    }

    private function sub_division($method, $routeParams)
    {
        $breadcrumbs = new BreadcrumbHelper('Sub Divisi');

        switch ($method) {
            case 'index':
                $breadcrumbs->add('Daftar', route('sub-divisions.index'));
                return $breadcrumbs->get();

                break;
            case 'create':
                $breadcrumbs->add('Daftar', route('sub-divisions.index'))->add('Tambah', route('sub-divisions.create'));
                return $breadcrumbs->get();

                break;
            case 'edit':
                $breadcrumbs->add('Daftar', route('sub-divisions.index'))->add('Edit', route('sub-divisions.edit', $routeParams->id))->add($routeParams->name);
                return $breadcrumbs->get();

                break;
            default:
                return null;
        }
    }

    private function instruction($method, $routeParams)
    {
        $breadcrumbs = new BreadcrumbHelper('Instruksi');

        switch ($method) {
            case 'index':
                $breadcrumbs->add('Daftar', route('instructions.index'));
                return $breadcrumbs->get();

                break;
            case 'create':
                $breadcrumbs->add('Daftar', route('instructions.index'))->add('Tambah', route('instructions.create'));
                return $breadcrumbs->get();

                break;
            case 'edit':
                $breadcrumbs->add('Daftar', route('instructions.index'))->add('Edit', route('instructions.edit', $routeParams->id))->add($routeParams->name);
                return $breadcrumbs->get();

                break;
            default:
                return null;
        }
    }

    private function permission($method, $routeParams)
    {
        $breadcrumbs = new BreadcrumbHelper('Hak Akses');

        switch ($method) {
            case 'index':
                $breadcrumbs->add('Daftar', route('permissions.index'));
                return $breadcrumbs->get();

                break;
            case 'create':
                $breadcrumbs->add('Daftar', route('permissions.index'))->add('Tambah', route('permissions.create'));
                return $breadcrumbs->get();

                break;
            default:
                return null;
        }
    }

    private function role($method, $routeParams)
    {
        $breadcrumbs = new BreadcrumbHelper('Peran');

        switch ($method) {
            case 'index':
                $breadcrumbs->add('Daftar', route('roles.index'));
                return $breadcrumbs->get();

                break;
            case 'create':
                $breadcrumbs->add('Daftar', route('roles.index'))->add('Tambah', route('roles.create'));
                return $breadcrumbs->get();

                break;
            case 'edit':
                $breadcrumbs->add('Daftar', route('roles.index'))->add('Edit', route('roles.edit', $routeParams->id))->add($routeParams->name);
                return $breadcrumbs->get();

                break;
            default:
                return null;
        }
    }

    private function user($method, $routeParams)
    {
        $breadcrumbs = new BreadcrumbHelper('Pengguna');

        switch ($method) {
            case 'index':
                $breadcrumbs->add('Daftar', route('users.index'));
                return $breadcrumbs->get();

                break;
            case 'create':
                $breadcrumbs->add('Daftar', route('users.index'))->add('Tambah', route('users.create'));
                return $breadcrumbs->get();

                break;
            case 'edit':
                $breadcrumbs->add('Daftar', route('users.index'))->add('Edit', route('users.edit', $routeParams->id))->add($routeParams->name);
                return $breadcrumbs->get();

                break;
            default:
                return null;
        }
    }

    private function disposition($method, $routeParams)
    {
        $breadcrumbs = new BreadcrumbHelper('Disposisi');

        switch ($method) {
            case 'index':
                $breadcrumbs->add('Daftar', route('dispositions.index'));
                return $breadcrumbs->get();

                break;
            case 'create':
                $breadcrumbs->add('Daftar', route('dispositions.index'))->add('Tambah', route('dispositions.create'));
                return $breadcrumbs->get();

                break;
            case 'show':
                $breadcrumbs->add('Daftar', route('dispositions.index'))->add('Tampilkan', route('dispositions.show', $routeParams->id))->add($routeParams->number_transaction );
                return $breadcrumbs->get();

                break;
            case 'edit':
                $breadcrumbs->add('Daftar', route('dispositions.index'))->add('Edit', route('dispositions.edit', $routeParams->id))->add($routeParams->number_transaction);
                return $breadcrumbs->get();

                break;
            default:
                return null;
        }
    }

    private function memo($method, $routeParams)
    {
        $breadcrumbs = new BreadcrumbHelper('Memo');

        switch ($method) {
            case 'index':
                $breadcrumbs->add('Daftar', route('memos.index'));
                return $breadcrumbs->get();

                break;
            case 'create':
                $breadcrumbs->add('Daftar', route('memos.index'))->add('Tambah', route('memos.create'));
                return $breadcrumbs->get();

                break;
            case 'show':
                $breadcrumbs->add('Daftar', route('memos.index'))->add('Tampilkan', route('memos.show', $routeParams->id))->add($routeParams->number_transaction );
                return $breadcrumbs->get();

                break;
            case 'edit':
                $breadcrumbs->add('Daftar', route('memos.index'))->add('Edit', route('memos.edit', $routeParams->id))->add($routeParams->number_transaction );
                return $breadcrumbs->get();

                break;
            default:
                return null;
        }
    }

    private function notification($method)
    {
        $breadcrumbs = new BreadcrumbHelper('Notifikasi');

        switch ($method) {
            case 'index':
                $breadcrumbs->add('Daftar', route('memos.index'));
                return $breadcrumbs->get();

                break;
            default:
                return null;
        }
    }
}
