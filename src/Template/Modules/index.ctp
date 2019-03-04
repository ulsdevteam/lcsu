<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Module[]|\Cake\Collection\CollectionInterface $modules
 */
?>
<div class="modules index content">
    <h3 class="page-title"><?= __('Modules') ?></h3>
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
                    <?= $this->Html->link(__('View'), ['action' => 'view', $module->module_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $module->module_id]) ?>
                    <!-- <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $module->module_id], ['confirm' => __('Are you sure you want to delete # {0}?', $module->module_id)]) ?> -->
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
