import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store/index'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', redirect: '/login' },
    {
      path: '/',
      component: () => import('../layouts/default.vue'),
      children: [
        {
          path: 'dashboard',
          component: () => import('../pages/dashboard.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'account-settings',
          component: () => import('../pages/account-settings.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'users',
          component: () => import('../pages/users.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'roles',
          component: () => import('../pages/roles.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'orders',
          component: () => import('../pages/orders.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'files',
          component: () => import('../pages/files.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'grammers',
          component: () => import('../pages/grammers.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'typography',
          component: () => import('../pages/typography.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'icons',
          component: () => import('../pages/icons.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'cards',
          component: () => import('../pages/cards.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'tables',
          component: () => import('../pages/tables.vue'),
          meta:{requiresAuth:true}
        },
        {
          path: 'form-layouts',
          component: () => import('../pages/form-layouts.vue'),
          meta:{requiresAuth:true}
        },
      ],
    },
    {
      path: '/',
      component: () => import('../layouts/blank.vue'),
      children: [
        {
          path: 'login',
          component: () => import('../pages/login.vue'),
          meta:{requiresUnAuth:true}
        },
        {
          path: 'register',
          component: () => import('../pages/register.vue'),
        },
        {
          path: '/:pathMatch(.*)*',
          component: () => import('../pages/[...all].vue'),
        },
      ],
    },
  ],
})
// Navigation guard
router.beforeEach(function(to,from,next){
  if(to.meta.requiresAuth && !store.getters.isAuth){
    next('/login');
  }
  else if(to.meta.requiresUnAuth && store.getters.isAuth){
    next('/dashboard')
  }
  else{
    next();
  }
});
export default router
