<?php

namespace App\Admin\Controllers;

use App\Models\Depot;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Company;
use Encore\Admin\Controllers\AdminController;

class DepotController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Depot';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Depot());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('company.name', __('Company'));
        $grid->column('email', __('Email'));

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
        $show = new Show(Depot::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('company.name', __('Company name'));
        $show->field('email', __('Email'));
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
    protected function form()
    {
        $form = new Form(new Depot());

        $form->text('name', __('Depot Name'))->required();
        $form->select('owner_id', 'Owning Company')->options(
            Company::all()->pluck('name', 'id')
        )->required();
        $form->email('email', __('Email'))->required();


        return $form;
    }
}
