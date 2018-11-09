<?php

namespace App\Admin\Controllers;

use App\Models\Host;
use App\Models\Group;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Database\Eloquent\Model;

class HostController extends Controller
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
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Host::class, function (Grid $grid) {
           
            $grid->id('ID')->sortable();
            $grid->sub_domain('Sub Domain')->sortable();

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
        return Admin::form(Host::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('sub_domain', 'Sub Domain');
            
            $form->display('created_at', 'created at');
            $form->display('updated_at', 'updated at');
        });
    }
}
