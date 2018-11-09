<?php

namespace App\Admin\Controllers;

use App\Models\Role;
use App\Models\Permission;

use Encore\Admin\Form;
use Encore\Admin\Grid;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;


use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RoleController extends Controller
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
    public function create()
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
        return Admin::grid(Role::class, function (Grid $grid) {
           
            $grid->id('ID')->sortable();
            
            $grid->column('name' ,'name');
            $grid->column('slug','slug');

            $grid->permissions(trans('permission'))->pluck('name')->label();

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
        return Admin::form(Role::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('name','name');
            $form->text('slug','slug');

            $form->listbox('permissions', trans('admin.permissions'))->options(Permission::all()->pluck('name', 'id'));

            $form->display('created_at', 'created at');
            $form->display('updated_at', 'updated at');
        });
    }
}
