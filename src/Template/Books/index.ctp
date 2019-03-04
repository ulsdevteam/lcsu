<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book[]|\Cake\Collection\CollectionInterface $books
 */
?>
<div class="books index content">
    <h3 class="page-title"><?= __('Books') ?></h3>
    <!-- <?=$this->Html->link( __('Add Book'),
                        array('action' => 'add'),
                        array(
                            'bootstrap-type' => 'primary',
                            'class' => 'func-btn'
                        )
                    );?> -->
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('book_barcode') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tray_barcode') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <!-- <td><?= h($book->book_title) ?></td> -->
                <td><?= h($book->book_barcode) ?></td>
                <td><?= $book->has('tray') ? $this->Html->link($book->tray->tray_barcode, ['controller' => 'Trays', 'action' => 'view', $book->tray->tray_id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $book->book_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $book->book_id]) ?>
                    <!-- <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $book->book_id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->book_id)]) ?> -->
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
