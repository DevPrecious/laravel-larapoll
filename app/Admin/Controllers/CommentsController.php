<?php

namespace App\Admin\Controllers;

use App\Models\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommentsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Comment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->column('id', __('Id'));
        $grid->column('comment', __('Comment'));
        $grid->column('poll_id', __('Poll id'));
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
        $show = new Show(Comment::findOrFail($id));

        $show->poll('Poll', function ($poll) {

            $poll->setResource('/comments');
        
            $poll->id();
            $poll->title();
            $poll->stake();
        });

        $show->user('User Profile', function ($user) {

            $user->setResource('/user-banks');
        
            $user->id();
            $user->name();
            $user->username();
            $user->email();
        });

        $show->field('id', __('Id'));
        $show->field('comment', __('Comment'));
        $show->field('poll_id', __('Poll id'));
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
        $form = new Form(new Comment());

        $form->text('comment', __('Comment'));
        $form->number('poll_id', __('Poll id'));
        $form->number('user_id', __('User id'));

        return $form;
    }
}
