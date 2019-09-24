<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>
<div class="books form columns content" id="app">
    <?= $this->Form->create($book) ?>
    <fieldset>
        <legend><?= __('Add Book').'- ['.$progress.'/'.$this->request->getQuery('count').']' ?></legend>
        <?php
            echo $this->Form->control('book_barcode', ['autofocus'=>'autofocus', 'ref' => 'book_barcode', 'value' => '']);
            echo $this->Form->hidden('tray_id', ['value' => $tray_id]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>