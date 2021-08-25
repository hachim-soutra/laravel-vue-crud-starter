<template>
  <section class="content w-75 m-auto">
    <!-- Modal -->
    <form @submit.prevent="createconsumer()">
        <div class="row">
            <div class="form-group col-6">
                <label>Prenom</label>
                <input v-model="form.prenom" type="text" name="prenom"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('prenom') }">
                <has-error :form="form" field="prenom"></has-error>
            </div>
            <div class="form-group col-6">
                <label>Nom</label>
                <input v-model="form.nom" type="text" name="nom"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nom') }">
                <has-error :form="form" field="nom"></has-error>
            </div>
            <div class="form-group col-12">
                <label>adresse</label>
                <input v-model="form.adresse" type="text" name="adresse"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('adresse') }">
                <has-error :form="form" field="adresse"></has-error>
            </div>
            <div class="form-group col-12">
                <label>phone</label>
                <input v-model="form.phone" type="text" name="phone"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                <has-error :form="form" field="phone"></has-error>
            </div>
            <div class="form-group col-6">
                <label>ville</label>
                <input v-model="form.ville" type="text" name="ville"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('ville') }">
                <has-error :form="form" field="ville"></has-error>
            </div>
            <div class="form-group col-6">
              <label>status</label>
              <select class="form-control" v-model="form.status">
                <option
                    v-for="(cat) in status_array" :key="cat"
                    :value="cat"
                    :selected="cat == form.status">{{ cat }}</option>
              </select>
              <has-error :form="form" field="status_id"></has-error>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
  </section>
</template>

<script>
    export default {

        data () {
            return {
                consumers : {},
                form: new Form({
                    id      : '',
                    nom     : '',
                    prenom  : '',
                    adresse : '',
                    status  : '',
                    ville   : '',
                    phone   : '',
                    order   : '',
                }),
            }
        },
        methods: {
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            createconsumer(){
                this.$Progress.start();
                this.form.post('/api/consumer').then((data)=>{
                    if(data.data.success){
                        $('#addNew').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: data.data.message
                        });
                        this.$Progress.finish();
                        this.form.reset();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                        this.$Progress.failed();
                    }
                }).catch(()=>{
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                })
            },
            editModal(order){
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(order);
            },
            updateorder(){
                this.$Progress.start();
                this.form.put('/api/order/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                    this.loadorders(this.url);
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },
        },
        mounted() {

        },
    }
</script>
