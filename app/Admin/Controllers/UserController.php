<?php

namespace App\Admin\Controllers;

use App\Models\Company;
use App\Models\Depot;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter\Where;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('depot.name', __('Default depot'));
        $grid->column('company.name', __('Company'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));
        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('depot.name', __('Default Depot'));
        $show->field('company.name', __('Company'));
        $show->divider();
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null)
    {
        $form = new Form(new User());
        // workaround to get selected user ID
        $url_atributes = explode("/", $_SERVER['REQUEST_URI']);
        $id = (array_reverse($url_atributes)[1]);
        $company_id = isset(User::find($id)->owner_id) ? User::find($id)->owner_id : null;

        $form->text('name', __('Name'))->required();
        $form->email('email', __('Email'))->required();
        $form->password('password', __('Password'))->required();
        $form->select('owner_id', 'Company')->options(
            Company::all()->pluck('name', 'id')
        )->required();

        $form->select('default_branch', 'Branch')->options(
            Depot::where('owner_id', $company_id)->pluck('name', 'id')
        )->help('If Depot not visable after selecting new depot please submit and edit again!');

        return $form;
    }
}
