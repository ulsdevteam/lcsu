<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permission[]|\Cake\Collection\CollectionInterface $permissions
 */
?>
<div class="permissions index columns content">
    <h3 class="page-title"><?= __('Permissions') ?></h3>
    <?=$this->Html->link( __('Add Permission'),
                        array('action' => 'add'),
                        array(
                            'bootstrap-type' => 'primary',
                            'class' => 'func-btn'
                        )
                    );?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('permission_title') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('permission_level') ?></th> -->
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permissions as $permission): ?>
            <tr>
                <td><?= h($permission->permission_title) ?></td>
                <!-- <td><?= $this->Number->format($permission->permission_level) ?></td> -->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $permission->permission_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $permission->permission_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $permission->permission_id], ['confirm' => __('Are you sure you want to delete # {0}?', $permission->permission_id)]) ?>
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
