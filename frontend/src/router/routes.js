// src/router.js
import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/auth/login.vue'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/',
    name: 'Teste',
    component: () => import('../views/Teste.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/auth/register.vue'),
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  if (to.meta.requiresAuth && !token) {
    next('/login');
  } else if (token && to.path === '/login') {
    next('/'); 
  } else if (token && to.path === '/register') {
    next('/'); 
  }
  else {
    next();
  }
});


export default router
