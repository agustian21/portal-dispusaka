<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatusConfirmationController extends Controller
{
    public function show(Request $request, string $id): View
    {
        $labels = [
            'panel.berita.status' => 'Berita',
            'panel.video.status' => 'Video',
            'panel.pamflet.status' => 'Pamflet',
            'panel.slider-website.status' => 'Slider Website',
            'panel.databidang.status' => 'Data Bidang',
            'panel.data-kadis.status' => 'Data Kadis',
            'panel.datapejabat.status' => 'Data Pejabat',
            'panel.ppid.status' => 'PPID',
            'panel.faqlayanan.status' => 'FAQ',
        ];

        $routeName = $request->route()?->getName();
        abort_unless(is_string($routeName) && isset($labels[$routeName]), 404);

        return view('administrator.confirm-status', [
            'dataLabel' => $labels[$routeName],
            'formAction' => route($routeName . '.submit', ['id' => $id]),
        ]);
    }
}
