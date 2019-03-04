<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Traysize $traysize
 */
?>
<!-- <nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $traysize->traysize_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $traysize->traysize_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Traysizes'), ['action' => 'index']) ?></li>
    </ul>
</nav> -->
<div class="traysizes form content">
    <?= $this->Form->create($traysize) ?>
    <fieldset>
        <legend><?= __('Edit Traysize') ?></legend>
        <?php
            echo $this->Form->control('tray_category');
            echo $this->Form->control('shelf_height');
            echo $this->Form->control('num_trays');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
