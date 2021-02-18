<template>
  <div id="app" class="container">
    <nav class="navbar navbar-expand-sm bg-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link :to="{ name: 'Home' }" class="nav-link">Home</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'Cozinha' }" class="nav-link">Cozinha</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'Cart' }" class="nav-link">Carrinho</router-link>
        </li>
      </ul>
    </nav>
    <transition name="fade">
      <div class="gap">
        <router-view></router-view>        
      </div>
    </transition>
  </div>
</template>

<script>

export default {
}
</script>

<style>
.box-shadow {
  box-shadow: none;
  transition: box-shadow 0.3s ease-in-out;
}
.box-shadow:hover {
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.box-shadow-inverse {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
}
.box-shadow-inverse:hover {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
  transition: box-shadow 0.3s ease-in-out;
}
</style>