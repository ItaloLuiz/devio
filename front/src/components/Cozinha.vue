<template>
  <div>
    <h1 class="text-center page-header m-b-60">Pedidos</h1>

    <!--loop-->
    <table class="table">
      <thead>
        <tr>
          <th>ID do carrinho</th>
          <th>Nome do cliente</th>
          <th>Contato cliente</th>
          <th>Forma de pagamento</th>
          <th>Troco</th>
          <th>Endereço do cliente</th>
          <th>Observações do cliente</th>
          <th>Status do pedido</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>

        <tr v-for="item in items"  v-bind:key="item.id">
          <td>{{ item.id_carrinho }} </td>
          <td>{{ item.nome_cliente }} </td>
          <td>{{ item.contato_cliente }} </td>
          <td>{{ item.forma_pagamento }} </td>
          <td>{{ item.troco_cliente }} </td>
          <td>{{ item.endereco_cliente }} </td>
          <td>{{ item.obs_cliente }} </td>
          <td>{{ item.status_pedido }} </td>
          <td style="width:250px">
           <form name="form" id="form" v-on:submit.prevent="updatePedido($event)">
          
             <input type="hidden" name="id" id="id" :value="item.id" class="form-control">
              <input type="hidden" name="id_carrinho" id="id_carrinho" :value="item.id_carrinho" class="form-control">
            
            <select v-on:change="entrega($event)" :model="entrega" name="mudar_status" id="mudar_status" class="form-control">
                 <option value="">Selecione</option>
                 <option value="saiu_para_entrega">Saiu para entrega</option>
                 <option value="entregue">Entregue</option>
                 <option value="cancelado">Cancelado</option>                
            </select>
              
              <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
           
            </form>
          </td>
        </tr>
      </tbody>
    </table>
    <!--loop-->

    <div id="footer" class="container">
      <div class="row">
        <div class="col-md-12">
          <p>Mundo Pizza</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const urlList = "http://127.0.0.1:8000/api/pedidos";
const urlPostCart = "http://127.0.0.1:8000/api/pedidos";

export default {
  data() {
    return {
      items: [],
     
      
    };
  },
    created: function() {
    this.fetchItems();
        
  },

  methods: {
    fetchItems() {
      this.axios
        .get(urlList)
        .then((response) => {
          let res = response.data.data;
          this.items = res;
          console.log(res);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    entrega(event){
      let valor = event.target.value;
      console.log(valor)   
    },
    updatePedido(event){
        //console.log(event)
        const id = this.id = event.target.elements.id.value;
        const id_carrinho = this.id_carrinho = event.target.elements.id_carrinho.value;
        const status_pedido = this.mudar_status = event.target.elements.mudar_status.value;
        console.log(id_carrinho)
        console.log(status_pedido)


        let reqData = "id_carrinho=" + id_carrinho + "&status_pedido="+ status_pedido;
        console.log(reqData)
        this.axios({
          method: "put",
          url: urlPostCart+'/'+id,
          withCredentials: false,
          crossdomain: true,
          data: reqData,
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
        })
          .then(function(response) {
            let status = response;
            let msg    = response.data.message;
            console.log(msg);
            console.log(status);
            //alert(msg)

            document.location.reload(true);
            
          })
          .catch(function(error) {
            console.log("Post Error : " + error);
          });




    }
   
  },
};
</script>

<style scoped>
.m-b-20 {
  margin-bottom: 20px;
}
.m-b-60 {
  margin-bottom: 60px;
}

#footer {
  margin-top: 60px;
  border-top: solid 1px #ccc;
  padding-top: 10px;
}
</style>
