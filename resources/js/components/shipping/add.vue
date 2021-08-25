<template>
    <section class="content">


    </section>
</template>

<script>
    export default {

        data () {
            return {
                editmode: false,
                orders : {},
                status_array: ['active','blocked'],
                consumer_array: null,
                listConsumer: [],
                product_array: null,
                form: new Form({
                    id      : '',
                    quantity : '',
                    subTotal  : '',
                    total : '',
                    status  : '',
                    consumer  : {
                      nom     : '',
                      prenom  : '',
                      adresse : '',
                      ville   : '',
                      phone   : '',
                    },
                    rows: [
                      {id: 1, active: 0,product: null, unit_cost: 0, quantity: 0, sub_total: 0 }
                    ],
                    shipping_id: null,
                    shipping_numero: null,
                    shipping_cost: null,
                    sell_shipping_cost: null,
                    delivery_note: null,
                    note: null,
                    product_id   : '',
                    consumer_id   : '',
                }),

            }
        },
        methods: {
          loadProducts(){
            axios.get("/api/products/list").then(response => {
                  this.product_array = response.data.data.map(a => {
                      return { text: a.name, id: a.id };
                  });
              }).catch(() => console.warn('Oh. Something went wrong'));
          },
          loadconsumers(){
            axios.get("/api/consumers/list").then(response => {

              this.listConsumer = response.data.data;
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
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          close(){
            this.$router.push({name:"order.index"})
          },
          createorder(){
              this.$Progress.start();
              this.form.post('api/order')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
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
          updateorder(){
              this.$Progress.start();
              this.form.put('api/order/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
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
          addProduit(){
             this.form.rows.push(
                {id: this.form.rows.length, active: 0,product: null, unit_cost: 0, quantity: 0, sub_total: 0 }
             );
          },
          deleteProduit(row){
           this.form.rows.splice(row,1);
          }

        },
        mounted() {
            this.loadProducts();
            this.loadconsumers();
        },
        created() {
            this.$Progress.start();
            this.$Progress.finish();
        },
        watch:{
          'form.consumer_id' : function (v) {
            let user = null;
              _(this.listConsumer).forEach(function(chr) {
                 if(chr.id == v){
                   user = chr;
                 }
               });
                  this.form.consumer.nom     = user.nom;
                  this.form.consumer.prenom  = user.prenom;
                  this.form.consumer.adresse = user.adresse;
                  this.form.consumer.ville   = user.ville;
                  this.form.consumer.phone   = user.phone;
          }
        }
    }
</script>
