<?php

namespace App\Admin\Controllers;

use App\Models\Poll;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PollController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Poll';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Poll());
        

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('stake', __('Stake'));
        $grid->column('end_at', __('End at'));
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
        $show = new Show(Poll::findOrFail($id));
        $show->user('User', function ($author) {

            $author->setResource('/users');
        
            $author->id();
            $author->name();
            $author->email();
        });

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('stake', __('Stake'));
        $show->field('end_at', __('End at'));
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
        $form = new Form(new Poll());

        $form->text('title', __('Title'));
        $form->number('stake', __('Stake'));
        $form->date('end_at', __('End at'))->default(date('Y-m-d'));
        $form->number('user_id', __('User id'));

        return $form;
    }
}
