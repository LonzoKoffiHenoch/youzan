<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('layouts.app');
    }
}
