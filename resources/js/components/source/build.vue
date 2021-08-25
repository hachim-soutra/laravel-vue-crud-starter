<template>
    <section class="content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link to="/sources">source</router-link>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    integration
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ source.name }}
                </li>
            </ol>
        </nav>
        <div class="container-fluid">
            <!-- ############ PAGE START-->
            <div class="row">
                <div class="col-sm-8 col-md-9">
                    <h4 class="m-0 m-b-sm text-md">Quick support</h4>
                    <div class="m-b" id="accordion">
                        <div class="panel box no-border m-b-xs">
                            <div class="box-header p-y-sm">
                                <a
                                    data-toggle="collapse"
                                    data-parent="#accordion"
                                    data-target="#c_1"
                                >
                                    Q: add your source link
                                </a>
                            </div>
                            <div id="c_1" class="collapse in">
                                <div class="box-body">
                                    <p class="text-sm text-muted">
                                        <span
                                            class="text-md pull-left w-32 m-r rounded success"
                                            >A</span
                                        >
                                        <code class=" language-markup">
                                            <span class="token tag">
                                                <span class="token tag">
                                                    <span
                                                        class="token punctuation"
                                                        >&lt;</span
                                                    >
                                                    form
                                                </span>
                                                <span class="token attr-name">
                                                    action="{{
                                                        this.$app_url
                                                    }}/api/order/{{
                                                        source.token
                                                    }}/store" method="post"
                                                </span>
                                            </span>
                                        </code>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel box no-border m-b-xs">
                            <div class="box-header p-y-sm">
                                <a
                                    data-toggle="collapse"
                                    data-parent="#accordion"
                                    data-target="#c_2"
                                >
                                    Q: add consumer info
                                </a>
                            </div>
                            <div id="c_2" class="collapse">
                                <div class="box-body">
                                    <p class="text-sm text-muted">
                                        <code class=" language-markup">
                                            <span class="token tag">
                                                <span class="token tag">
                                                    <span
                                                        class="token punctuation"
                                                        >&lt;</span
                                                    >
                                                    input
                                                </span>

                                                <span class="token attr-name">
                                                    name="phone" type="text"
                                                </span>
                                            </span>
                                        </code>
                                        <br />
                                        <br />
                                        <code class=" language-markup">
                                            <span class="token tag">
                                                <span class="token tag">
                                                    <span
                                                        class="token punctuation"
                                                        >&lt;</span
                                                    >
                                                    input
                                                </span>

                                                <span class="token attr-name">
                                                    name="ville" type="text"
                                                </span>
                                            </span>
                                        </code>
                                        <br />
                                        <br />
                                        <code class=" language-markup">
                                            <span class="token tag">
                                                <span class="token tag">
                                                    <span
                                                        class="token punctuation"
                                                        >&lt;</span
                                                    >
                                                    input
                                                </span>

                                                <span class="token attr-name">
                                                    name="adresse" type="text"
                                                </span>
                                            </span>
                                        </code>
                                        <br />
                                        <br />
                                        <code class=" language-markup">
                                            <span class="token tag">
                                                <span class="token tag">
                                                    <span
                                                        class="token punctuation"
                                                        >&lt;</span
                                                    >
                                                    input
                                                </span>
                                                <span class="token attr-name">
                                                    name="prenom" type="text"
                                                </span>
                                            </span>
                                        </code>
                                        <br />
                                        <br />
                                        <code class=" language-markup">
                                            <span class="token tag">
                                                <span class="token tag">
                                                    <span
                                                        class="token punctuation"
                                                        >&lt;</span
                                                    >
                                                    input
                                                </span>

                                                <span class="token attr-name">
                                                    name="nom" type="text"
                                                </span>
                                            </span>
                                        </code>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel box no-border m-b-xs">
                            <div class="box-header p-y-sm">
                                <a
                                    data-toggle="collapse"
                                    data-parent="#accordion"
                                    data-target="#c_3"
                                >
                                    Q: add produit
                                </a>
                            </div>
                            <div id="c_3" class="collapse">
                                <div class="box-body">
                                    <p class="text-sm text-muted">
                                    <div class="form-group col-4">
                                        <label>product</label>
                                        <select
                                            class="form-control"
                                            v-model="product"
                                        >
                                            <option
                                                v-for="cat in product_array"
                                                :key="cat.id"
                                                :value="cat.id"
                                                :selected="
                                                    cat.id == product
                                                "
                                                >{{ cat.text }}</option
                                            >
                                        </select>
                                    </div>
                                        <code class=" language-markup">
                                            <span class="token tag">
                                                <span class="token tag">
                                                    <span
                                                        class="token punctuation"
                                                        >&lt;</span
                                                    >
                                                    input
                                                </span>

                                                <span class="token attr-name">
                                                    name="produit_id"
                                                    type="text"
                                                    value="{{product}}"
                                                </span>
                                            </span>
                                        </code>
                                        <br />
                                        <br />
                                        <code class=" language-markup">
                                            <span class="token tag">
                                                <span class="token tag">
                                                    <span
                                                        class="token punctuation"
                                                        >&lt;</span
                                                    >
                                                    input
                                                </span>

                                                <span class="token attr-name">
                                                    name="quantity" type="number"
                                                </span>
                                            </span>
                                        </code>
                                        <br />
                                        <br />
                                        <code class=" language-markup">
                                            <span class="token tag">
                                                <span class="token tag">
                                                    <span
                                                        class="token punctuation"
                                                        >&lt;</span
                                                    >
                                                    select
                                                </span>

                                                <span class="token attr-name">
                                                    name="offre"
                                                </span>
                                            </span>
                                        </code>
                                        <br />
                                        <br />
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="m-b">
                        <p>
                            <i
                                class="fa fa-fw text-muted m-r-xs fa-envelope"
                            ></i>
                            contact@company.com
                        </p>
                        <p>
                            <i class="fa fa-fw text-muted m-r-xs fa-phone"></i>
                            (432) 999 000
                        </p>
                        <p>
                            <i
                                class="fa fa-fw text-muted m-r-xs fa-clock-o"
                            ></i>
                            Mon-Fri 9:00 - 16:00
                        </p>
                    </div>
                </div>
            </div>
            <!-- ############ PAGE END-->
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            source: {},
            product_array: [],
            product: null
        };
    },
    mounted() {
        let url = this.$app_url + "/api/source/" + this.$route.params.id;
        this.loadSource(url);
        this.loadProducts();
    },
    methods: {
        loadSource(url) {
            axios.get(url).then(data => {
                this.source = data.data.data;
            });
        },
        loadProducts() {
            axios
                .get(this.$app_url + "/api/products/list")
                .then(response => {
                    this.product_array = response.data.data.map(a => {
                        return { text: a.name, id: a.id, offres: a.offres };
                    });
                })
                .catch(() => console.warn("Oh. Something went wrong"));
        }
    }
};
</script>
