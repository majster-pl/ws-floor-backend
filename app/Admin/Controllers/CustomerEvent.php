<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Event;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Customer;
use App\Models\Depot;
use Encore\Admin\Controllers\AdminController;

class CustomerEvent extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Event';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Event());

        $grid->column('id', __('Id'));
        $grid->column('asset.reg', __('Reg'));
        $grid->column('customer.customer_name', __('Customer'));
        $grid->column('booked_date_time', __('Booked date time'));
        $grid->column('description', __('Description'));
        $grid->column('arrived_date', __('Arrived date'));
        $grid->column('breakdown', __('Breakdown'));
        $grid->column('user.name', __('Created by'));
        $grid->column('company.name', __('Owning Company'));
        $grid->column('depot.name', __('Owning branch'));
        $grid->column('status', __('Status'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Event::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uuid', __('Uuid'));
        $show->field('asset.reg', __('Reg'));
        $show->field('customer.customer_name', __('Customer id'));
        $show->field('order', __('Order'));
        $show->field('odometer_in', __('Odometer in'));
        $show->field('odometer_out', __('Odometer out'));
        $show->field('waiting', __('Waiting'));
        $show->field('others', __('Others'));
        $show->field('description', __('Description'));
        $show->field('special_instructions', __('Special instructions'));
        $show->field('free_text', __('Free text'));
        $show->field('arrived_date', __('Arrived date'));
        $show->field('collected_at', __('Collected at'));
        $show->field('booked_date_time', __('Booked date time'));
        $show->field('breakdown', __('Breakdown'));
        $show->field('allowed_time', __('Allowed time'));
        $show->field('key_location', __('Key location'));
        $show->field('spent_time', __('Spent time'));
        $show->field('user.name', __('Created by'));
        $show->field('company.name', __('Owning Company'));
        $show->field('depot.name', __('Owning branch'));
        $show->field('status', __('Status'));
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

        // print(User::where('id', $id)->get());
        // print($id);

        $form = new Form(new Event());

        $form->text('uuid', __('Uuid'));
        // $form->number('asset_id', __('Asset id'));
        $form->select('asset_id', 'Reg')->options(
            Asset::all()->pluck('reg', 'id')
        )->required();
        // $form->number('customer_id', __('Customer id'));
        $form->select('customer_id', 'Customer')->options(
            Customer::all()->pluck('customer_name', 'id')
        )->required();
        $form->decimal('order', __('Order'));
        $form->decimal('odometer_in', __('Odometer in'));
        $form->decimal('odometer_out', __('Odometer out'));
        $form->switch('waiting', __('Waiting'));
        $form->textarea('others', __('Others'));
        $form->textarea('description', __('Description'));
        $form->textarea('special_instructions', __('Special instructions'));
        $form->textarea('free_text', __('Free text'));
        $form->datetime('arrived_date', __('Arrived date'))->default(date('Y-m-d H:i:s'));
        $form->datetime('collected_at', __('Collected at'))->default(date('Y-m-d H:i:s'));
        $form->datetime('booked_date_time', __('Booked date time'))->default(date('Y-m-d H:i:s'));
        $form->switch('breakdown', __('Breakdown'));
        $form->decimal('allowed_time', __('Allowed time'));
        $form->decimal('key_location', __('Key location'));
        $form->decimal('spent_time', __('Spent time'));

        $form->select('created_by', 'Created by')->options(
            User::all()->pluck('name', 'id')
        )->required();
        $form->select('owner_id', 'Owning Company')->options(
            Company::all()->pluck('name', 'id')
        )->required();
        // $form->number('owning_branch', __('Owning branch'));
        // workaround to get selected user ID
        $url_atributes = explode("/", $_SERVER['REQUEST_URI']);
        $id = (array_reverse($url_atributes)[1]);
        $company_id = isset(User::find($id)->owner_id) ? User::find($id)->owner_id : null;

        if (isset($company_id)) {
            $form->select('owning_branch', 'Branch')->options(
                Depot::where('owner_id', $company_id)->pluck('name', 'id')
            )->help('If Depot not visable after selecting new depot please submit and edit again!');
        } else {
            $form->select('owning_branch', 'Branch')->options(
                Depot::all()->pluck('name', 'id')
            )->help('If Depot not visable after selecting new depot please submit and edit again!');

        }

        $form->text('status', __('Status'));

        return $form;
    }
}
