<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shelf[]|\Cake\Collection\CollectionInterface $shelves
 */
?>
<div class="shelves index content">
    <h3 class="page-title"><?= __('Shelves') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('shelf_barcode') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shelf_height') ?></th>
                <th scope="col"><?= $this->Paginator->sort('traysize_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shelves as $shelf):?>
            <tr>
                <td><?= h($shelf->shelf_barcode) ?></td>
                <td><?= $this->Number->format($shelf->shelf_height) ?></td>
                <td><?= h($shelf->tray_category) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $shelf->shelf_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shelf->shelf_id]) ?>
                    <!-- <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shelf->shelf_id], ['confirm' => __('Are you sure you want to delete # {0}?', $shelf->shelf_id)]) ?> -->
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
