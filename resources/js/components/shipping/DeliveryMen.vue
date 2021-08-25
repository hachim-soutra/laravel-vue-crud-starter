<template>
    <section class="content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link to="/shippings/men">delivery Men</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ shipping.name }}
                </li>
            </ol>
        </nav>
        <div class="container-fluid">
            <div class="item">
                <div class="item-bg">
                    <img
                        :src="$app_url + '/assets/images/a1.jpg'"
                        class="blur opacity-3"
                    />
                </div>
                <div class="p-a-md">
                    <div class="row m-t">
                        <div class="col-sm-7">
                            <a href class="pull-left m-r-md">
                                <span class="avatar w-96">
                                    <img
                                        :src="
                                            $app_url + '/assets/images/a1.jpg'
                                        "
                                    />
                                    <i class="on b-white"></i>
                                </span>
                            </a>
                            <div class="clear m-b">
                                <h3 class="m-0 m-b-xs">{{ shipping.name }}</h3>
                                <p class="text-muted">
                                    <span class="m-r">
                                        {{ shipping.phone }}<br />
                                        {{ shipping.email }}
                                    </span>
                                    <small>
                                        <i class="fa fa-map-marker m-r-xs"></i>
                                        {{ shipping.city || "city" }}</small
                                    >
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dker p-x">
                <div class="row">
                    <div class="col-10">
                        <div class="p-y-md clearfix nav-active-primary">
                            <ul class="nav nav-pills nav-sm">
                                <li
                                    class="nav-item"
                                    @click="tab = 1"
                                    :class="{ active: tab == 1 }"
                                >
                                    <a class="nav-link">Orders reportie</a>
                                </li>
                                <li
                                    class="nav-item"
                                    @click="tab = 2"
                                    :class="{ active: tab == 2 }"
                                >
                                    <a class="nav-link">Pas de reponse</a>
                                </li>
                                <li
                                    class="nav-item"
                                    @click="tab = 3"
                                    :class="{ active: tab == 3 }"
                                >
                                    <a class="nav-link">Annuler</a>
                                </li>
                                <li
                                    class="nav-item"
                                    @click="tab = 4"
                                    :class="{ active: tab == 4 }"
                                >
                                    <a class="nav-link">Livré</a>
                                </li>
                                <li
                                    class="nav-item"
                                    @click="tab = 5"
                                    :class="{ active: tab == 5 }"
                                >
                                    <a class="nav-link">Payé</a>
                                </li>
                                <li
                                    class="nav-item"
                                    @click="tab = 6"
                                    :class="{ active: tab == 6 }"
                                >
                                    <a class="nav-link">New</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="padding px-0">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-9">
                        <div>
                            <div class=" " v-if="tab == 1">
                                <OrderReportie type="PROCESSED"></OrderReportie>
                            </div>
                            <div class="" v-if="tab == 2">
                                <OrderPasReponse
                                    type="NO ANSWER"
                                ></OrderPasReponse>
                            </div>
                            <div class="" v-if="tab == 3">
                                <OrderAnnuler type="CANCELED"></OrderAnnuler>
                            </div>
                            <div class="" v-if="tab == 4">
                                <OrderLivre type="CLOSED"></OrderLivre>
                            </div>
                            <div class="" v-if="tab == 5">
                                <OrderPaye type="PAID"></OrderPaye>
                            </div>
                            <div class="" v-if="tab == 6">
                                <OrderNew type="NEW"></OrderNew>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="box">
                            <div class="box-header">
                                <h2>Statistique</h2>
                            </div>
                            <div class="box-divider m-0"></div>
                            <ul class="list no-border p-b">
                                <li class="list-item">
                                    <div class="list-body">
                                        <div><h3>Orders reportie</h3></div>
                                        <small
                                            class="text-muted text-ellipsis"
                                            >{{
                                                shipping.order_reportie
                                            }}</small
                                        >
                                    </div>
                                </li>
                                <li class="list-item">
                                    <div class="list-body">
                                        <div><h3>Annuler</h3></div>
                                        <small
                                            class="text-muted text-ellipsis"
                                            >{{ shipping.order_annuler }}</small
                                        >
                                    </div>
                                </li>
                                <li class="list-item">
                                    <div class="list-body">
                                        <div><h3>Payé</h3></div>
                                        <small
                                            class="text-muted text-ellipsis"
                                            >{{ shipping.order_paye }}</small
                                        >
                                    </div>
                                </li>
                                <li class="list-item">
                                    <div class="list-body">
                                        <div><h3>Livré</h3></div>
                                        <small
                                            class="text-muted text-ellipsis"
                                            >{{ shipping.order_livre }}</small
                                        >
                                    </div>
                                </li>
                                <li class="list-item">
                                    <div class="list-body">
                                        <div><h3>Pas de reponse</h3></div>
                                        <small
                                            class="text-muted text-ellipsis"
                                            >{{
                                                shipping.order_pas_reponse
                                            }}</small
                                        >
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import OrderLivre from "./tableau/OrderLivre";
import OrderPaye from "./tableau/OrderPaye";
import OrderAnnuler from "./tableau/OrderAnnuler";
import OrderPasReponse from "./tableau/OrderPasReponse";
import OrderReportie from "./tableau/OrderReportie";
import OrderNew from "./tableau/OrderNew";
export default {
    components: {
        OrderPaye,
        OrderLivre,
        OrderAnnuler,
        OrderPasReponse,
        OrderReportie,
        OrderNew
    },
    data() {
        return {
            tab: 1,
            editmode: false,
            shipping: {},
            orders: {},
            url: this.$app_url + "/api/shipping/" + this.$route.params.id,
            status_array: ["active", "blocked"],
            consumer_array: null,
            listConsumer: [],
            product_array: null,
            form: new Form({
                id: "",
                quantity: "",
                subTotal: "",
                total: "",
                status: "",
                consumer: {
                    nom: "",
                    prenom: "",
                    adresse: "",
                    ville: "",
                    phone: ""
                },
                rows: [
                    {
                        id: 1,
                        active: 0,
                        product: null,
                        unit_cost: 0,
                        quantity: 0,
                        sub_total: 0
                    }
                ],
                shipping_id: null,
                shipping_numero: null,
                shipping_cost: null,
                sell_shipping_cost: null,
                delivery_note: null,
                note: null,
                product_id: "",
                consumer_id: ""
            })
        };
    },
    methods: {
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
                .post("api/order")
                .then(data => {
                    if (data.data.success) {
                        $("#addNew").modal("hide");

                        Toast.fire({
                            icon: "success",
                            title: data.data.message
                        });
                        this.$Progress.finish();
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
                .put("api/order/" + this.form.id)
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
        },
        loadshipping(url) {
            console.log(url);
            // if(this.$gate.isAdmin()){
            axios.get(url).then(data => {
                console.log(data);
                this.shipping = data.data.data;
            });
            // }
        },
        loadorders(url) {
            // if(this.$gate.isAdmin()){
            axios.get(url).then(({ data }) => (this.orders = data.data));
            // }
        },
        insertParam: function(key, value, url) {
            var urlL = new URL(url);
            urlL.searchParams.append(key, value);
            urlL.searchParams.set(key, value);
            return urlL;
        },
        search: function() {
            var url = this.insertParam("search", this.search_term, this.url);
            this.loading = true;
            this.loadorders(url);
        }
    },
    mounted() {},
    created() {
        this.$Progress.start();
        this.loadshipping(this.url);
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
        }
    }
};
</script>
