<script setup>
import { computed, ref, onMounted } from "vue";
import { useModalStore } from "@/stores/modal";
import bus from "@/utils/bus.js";
import Header from "@/layout/Header.vue";
import Modal from "@/components/Modal.vue";

const primaryModal = computed(() => {
  return useModalStore().modalData;
})

const thisModal = ref(null);

onMounted(() => {
  bus.on('openModal', () => {
    thisModal.value.show();
  });

  bus.on('closeModal', () => {
    thisModal.value.close();
  });
});
</script>

<template>
  <a-layout>
    <Header />
    <a-layout>
      <a-layout-content :style="{ background: '#fff', padding: '24px', margin: 0, minHeight: '768px' }">
        <router-view />
      </a-layout-content>
    </a-layout>

    <Modal ref="thisModal" :data="primaryModal"/>
  </a-layout>
</template>
