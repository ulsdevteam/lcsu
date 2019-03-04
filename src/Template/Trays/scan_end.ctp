<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray $tray
 */
?>
<div class="trays form columns content">
    <?= $this->Form->create($tray) ?>
    <fieldset>
        <legend><?= __('Wrap up this tray') ?></legend>
        <?php
            echo 'Please scanning the tray barcode again to complete this process.';
            echo $this->Form->control('tray_barcode',  ['autofocus' => 'autofocus', 'value' => '']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
