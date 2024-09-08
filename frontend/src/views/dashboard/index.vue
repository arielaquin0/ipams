<script setup>
import { reactive, onMounted } from "vue";
import bus from "@/utils/bus";
import { useIpAddressStore } from "@/stores/ip-address";
import { useModalStore } from "@/stores/modal";
import AddIpAddressModal from "@/views/dashboard/AddIpAddressModal.vue";
import EditIpAddressModal from "@/views/dashboard/EditIpAddressModal.vue";
import ViewIpAddressLogModal from "@/views/dashboard/ViewIpAddressLogModal.vue";

const columns = [
  {
    title: 'IP Address',
    dataIndex: 'ip_address',
  },
  {
    title: 'Label',
    dataIndex: 'label',
  },
  {
    title: 'Comment',
    dataIndex: 'comment',
  },
  {
    title: 'Action',
    dataIndex: 'action',
    key: 'action',
  }
];

const state = reactive({
  loading: false,
  page: 1,
  per_page: 10,
  total: 0,
  data: []
});

onMounted(() => {
  fetchIpAddresses();

  bus.on('ipAddressAdded', (data) => {
    if (state.data.length >= state.per_page) {
      state.data.pop();
      state.total = Math.ceil(state.total + 1 / state.per_page);
    }
    state.data.unshift(data);
  });

  bus.on('ipAddressLabelUpdated', (payload) => {
    const index = state.data.findIndex(datum => datum.id === payload.id);
    if (index !== -1) {
      state.data[index].label = payload.label;
    }
  });
})

function fetchIpAddresses(page = 1) {
  state.page = page;
  state.loading = true;

  useIpAddressStore().fetchIpAddresses({
    page: state.page,
    per_page: state.per_page,
  })
    .then(response => {
      state.page = response.current_page;
      state.total = response.total;
      state.data = response.data;
      state.loading = false;
    })
    .catch(error => {
      console.log('error: ', error);
      state.loading = false;
    })
}

function launchAddIpAddressModal() {
  useModalStore()
    .callModal({
      childComponent: AddIpAddressModal,
      title: "Add IP Address",
      width: 620,
    })
}

function launchEditIpAddressModal(row) {
  useModalStore()
    .callModal({
      childComponent: EditIpAddressModal,
      title: `Change IP Address Label: ${row.ip_address}`,
      width: 368,
      props: {
        id: row.id,
        currentLabel: row.label,
      }
    })
}

function launchIpAddressLogModal(id) {
  useModalStore()
    .callModal({
      childComponent: ViewIpAddressLogModal,
      title: "Audit Logs",
      width: 768,
      props: {
        id
      }
    })
}
</script>

<template>
  <div>
    <div style="display: flex; justify-content: flex-end; margin-bottom: 15px">
      <a-button type="primary" size="large" @click="launchAddIpAddressModal" :style="{ width: '120px' }">Add</a-button>
    </div>
    <a-table
      :columns="columns"
      :data-source="state.data"
      :pagination="false"
      :loading="state.loading"
    >
      <template #bodyCell="{ column, record }">
        <template v-if="column.key === 'action'">
          <span>
            <a @click="launchEditIpAddressModal(record)">Edit Label</a>
            <a-divider type="vertical" />
            <a @click="launchIpAddressLogModal(record.id)">View Log</a>
          </span>
        </template>
      </template>
    </a-table>
    <a-pagination
      v-model:current="state.page"
      v-model:page-size="state.per_page"
      :total="state.total"
      show-less-items
      :style="{ display: 'flex', justifyContent: 'flex-end', marginTop: '15px' }"
      @change="fetchIpAddresses"
    />
  </div>
</template>
