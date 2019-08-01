<?php

namespace Exdeliver\Causeway\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Lang;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @param Request $request
     * @param Model   $model
     * @param bool    $fallback
     *
     * @return mixed
     */
    public function getTranslatedResult(Request $request, Model $model, bool $fallback = false)
    {
        $language = $request->language ?? Lang::locale();
        $newModel = $model->translate($language, $fallback);

        if ($newModel instanceof Model) {
            return $newModel;
        }

        return $model;
    }
}
