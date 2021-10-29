<template>
    <div class="container">
        <div class="row justify-content-center">
            <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add New
                  </button>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Usuarios</div>
                        <table class="table table-striped">
                            <thead>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td>

                                        <a href="#" @click="editModal(user)" class="btn btn-primary">
                                            Editar
                                        </a>
                                        /
                                        <a href="#" @click="deleteUser(user.id)" class="btn btn-danger">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>





            <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New User</h5>
                    <h5 class="modal-title" v-show="editmode">Update User's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form @submit.prevent="editmode ? updateUser() : createUser()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                         <div class="form-group">
                            <label>Apellido</label>
                            <input v-model="form.lastname" type="text" name="lastname"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('lastname') }">
                            <has-error :form="form" field="lastname"></has-error>
                        </div>
                         <div class="form-group">
                            <label>Cédula</label>
                            <input v-model="form.national_identity_document" type="text" name="national_identity_document"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('national_identity_document') }">
                            <has-error :form="form" field="national_identity_document"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Correo Electronico</label>
                            <input v-model="form.email" type="text" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <label>País</label>
                            <select name="coutry" v-model="form.country" id="country" class="form-control" :class="{ 'is-invalid': form.errors.has('country') }">
                                <option value="">Seleccione pais</option>
                                <option :value="data.country" v-for="data in countries">{{data.country}}</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <input v-model="form.address" type="text" name="address"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                            <has-error :form="form" field="address"></has-error>
                        </div>  
                        <div class="form-group">
                            <label>Celular</label>
                            <input v-model="form.mobile" type="text" name="mobile"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                            <has-error :form="form" field="mobile"></has-error>
                        </div>                  
                        <div class="form-group">
                            <label>Password</label>
                            <input v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" autocomplete="false">
                            <has-error :form="form" field="password"></has-error>
                        </div>
                    
                        <div class="form-group">
                            <label>Categoria</label>
                            <select name="category_id" v-model="form.category_id" id="category_id" class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }">
                                <option value="">Seleccione categoria</option>
                                <option :value="category.id" v-for="category in categories">{{category.name}}</option>
                                
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {

        data() {
            return {
                users:[],
                editmode: false,
                form: new Form({
                    id : "",
                    category_id : "",
                    name: "",
                    lastname: "",
                    email: "",
                    password: "",
                    country: "",
                    national_identity_document:"",
                    address:"",
                    mobile:""
                }),

                categories:[],
                countries: []
            }
    },

        created() {
                this.index();
                this.loadcountry();
                this.loadcategory();
        },

        methods: {
           async index() {
                   
                 await axios.get("/users")
                    .then((res) => {
                        console.log(res.data);
                        this.users = res.data;
                        
                    });
            },

            editModal(user){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },

            updateUser(){
             
                // console.log('Editing data');
                this.form.put('users/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    
                        //  Fire.$emit('AfterCreate');
                    this.index();
                })
                .catch(() => {
                    console.error("error");
                });
            },

            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            createUser(){
              this.form.post('users')
              .then((response)=>{
                  $('#addNew').modal('hide');
                  Toast.fire({
                        icon: 'success',
                        title: response.data.message
                  });
                 
                  this.index();
              })
              .catch(()=>{
                  Toast.fire({
                      icon: 'error',
                      title: 'Ha ocurrido un error! intente nuevamente'
                  });
              })
          },

                async loadcategory(){
                    await axios.get("/categories")
                        .then((res)=>{
                            console.log(res.data);
                            this.categories = res.data;
                        });
                },

                loadcountry(){
                     axios.get('/countries')
                    .then(res => {
                        this.countries = res.data.data;
                            console.log(res.data);   
                    });
                },

            deleteUser(id){
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "Si eliminas el usuario no podras recuperarlo!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.form.delete('users/'+id).then(()=>{
                                        Swal.fire(
                                        'Elimninado!',
                                        'El usaurio a sido eliminado.',
                                        'success'
                                        );
                                    // Fire.$emit('AfterCreate');
                                    this.index();
                                }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                         }
                    })
            },
        },

        mounted() {
            console.log('Component mounted.');
        }
    }
</script>