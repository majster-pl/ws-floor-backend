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
        $grid->column('owner_id', __('Owner id'))->default("TEST");
        $grid->column('default_branch', __('Default branch id'));

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
        $show->field('owner_id', __('Company id'));
        $show->field('default_branch', __('Default branch ID'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        // print($id);
        $form = new Form(new User());
        $form->text('name', __('Name'))->required();
        $form->email('email', __('Email'))->required();
        $form->password('password', __('Password'));
        $form->select('owner_id', 'Company')->options(
            Company::all()->pluck('name', 'id')
        )->required();

        $form->select('default_branch', 'Branch')->options(
            Depot::all()->pluck('name', 'id')
        )->required()->help('Please make sure you sellect depot which belongs to Company!');

        return $form;
    }
}
