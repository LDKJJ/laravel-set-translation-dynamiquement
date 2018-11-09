<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Encore\Admin\Form::forget(['map', 'editor']);
Encore\Admin\Admin::css('/vendor/laravel-admin/autocomplete/select2.css');
Encore\Admin\Admin::js('/vendor/laravel-admin/autocomplete/select2.js');
Encore\Admin\Admin::js('/vendor/laravel-admin/autocomplete/autocomplete.js');
Encore\Admin\Admin::js('/vendor/laravel-admin/autocomplete/jquery-validate.min.js');
