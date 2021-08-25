<template>
  <section class="content">
    <div class="row">
      <div class="col-12" id="tab-home" md-label="Delivery Services" @click="type='company'">


                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">shipping List</h3>

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
                  <div class="table-responsive">
                    <table class="table w-100 table-striped b-t">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>name</th>
                          <th>Date</th>
                          <th>price</th>
                          <th>dure</th>
                          <th>status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <template v-for="shipping in shippings.data">
                            <tr v-if="shipping.type != 'men'" :key="shipping.id" >
                            <td>{{shipping.id}}</td>
                            <td>{{shipping.name }}</td>
                            <td>{{shipping.created_at}}</td>
                            <td>{{shipping.price}}</td>
                            <td>{{shipping.dure}}</td>
                            <td>{{shipping.status}}</td>
                            <!-- <td><img v-bind:src="'/' + shipping.photo" width="100" alt="shipping"></td> -->
                            <td>

                              <a href="#" @click="editModal(shipping)">
                                  <i class="fa fa-edit"></i>
                              </a>
                              /
                              <a href="#" @click="deleteshipping(shipping.id)">
                                  <i class="fa fa-trash"></i>
                              </a>
                            </td>
                          </tr>
                        </template>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                    <footer class="dker p-a">
                        <div class="row">
                            <div class="col text-left">
                                <small class="text-muted inline m-t-sm m-b-sm">showing {{this.shippings.from}}-{{this.shippings.to}} of {{this.shippings.total}} items</small>
                            </div>
                            <div class="col justify-content-end d-flex">
                                <pagination :data="shippings" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </footer>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" v-show="!editmode">Create New shipping</h5>
                <h5 class="modal-title" v-show="editmode">Edit shipping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form @submit.prevent="editmode ? updateshipping() : createshipping()">
                <div class="modal-body">
                    <div class="form-group">
                        <label>name</label>
                        <input v-model="form.name" type="text" name="name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <label>price</label>
                        <input v-model="form.price" type="text" name="price"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                        <has-error :form="form" field="price"></has-error>
                    </div>
                    <div class="form-group" v-if="type != 'men'">
                        <label>dure</label>
                        <input v-model="form.dure" type="text" name="dure"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('dure') }">
                        <has-error :form="form" field="dure"></has-error>
                    </div>
                    <div class="form-group"  v-if="type =='men'">
                        <label>phone</label>
                        <input v-model="form.phone" type="text" name="phone"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                        <has-error :form="form" field="phone"></has-error>
                    </div>
                    <div class="form-group" v-if="type =='men'">
                        <label>email</label>
                        <input v-model="form.email" type="text" name="email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group"  v-if="type =='men'">
                        <label>password</label>
                        <input v-model="form.password" type="text" name="password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
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
                editmode: false,
                type: 'company',
                url : this.$app_url +"/api/shipping?type=company",
                search_term   : "",
                shippings : {},
                status_array: ['active','blocked'],
                consumer_array: null,
                shipping_array: null,
                form: new Form({
                    id       : '',
                    price    : '',
                    dure     : '',
                    phone    : '',
                    email    : '',
                    password : '',
                    type     : 'active',
                    status   : 'active'
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

                axios.get('api/shipping?page=' + page).then(({ data }) => (this.shippings = data.data));

                this.$Progress.finish();
            },
            loadshippings(url){

                // if(this.$gate.isAdmin()){
                axios.get(url).then(({ data }) => (this.shippings = data.data));
                // }
            },

          loadconsumers(){
            axios.get("/api/consumers/list").then(response => {
              console.log(response);
                  this.consumer_array = response.data.data.map(a => {
                      return { text: a.nom +" "+a.prenom, id: a.id };
                  });
              }).catch(() => console.warn('Oh. Something went wrong'));
          },
          editModal(shipping){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(shipping);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createshipping(){
              this.$Progress.start();
              this.form.type = this.type;
              this.form.post('api/shipping')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadshippings();

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
          updateshipping(){
              this.$Progress.start();
              this.form.put('api/shipping/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadshippings();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
            deleteshipping(id){
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
                              this.form.delete('api/shipping/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadshippings();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
            },
            showDeliveryMen(shipping){
                this.$router.push({name:"shipping.deliveryMen"})
            }

        },
        created() {
            this.$Progress.start();
            this.loadshippings(this.url);
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
        watch: {
          type :function(value){
            this.loadshippings();
          }
        }
    }
</script>
