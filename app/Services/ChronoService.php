<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class ChronoService
{
    public function generateCode(Model $model)
    {
        $count = $model::where('user_id', auth()->id())->count();

        return date('Ym') . '00' . $count + 1;
    }
}
