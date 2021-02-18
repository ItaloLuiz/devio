<template>
  <div>
    <h1 class="text-center page-header m-b-60">Mundo Pizza</h1>

    <div class="cart" v-on:click="mostrarDivCart()">
     carrinho <strong>{{ qtdaItensCart }}</strong>
    </div>

    <div v-if="showCart" id="mostrarItensCarrinho">
      <div class="carrinho">
       <div v-on:click="ocultarDivCart()" class="fecharCarrinho" title="Fechar carrinho"> x </div>    
       <span><strong>{{ qtdaItensCart }}</strong> itens(s) no Carrinho </span>  
      </div>

      <div id="renderizar-itens-carrinho">

        <div v-for="(cart,index) in itensCart"  v-bind:key="cart.id"  class="itens-carrinho">
           <div  class="imagem-carrinho">
            <img  :src="'http://localhost/foodapi/public/storage/produtos/'+cart.imagem_produto"/>
           </div>

           <div class="titulo-item-carrinho">
              {{ cart.nome_produto }}
           </div>

           <div class="remover-tem-carrinho">
             <button v-on:click="removeItem(cart.id,cart.valor_produto),itensCart.splice(index, 1)" class="btn btn-danger btn-remover">Remover</button>
           </div>
       </div>

      </div>

      <div class="abrir-checkout">
       <div class="total-compra">Total: <strong>{{ calcSum }}</strong></div>
       <button v-on:click="ocultarDivCart(),mostraCheckout()" type="button" class="btn btn-success btn-sm">Ir para o checkout</button>        
      </div>
    </div>

    <div v-if="showCheckout" id="checkout">
     <div v-on:click="ocultarCheckout()" class="ocultar-checkout" title="Fechar Checkout">x</div>
       <div class="checkout">
          <form name="form" id="form" v-on:submit.prevent="cadastrarPedido($event)">

            <div class="form-group">
              <label>Seu nome</label>
              <input type="text" name="nome" id="nome" :model="nome" class="form-control">
            </div>

            <div class="form-group">
              <label>Seu Telefone</label>
              <input type="text" name="celular" id="celular" :model="contato" class="form-control">
            </div>

            <div class="form-group">
              <label>Endereço para entrega</label>
              <input type="text" name="endereco_cliente" id="endereco_cliente" :model="endereco_cliente" class="form-control">
            </div>

            <div class="form-group">
              <label>Forma de pagamento</label>
              <select v-on:change="tipoPagamento($event)" name="forma_pgto" id="forma_pgto" class="form-control" :model="forma_pgto">
                <option disabled>Selecione</option>
                <option value="dinheiro" >Dinheiro</option>
                <option value="cartao_credito">Cartão de crédito</option>
                <option value="cartao_debito">Cartão de Débito</option>
              </select>
            </div>

            <div v-if="pagamento_dinheiro" class="form-group">
              <label>Levar troco para:</label>
              <input type="text" name="troco" id="troco" :model="troco" :value="0" class="form-control">
            </div>
             <div v-else class="form-group">
             
              <input type="hidden" name="troco" id="troco" :model="troco" :value="0" class="form-control">
            </div>

            <div class="form-group">
              <label>Observação</label>
              <textarea name="obs" id="obs" class="form-control" :model="obs"></textarea>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
            </div>


          </form>
       </div>
    </div>

    <!--loop-->
    <div class="row">
    <div v-for="item in items"
         v-bind:key="item.id"
      class="col-md-3 col-sm-6">

        <div class="box-pizza box-shadow-inverse">
          <figure>
            <img  :src="'http://localhost/foodapi/public/storage/produtos/'+item.imagem_produto"/> 
          </figure>
          <div class="conteudo">
            <div class="row">
              <div class="col-md-12 titulo-pizza m-b-20">
                <h3 class="text-capitalize">{{ item.nome_produto }}</h3>
              </div>
             <div class="col-md-7 preco-pizza">
                <h4>R$ {{ item.valor_produto }}</h4>
              </div>
             <div class="col-md-5 btn-pizza">
                  <button  class="btn btn-primary btn-sm btn-block" v-on:click.prevent="addCart(item.id,item.valor_produto),fetchItems(),getCart();">Comprar</button>
              </div>
            </div>
          
          </div>        
        </div>


    </div>
    </div>
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
const urlList = "http://127.0.0.1:8000/api/products";
const urlPostCart = "http://127.0.0.1:8000/api/cart";
const urlCart     = "http://127.0.0.1:8000/api/cart";
const urlCadastroPedido = 'http://127.0.0.1:8000/api/pedidos';

