<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Host;

use App\Models\Group;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use App\Models\Language;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Controllers\ModelForm;

class GroupController extends Controller
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
        return Admin::grid(Group::class, function (Grid $grid) {
           
            $grid->id(trans('groups.id'))->sortable();
            
            $grid->column('name' ,trans('groups.name'));

            $grid->column('host' ,trans('groups.host'));

            $grid->users(trans('groups.users'))->pluck('email')->label();

            $grid->languages(trans('languages.users'))->pluck('iso')->label();

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
        return Admin::form(Group::class, function (Form $form) {
            $form->display('id', trans('groups.id'));

            $form->text('name',trans('groups.name'));

            $form->text('host',trans('groups.host'));

            $form->belongsToMany('users', function (Form\NestedForm $form) {
                $form->text('name',trans('users.name'));
                $form->text('username',trans('users.username'));
                $form->email('email',trans('users.email'));
                $form->password('password',trans('users.password'));
                $form->switch('is_active',trans('users.state'));
            });

            $form->multipleSelect('users', trans('users.email'))
                ->options(User::all()
                ->pluck('email','id'));

            $form->multipleSelect('languages', trans('languages.iso'))->options(Language::all()->pluck('iso','id'));
            
            $form->display('created_at',trans('groups.createdat'));
            $form->display('updated_at',trans('groups.updatedat'));
        });
    }
}
