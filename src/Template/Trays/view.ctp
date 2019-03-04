<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray $tray
 */
?>
<div class="trays view content">
    <?=$this->Html->link( __('Edit'),
                        ['action' => 'edit', $tray->tray_id],
                        ['class' => 'func-btn']
                    );?>
    <p class='func-btn'> | </p>
    <?= $this->Form->postLink(__('Delete'),
                        ['action' => 'delete', $tray->tray_id],
                        ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $tray->tray_id), 'class' => 'func-btn']
                    ); ?>

    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Tray Barcode') ?></th>
            <td><?= h($tray->tray_barcode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified User') ?></th>
            <td><?= h($tray->modified_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($tray->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($tray->modified) ?></td>
        </tr>
    </table>

    <div class="child-table">
        <h3 class="page-title"><?= __('Books') ?></h3>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('book_barcode') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= h($book->book_barcode) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Books', 'action' => 'view', $book->book_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Books', 'action' => 'edit', $book->book_id]) ?>
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
