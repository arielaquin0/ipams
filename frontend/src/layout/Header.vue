<script setup>
import { useUserStore } from "@/stores/user";
import { useRouter } from "vue-router";

const router = useRouter();
const boxStyle = {
  width: '100%',
  height: '65px',
};

const logOut = () => {
 useUserStore().logout().then(() => {
    router.push(`/login?redirect=/`)
  })
}
</script>

<template>
  <a-layout-header class="header" :style="{ background: '#F5F5F5' }">
    <a-flex :style="{ ...boxStyle }" justify="space-between" align="center">
      <h2>IP Address Management Solution</h2>
      <a-button size="large" type="default" @click="logOut" :style="{ width: '120px' }">Logout</a-button>
    </a-flex>
  </a-layout-header>
</template>
