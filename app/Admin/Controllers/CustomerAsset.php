<?php

namespace App\Admin\Controllers;

use App\Models\Asset;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;

class CustomerAsset extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Asset';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Asset());

        $grid->column('id', __('Id'));
        $grid->column('reg', __('Reg'));
        $grid->column('make', __('Make'));
        $grid->column('model', __('Model'));
        $grid->column('customer.customer_name', __('Customer Name'));
        $grid->column('company.name', __('Owning Company'));
        $grid->column('user.name', __('Created by'));
        $grid->column('created_at', __('Created at'))->date('Y-m-d H:M');

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
        $show = new Show(Asset::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uuid', __('Uuid'));
        $show->field('reg', __('Reg'));
        $show->field('make', __('Make'));
        $show->field('model', __('Model'));
        $show->field('customer.customer_name', __('Customer Name'));
        $show->field('company.name', __('Owning Company'));
        $show->field('user.name', __('Created by'));
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
        $form = new Form(new Asset());

        $form->text('uuid', __('Uuid'))->required();
        $form->text('reg', __('Reg'))->required();
        $form->text('make', __('Make'))->required();
        $form->text('model', __('Model'))->required();
        // $form->number('belongs_to', __('Belongs to'));
        $form->select('belongs_to', 'Company')->options(
            Customer::all()->pluck('customer_name', 'id')
        )->required();

        $form->select('owner_id', 'Company')->options(
            Company::all()->pluck('name', 'id')
        )->required();
        $form->select('status', 'Status')->options(
            ['on_hold' => 'On Hold', 'active' => 'active']
        )->required();

        $form->select('created_by', 'Created by')->options(
            User::all()->pluck('name', 'id')
        )->required();
        return $form;
    }
}
