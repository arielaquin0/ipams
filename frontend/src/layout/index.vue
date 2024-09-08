<script setup>
import Header from "@/layout/Header.vue";
</script>

<template>
  <a-layout>
    <Header />
    <a-layout>
      <a-layout-content :style="{ background: '#fff', padding: '24px', margin: 0, minHeight: '768px' }">
        <router-view />
      </a-layout-content>
    </a-layout>
  </a-layout>
</template>
