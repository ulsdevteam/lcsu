<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray $tray
 */
?>
<div class="trays form columns content" id='app'>

    <?= $this->Form->create($tray, ['ref' => 'form']) ?>
    <fieldset>
        <legend><?= __('Validate Tray') ?></legend>
        <?php
            echo $this->Form->control('num_books', ['label'=>'The number of books in this tray', 'autofocus' => 'autofocus', 'v-model' => 'input_amount']);
            echo $this->Form->control('tray_barcode', ['value' => '', 'placeholder' => $tray->tray_barcode, 'v-model' => 'input_tray', 'v-on:keyup.13'=> 'goNext']);
        ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->button(__('Submit'), ['v-on:click' => 'goNext']) ?>
</div>
<script type="text/javascript">
    new Vue({
        el: '#app',
        data: {
            input_amount:"",
            input_tray:"",
            book_amount: 0
        },
        methods: {
            goNext: function(e) {
                var tray = "<?php echo $tray->tray_barcode?>";
                if (this.input_tray && this.input_tray == tray) {
                    this.book_amount  = parseInt(<?php echo $amount;?>);
                    if (this.book_amount == this.input_amount) {
                         this.$refs.form.submit();
                    } else {
                        if (confirm("The number of the books doesn't match the number in database, do you want to restart this tray from scratch?")) {
                            this.$refs.form.submit();
                        }
                    }
                } else {
                    alert("The tray_barcode doesn't match.");
                }
            }
        }
    })
</script>
