<template>
    <div class="back_all py-3" v-bind:class="{'back_off': loading.back_off}">
        <div class="text-center">
            <b-spinner class="spinner" v-bind:class="{'hide': loading.hide}" variant="primary" label="Text Centered"></b-spinner>
        </div>

        <div class="container mb-5">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <b-alert
                        class="alert"
                        :show="dismissCountDown"
                        dismissible
                        fade
                        variant="info"
                        @dismiss-count-down="countDownChanged"
                        >
                        {{alert_text}} {{ dismissCountDown }} 秒...
                    </b-alert>
                    <div class="card">
                        <div class="card-header">
                            <form v-on:submit.prevent="addItem" class="form-group">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" v-model="newItem" class="form-control">
                                        <span class="input-group-btn"><button class="btn btn-primary" type="submit">送信</button></span>
                                    </div>
                                    <div class="input-group">
                                        <span class="text-danger font-weight-bolder">{{newItemError}}</span>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body">
                            <h3>やることリスト</h3>
                            <ul class="list-group">
                                <li class="list-group-item list_item" v-for="(todo) in todos" :key="todo.id">
                                    <div class="row mt-2">
                                        <div class="col-9">
                                            <label class="">
                                                <input type="checkbox" class="custom-control-input d-none" v-model="todo.done" />
                                                <span v-bind:class="{'done': todo.done}" @click="changeDone(todo)">{{todo.name}}</span>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <i class="fas fa-trash-alt float-right delete-confirm pointer p-1" @click="d_modalToggle(todo)"></i>
                                            <i class="fas fa-edit float-right pointer p-1" @click="e_modalToggle(todo)"></i>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <b-modal v-model="modal.d_modalShow" id="modal-1" title="削除しますか？" @ok="deleteOK">
                <div>
                    <div class="mt-2">タスク：{{ task.name }}</div>
                </div>
            </b-modal>

            <b-modal v-model="modal.e_modalShow" id="modal-2" title="編集しますか？" @ok="editOK">
                <div>
                    <b-form-input v-model="task.name" @blur="onBlur" placeholder="タスクを入れてください・・・"></b-form-input>
                    <div class="mt-2">タスク：{{ task.name }}</div>
                    <div class="input-group">
                        <span class="text-danger font-weight-bolder">{{newItemError}}</span>
                    </div>
                </div>
            </b-modal>
        </div>
    </div>
</template>

<script>
// Ajax通信先のドメインを定義しておく
var baseURL = location.origin;

export default {
    components: {

    },
    data () {
        return {
            spinner_flg: false,
            newItem: '',
            newItemError: '',
            todos: [],
            alert_text: '',
            dismissSecs: 5,
            dismissCountDown: 0,
            showDismissibleAlert: false,
            task : {
                id: '',
                name: '',
                done: '',
            },
            loading : {
                hide: true,
                back_off: false,
            },
            modal : {
                d_modalShow: false,
                e_modalShow: false,
            }
        }
    },
    props: {

    },
    computed: {

    },
    watch: {
        spinner_flg: function (newSpinner, oldSpinner) {
            if(this.spinner_flg){
                this.loading.hide = false
                this.loading.back_off = true
            } else {
                this.loading.hide = true
                this.loading.back_off = false
            }
        }
    },
    methods: {
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert(text) {
            this.alert_text = text
            this.dismissCountDown = this.dismissSecs
        },
        addItem: async function() {
            this.newItemError = ''
            // console.log(this.newItem.trim().length)
            if(!this.newItem.trim()) {
                this.newItemError = '文字を入力してください'
                return
            } else if(this.newItem.trim().length > 50){
                this.newItemError = '50文字以下にしてください'
                return
            }
            this.spinner_flg = true
            const data = {
                task: this.newItem.trim()
            }
            this.newItem = '';
            if(data.task !== ''){
                const items = await axios.post("todo/store", data)
                    .catch(err => {
                    return err.response
                });
                console.log('返信：' + items.data)
                // console.log('返信：' + items.config.data)
                // console.dir(items);
                if (items.status != 200) {
                    console.log('エラー！：' + items)
                }
                await this.getItemAll()
                this.spinner_flg = false
                this.showAlert('タスクを追加しました')
                return
            }
            this.spinner_flg = false
            this.showAlert('タスクを追加しました')
            return

        },
        changeDone: async function(todo){
            this.newItemError = ''
            console.log('change!' + todo.id)
            let toDone
            if(todo.done == 0 && todo.done == false) {
                toDone = 1
            } else {
                toDone = 0
            }
            const data = {
                name: todo.name,
                done: toDone
            }
            const items = await axios.post("/todo/update/" + todo.id, data)
                .catch(err => {
                return err.response
            });
            console.log('レスポンス：' + items.status)

        },
        e_modalToggle: function(todo) {
            this.newItemError = ''
            this.modal.e_modalShow = !this.modal.e_modalShow
            this.task.id = todo.id
            this.task.name = todo.name
            this.task.done = todo.done
        },
        onBlur: function() {
            this.newItemError = ''
            // console.log(this.task.name.length)
            if(!this.task.name.trim()) {
                this.newItemError = '文字を入力してください'
                return false
            } else if(this.task.name.trim().length > 50){
                this.newItemError = '50文字以下にしてください'
                return false
            }
        },
        editOK: async function() {
            this.newItemError = ''
            // console.log(this.task.name.length)
            if(!this.task.name.trim()) {
                this.newItemError = '文字を入力してください'
                return false
            } else if(this.task.name.trim().length > 50){
                this.newItemError = '50文字以下にしてください'
                return false
            }
            this.spinner_flg = true
            console.log('編集します：' + this.task.done)
            const data = {
                name: this.task.name,
                done: this.task.done
            }
            const items = await axios.post("/todo/update/" + this.task.id, data)
                .catch(err => {
                return err.response
            });
            console.log('レスポンス：' + items.status)
            await this.getItemAll()
            this.spinner_flg = false
            this.showAlert('タスクを編集しました')
            return
        },
        d_modalToggle: function(todo) {
            this.newItemError = ''
            this.modal.d_modalShow = !this.modal.d_modalShow
            this.task.id = todo.id
            this.task.name = todo.name
            this.task.done = todo.done
        },
        deleteOK: async function() {
            this.spinner_flg = true
            console.log('削除します：' + this.task.id)
            const items = await axios.get("/todo/delete/" + this.task.id)
                .catch(err => {
                return err.response
            });
            console.log('レスポンス：' + items.status)
            await this.getItemAll()
            this.spinner_flg = false
            this.showAlert('タスクを削除しました')
            return
        },
        getItemAll: async function(){
            this.newItemError = ''
            const items = await axios.get("todo/all")
                .catch(err => {
                return err.response
            });
            console.log(items.data.todos)

            if (items.status != 200) {
                console.log('エラー！：' + items)
            }
            this.todos = items.data.todos
        },
    },
    created() {
        this.getItemAll()
    },
}

</script>

<style module>
.alert{
    text-align: center;
}
.list_item{
    font-size: 1.2rem;
    font-weight: bold;
}
.done {
    text-decoration: line-through;
    color: tomato;
}
.pointer{
    cursor: pointer;
}
.back_off{
    opacity:0.5;
    z-index: 1;
}
.spinner{
    position: absolute;
    top: 13rem;
    opacity:1;
    z-index: 10;
}
.hide{
    display: none;
}
.spinner_on{
    display: block;
}
</style>
