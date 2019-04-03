<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shelf $shelf
 */
use Cake\Core\Configure;
?>
<div class="shelves view content">

    <?php 
        $perm = $cur_user['permission_id'];
        echo $this->Html->link(__('Print'), ['action' => 'printLabel', $shelf->shelf_id], ['class'=>'func-btn tooltips', 'title' => 'Print this shelf barcode']); 
        if ($perm == 1 )echo $this->Html->link(__('Edit'), ['action' => 'edit', $shelf->shelf_id], ['class'=>'func-btn']); 
    ?>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Shelf Barcode') ?></th>
            <td><?= h($shelf->shelf_barcode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shelf Height') ?></th>
            <td><?= $this->Number->format($shelf->shelf_height) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Traysize') ?></th>
            <td><?php if (isset($traysize)) echo h($traysize->tray_category) ?></td>
        </tr>
    </table>

    <?= $this->Html->link(__('Print'), ['action' => 'printLabels', $shelf->shelf_id], ['class'=>'func-btn tooltips', 'title' => 'Print all tray labels in this shelf']); ?>
    <div class="index-table">
        <h5 class="page-title">Located trays</h5>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('tray_barcode') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('modified_user') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trays as $tray): ?>
                <tr>
                    <td><?= h($tray->tray_barcode) ?></td>
                    <td><span class="status"><?= h($tray->status->status_des) ?><span></td>
                    <td><?= h($tray->created) ?></td>
                    <td><?= h($tray->modified) ?></td>
                    <td><?= h($tray->modified_user) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Trays', 'action' => 'view', $tray->tray_id]) ?>
                        <?php if ($tray->status_id >= Configure::read('Completed')) echo $this->Html->link(__('Export'), ['controller' => 'Trays','action' => 'export', $tray->tray_id] , ['target' => '_blank','v-on:click' => 'download('.$tray->tray_id.')']) ?>
                        <?php //if ($perm == 1) echo $this->Form->postLink(__('Delete'), ['controller' => 'Trays','action' => 'delete', $tray->tray_id], ['confirm' => __('Are you sure you want to delete # {0}?', $tray->tray_id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
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