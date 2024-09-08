<script setup>
import { ref, reactive, computed, watch } from "vue";
import { UserOutlined, LockOutlined } from "@ant-design/icons-vue";
import { useRouter, useRoute } from "vue-router";
import { useUserStore } from "@/stores/user";

const formState = reactive({
  username: "admin",
  password: "123456",
});

const errorMessage = ref(null);

const state = reactive({
  otherQuery: {},
  redirect: undefined
})

const router = useRouter();
const route = useRoute()
let getOtherQuery = (query) => {
  return Object.keys(query).reduce((acc, cur) => {
    if (cur !== 'redirect') {
      acc[cur] = query[cur]
    }
    return acc
  }, {})
}

watch(
  () => route.query,
  (query) => {
    if (query) {
      state.redirect = query.redirect
      state.otherQuery = getOtherQuery(query)
    }
  },
  { immediate: true }
)
const onFinish = (values) => {
  useUserStore()
    .login(values)
    .then(() => {
      router.push({ path: state.redirect || '/', query: state.otherQuery });
      location.reload();
    })
    .catch(error => {
      errorMessage.value = error?.response?.data?.msg || "Something went wrong! Please try again later";
    })
};

const disabled = computed(() => {
  return !(formState.username && formState.password);
});
</script>

<template>
  <div class="container">
    <div class="centered">
      <a-alert v-if="errorMessage" closable :message="errorMessage" type="error" :style="{ marginBottom: '12px' }" />
      <a-form
          :model="formState"
          class="login-form"
          @finish="onFinish"
          layout="vertical"
      >
        <a-form-item
            label="Username"
            name="username"
            :rules="[{ required: true, message: 'Please input your username!' }]"
        >
          <a-input v-model:value="formState.username">
            <template #prefix>
              <UserOutlined class="site-form-item-icon" />
            </template>
          </a-input>
        </a-form-item>

        <a-form-item
            label="Password"
            name="password"
            :rules="[{ required: true, message: 'Please input your password!' }]"
        >
          <a-input-password v-model:value="formState.password">
            <template #prefix>
              <LockOutlined class="site-form-item-icon" />
            </template>
          </a-input-password>
        </a-form-item>

        <a-form-item>
          <a-button :disabled="disabled" type="primary" html-type="submit" class="login-form-button">
            Log in
          </a-button>
        </a-form-item>
      </a-form>
    </div>
  </div>
</template>

<style>
body {
  background-color: #F8F9FB;
}
</style>

<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 98vh;
}

.centered {
  background-color: white;
  padding: 40px;
  border-radius: 8px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  width: 400px;
}

#components-form-demo-normal-login .login-form {
  max-width: 300px;
}
#components-form-demo-normal-login .login-form-forgot {
  float: right;
}
#components-form-demo-normal-login .login-form-button {
  width: 100%;
}
</style>
