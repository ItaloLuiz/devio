<template>
  <div></div>
</template>

<script>
//const urlList = "http://127.0.0.1:8000/api/products";
const urlPostCart = "http://127.0.0.1:8000/api/cart";

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
     
      this.axios.get(urlPostCart).then((response) => {
        this.items = response.data;
      });
    },
  },
};
</script>
