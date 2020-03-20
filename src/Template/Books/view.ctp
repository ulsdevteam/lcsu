<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>
<div class="books view content">
    <!-- <h3 class="page-title"><?= h($book->book_id) ?></h3> -->
    <!-- <?= $this->Html->link(__('Edit'), ['action' => 'edit', $book->book_id], ['class' => 'func-btn']) ?> -->
    <!-- <p class="func-btn">|</p> -->
    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $book->book_id], ['confirm' => __('Are you sure you want to remove this book # {0}?', $book->book_barcode), 'class' => 'func-btn']) ?>
    <table class="vertical-table">
        <!-- <tr>
            <th scope="row"><?= __('Book Id') ?></th>
            <td><?= $this->Number->format($book->book_id) ?></td>
        </tr> -->
        <tr>
            <th scope="row"><?= __('Book Barcode') ?></th>
            <td><?= h($book->book_barcode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tray') ?></th>
            <td><?= $book->has('tray') ? $this->Html->link($book->tray->tray_barcode, ['controller' => 'Trays', 'action' => 'view', $book->tray->tray_id]) : '' ?></td>
        </tr>
    </table>
</div>
