<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shelf[]|\Cake\Collection\CollectionInterface $shelves
 */
?>
<div class="shelves form content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Choose tray size') ?></legend>
        <?php
            echo $this->Form->control('traysizes', ['value' => $traysize->traysize_id]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('shelf_barcode') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shelves as $shelf):?>
            <tr>
                <td><?= h($shelf->shelf_barcode) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $shelf->shelf_id]) ?>
                    <?= $this->Html->link(__('Allocate trays'), ['action' => 'allocate', $shelf->shelf_id, 'traysize_id' => $traysize->traysize_id]) ?>
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
