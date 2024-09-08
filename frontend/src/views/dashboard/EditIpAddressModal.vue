<script setup>
import { reactive, ref } from 'vue';
import bus from "@/utils/bus";
import { useIpAddressStore } from "@/stores/ip-address";
import { useModalStore } from "@/stores/modal";
import { labelOptions } from './selectOptions';

const saveText = ref("Save");
const loading = ref(false);
const alert = reactive({
  message: "",
  type: "error",
});
const formRef = ref();
const formState = reactive({
  ip_address: null,
  label: null,
  comment: null,
});

const props = defineProps({
  id: {
    type: Number,
    required: true,
  },
  currentLabel: {
    type: String,
    required: true,
  }
});

const onSubmit = (values) => {
  loading.value = true;
  saveText.value = "Saving...";
  useIpAddressStore().updateIpAddress(props.id, values)
    .then(response => {
      loading.value = false;
      saveText.value = "Saved";
      alert.type = "success";
      alert.message = "Label updated successfully";

      setTimeout(() => {
        saveText.value = "Save";
        bus.emit("ipAddressLabelUpdated", response);
        useModalStore().closeModal();
      }, 1000)
    })
    .catch(error => {
      loading.value = false;
      alert.type = "error";
      alert.message = error?.response?.data.message || "Something went wrong! Please try again later";
      console.log('error: ', error);
    })
}
</script>

<template>
  <div>
    <a-alert v-if="alert.message" :message="alert.message" :type="alert.type" :style="{ marginBottom: '12px' }" />
    <a-form
      ref="formRef"
      name="advanced_search"
      class="ant-advanced-search-form"
      :model="formState"
      @finish="onSubmit"
      layout="vertical"
    >
      <a-row :gutter="24">
        <a-col :span="24">
          <a-form-item
            name="label"
            label="Label"
            :rules="[{ required: true, message: 'This field is required' }]"
          >
            <a-select v-model:value="formState.label" placeholder="please select label">
              <a-select-option
                v-for="option in labelOptions.filter(label => label.value !== props.currentLabel)"
                :key="option.value"
                :value="option.value"
              >
                {{ option.value }}
              </a-select-option>
            </a-select>
          </a-form-item>
        </a-col>
      </a-row>
      <a-row>
        <a-col :span="24" style="text-align: right">
          <a-button type="primary" :loading="loading" html-type="submit">
            {{ saveText }}
          </a-button>
          <a-button style="margin: 0 8px" @click="() => useModalStore().closeModal()">Cancel</a-button>
        </a-col>
      </a-row>
    </a-form>
  </div>
</template>
