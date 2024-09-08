<script setup>
const boxStyle = {
  width: '100%',
  height: '65px',
};

const logOut = () => {

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