export default {


  data() {
    return {
      items: [],
      item: {},
      itensCart: [],
      name: '',
      qtdaItensCart: '',
      showCart: false,
      showCheckout: false,
      forma_pgto: {
        dinheiro:'',
        cartao_debito:'',
        cartao_credito:''
      },
      pagamento_dinheiro: false,
      nome:'',
      contato:'',
      troco:0,
      obs:'',
      endereco_cliente: '',
      identificar_carrinho: 'clientes_estatico'
     
      
    };
  },

  created: function() {
    this.fetchItems();
    this.getCart();    
  },
  computed: {
    calcSum(){
      let total = 0;
      this.itensCart.forEach((item) => {
          total += item.valor_produto * 1;
      });
      return total;
    }
  },

  methods: {  
      fetchItems() {
        this.axios
          .get(urlList)
          .then((response) => {
            let res = response.data.data;
            this.items = res;
            //console.log(res);
          })
          .catch(function(error) {
            console.log(error);
          });
      },
    addCart(item,valor){
        let id_produto = item;
        
        let reqData = "id=" + id_produto + "&identificar_carrinho="+ this.identificar_carrinho;
        console.log(reqData)
        this.axios({
          method: "post",
          url: urlPostCart,
          withCredentials: false,
          crossdomain: true,
          data: reqData,
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
        })
          .then(function(response) {
            let status = response.data.error;
            let msg    = response.data.message;
            console.log(msg);
            console.log(status);
            //alert(msg)
            
          })
          .catch(function(error) {
            console.log("Post Error : " + error);
          });

          this.totalCarrinho + valor
    },

    getCart(){
        this.axios
          .get(urlCart)
          .then((response) => {
            let res = response.data;
            this.itensCart = res;
            this.qtdaItensCart = res.length;
            //console.log(res);
          })
          .catch(function(error) {
            console.log(error);
          }); 
    },


   
    removeItem(item,valor) {

      this.showList = false; 
       let id_produto = item;
       let reqData = "id=" + id_produto;
       this.qtdaItensCart = this.qtdaItensCart -1      

      this.axios({
        method: "delete",
        url: "http://127.0.0.1:8000/api/cart/" + id_produto,
        withCredentials: false,
        crossdomain: true,
        data: reqData,
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      })
        .then(function(response) {
          let status = response.data.error;
          let msg = response.data.message;
          let id   = response.data.id;
          console.log(msg);
          console.log(status);
          console.log(id)
          
          
        })
        .catch(function(error) {
          console.log("Post Error : " + error);
        });

        this.totalCarrinho - valor
        
    },

    mostrarDivCart(){
       this.showCart = true;
    },
    ocultarDivCart(){
     this.showCart = false; 
    },

    mostraCheckout()
    {
      this.showCheckout = true;
    },
      ocultarCheckout()
    {
      this.showCheckout = false;
    },
    tipoPagamento(event){
      let valor = event.target.value;
      if(valor == 'dinheiro'){
        this.pagamento_dinheiro = true
      }else{
        this.pagamento_dinheiro = false
      }
    },

    cadastrarPedido(event){
      const nome_cliente = this.nome = event.target.elements.nome.value;
      const contato_cliente = this.celular = event.target.elements.celular.value;
      const forma_pagamento_cliente = this.forma_pgto = event.target.elements.forma_pgto.value;
      const troco_cliente = this.troco = event.target.elements.troco.value;
      const obs_cliente   = this.obs = event.target.elements.obs.value;
      const carrinho_cliente = this.identificar_carrinho;
      const endereco_cliente = this.endereco_cliente = event.target.elements.endereco_cliente.value;

     console.log(nome_cliente)
     console.log(contato_cliente)
     console.log(forma_pagamento_cliente)
     console.log(troco_cliente)
     console.log(obs_cliente)
     console.log(carrinho_cliente)

    

    let reqData = "id_carrinho=" + carrinho_cliente+'&'
       + "nome_cliente=" + nome_cliente+'&'
       + "contato_cliente=" + contato_cliente+'&'
        + "forma_pagamento=" + forma_pagamento_cliente+'&'
       + "troco_cliente=" + troco_cliente+'&'
       + "obs_cliente=" + obs_cliente+'&'
        + "endereco_cliente=" + endereco_cliente+'&'
        +"status_pedido=aguardando"

        //console.log(reqData)

     this.axios({
          method: "post",
          url: urlCadastroPedido,
          withCredentials: false,
          crossdomain: true,
          data: reqData,
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
        })
          .then(function(response) {
            let status = response.data.error;
            let msg    = response.data.message;
            console.log(msg);
            console.log(status);
            alert(msg)
            
          })
          .catch(function(error) {
            console.log("Post Error : " + error);
        });
     
    }


  },


};
</script>



