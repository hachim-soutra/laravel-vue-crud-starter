<template>
    <div class="box">
        <div class="box-header">
            <h3>New order List</h3>
        </div>
        <div class="row p-a">
            <div class="col-4">
                <div class="input-group input-group-sm">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search"
                        v-model="search_term"
                    />
                    <span class="input-group-btn">
                        <button
                            class="btn b-a white"
                            type="button"
                            @click="search"
                        >
                            Go!
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!-- /.card-header -->
        <div class="table-responsive ">
            <table class="table table-striped b-t">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Consumer</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>total</th>
                        <th>order</th>
                        <th>package</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders.data" :key="order.id">
                        <td>{{ order.id }}</td>
                        <td>{{ order.consumer_name }}</td>
                        <td>{{ order.created_at }}</td>
                        <td>{{ order.product_name }}</td>
                        <td>{{ order.total }}</td>
                        <td>{{ order.status }}</td>
                        <td>{{ order.package }}</td>
                        <!-- <td><img v-bind:src="'/' + order.photo" width="100" alt="order"></td> -->
                        <td>
                            <a href="#" @click="editModal(order)">
                                <i class="fa fa-edit"></i>
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
                    <small class="text-muted inline m-t-sm m-b-sm"
                        >showing {{ this.orders.from }}-{{ this.orders.to }} of
                        {{ this.orders.total }} items</small
                    >
                </div>
                <div class="col justify-content-end d-flex">
                    <pagination
                        :data="orders"
                        @pagination-change-page="getResults"
                    ></pagination>
                </div>
            </div>
        </footer>
        <div
            class="modal fade"
            id="addNew"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addNew"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit order</h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="updateorder()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Status</label>
                                <select
                                    class="form-control"
                                    v-model="form.status"
                                >
                                    <option
                                        v-for="cat in orders_status"
                                        :key="cat"
                                        :value="cat"
                                        :selected="cat == form.status"
                                        >{{ cat }}</option
                                    >
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button type="submit" class="btn btn-success">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import OrderEdit from "../popup/Edit.vue";

export default {
    components: {
        OrderEdit
    },
    data() {
        return {
            orders: {},
            search_term: null,
            search_term: null,
            orders_status: [
                "NEW",
                "CONFIRMED",
                "PROCESSED",
                "READY",
                "CLOSED",
                "CANCELED",
                "RETURN",
                "NO ANSWER",
                "LATER",
                "PAID"
            ],
            form: new Form({
                id: "",
                status: ""
            })
        };
    },
    props: ["type"],
    methods: {
        getResults(page = 1) {
            this.$Progress.start();
            axios
                .get("api/order/" + this.$route.params.id + "?page=" + page)
                .then(({ data }) => (this.orders = data.data));
            this.$Progress.finish();
        },
        loadorders(url) {
            axios.get(url).then(({ data }) => (this.orders = data.data));
        },
        insertParam: function(key, value, url) {
            var urlL = new URL(url);
            urlL.searchParams.append(key, value);
            urlL.searchParams.set(key, value);
            return urlL;
        },
        search: function() {
            var url = this.insertParam("search", this.search_term, this.url);
            url = this.insertParam("status", this.type, url);
            this.loading = true;
            this.loadorders(url);
        },
        editModal(order) {
            this.form.reset();
            $("#addNew").modal("show");
            this.form.fill(order);
        },
        updateorder() {
            this.$Progress.start();
            this.form
                .put("/api/order/" + this.form.id)
                .then(response => {
                    // success
                    $("#addNew").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: response.data.message
                    });
                    this.$Progress.finish();
                    this.loadorders(this.url);
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        }
    },
    mounted() {
        let url = this.$app_url + "/api/order/" + this.$route.params.id;
        this.url = this.insertParam("status", this.type, url);
        this.loadorders(this.url);
    }
};
</script>
