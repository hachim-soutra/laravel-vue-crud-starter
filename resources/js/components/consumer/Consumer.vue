<template>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="box">
          <div class="box-header">
            <h3>Consumers liste</h3>
          </div>
          <div class="row p-a">
            <div class="col-4">
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" placeholder="Search" v-model="search_term">
                <span class="input-group-btn">
                  <button class="btn b-a white" type="button" @click="search">Go!</button>
                </span>
              </div>
            </div>
            <div class="col text-right">
              <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                  <i class="fa fa-plus-square"></i>
                  Add New
              </button>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped b-t">
              <thead>
                <tr>
                  <th >ID</th>
                  <th>Name</th>
                  <th>phone</th>
                  <th>adresse</th>
                  <th>ville</th>
                  <th>order</th>
                  <th>status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="consumer in consumers.data" :key="consumer.id">
                  <td>{{consumer.id}}</td>
                  <td>{{consumer.prenom +" "+consumer.nom}}</td>
                  <td>{{consumer.phone}}</td>
                  <td>{{consumer.adresse | truncate(30, '...')}}</td>
                  <td>{{consumer.ville}}</td>
                  <td>{{consumer.order}}</td>
                  <td>{{consumer.status}}</td>
                  <!-- <td><img v-bind:src="'/' + consumer.photo" width="100" alt="consumer"></td> -->
                  <td>
                    <a href="#" @click="editModal(consumer)">
                        <i class="fa fa-edit "></i>
                    </a>
                    /
                    <a href="#" @click="deleteconsumer(consumer.id)">
                        <i class="fa fa-trash "></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <footer class="dker p-a">
            <div class="row">
              <div class="col text-left">
                <small class="text-muted inline m-t-sm m-b-sm">showing {{this.consumers.from}}-{{this.consumers.to}} of {{this.consumers.total}} items</small>
              </div>
              <div class="col justify-content-end d-flex">                
                <pagination :data="consumers" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" v-show="!editmode">Create New consumer</h5>
                <h5 class="modal-title" v-show="editmode">Edit consumer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form @submit.prevent="editmode ? updateconsumer() : createconsumer()">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Prenom</label>
                        <input v-model="form.prenom" type="text" name="prenom"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('prenom') }">
                        <has-error :form="form" field="prenom"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Nom</label>
                        <input v-model="form.nom" type="text" name="nom"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('nom') }">
                        <has-error :form="form" field="nom"></has-error>
                    </div>
                    <div class="form-group">
                        <label>adresse</label>
                        <input v-model="form.adresse" type="text" name="adresse"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('adresse') }">
                        <has-error :form="form" field="adresse"></has-error>
                    </div>
                    <div class="form-group">
                        <label>phone</label>
                        <input v-model="form.phone" type="text" name="phone"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                        <has-error :form="form" field="phone"></has-error>
                    </div>
                    <div class="form-group">
                        <label>ville</label>
                        <input v-model="form.ville" type="text" name="ville"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('ville') }">
                        <has-error :form="form" field="ville"></has-error>
                    </div>
                    <div class="form-group">

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
                    <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                </div>
              </form>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
      components: {
          VueTagsInput,
        },
        data () {
            return {
                editmode      : false,
                search_term   : "",
                consumers     : {},
                url           : "",
                status_array  : ['active','blocked'],
                form          : new Form({
                    id      : '',
                    nom     : '',
                    prenom  : '',
                    adresse : '',
                    status  : '',
                    ville   : '',
                    phone   : '',
                    order   : '',
                }),              
                tag:  '',
                autocompleteItems: [],
            }
        },
        methods: {

          getResults(page = 1) {

              this.$Progress.start();
              
              axios.get('api/consumer?page=' + page).then(({ data }) => (this.consumers = data.data));

              this.$Progress.finish();
          },
          loadconsumers(url){

            // if(this.$gate.isAdmin()){
              axios.get(url).then(({ data }) => (this.consumers = data.data));
            // }
          },
          editModal(consumer){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(consumer);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createconsumer(){
              this.$Progress.start();

              this.form.post('api/consumer')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadconsumers();

                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });

                  this.$Progress.failed();
                }
              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
          },
          updateconsumer(){
              this.$Progress.start();
              this.form.put('api/consumer/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadconsumers();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deleteconsumer(id){
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/consumer/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file a été supprimé.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadconsumers();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
          },
          insertParam:function(key, value,url){
            var urlL = new URL(url);
            urlL.searchParams.append(key, value);
            urlL.searchParams.set(key, value);
            return urlL;
          },
          search:function() {
            var url = this.insertParam('search', this.search_term, this.url);
            this.loading = true;
            this.loadconsumers(url);
          },

        },
        mounted() {
            
        },
        created() {
            this.$Progress.start();
            this.url ="http://localhost:8000/api/consumer";
            this.loadconsumers(this.url);
            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          },
        },
    }
</script>
