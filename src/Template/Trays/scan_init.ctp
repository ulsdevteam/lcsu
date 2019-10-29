<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray $tray
 */
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<div class="trays form columns content"  id="app">
    <?= $this->Form->create($tray, ['ref' => 'form']) ?>
    <fieldset>
        <legend><?= __('Add Tray') ?></legend>
        <?php
            echo $this->Form->control('num_books', ['label'=>'The number of books in this tray', 'autofocus' => 'autofocus', 'ref' => 'numBooks']);
            echo $this->Form->control('tray_barcode');
            echo $this->Form->control('is_restart', ['type' => 'hidden', 'ref' => 'isRestart']);
            $this->Form->unlockField('is_restart');
        ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->button(__('Next'), ['v-on:click' => 'goNext']) ?>

    <!-- Modal -->
    <div class="modal fade" id="selectActionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Select the next step</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <ul>
                  <li>Restart: scan all of the books from the tray.</li>
                  <li>Continue: resume the scanning progress from last time.</li>
              </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" v-on:click="choose_action(1)" data-dismiss="modal">Restart</button>
            <button type="button" class="btn" v-on:click="choose_action(0)" data-dismiss="modal">Continue</button>
          </div>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
    new Vue({
        el: '#app',
        data: {
            tray_id: null,
            showModal: false,
            progress: 0,
        },
        methods: {
            choose_action: function(isRestart) {
                if (!isRestart && this.$refs.numBooks.value < this.progress) {
                    alert("The number of books in this tray is less than the amount in the database. Please choose 'Restart' instead.");
                } else {
                    this.$refs.isRestart.value = isRestart;
                    this.$refs.form.submit();
                }
            },
            goNext: function() {
                if (this.tray_id) {
                    $('#selectActionModal').modal();
                } else {
                    this.$refs.form.submit();
                }
            }
        },
        mounted() {
            var currentUrl = window.location.pathname;
            var id = currentUrl.split('/').slice(-1)[0];
            this.tray_id = ( isNaN(id) || id.length == 0) ?  null : id;
            this.progress = "<?php echo $progress?>";
            console.log("rewre");
//            window.addEventListener('keyup', function(event) {
//                if (event.keyCode === 13) { 
//                  this.goNext();
//                }
//            });
        }
    })
</script>