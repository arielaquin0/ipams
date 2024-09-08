import { createRouter, createWebHistory } from 'vue-router'
import Layout from '@/layout/index.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/redirect',
      component: Layout,
      children: [
        {
          path: '/redirect/:path(.*)',
          component: () => import('@/views/redirect')
        }
      ]
    },
    {
      path: '/login',
      component: () => import('@/views/auth/Login.vue'),
      hidden: true
    },
    {
      path: '/404',
      component: () => import('@/views/error-page/404.vue'),
      hidden: true
    },
    {
      path: "/",
      name: "Root",
      component: Layout,
      redirect: '/dashboard',
      children: [
        {
          path: "dashboard",
          name: "Dashboard",
          component: () => import('@/views/dashboard/index.vue'),
        },
      ]
    },
    { path: '/:pathMatch(.*)', redirect: '/404' }
  ]
});

export default router;
