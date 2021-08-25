<template>
    <section class="content">
        <div class="container-fluid">
            <form @submit.prevent="createsource()" class="row">
                <div class="col-6 m-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">source</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <div class="modal-body row  m-0 p-0">
                                <div class="form-group col-12">
                                    <label>source Status</label>
                                    <select
                                        class="form-control"
                                        v-model="form.status"
                                    >
                                        <option
                                            v-for="cat in source_liste"
                                            :key="cat"
                                            :value="cat"
                                            :selected="cat == form.status"
                                            >{{ cat }}</option
                                        >
                                    </select>
                                    <has-error
                                        :form="form"
                                        field="status"
                                    ></has-error>
                                </div>
                                <div class="form-group col-12">
                                    <label>platform</label>
                                    <select
                                        class="form-control"
                                        v-model="form.type"
                                    >
                                        <option
                                            v-for="cat in type_liste"
                                            :key="cat"
                                            :value="cat"
                                            :selected="cat == form.type"
                                            >{{ cat }}</option
                                        >
                                    </select>
                                    <has-error
                                        :form="form"
                                        field="type"
                                    ></has-error>
                                </div>
                                <div class="form-group col-12">
                                    <label>Name</label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.errors.has(
                                                'name'
                                            )
                                        }"
                                    />
                                    <has-error
                                        :form="form"
                                        field="name"
                                    ></has-error>
                                </div>
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="btn btn-primary col-6 mx-auto my-3"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            editmode: false,
            source_liste: ["active", "blocked"],
            type_liste: [
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
                name: "",
                type: "",
                status: ""
            })
        };
    },
    methods: {
        createsource() {
            this.$Progress.start();
            this.form
                .post(this.$app_url + "/api/source")
                .then(res => {
                    Toast.fire({
                        icon: "success",
                        title: res.data.message
                    });
                    this.$Progress.finish();
                    vm.$forceUpdate();
                })
                .catch(() => {
                    Toast.fire({
                        icon: "error",
                        title: "Some error occured! Please try again"
                    });
                });
        }
    }
};
</script>
