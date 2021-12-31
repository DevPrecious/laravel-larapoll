<?php

namespace App\Admin\Controllers;

use App\Models\Vote;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VoteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Vote';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Vote());

        $grid->column('id', __('Id'));
        $grid->column('poll_id', __('Poll id'));
        $grid->column('option_id', __('Option id'));
        $grid->column('user_id', __('User id'));
        $grid->column('staked', __('Staked'));
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
        $show = new Show(Vote::findOrFail($id));

        $show->poll('Poll voted on', function ($poll) {

            $poll->setResource('/votes');
        
            $poll->id();
            $poll->title();
            $poll->stake();
        });

        $show->field('id', __('Id'));
        $show->field('poll_id', __('Poll id'));
        $show->field('option_id', __('Option id'));
        $show->field('user_id', __('User id'));
        $show->field('staked', __('Staked'));
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
        $form = new Form(new Vote());

        $form->number('poll_id', __('Poll id'));
        $form->number('option_id', __('Option id'));
        $form->number('user_id', __('User id'));
        $form->text('staked', __('Staked'));

        return $form;
    }
}
