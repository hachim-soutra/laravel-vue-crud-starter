<template>
    <section class="content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link to="/orders">Order</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Add new order
                </li>
            </ol>
        </nav>
        <div class="container-fluid">
            <form
                @submit.prevent="editmode ? updateorder() : createorder()"
                class="row"
            >
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <div>
                                <div class="modal-body row  m-0 p-0">
                                    <div class="form-group col-4">
                                        <label>Order Status</label>
                                        <select
                                            class="form-control"
                                            v-model="form.order_status"
                                        >
                                            <option
                                                v-for="cat in orders_status"
                                                :key="cat"
                                                :value="cat"
                                                :selected="
                                                    cat == form.order_status
                                                "
                                                >{{ cat }}</option
                                            >
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="order_status"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Package Status </label>
                                        <select
                                            class="form-control"
                                            v-model="form.package_status"
                                        >
                                            <option
                                                v-for="cat in packages_status"
                                                :key="cat"
                                                :value="cat"
                                                :selected="
                                                    cat == form.package_status
                                                "
                                                >{{ cat }}</option
                                            >
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="package_status"
                                        ></has-error>
                                    </div>
                                    <div class="form-group  col-4">
                                        <label>Source</label>
                                        <select
                                            class="form-control"
                                            v-model="form.source_id"
                                        >
                                            <option
                                                v-for="cat in source_array"
                                                :key="cat.id"
                                                :value="cat.id"
                                                :selected="
                                                    cat.id == form.source_id
                                                "
                                                >{{ cat.text }}</option
                                            >
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="source_id"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Date confirmation</label>
                                        <input
                                            type="datetime-local"
                                            class="form-control"
                                            v-model="form.dateConfirmation"
                                        />
                                        <has-error
                                            :form="form"
                                            field="datetime"
                                        ></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <div class="modal-body ">
                                <div
                                    class="row m-0 p-0"
                                    v-for="(row, index) in form.rows"
                                >
                                    <div
                                        class="d-flex align-items-center mx-2 my-0 flex-column"
                                    >
                                        <label>upsell</label>
                                        <input
                                            v-model="form.rows[index].active"
                                            type="checkbox"
                                            name="rows[index].active"
                                            class="form-control w-50"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'rows[index].active'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="rows[index].active"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>product</label>
                                        <select
                                            class="form-control"
                                            v-model="form.rows[index].product"
                                        >
                                            <option
                                                v-for="cat in product_array"
                                                :key="cat.id"
                                                :value="cat.id"
                                                :selected="
                                                    cat.id ==
                                                        form.rows[index].product
                                                "
                                                >{{ cat.text }}</option
                                            >
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="rows[index].product"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col">
                                        <label>Unit Cost</label>
                                        <input
                                            @change="quantityHandler(index)"
                                            v-model="form.rows[index].unit_cost"
                                            type="text"
                                            name="rows[index].unit_cost"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'rows[index].unit_cost'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="rows[index].unit_cost"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col">
                                        <label>Quantity</label>
                                        <input
                                            @change="quantityHandler(index)"
                                            v-model="form.rows[index].quantity"
                                            type="text"
                                            name="rows[index].quantity"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'rows[index].quantity'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="rows[index].quantity"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col">
                                        <label>Subtotal</label>
                                        <input
                                            disabled
                                            v-model="form.rows[index].sub_total"
                                            type="text"
                                            name="rows[index].sub_total"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'rows[index].sub_total'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="rows[index].sub_total"
                                        ></has-error>
                                    </div>
                                    <div
                                        class="d-flex align-items-center mx-2 my-0"
                                    >
                                        <span @click="deleteProduit(index)">
                                            <i class="fa fa-trash w-50"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <span
                                    @click="addProduit"
                                    class="btn btn-primary"
                                    >Add produit</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0 my-2">
                            <div class=" row  m-0 p-0">
                                <div class="col-6">
                                    <div class="form-group col-12">
                                        <md-field>
                                            <label>Note</label>
                                            <md-textarea
                                                v-model="form.note"
                                                md-autogrow
                                            ></md-textarea>
                                        </md-field>
                                    </div>
                                    <div class="form-group col-12">
                                        <md-field>
                                            <label>Delivery service note</label>
                                            <md-textarea
                                                v-model="form.delivery_note"
                                                md-autogrow
                                            ></md-textarea>
                                        </md-field>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Shipping cost</label>
                                        <input
                                            v-model="form.sell_shipping_cost"
                                            type="text"
                                            name="sell_shipping_cost"
                                            class="form-control"
                                            disabled
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'sell_shipping_cost'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="sell_shipping_cost"
                                        ></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label>subTotal</label>
                                        <input
                                            v-model="form.subTotal"
                                            type="text"
                                            name="subTotal"
                                            class="form-control"
                                            disabled
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'subTotal'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="subTotal"
                                        ></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label>Total</label>
                                        <input
                                            v-model="form.total"
                                            disabled
                                            type="text"
                                            name="total"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'total'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="total"
                                        ></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Customer Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <div>
                                <div class="modal-body row col-12 m-0 p-0">
                                    <div class="form-group col-12">
                                        <label
                                            >Search existing customer...
                                        </label>
                                        <select
                                            class="form-control"
                                            v-model="form.consumer_id"
                                        >
                                            <option
                                                v-for="cat in consumer_array"
                                                :key="cat.id"
                                                :value="cat.id"
                                                :selected="
                                                    cat.id == form.consumer_id
                                                "
                                                >{{ cat.text }}</option
                                            >
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="consumer_id"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label>First Name</label>
                                        <input
                                            v-model="form.consumer.prenom"
                                            type="text"
                                            name="consumer.prenom"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'consumer.prenom'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="consumer.prenom"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label>Last Name</label>
                                        <input
                                            v-model="form.consumer.nom"
                                            type="text"
                                            name="consumer.nom"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'consumer.nom'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="consumer.nom"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label>Phone</label>
                                        <input
                                            v-model="form.consumer.phone"
                                            type="text"
                                            name="consumer.phone"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'consumer.phone'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="consumer.phone"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label>Ville</label>
                                        <input
                                            v-model="form.consumer.ville"
                                            type="text"
                                            name="consumer.ville"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'consumer.ville'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="consumer.ville"
                                        ></has-error>
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Address</label>
                                        <input
                                            v-model="form.consumer.adresse"
                                            type="text"
                                            name="consumer.adresse"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'consumer.adresse'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="consumer.adresse"
                                        ></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Shipping</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <div>
                                <div class="modal-body">
                                    <div class="form-group">
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
                                        <has-error
                                            :form="form"
                                            field="shipping_id"
                                        ></has-error>
                                    </div>
                                    <div
                                        class="form-group"
                                        @click="randomNumber"
                                    >
                                        <label>Tracking Number</label>
                                        <input
                                            v-model="form.shipping_numero"
                                            type="text"
                                            name="shipping_numero"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'shipping_numero'
                                                )
                                            }"
                                        />

                                        <has-error
                                            :form="form"
                                            field="shipping_numero"
                                        ></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label>Shipping cost</label>
                                        <input
                                            v-model="form.shipping_cost"
                                            type="text"
                                            name="shipping_cost"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'shipping_cost'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="shipping_cost"
                                        ></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            editmode: false,
            orders: {},
            status_array: ["active", "blocked"],
            consumer_array: null,
            listConsumer: [],
            listShipping: [],
            product_array: null,
            orders_status: [
                "NEW",
                "CONFIRMED",
                "PROCESSED",
                "CANCELED",
                "RETURN",
                "NO ANSWER",
                "LATER",
                "PAID"
            ],
            packages_status: [
                "UNPACKED",
                "PACKED",
                "SHIPPED",
                "DELIVERED",
                "NO ANSWER"
            ],
            source_array: [],
            form: new Form({
                id: "",
                quantity: "",
                datetime: "",
                subTotal: "",
                total: "",
                dateConfirmation: "",
                status: "",
                consumer: {
                    nom: "",
                    prenom: "",
                    adresse: "",
                    ville: "",
                    phone: ""
                },
                source_id: null,
                package_status: null,
                rows: [
                    {
                        id: 1,
                        active: 0,
                        product: null,
                        unit_cost: 1,
                        quantity: 1,
                        sub_total: 1
                    }
                ],
                shipping_id: null,
                shipping_numero: null,
                shipping_cost: null,
                sell_shipping_cost: null,
                delivery_note: null,
                order_status: null,
                note: null,
                product_id: "",
                consumer_id: ""
            })
        };
    },
    methods: {
        loadProducts() {
            axios
                .get("/api/products/list")
                .then(response => {
                    this.product_array = response.data.data.map(a => {
                        return { text: a.name, id: a.id };
                    });
                })
                .catch(() => console.warn("Oh. Something went wrong"));
        },
        loadSources() {
            axios
                .get("/api/sources/list")
                .then(response => {
                    this.source_array = response.data.data.map(a => {
                        return { text: a.name, id: a.id };
                    });
                })
                .catch(() => console.warn("Oh. Something went wrong"));
        },
        loadconsumers() {
            axios
                .get("/api/consumers/list")
                .then(response => {
                    this.listConsumer = response.data.data;
                    this.consumer_array = response.data.data.map(a => {
                        return { text: a.nom + " " + a.prenom, id: a.id };
                    });
                })
                .catch(() => console.warn("Oh. Something went wrong"));
        },
        loadshippings() {
            axios
                .get("/api/shippings/list")
                .then(response => {
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
        editModal(order) {
            this.editmode = true;
            this.form.reset();
            $("#addNew").modal("show");
            this.form.fill(order);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $("#addNew").modal("show");
        },
        close() {
            this.$router.push({ name: "order.index" });
        },
        createorder() {
            this.$Progress.start();
            this.form
                .post("/api/order")
                .then(data => {
                    if (data.data.success) {
                        //$('#addNew').modal('hide');

                        Toast.fire({
                            icon: "success",
                            title: data.data.message
                        });
                        this.$Progress.finish();
                        vm.$forceUpdate();
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: "Some error occured! Please try again"
                        });

                        this.$Progress.failed();
                    }
                })
                .catch(() => {
                    Toast.fire({
                        icon: "error",
                        title: "Some error occured! Please try again"
                    });
                });
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
                    //  Fire.$emit('AfterCreate');

                    this.loadorders();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
        addProduit() {
            this.form.rows.push({
                id: this.form.rows.length,
                active: 0,
                product: null,
                unit_cost: 0,
                quantity: 0,
                sub_total: 0
            });
        },
        deleteProduit(row) {
            this.form.rows.splice(row, 1);
            this.form.subTotal = this.form.rows.reduce(function(
                previous,
                current
            ) {
                return previous + current.sub_total;
            },
            0);
            this.form.total = this.form.subTotal + this.form.sell_shipping_cost;
        },
        randomNumber: function() {
            this.form.shipping_numero =
                "CA" + Math.floor(Math.random() * (999999999 - 1 + 1)) + 1;
        },
        // r

        quantityHandler(index) {
            this.form.rows[index].sub_total =
                this.form.rows[index].quantity *
                this.form.rows[index].unit_cost;
            this.form.subTotal = this.form.rows.reduce(function(
                previous,
                current
            ) {
                return previous + current.sub_total;
            },
            0);
            this.form.total = this.form.subTotal + this.form.sell_shipping_cost;
        }
    },
    mounted() {
        this.loadProducts();
        this.loadconsumers();
        this.loadshippings();
        this.loadSources();
    },
    created() {
        this.$Progress.start();
        this.$Progress.finish();
    },
    watch: {
        "form.consumer_id": function(v) {
            let user = null;
            _(this.listConsumer).forEach(function(chr) {
                if (chr.id == v) {
                    user = chr;
                }
            });
            this.form.consumer.nom = user.nom;
            this.form.consumer.prenom = user.prenom;
            this.form.consumer.adresse = user.adresse;
            this.form.consumer.ville = user.ville;
            this.form.consumer.phone = user.phone;
        },
        "form.shipping_id": function(v) {
            let user = null;
            _(this.listShipping).forEach(function(chr) {
                if (chr.id == v) {
                    user = chr;
                }
            });
            this.randomNumber();
            this.form.shipping_cost = user.price;
        }
    }
};
</script>