<style scoped>
.m-b-20{
    margin-bottom:20px;
}
.m-b-60{
    margin-bottom:60px;
}

.box-pizza{
    border:solid 1px #ccc;    
    border-radius:4px;
    display:block;
    margin-bottom:10px;
    overflow:hidden;
    
}

figure{
    width:100%;
    height:140px;
    position:relative;
    object-fit: cover;
    margin-bottom:0;   
      
}

figure img{
    width:100%;
    height:100%;
    position:relative;
    border-top-left-radius:4px;
    border-top-right-radius:4px;
}

.conteudo{
    width:100%;
    height:100%;
    position:relative;
    padding:6px;
    
    border-bottom-left-radius:4px;
    border-bottom-right-radius:4px;
}
.conteudo h3{
    margin:0;
    padding:0;
    font-size:22px;
}

.preco-pizza h4{
    font-size:20px;
    color:green;
}

#footer{
    margin-top:60px;
    border-top:solid 1px #ccc;
    padding-top:10px;
}

.cart{
    position:fixed;
    top:60px;
    right:120px;
    background-color:#ddd;
    border:solid 1px #ccc;
    cursor:pointer;
    padding:15px;
    border-radius:4px;
    z-index:5;
}

#mostrarItensCarrinho{
  width:300px;
  height:100vh;
  background-color:#ddd;
  position:fixed;
  top:0;
  right:0;
  z-index:5;
  overflow:hidden;
}

.carrinho{
   padding:15px;
   background-color:#fff;
   margin-bottom:15px;
}
.fecharCarrinho{
  color:red;
  font-size:18px;
  font-weight:bold;
  cursor:pointer;
  position:relative; 
  
  
}
.abrir-checkout{
  width:100%;
  height:auto;
  padding:10px;
  position:absolute;
  bottom:0;
}



.itens-carrinho{
  border:solid 1px #ccc;  
  padding:5px;
  border-radius:2px;
  background-color:#fff;
  margin-bottom:5px;
  position:relative;  
  display:flex;
  align-items: center;
  text-transform:capitalize;

}

#renderizar-itens-carrinho{
  width:100%;
  height:75vh;
  overflow:hidden;
  overflow-y:scroll;
  padding:5px;
}
.imagem-carrinho{
  position:relative;
  margin-right:5px;
}
.imagem-carrinho img{
  width:50px;
}

.btn-remover{
  padding:2px;
  position:absolute;
  font-size:12px;
  right:5px;
  top:11px;

}

.showList{
  background-color:red !important;
}

#checkout{
  width:65vh;
  height:100vh;
  background-color:#eee;
  padding:15px;
  position:fixed;
  z-index:10;
  display:block;
  top:0;
  left:0;
  
}
.ocultar-checkout{
  border-bottom:solid 1px #ccc;
  padding-bottom:5px;
  margin-bottom:25px;
  font-weight:bold;
  color:red;
  cursor:pointer;
}
</style>