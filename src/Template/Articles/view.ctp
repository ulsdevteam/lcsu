<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Article'), ['action' => 'edit', $article->article_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Article'), ['action' => 'delete', $article->article_id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->article_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Articles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="articles view large-9 medium-8 columns content">
    <h3><?= h($article->article_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Article Name') ?></th>
            <td><?= h($article->article_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Article Category') ?></th>
            <td><?= h($article->article_category) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Article Content') ?></th>
            <td><?= h($article->article_content) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Article Author') ?></th>
            <td><?= h($article->article_author) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Article Id') ?></th>
            <td><?= $this->Number->format($article->article_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Timestamp') ?></th>
            <td><?= h($article->timestamp) ?></td>
        </tr>
    </table>
</div>
