<template>
    <section class="content">
        <div class="p-a white lt box-shadow">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0 _300">Overview</h4>
                    <small class="text-muted"
                        >cod<strong>marrakech</strong>
                    </small>
                </div>
            </div>
        </div>
        <div class="padding">
            <div class="row">
                <div class="col-xs-12 col-sm">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            <span class="w-48 rounded  accent">
                                <i class="material-icons">&#xe151;</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-0 text-lg _300">
                                {{ this.total_orders }}
                            </h4>
                            <small class="text-muted"
                                >Total <br />
                                orders</small
                            >
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            <span class="w-48 rounded primary">
                                <i class="material-icons">&#xe54f;</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-0 text-lg _300">
                                {{ this.total_sales }}
                            </h4>
                            <small class="text-muted"
                                >Total <br />
                                sales</small
                            >
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            <span class="w-48 rounded warn">
                                <i class="material-icons">&#xe8d3;</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-0 text-lg _300">
                                {{ this.in_progress_orders }}
                            </h4>
                            <small class="text-muted"
                                >In progress <br />
                                orders</small
                            >
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            <span class="w-48 rounded primary">
                                <i class="material-icons">&#xe54f;</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-0 text-lg _300">
                                {{ this.confirmed_orders }}
                            </h4>
                            <small class="text-muted"
                                >Confirmed <br />
                                orders</small
                            >
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            <span class="w-48 rounded warn">
                                <i class="material-icons">&#xe8d3;</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-0 text-lg _300">
                                {{ this.delivred_orders }}
                            </h4>
                            <small class="text-muted"
                                >Delivered <br />
                                orders</small
                            >
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            <span class="w-48 rounded warn">
                                <i class="material-icons">&#xe8d3;</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-0 text-lg _300">
                                {{ this.payed_orders }}
                            </h4>
                            <small class="text-muted"
                                >Payed <br />
                                orders</small
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
        this.loadDashboard();
    },
    data() {
        return {
            total_orders: null,
            total_sales: null,
            confirmed_orders: null,
            in_progress_orders: null,
            delivred_orders: null,
            payed_orders: null
        };
    },
    methods: {
        loadDashboard() {
            axios
                .get("/api/dashboard")
                .then(response => {
                    this.total_orders = response.data.data.total_orders;
                    this.total_sales = response.data.data.total_sales;
                    this.confirmed_orders = response.data.data.confirmed_orders;
                    this.in_progress_orders =
                        response.data.data.in_progress_orders;
                    this.delivred_orders = response.data.data.delivred_orders;
                    this.payed_orders = response.data.data.payed_orders;
                    console.log(response);
                })
                .catch(() => console.warn("Oh. Something went wrong"));
        }
    }
};
</script>
