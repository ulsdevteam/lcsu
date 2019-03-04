<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>
<div class="books form columns content">
    <?= $this->Form->create($book) ?>
    <fieldset>
        <legend><?= __('Add Book').'- ['.$this->request->getQuery('id').'/'.$this->request->getQuery('count').']' ?></legend>
        <?php
            echo $this->Form->control('book_barcode', ['autofocus'=>'autofocus']);
            // echo $this->Form->control('tray_id', ['options' => $trays]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
