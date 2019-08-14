<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Range[]|\Cake\Collection\CollectionInterface $ranges
 */
?>

<div class="ranges index content">
    <h3 class="page-title"><?= __('Ranges') ?></h3>
    <?php 
        $perm = $cur_user['permission_id'];
        if ($perm == 1 ) {
            echo $this->Html->link( __('Add Range'),
                        array('action' => 'add'),
                        array(
                            'bootstrap-type' => 'primary',
                            'class' => 'func-btn'
                        ));}
    ?>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('range_title') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ranges as $range): ?>
            <tr>
                <td><?= h($range->range_title) ?></td>
                <td class="actions">
                    <span>|</span>
                    <?= $this->Html->link(__('View'), ['action' => 'view', $range->range_id]) ?>
                    <span>|</span>
                    <!-- <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $range->range_id], ['confirm' => __('Are you sure you want to delete # {0}?', $range->range_id)]) ?> -->
                </td>
            </tr>
            <?php endforeach;?>
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
