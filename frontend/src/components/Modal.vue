<script setup>
import { ref, toRefs } from "vue";
import { useModalStore } from "@/stores/modal";

const isVisible = ref(false);
const props = defineProps({
  data: {
    type: Object,
    default: null
  }
});

function _close() {
  isVisible.value = false
  setTimeout(() => {
    useModalStore().resetModal()
  }, 200)
}

defineExpose({
  close: _close,
  show: () => {
    isVisible.value = true
  }
});

const {
  data
} = toRefs(props);
</script>

<template>
  <a-modal
    v-model:open="isVisible"
    :title="data?.title"
    :footer="null"
    :maskClosable="false"
    :width="data?.width || 520"
  >
    <template v-if="data?.childComponent">
      <component
        v-bind:is="{...data.childComponent}"
        v-bind="data?.props || {}"
      />
    </template>
  </a-modal>
</template>

<style scoped>

</style>
