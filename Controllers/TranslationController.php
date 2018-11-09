<?php

namespace App\Admin\Controllers;

use App\Models\Translation;
use Encore\Admin\Form;
use Encore\Admin\Grid;

use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Row;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class TranslationController extends Controller
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
            $content->header('Translation');
            $content->description('data');
            $content->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append(view::make('admin.translation', array('directories' => Translation::GetChildsFilesLang(resource_path('/lang/')))));
                });
            });
        });

    }

    public function CheckLastKey($array = array(), $key){

        $keys = array_keys($array);
        $last = end($keys);
        if($last == $key) return true; else return false;

    }

    public function GetKeysOfArray(&$parentarray = array(), $array, $path){

        foreach($array as $key=>$value){
            if(is_array($value)){
                $path .= $key.'=>';
                foreach($value as $key2=>$value2){
                    if(is_array($value2)){
                        $path .= $key2.'=>';
                        array_merge( $parentarray, $this->GetKeysOfArray($parentarray, $value2, $path));
                            $arr = array_filter(explode('=>', $path));
                            $new_array = array_pop($arr);
                            $path = '';
                            foreach($arr as $value22){
                                $path .= $value22.'=>';
                            }
                    }else {
                        $parentarray[$path.$key2] = $value2;
                        if($this->CheckLastKey($value, $key2)){
                            $arr = array_filter(explode('=>', $path));
                            $new_array = array_pop($arr);
                            $path = '';
                            foreach($arr as $value33){
                                $path .= $value33.'=>';
                            }
                        }
                    }
                }
            }else{
                    $parentarray[$path.$key] = $value;
            }
        }
       return $parentarray;

    }

    public function GetPathParentKey($array, $key_name, &$path = null){

        foreach($array as $key=>$value){
            if(is_array($value) && !empty($value)){
                $path .= $key.'/';
                foreach($value as $key2=>$value2){
                    if(is_array($value2)){
                        $path .= $key2.'/';
                        $this->GetPathParentKey($value2, $key_name, $path);
                    }else {
                        if($key2 == $key_name) { $path .= $key2; break; }
                        else $path = '';
                    }
                }
            }else{
                if($key == $key_name) { $path .= 'path/'.$key; break; }
            }
        }
        return $path;

    }

    public function GetLanguageArray(Request $request){

        $object = array();
      foreach(Translation::GetChildsFilesLang(resource_path('/lang/'.$request->input('lang_name').'/')) as $file){
            $languageArray = Translation::GetLanguageArray($request->input('lang_name'), $file);
            $tableauLang = array();
            $object[explode('.', $file)[0]] = $this->GetKeysOfArray($tableauLang, $languageArray, null);
            $object[explode('.', $file)[0]]['parent_name'] = explode('.', $file)[0];
      }
         echo json_encode($object);

    }

    public function SetLanguageArray(Request $request){

        $array = array();
        /*--------------------- Store backup of translation --------------------------*/
        $contents = var_export(Translation::GetLanguageArray($request->input('lang_name'), $request->input('parent_file')), true);
        Storage::put('backup_lang/'.$request->input('parent_file').'.php', "<?php\n  return {$contents} \n ?>");
        /*--------------------------- Finish store -----------------------------------*/
        $object = Translation::GetLanguageArray($request->input('lang_name'), $request->input('parent_file'));
        $result = $this->SetKeysInArray($object, $request->input('key'), $request->input('value'));
        echo json_encode($result);

    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit(Request $request, $id)
    {
        //dd($request);
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
        return Admin::grid(Translation::class, function (Grid $grid) {

            $grid->id(trans('languages.id'))->sortable();

            $grid->column('name' ,trans('languages.name'));

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
        return Admin::form(Translation::class, function (Form $form) {

            $form->display('id', trans('languages.id'));

            $form->text('name',trans('name'))->attribute('id', 'language_name');

            $form->select('autoselect')->options(function ($id) {
                $languageArray = Translation::GetLanguageArray('en');
                $tableauLang = array();
                foreach($languageArray as $key=>$value){
                    if(is_array($value)){
                        foreach($value as $key2=>$value2){
                            $tableauLang[$value2] = $key2;
                        }
                    }else{
                        $tableauLang[$value] = $key;
                    }
                }
                return $tableauLang;
            });

            $form->text('value',trans('value'))->attribute('id', 'autocomplete')->attribute('disabled', 'disabled');

        });
    }
}
