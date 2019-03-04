<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Article'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="articles index large-9 medium-8 columns content">
    <h3><?= __('Articles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('article_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('article_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('article_category') ?></th>
                <th scope="col"><?= $this->Paginator->sort('article_content') ?></th>
                <th scope="col"><?= $this->Paginator->sort('article_author') ?></th>
                <th scope="col"><?= $this->Paginator->sort('timestamp') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= $this->Number->format($article->article_id) ?></td>
                <td><?= h($article->article_name) ?></td>
                <td><?= h($article->article_category) ?></td>
                <td><?= h($article->article_content) ?></td>
                <td><?= h($article->article_author) ?></td>
                <td><?= h($article->timestamp) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $article->article_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $article->article_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $article->article_id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->article_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
