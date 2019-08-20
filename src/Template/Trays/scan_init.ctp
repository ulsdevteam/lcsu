<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray $tray
 */
?>
<div class="trays form columns content">
    <?= $this->Form->create($tray) ?>
    <fieldset>
        <legend><?= __('Add Tray') ?></legend>
        <?php
            echo $this->Form->control('num_books', ['label'=>'The number of books in this tray', 'autofocus' => 'autofocus']);
            echo $this->Form->control('tray_barcode');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Next')) ?>
    <?= $this->Form->end() ?>
</div>
