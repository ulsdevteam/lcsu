<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray $tray
 */
?>
<div class="trays form columns content" id="app">
    <?= $this->Form->create($tray, ['ref' => 'form']) ?>
    <fieldset>
        <legend><?= __('To complete a tray') ?></legend>
        <?php
            echo $this->Form->control('num_books', ['label'=>'The amount of books in this tray', 'autofocus' => 'autofocus']);
            echo $this->Form->control('tray_barcode', ['value' => '', 'placeholder' => $tray->tray_barcode, 'v-model' => 'input_tray', 'v-on:keyup.13'=> 'goNext']);
        ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->button(__('Next'), ['v-on:click' => 'goNext']) ?>
</div>
<script type="text/javascript">
new Vue({
    el: '#app',
    data: {
        input_tray:""
    },
    methods: {
        goNext: function(e) {
            var tray = "<?php echo $tray->tray_barcode;?>";
            if (this.input_tray == tray) {
                this.$refs.form.submit();
            } else {
                alert("The tray_barcode doesn't match.");
            }
        }
    }
})
</script>
