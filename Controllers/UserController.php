<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Controllers\ModelForm;
class UserController extends Controller
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
            $grid = $this->grid()->disableExport();
            $content->body($grid);
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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id(trans('users.id'))->sortable();

            $grid->column('name' ,trans('users.name'));

            $grid->column('username',trans('users.username'));
            $grid->column('email' ,trans('users.email'));

            $grid->column('is_active' ,trans('users.state'));

            $grid->roles(trans('users.roles'))->pluck('name')->label();

            $grid->groups(trans('users.groups'))->pluck('name')->label();

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
        return Admin::form(User::class, function (Form $form) {
            $form->display('id');

            $form->text('name',trans('users.name'));
            $form->text('username',trans('users.username'));
            $form->email('email',trans('users.email'));
            $form->password('password', trans('users.password'))->rules('required|confirmed');
            $form->password('password_confirmation', trans('users.password_confirmation'))->rules('required')
            ->default(function ($form) {
                return $form->model()->password;
            });
            $form->ignore(['password_confirmation']);
            $form->switch('is_active',trans('users.state'));
            
            $form->multipleSelect('roles', trans('users.roles'))->options(Role::all()->pluck('name', 'id'));
            
            $form->select('groups', trans('users.groups'))->options(Group::all()->pluck('name', 'id'));
            
            $form->display('created_at',trans('users.createdat'));
            $form->display('updated_at',trans('users.updated at'));
            $form->file('blalblala',trans('blablabla'));
            
            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });
        });
    }
}
