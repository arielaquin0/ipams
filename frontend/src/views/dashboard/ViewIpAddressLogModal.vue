<script setup>
import { onMounted, ref } from "vue";
import { useIpAddressStore } from "@/stores/ip-address";

const props = defineProps({
  id: {
    type: Number,
    required: true,
  }
});

const loading = ref(true);
const columns = [
  {
    title: "Updated At",
    dataIndex: "updated_at",
    key: "updated_at",
  },
  {
    title: "Details",
    dataIndex: "details",
    key: "details",
  }
];
const data = ref([]);

onMounted(() => {
  showAuditLog();
});

function showAuditLog() {
  useIpAddressStore().showAuditLog(props.id)
    .then(response => {
      data.value = response;
      loading.value = false;
    })
    .catch(error => {
      console.log("error: ", error);
      loading.value = false;
    })
}
</script>

<template>
  <a-table :columns="columns" :data-source="data" :pagination="false" :loading="loading" :style="{ marginBottom: '10px' }">
    <template #bodyCell="{ column, text }">
      <template v-if="column.dataIndex === 'name'">
        <a>{{ text }}</a>
      </template>
    </template>
  </a-table>
</template>
