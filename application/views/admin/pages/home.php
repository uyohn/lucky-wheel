<div class="container" id="kolesa">

    <br>

    <div class="row">
        <div class="col-md-12">
            <button @click="openNewWheel()" type="button" class="btn btn-primary"
                    style="float: right">Vytvoriť koleso
            </button>
        </div>
    </div>

    <br>

    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Číslo kolesa</th>
            <th scope="col">Názov</th>
            <th scope="col">Vytvorené</th>
            <th scope="col">Akcie</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="wheel in wheels">
            <td>{{wheel.wheel_number}}</td>
            <td>{{wheel.wheel_name}}</td>
            <td>{{wheel.created}}</td>
            <td>
                <a href="#" @click="showWheelCode(wheel.wheel_number)">Kód</a>&nbsp;|&nbsp;
                <a href="#" @click="editWheel(wheel.id)">Upraviť</a>&nbsp;|&nbsp;
                <a :href="'<?php echo base_url('admin/wheel/'); ?>'+wheel.wheel_number">Zobraziť</a>&nbsp;|&nbsp;
                <a @click="deleteWheel(wheel.id)" class="text-danger">Zmazať</a>
            </td>
        </tr>
        </tbody>
    </table>


    <div class="modal" id="nove-koleso">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!--                <form ref="form" @submit.prevent="newWheel()">-->
                <div class="modal-header">
                    <h5 class="modal-title">Vytvoriť koleso šťastia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form ref="formss" @submit.prevent="addNewOption()">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="wheel_name"><b>Názov</b></label>
                                    <input v-model="wheel_name" required type="text" class="form-control"
                                           id="new_wheel_name">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="win_mail">Výherny mail</label>
                                    <textarea id="win_mail" rows="4" type="text" v-model="win_mail"
                                              class="form-control"></textarea>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <span><b>Možnosti</b></span>
                            </div>
                            <div class="col-md-12">


                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="new_wheel_name">Názov</label>
                                            <input type="text" v-model="option_name" @keydown.enter.prevent=""
                                                   class="form-control" required
                                                   id="new_wheel_option">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="new_wheel_name">Šanca</label>
                                            <input type="number" v-model="option_chance"
                                                   @keydown.enter.prevent="" min="0" max="100"
                                                   required
                                                   class="form-control"
                                                   id="new_wheel_option">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_wheel_name">Farba textu</label>
                                            <input type="text" v-model="option_text_color"
                                                   @keydown.enter.prevent="" required
                                                   class="form-control"
                                                   id="new_wheel_option">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_wheel_name">Farba pozadia</label>
                                            <input type="text" v-model="option_bg_color"
                                                   @keydown.enter.prevent="" required
                                                   class="form-control"
                                                   id="new_wheel_option">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-block btn-primary">Pridať
                                </button>


                                <hr>

                                <ul>
                                    <li v-for="(option,index) in new_wheel_options">{{option.option_name}} -
                                        {{option.option_chance}} - {{option.option_text_color}} -
                                        {{option.option_bg_color}} - <a class="text-danger"
                                                                        @click="removeOption(index)">Zmazať</a>
                                    </li>
                                </ul>
                            </div>


                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button @click.prevent="newWheel()" type="buttom" class="btn btn-primary">Vytvoriť</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušiť</button>
                </div>
                <!--                </form>-->
            </div>
        </div>
    </div>

    <div class="modal" id="edit-koleso">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!--                <form ref="editform" @submit.prevent="saveEditWheel(editing_wheel_number)">-->
                <div class="modal-header">
                    <h5 class="modal-title">Upraviť koleso šťastia: {{editing_wheel_number}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="new_wheel_name">Názov</label>
                                <input v-model="wheel_name" required type="text" class="form-control"
                                       id="new_wheel_name">
                            </div>
                        </div>

                        <!--                        <div class="row">-->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="win_mail">Výherny mail</label>
                                <textarea id="win_mail" rows="4" type="text" v-model="win_mail"
                                          class="form-control"></textarea>
                            </div>
                        </div>
                        <!--                        </div>-->


                        <div class="col-md-12">
                            <span><b>Možnosti</b></span>
                        </div>

                        <div class="col-md-12">
                            <form @submit.prevent="addNewEditOption()">


                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="new_wheel_name">Názov</label>
                                            <input type="text" v-model="option_name" @keydown.enter.prevent=""
                                                   class="form-control" required
                                                   id="new_wheel_option">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="wheel_name">Šanca</label>
                                            <input type="number" v-model="option_chance"
                                                   min="0" max="100"
                                                   @keydown.enter.prevent=""
                                                   required
                                                   class="form-control"
                                                   id="new_wheel_option">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_wheel_name">Farba textu</label>
                                            <input type="text" v-model="option_text_color"
                                                   @keydown.enter.prevent="" required
                                                   class="form-control"
                                                   id="new_wheel_option">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_wheel_name">Farba pozadia</label>
                                            <input type="text" v-model="option_bg_color"
                                                   @keydown.enter.prevent="" required
                                                   class="form-control"
                                                   id="new_wheel_option">
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-block btn-primary">Pridať
                                </button>


                                <hr>

                            </form>
                        </div>

                        <div class="col-md-12">
                            <p><b>Aktualne možnosti</b></p>
                        </div>

                        <div v-for="(option,index) in new_wheel_options" class="col-md-12">

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="new_wheel_name">Názov</label>
                                        <input type="text" v-model="option.option_name" @keydown.enter.prevent=""
                                               class="form-control" required
                                               id="new_wheel_option">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_wheel_name">Šanca</label>
                                        <input type="number" v-model="option.option_chance"
                                               @keydown.enter.prevent=""
                                               min="0" max="100"
                                               required
                                               class="form-control"
                                               id="new_wheel_option">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_wheel_name">Farba textu</label>
                                        <input type="text" v-model="option.option_text_color"
                                               @keydown.enter.prevent="" required
                                               class="form-control"
                                               id="new_wheel_option">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_wheel_name">Farba pozadia</label>
                                        <input type="text" v-model="option.option_bg_color"
                                               @keydown.enter.prevent="" required
                                               class="form-control"
                                               id="new_wheel_option">
                                    </div>
                                </div>
                            </div>

                            <button @click.prevent="saveEditWheel(editing_wheel_number)" class="btn btn-danger">Zmazať
                            </button>


                            <hr>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="saveEditWheel(editing_wheel_number)" type="buttom" class="btn btn-primary">Upraviť
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušiť</button>
                </div>
                <!--                </form>-->
            </div>
        </div>
    </div>

    <div class="modal" id="wheel-code">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kód pre koleso: {{editing_wheel_number}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <b>Vlož na miesto kde sa ma zobraziť koleso</b>
                            <p>
                                &lt;div id="happy-wheel" wheel-number="{{editing_wheel_number}}">&lt;/div>
                            </p>
                            <b>Vlož do petičky stránky</b>
                            <p>
                                &lt;script src="<?php echo base_url(); ?>public/wheel.js">&lt;/script>&nbsp;
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušiť</button>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    new Vue({
        el: '#kolesa',
        data: {
            wheels: <?php echo json_encode($wheels);?>,

            new_wheel_options: [],

            option_name: '',
            option_chance: '',
            option_text_color: '',
            option_bg_color: '',

            wheel_name: '',
            win_mail: '',

            editing_wheel_number: '',
        },
        methods: {

            submitsubsdd() {
                console.log(this.$refs)
            },

            addNewOption() {
                this.new_wheel_options.push(this.getNewOption())
                this.resetOption()
            },
            resetOption() {
                this.option_name = ''
                this.option_chance = ''
                this.option_text_color = ''
                this.option_bg_color = ''
            },
            getNewOption() {
                return {
                    option_name: this.option_name,
                    option_chance: this.option_chance,
                    option_text_color: this.option_text_color,
                    option_bg_color: this.option_bg_color,
                }
            },
            addNewEditOption() {
                this.new_wheel_options.push(this.getNewOption())

                this.resetOption()
                // this.new_option = ''
            },
            removeOption(i) {
                if (confirm('Naozaj chceš zmaza%t možnosť ?')) {
                    this.new_wheel_options.splice(i, 1);
                }
            },
            openNewWheel() {
                this.new_wheel_options = []
                this.resetOption()
                // this.new_option = ''
                // this.wheel_name = ''
                $('#nove-koleso').modal('toggle')
            },
            newWheel() {
                axios.post('<?php echo base_url();?>admin/new/wheel', Qs.stringify({
                    new_wheel_options: this.new_wheel_options,
                    wheel_name: this.wheel_name,
                    win_mail: this.win_mail,
                })).then((resp) => {
                    // console.log(resp)
                    // return;
                    window.location.reload()
                }).catch(function (error, a, b) {
                    console.log(error)
                    console.log(a)
                    console.log(b)
                    alert('chyba')
                });
            },
            deleteWheel(id) {
                if (confirm('Naozaj chceš zamzať koleso ?')) {
                    window.location.href = '<?php echo base_url('admin/wheel/');?>' + id + '/delete'
                }
            },
            async loadWheelOptiosByWheelNumber(number) {
                let woptions = []
                await axios.get('<?php echo base_url();?>api/wheel/' + number + '/options').then((response) => {
                    woptions = response.data
                }).catch((error) => {
                    console.log(error)
                    alert('chyba')
                });
                return woptions
            },
            async editWheel(id) {
                for (let w of this.wheels) {
                    if (w.id === id) {
                        this.new_wheel_options = await this.loadWheelOptiosByWheelNumber(w.wheel_number)
                        this.wheel_name = w.wheel_name
                        this.win_mail = w.win_mail
                        this.editing_wheel_number = w.wheel_number
                        $('#edit-koleso').modal('toggle')
                        return
                    }
                }
            },
            saveEditWheel(wheel_number) {
                axios.post('<?php echo base_url();?>admin/edit/wheel/' + wheel_number, Qs.stringify({
                    new_wheel_options: this.new_wheel_options,
                    wheel_name: this.wheel_name,
                    win_mail: this.win_mail,
                })).then((res) => {
                    console.log(res)
                    window.location.reload()
                }).catch(function (error, e, r) {
                    console.log(error)
                    console.log(e)
                    console.log(r)
                    alert('chyba pri aktualizovani')
                });
            },
            showWheelCode(wheelNumber) {
                this.editing_wheel_number = wheelNumber
                $('#wheel-code').modal('toggle')
            }
        }
    })
</script>