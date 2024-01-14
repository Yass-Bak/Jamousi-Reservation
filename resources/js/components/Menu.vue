<template>
   <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Mohamed Jamoussi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor02">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <router-link class="nav-link active" to="/">Page d'accueil</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link active" to="/ViewProducers">Liste Producteurs</router-link>
            </li>
             <li class="nav-item">
                  <router-link class="nav-link active" to="/ViewActeurs">Liste Acteurs</router-link>
                </li>
                <li class="nav-item">
                      <router-link class="nav-link active" to="/ViewFilms">Liste Films</router-link>
                    </li>
                    <li class="nav-item">
                          <router-link class="nav-link active" to="/EventsHomeCart">Nos Films</router-link>
                        </li>
                 <form class="d-flex" @submit.prevent="handleSearch">
            <!-- Bind the input value to the searchQuery property -->
            <input v-model="searchQuery" class="form-control me-sm-2" type="search" placeholder="Cherhcer un film">
            <!-- Change the type to button to prevent form submission -->
            <button @click="handleSearch" class="btn btn-secondary my-2 my-sm-0" type="button">Recherche</button>
          </form>
          </ul>

          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
    <li class="nav-item me-3">
    <router-link class="nav-link position-relative" :class="$route.name == 'Panier' ? 'active' : ''" aria-current="page" :to="{name: 'Panier'}">
    <i class="fa-solid fa-cart-shopping fa-lg" style="color:#ffffff;"></i>
    <span v-if="$store.state.Features.cart.length > 0"
    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
    {{ $store.state.Features.cart.length }}
    </span>
    </router-link>

    </li>
    </ul>
        </div>
      </div>
    </nav>
</template>

<script setup>

</script>

<style lang="scss" scoped></style>
