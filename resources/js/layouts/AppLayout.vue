<template>
  <div class="container">
    <TheHeader />
    <div class="row">
      <div class="col">
        <router-view v-slot="{ Component }">
          <transition name="component-fade" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view>
        <!-- <transition name="component-fade" mode="out-in">
          <router-view />
        </transition> -->
      </div>
    </div>
  </div>
</template>

<script>
import TheHeader from "../components/blocks/TheHeader.vue";

export default {
  components: { TheHeader },
};
</script>

<style></style>
