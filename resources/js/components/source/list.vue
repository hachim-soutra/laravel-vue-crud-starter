<template>
  <section class="content">
    <div class="row">
      <div class="col-12">
            <div class="box">
              <div class="box-header">
                <h3 >source List</h3>
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

              <!-- /.card-header -->
              <div class="table-responsive ">
                <table class="table table-striped b-t">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>name</th>
                      <th>platform</th>
                      <th>status</th>
                      <th>integration</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="source in sources.data" :key="source.id">

                        <td>{{source.id}}</td>
                        <td>{{source.name }}</td>
                        <td>{{source.type}}</td>
                        <td>{{source.status}}</td>
                        <td>
                            <span @click="integration(source)" class="label blue">
                                <i class="fa fa-edit"></i> integration
                            </span>
                        </td>
                        <td>
                            <a href="#" @click="editModal(source)">
                                <i class="fa fa-edit"></i>
                            </a>
                            /
                            <a href="#" @click="deletesource(source.id)">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <footer class="dker p-a">
                <div class="row">
                  <div class="col text-left">
                    <small class="text-muted inline m-t-sm m-b-sm">showing {{this.sources.from}}-{{this.sources.to}} of {{this.sources.total}} items</small>
                  </div>
                  <div class="col justify-content-end d-flex">
                    <pagination :data="sources" @pagination-change-page="getResults"></pagination>
                  </div>
                </div>
              </footer>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="editmode">Edit source</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="updatesource()">
                    <div class="modal-body">
                        <div class="form-group col-12">
                            <label>source Status</label>
                            <select class="form-control" v-model="form.status">
                                <option v-for="(cat) in source_liste" :key="cat"
                                    :value="cat"
                                    :selected="cat == form.status">{{ cat }}</option>
                            </select>
                            <has-error :form="form" field="status"></has-error>
                        </div>
                        <div class="form-group col-12">
                            <label>platform</label>
                            <select class="form-control" v-model="form.type">
                                <option
                                    v-for="(cat) in type_liste" :key="cat"
                                    :value="cat"
                                    :selected="cat == form.type">{{ cat }}</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                        <div class="form-group col-12">
                            <label>First Name</label>
                            <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
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
                editmode: false,
                sources : {},
                url           : "",
                search_term   : "",
                source_liste: ['active','blocked'],
                type_liste: [
                  'NEW',
                  'CONFIRMED',
                  'PROCESSED',
                  'READY',
                  'CLOSED',
                  'CANCELED',
                  'RETURN',
                  'NO ANSWER',
                  'LATER',
                  'PAID'
                ],
                form: new Form({
                    id      : '',
                    name    : '',
                    type    : '',
                    status  : ''
                }),
            }
        },
        methods: {
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
            getResults(page = 1) {

                this.$Progress.start();

                axios.get('api/source?page=' + page).then(({ data }) => (this.sources = data.data));

                this.$Progress.finish();
            },
            loadsources(url=this.url){

                // if(this.$gate.isAdmin()){
                axios.get(url).then(({ data }) => (this.sources = data.data));
                // }
            },

            editModal(source){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(source);
            },
            integration(source){
                this.$router.replace({name: "source.build",params: {id: source.id }})
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                // $('#addNew').modal('show');
                this.$router.replace({name: "source.add"})
            },

            updatesource(){
                this.$Progress.start();
                this.form.put('/api/source/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                    this.loadsources(this.url);
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },
            deletesource(id){
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
                                this.form.delete('api/source/'+id).then(()=>{
                                        Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        );
                                    // Fire.$emit('AfterCreate');
                                    this.loadsources();
                                }).catch((data)=> {
                                    Swal.fire("Failed!", data.message, "warning");
                                });
                            }
                    })
            },

        },
        mounted() {
            this.loadProducts();
            this.loadconsumers();
        },
        created() {
            this.$Progress.start();
            this.url = this.$app_url +"/api/source";
            this.loadsources(this.url);
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
