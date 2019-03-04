<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Range $range
 */
?>
<div class="ranges view content">
    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $range->range_id], ['class'=>'func-btn']) ?>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Range Title') ?></th>
            <td><?= h($range->range_title) ?></td>
        </tr>
    </table>

    <div class="child-table">
        <h5 class="page-title">Located modules</h5>
        <?=$this->Html->link( __('Add Module'),
                            array('controller'=>'modules', 'action' => 'add', 'range_id' => $range->range_id),
                            array(
                                'bootstrap-type' => 'primary',
                                'class' => 'func-btn'
                            )
                        );?>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('module_title') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modules as $module): ?>
                <tr>
                    <td><?= h($module->module_title) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller'=>'modules', 'action' => 'view', $module->module_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller'=>'modules', 'action' => 'edit', $module->module_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller'=>'modules', 'action' => 'delete', $module->module_id], ['confirm' => __('Are you sure you want to delete # {0}?', $module->module_id)]) ?>
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
