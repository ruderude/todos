<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">マイページ</div>

                    <div class="card-body">
                        <h4>{{userName}}</h4>
                        <h4>{{email}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <b-button id="show-btn" @click="showModal" >編集する</b-button>

            <b-modal ref="my-modal" hide-footer title="Using Component Methods">
            <div class="d-block text-center">
                <h3>
                    <b-form-input v-model="userName" @blur="onBlur" placeholder="名前を入れてください・・・"></b-form-input>
                </h3>
            </div>
            <div class="input-group">
                <span class="text-danger font-weight-bolder">{{error_message}}</span>
            </div>
            <b-button class="mt-3" variant="outline-success" block @click="updateName" :disabled="error">更新</b-button>
            <b-button class="mt-3" variant="outline-danger" block @click="hideModal">Close</b-button>
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
            userName: this.name,
            error: false,
            error_message: '',
        }
    },
    props: {
        name: '',
        email: '',
    },
    methods: {
        showModal() {
            this.$refs['my-modal'].show()
        },
        hideModal() {
            this.$refs['my-modal'].hide()
        },
        onBlur: function() {
            this.error_message = ''
            // console.log(this.userName.length)
            if(!this.userName.trim()) {
                this.error_message = '名前を入力してください'
                this.error = true
                return false
            } else if(this.userName.trim().length > 20){
                this.error_message = '20文字以下にしてください'
                this.error = true
                return false
            }
            this.error = false
        },
        updateName: async function() {
            this.error_message = ''
            const Name = { name: this.userName }
            const items = await axios.post("/user/update", Name)
                .catch(err => {
                return err.response
            });
            location.reload();
        },
    },
    created() {
        console.log(baseURL)
    },

}

</script>
