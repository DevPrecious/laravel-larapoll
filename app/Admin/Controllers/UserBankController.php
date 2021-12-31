<?php

namespace App\Admin\Controllers;

use App\Models\UserBank;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserBankController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UserBank';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserBank());

        $grid->column('id', __('Id'));
        $grid->column('acc_number', __('Acc number'));
        $grid->column('acc_name', __('Acc name'));
        $grid->column('bank_code', __('Bank code'));
        $grid->column('user_id', __('User id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(UserBank::findOrFail($id));

        $show->user('User Profile', function ($user) {

            $user->setResource('/user-banks');
        
            $user->id();
            $user->name();
            $user->username();
            $user->email();
        });

        $show->field('id', __('Id'));
        $show->field('acc_number', __('Acc number'));
        $show->field('acc_name', __('Acc name'));
        $show->field('bank_code', __('Bank code'));
        $show->field('user_id', __('User id'));
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
        $form = new Form(new UserBank());

        $form->text('acc_number', __('Acc number'));
        $form->text('acc_name', __('Acc name'));
        $form->text('bank_code', __('Bank code'));
        $form->number('user_id', __('User id'));

        return $form;
    }
}
