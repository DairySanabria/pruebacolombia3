<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an {{mensaje}}.

                        {{ users }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                users:[],
                mensaje:"prueba"
            }
        },
        mounted() {
            console.log('Component mounted.')
        },

        created() {
            this.index();
        },

        methods: {
                index() {
                    axios.get('/users').then((res) => this.users = res.data);
                }
        }
    }
</script>
