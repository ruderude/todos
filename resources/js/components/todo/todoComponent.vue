<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <form v-on:submit.prevent="addItem" class="form-group">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" v-model="newItem" class="form-control">
                                    <span class="input-group-btn"><button class="btn btn-primary" type="submit">送信</button></span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <h3>やることリスト</h3>
                        <ul class="list-group">
                            <li class="list-group-item" v-for="(todo) in todos" :key="todo.id">
                                <div class="row mt-2">
                                    <div class="col">
                                        <label class="">
                                            <input type="checkbox" class="custom-control-input d-none" v-model="todo.done" />
                                            <span v-bind:class="{'done': todo.done}" @click="changeDone(todo)">{{todo.name}}</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <i class="fas fa-trash-alt float-right pointer p-1"></i>
                                        <i class="fas fa-edit float-right pointer p-1"></i>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
            newItem: '',
            todos: []
        }
    },
    props: {

    },
    methods: {
        addItem: async function() {
            const data = {
                task: this.newItem.trim()
            }
            this.newItem = '';
            if(data.task !== ''){
                const items = await axios.post("todo", data)
                    .catch(err => {
                    return err.response
                });
                console.log('返信：' + items)
                if (items.status != 200) {
                    console.log('エラー！：' + items)
                }
                this.getItemAll()
            }
            return

        },
        changeDone: async function(todo){
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
            const items = await axios.put("todo/" + todo.id, data)
                .catch(err => {
                return err.response
            });
            console.log('レスポンス：' + items)
        },
        getItemAll: async function(){
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
.done {
  text-decoration: line-through;
  color: tomato;
}
.pointer{
  cursor: pointer;
}
</style>
