<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        user!!
                        {{name}}
                        {{email}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {

    },
    data () {
        return {

        }
    },
    props: {
        name: {
            type: String,
        },
        email: {
            type: String,
        },
    },
}

</script>
