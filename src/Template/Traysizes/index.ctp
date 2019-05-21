<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Traysize[]|\Cake\Collection\CollectionInterface $traysizes
 */
?>
<div class="traysizes index content">
    <h3 class="page-title"><?= __('Traysizes') ?></h3>
    <?=$this->Html->link( __('Add Traysize'),
                        array('action' => 'add'),
                        array(
                            'bootstrap-type' => 'primary',
                            'class' => 'func-btn'
                        )
                    );?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('tray_category') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shelf_height') ?></th>
                <th scope="col"><?= $this->Paginator->sort('num_trays', "Number of Trays") ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($traysizes as $traysize): ?>
            <tr>
                <td><?= h($traysize->tray_category) ?></td>
                <td><?= $this->Number->format($traysize->shelf_height) ?></td>
                <td><?= $this->Number->format($traysize->num_trays) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $traysize->traysize_id]) ?>
                    <!--<?= $this->Html->link(__('Edit'), ['action' => 'edit', $traysize->traysize_id]) ?>--!>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $traysize->traysize_id], ['confirm' => __('Are you sure you want to delete # {0}?', $traysize->traysize_id)]) ?>
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
