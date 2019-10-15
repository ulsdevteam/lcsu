<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray $tray
 */
?>
<div class="trays form columns content"  id="app">
    <script type="text/javascript">
        function rewriteAction() {
            document.getElementById('scanForm').action += '/' + document.getElementById('tray-barcode').value;
            return true;
        }
    </script>
    <?= $this->Form->create(null, ['url' => ['controller' => 'Trays', 'action' => 'shelflist'], 'type' => 'get', 'id' => 'scanForm', 'onsubmit' => 'rewriteAction()']) ?>
    <fieldset>
        <legend><?= __('Scan Tray') ?></legend>
        <?php
            echo $this->Form->control('tray_barcode');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Check Inventory'), ['onclick' => 'document.getElementById(\'scanForm\').submit();']) ?>
    <?= $this->Form->end() ?>
</div>

