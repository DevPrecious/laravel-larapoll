<?php

namespace App\Admin\Controllers;

use App\Models\Option;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OptionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Option';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Option());

        $grid->column('id', __('Id'));
        $grid->column('poll_id', __('Poll id'));
        $grid->column('option', __('Option'));
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
        $show = new Show(Option::findOrFail($id));

        $show->poll('Poll', function ($poll) {

            $poll->setResource('/options');
        
            $poll->id();
            $poll->title();
            $poll->stake();
        });

        $show->field('id', __('Id'));
        $show->field('poll_id', __('Poll id'));
        $show->field('option', __('Option'));
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
        $form = new Form(new Option());

        $form->number('poll_id', __('Poll id'));
        $form->text('option', __('Option'));

        return $form;
    }
}
