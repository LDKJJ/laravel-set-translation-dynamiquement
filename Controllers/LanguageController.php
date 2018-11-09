<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Host;
use App\Models\Group;
use App\Models\Language;

use Encore\Admin\Form;
use Encore\Admin\Grid;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;

use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Request $request)
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Language::class, function (Grid $grid) {
           
            $grid->id(trans('languages.id'))->sortable();
            
            $grid->column('name' ,trans('languages.name'));

            $grid->column('iso' ,trans('languages.iso'));

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Language::class, function (Form $form) {

            $form->display('id', trans('languages.id'));

            $form->text('iso',trans('languages.iso'));

            $form->text('name',trans('languages.name'));
        });
    }
}
