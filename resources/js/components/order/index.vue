<template>
  <section class="content">
    <div class="row">
      <div class="col-12">
            <div class="box">
              <div class="box-header">
                <h3 >order List</h3>
              </div>
              <div class="row p-a">
                <div class="col-4">
                  <div class="input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="Search" v-model="search_term">
                    <span class="input-group-btn">
                      <button class="btn b-a white" type="button" @click="search">Search</button>
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
              <div class="row p-a">
                <div class="form-group col-3">
                    <label>Date debut</label>
                    <input
                        class="form-control"
                        type="date" placeholder="Date debut" v-model="date_debut" @change="filterPeriode"
                    />
                </div>
                <div class="form-group col-3">
                    <label>Date fin</label>
                    <input
                        class="form-control"
                        type="date" placeholder="Date fin" v-model="date_fin" @change="filterPeriodeFin"
                    />
                </div>



              </div>
              <!-- /.card-header -->
              <div class="table-responsive ">
                <table class="table table-striped b-t">
                  <thead>
                    <tr>
                      <th colspan="5" >filters :</th>

                      <th>
                       <select class="form-control" v-model="status_filter" @change="filterStatus(status_filter)">
                            <option
                                v-for="(cat) in orders_status" :key="cat"
                                :value="cat"
                                :selected="cat == form.status">{{ cat}}</option>
                        </select>
                      </th>
                      <th> <select class="form-control" v-model="package_filter" @change="filterPackage(package_filter)">
                              <option
                                  v-for="(cat) in package_status" :key="cat"
                                  :value="cat"
                                  :selected="cat == form.status">{{ cat}}</option>
                            </select>
                       </th>
                    </tr>
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th>Consumer</th>
                      <th>Product</th>
                      <th>total</th>
                      <th>ville</th>
                      <th>phone</th>
                      <th>order</th>
                      <th>package</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="order in orders.data" :key="order.id">

                      <td>{{order.id}}</td>
                      <td>{{ order.created_at | moment }}</td>
                      <td>{{order.consumer_name }}</td>
                      <td>{{order.product_name}}</td>
                      <td>{{order.total}}</td>
                      <td>{{order.consumer.ville}}</td>
                      <td>{{order.consumer.phone}}</td>
                      <td>{{order.status}}</td>
                      <td>{{order.package}}</td>
                      <!-- <td><img v-bind:src="'/' + order.photo" width="100" alt="order"></td> -->
                      <td>

                        <a href="#" @click="editModal(order)">
                            <i class="fa fa-edit"></i>
                        </a>
                        /
                        <a href="#" @click="deleteorder(order.id)">
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
                    <small class="text-muted inline m-t-sm m-b-sm">showing {{this.orders.from}}-{{this.orders.to}} of {{this.orders.total}} items</small>
                  </div>
                  <div class="col justify-content-end d-flex">
                    <pagination :data="orders" @pagination-change-page="getResults"></pagination>
                  </div>
                </div>
              </footer>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true" v-if="consumer_array">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode">Edit order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="updateorder()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" v-model="form.status">
                                <option
                                    v-for="(cat) in orders_status" :key="cat"
                                    :value="cat"
                                    :selected="cat == form.status">{{ cat}}</option>
                                </select>
                                <has-error :form="form" field="product_id"></has-error>
                            </div>
                            <div class="form-group" v-if="form.status == 'LATER'">
                                <label>Date Confirmation :</label>
                                <input type="datetime-local" class="form-control" v-model="form.dateConfirmation"/>
                            </div>
                            <div class="form-group" v-if="form.status == 'CONFIRMED'">
                                <label>Delivery Service </label>
                                <select
                                    class="form-control"
                                    v-model="form.shipping_id"
                                >
                                    <option
                                        v-for="cat in listShipping"
                                        :key="cat.id"
                                        :value="cat.id"
                                        :selected="
                                            cat.id == form.shipping_id
                                        "
                                        >{{ cat.text }}</option
                                    >
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update</button>
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
    import moment from 'moment';
    export default {
        components: {
          VueTagsInput
        },
        filters: {
            moment: function (date) {
                if(date)
                return moment(date).format('Y-m-d');
                else
                return "";
            },
            human_moment: function (date) {
                if(date)
                return moment(date).format('Y-m-d hh:mm');
                else
                return "";
            }
        },
        data () {
            return {
                listShipping: [],
                editmode: false,
                status_filter: null,
                package_filter: null,
                date_debut: null,
                date_fin: null,
                orders : {},
                url           : "",
                search_term   : "",
                status_array: ['active','blocked'],
                orders_status: [
                  '',
                  'NEW',
                  'CONFIRMED',
                  'NO ANSWER',
                  'NO ANSWER(2)',
                  'NO ANSWER(3)',
                  'LATER',
                  'CANCELED'
                ],
                package_status: [
                    "",
                    "UNPACKED",
                    "PACKED",
                    "SHIPPED",
                    "DELIVERED",
                    "NO ANSWER"
                ],
                consumer_array: null,
                product_array: null,
                form: new Form({
                    id      : '',
                    status  : '',
                    dateConfirmation: ''
                }),
                tag:  '',
                autocompleteItems: [],
                selectedDate: null,
                menu: false,
                modal: false,
                menu2: false,
            }
        },
        methods: {
            loadshippings() {
                axios.get("/api/shippings/list").then(response => {
                    this.listShipping = response.data.data.map(a => {
                        return {
                            text: a.name + "(" + a.type + ")",
                            id: a.id,
                            price: a.price
                        };
                    });
                })
                .catch(() => console.warn("Oh. Something went wrong"));
            },
            search:function() {
                var url = this.insertParam('search', this.search_term, this.url);
                this.loading = true;
                this.loadorders(url);
            },
            insertParam:function(key, value,url){
                var urlL = new URL(url);
                urlL.searchParams.append(key, value);
                urlL.searchParams.set(key, value);
                return urlL;
            },
            filterPeriode:function() {
                this.url = this.insertParam('date_debut', this.date_debut, this.url);
                this.loading = true;
                this.loadorders(this.url);
            },
            filterPeriodeFin:function() {
                this.url = this.insertParam('date_fin', this.date_fin, this.url);
                this.loading = true;
                this.loadorders(this.url);
            },
            filterStatus:function($item) {
                this.url = this.insertParam('status', this.status_filter, this.url);
                this.loading = true;
                this.loadorders(this.url);
            },
            filterPackage:function($item) {
                this.url = this.insertParam('package', this.package_filter, this.url);
                this.loading = true;
                this.loadorders(this.url);
            },
            getResults(page = 1) {
                this.$Progress.start();
                axios.get('api/order?page=' + page).then(({ data }) => (this.orders = data.data));
                this.$Progress.finish();
            },
            loadorders(url=this.url){
                axios.get(url).then(({ data }) => (this.orders = data.data));
            },
            loadProducts(){
                axios.get("/api/products/list").then(response => {
                    this.product_array = response.data.data.map(a => {
                        return { text: a.name, id: a.id };
                    });
                }).catch(() => console.warn('Oh. Something went wrong'));
            },
            loadconsumers(){
                axios.get("/api/consumers/list").then(response => {
                    this.consumer_array = response.data.data.map(a => {
                        return { text: a.nom +" "+a.prenom, id: a.id };
                    });
                }).catch(() => console.warn('Oh. Something went wrong'));
            },
            editModal(order){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(order);
            },
            newModal(){
                this.$router.replace({name: "order.add"})
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
            deleteorder(id){
                if(this.$gate.isAdmin()){
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
                                this.form.delete('api/order/'+id).then(()=>{
                                        Swal.fire(
                                        'Deleted!',
                                        'Your file a été supprimé.',
                                        'success'
                                        );
                                    // Fire.$emit('AfterCreate');
                                    this.loadorders();
                                }).catch((data)=> {
                                    Swal.fire("Failed!", data.message, "warning");
                                });
                            }
                    })
                }
            },

        },
        mounted() {
            this.loadProducts();
            this.loadconsumers();
            this.loadshippings();
        },
        created() {
            this.$Progress.start();
            this.url = this.$app_url +"/api/order";
            this.loadorders(this.url);
            this.$Progress.finish();
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
