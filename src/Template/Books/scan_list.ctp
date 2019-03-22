<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>

<div class="books form columns content" id="app">
    <label for="book_barcode">Book Barcode</label>
    <input type="text" name="book_barcode" ref="input_barcode" id="input_barcode" v-model="input" v-on:keyup.13="checkBook" value="">

    <table id="book-list">
        <thead>
            <tr>
                <th scope="col"><?= h('Book List') ?></th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for= "book in bookList">
                <td>{{book.book_barcode}}</td>
                <td>{{book.status}}</td>
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    new Vue({
        el: '#app',
        data: {
            bookList: [],
            input:"",
            count:0
        },
        methods: {
            fetchBookList: function() {
                axios
                  .get('<?=  $this->Url->build(["controller" => "books",
                                                "action" => "bookList",
                                                "tray_id" => $this->request->getQuery('tray_id')
                                                 ]); ?>')
                  .then((response)=>{
                      for (var i = 0; i < response['data'].length; i++) {
                          this.bookList.push({'book_barcode': response['data'][i]['book_barcode'], 'status': 'Uncheck'});
                      }
                  })
            },
            checkBook() {
                if (!isNaN(this.input) && this.input.length == 14) {
                    var flag = false;
                    for (var i = 0; i < this.bookList.length; i++) {
                        if(this.bookList[i]['book_barcode'] == this.input) {
                            if(this.bookList[i]['status'] == 'Uncheck') {
                                this.count++;
                                if (this.count == this.bookList.length) {
                                    //window.location = "<?= $this->Url->build(array('controller' => 'trays', 'action' => 'scan_end', $this->request->getQuery('tray_id'),'source' => 'validate','count' => $this->request->getQuery('count'))); ?>";
                                    window.location = "<?= $this->Url->build([
                                                            'controller' => 'trays',
                                                            'action' => 'scan_end',
                                                            $this->request->getQuery('tray_id'),
                                                            '?' => [
                                                                'source' => 'validate',
                                                                'count' => $this->request->getQuery('count')
                                                            ]
                                                        ], ['escape' => false])?>";
                                    
                                }
                            }
                            this.bookList[i]['status'] = 'Check';
                            flag = true;
                        }
                    }
                    if (!flag) {
                        alert("The book doesn't belong to this tray");
                    }
                } else {
                    alert("The barcode is invalid.");
                }
                this.input = "";
            }
        },
        beforeMount () {
            this.fetchBookList()
        },
        mounted() {
            this.$refs.input_barcode.focus();
        }
    })
</script>
