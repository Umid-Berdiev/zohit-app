<template>
  <div class="row">
    <div class="col">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Navbar</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <router-link to="/" class="nav-link">Home</router-link>
              <router-link to="/about" class="nav-link">About</router-link>
              <router-link to="/map" class="nav-link">Map</router-link>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style></style>
