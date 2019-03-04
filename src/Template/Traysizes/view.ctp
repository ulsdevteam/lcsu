<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Traysize $traysize
 */
?>
<div class="traysizes view content">
    <h3 class="page-title"><?= h($traysize->traysize_id) ?></h3>
    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $traysize->traysize_id], ['class' => 'func-btn']) ?>
    <p class='func-btn'> | </p
    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $traysize->traysize_id], ['confirm' => __('Are you sure you want to delete # {0}?', $traysize->traysize_id), 'class' => 'func-btn']) ?>

    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Tray Category') ?></th>
            <td><?= h($traysize->tray_category) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Traysize Id') ?></th>
            <td><?= $this->Number->format($traysize->traysize_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shelf Height') ?></th>
            <td><?= $this->Number->format($traysize->shelf_height) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number of the Tray') ?></th>
            <td><?= $this->Number->format($traysize->num_trays) ?></td>
        </tr>
    </table>
</div>
