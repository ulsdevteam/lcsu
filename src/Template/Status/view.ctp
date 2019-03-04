<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Status $status
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Status'), ['action' => 'edit', $status->status_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Status'), ['action' => 'delete', $status->status_id], ['confirm' => __('Are you sure you want to delete # {0}?', $status->status_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Status'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Status'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="status view large-9 medium-8 columns content">
    <h3><?= h($status->status_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Status Des') ?></th>
            <td><?= h($status->status_des) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status Id') ?></th>
            <td><?= $this->Number->format($status->status_id) ?></td>
        </tr>
    </table>
</div>
