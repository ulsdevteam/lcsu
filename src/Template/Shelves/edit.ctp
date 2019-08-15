<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shelf $shelf
 */
?>
<div class="shelves form content" id="app">
    <?= $this->Form->create($shelf, ['id' => 'edit_shelf']) ?>
    <fieldset>
        <legend><?= __('Edit Shelf') ?></legend>
        <h2><?= $shelf->shelf_barcode ?></h2>
        <?php
            echo $this->Form->hidden('shelf_title');
            echo $this->Form->control('shelf_height', ['id' => 'shelf_height_input', 'v-model' => 'input_height', 'v-on:change' => 'updateTraysizeList']);
            echo $this->Form->hidden('module_id');
            $this->Form->unlockField('traysize_id');
        ?>
        <label for="traysize_id">Tray size</label>
        <select name="traysize_id" form="edit_shelf" v-model="selectTraysizeId">
            <option value=""></option>
            <option v-for="value in cur_traysizes" :value="value.id">{{value.text}}</option>
        </select>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script type="text/javascript">
    new Vue({
        el: '#app',
        data: {
            info: [],
            input_height: 0,
            traysizes: [],
            cur_traysizes: [{0:'type in shelf height first'}],
            selectTraysizeId: 0,
        },
        methods: {
            updateTraysizeList: function(evt) {
                this.cur_traysizes.length = 0;
                if (this.traysizes.length != 0) {
                    for ( i = 0 ; i < this.traysizes.length ; i++) {
                        if (this.traysizes[i].shelf_height == this.input_height) {
                            this.cur_traysizes.push({'id':this.traysizes[i]['traysize_id'], 'text': this.traysizes[i]['traysize_option']});
                        }
                    }
                }
            }
        },
        mounted () {
            axios
              .get("<?=  $this->Url->build(['controller' => 'Traysizes',
                                            'action' => 'listAllTraysizes']); ?>")
              .then((response)=>{
                  this.traysizes = response['data'];
                  this.input_height = "<?php echo $shelf->shelf_height ? $shelf->shelf_height : 0;?>";
                  this.updateTraysizeList();
                  this.selectTraysizeId = <?php echo $shelf->traysize_id ? $shelf->traysize_id : 0; ?>;
              });
        }
    });
</script>