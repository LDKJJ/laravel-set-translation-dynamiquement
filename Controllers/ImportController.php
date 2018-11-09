<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Language;
use Encore\Admin\Form;
use Encore\Admin\Layout\Row;
use Encore\Admin\Layout\Column;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ImportController extends Controller
{
    use ModelForm;
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {
            $content->header('Import');
            $content->description('data');
            $content->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    //dd(View::make());
                    $column->append(view::make('admin.import'));
                });
            });
        });
    }

}
