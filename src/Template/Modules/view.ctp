<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Module $module
 */
?>
<div class="modules view content">
    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $module->module_id], ['class'=>'func-btn']) ?>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Module Title') ?></th>
            <td><?= h($module->module_title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Located in Range') ?></th>
            <td><?= h($range->range_title) ?></td>
        </tr>
    </table>

    <div class="child-table">
        <h5 class="page-title">Located shelves</h5>
        <?=$this->Html->link( __('Add Shelf'),
                            array('controller'=>'shelves', 'action' => 'add', 'module_id' => $module->module_id),
                            array(
                                'bootstrap-type' => 'primary',
                                'class' => 'func-btn'
                            )
                        );?>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('shelf_barcode') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shelves as $shelf): ?>
                <tr>
                    <td><?= h($shelf->shelf_barcode) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Shelves', 'action' => 'view', $shelf->shelf_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Shelves', 'action' => 'edit', $shelf->shelf_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Shelves', 'action' => 'delete', $shelf->shelf_id], ['confirm' => __('Are you sure you want to delete # {0}?', $shelf->shelf_id)]) ?>
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
</div>
