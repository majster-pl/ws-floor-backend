<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Company;
use App\Models\Customer;
use Encore\Admin\Controllers\AdminController;

class CustomerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Customer';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Customer());
        $grid->filter(function ($filter) {

            // Remove the default id filter
            $filter->disableIdFilter();

            // Add a column filter
            $filter->contains('customer_name', __('Customer'));
            $filter->contains('email', __('Email'));
            $filter->contains('company.name', __('Owning Company'));
        });

        $grid->column('id', __('Id'));
        $grid->column('customer_name', __('Customer name'));
        $grid->column('email', __('Email'));
        $grid->column('user.name', __('Created by'));
        $grid->column('customer_contact', __('Customer contact'));
        $grid->column('created_at', __('Created at'));
        $grid->column('company.name', __('Owning Company'));

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
        $show = new Show(Customer::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('customer_name', __('Customer name'));
        $show->field('email', __('Email'));
        $show->field('uuid', __('Uuid'));
        $show->field('user.name', __('Created by'));
        $show->field('customer_contact', __('Customer contact'));
        $show->field('status', __('Status'));
        $show->field('company.name', __('Owning Company'));
        $show->divider();
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Customer());

        $form->text('customer_name', __('Customer name'))->required();
        $form->email('email', __('Email'))->required();
        $form->text('uuid', __('Uuid'))->required();
        // $form->number('created_by', __('Created by'));
        $form->text('customer_contact', __('Customer contact'))->required();
        $form->select('status', 'Status')->options(
            ['on_hold' => 'On Hold', 'active' => 'active']
        )->required();
        $form->select('owner_id', 'Owning Company')->options(
            Company::all()->pluck('name', 'id')
        )->required();
        $form->select('created_by', 'Created by')->options(
            User::all()->pluck('name', 'id')
        )->required();

        $form->divider();
        $form->datetime('created_at', __('Created at'));
        $form->datetime('updated_at', __('Updated at'));

        $form->datetime('deleted_at', __('Deleted at'));

        return $form;
    }
}
