import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  {
    path: '/',
    name: 'login',
    component: () =>
      
      import(
        /* webpackChunkName: "login" */ '../components/views/auth/login.vue'
      ),      
  },
  {
    path: '/admin/home',
    name: 'admin/home',
    component: () =>
      import(
        /* webpackChunkName: "login" */ '../components/views/admin/admin-index.vue'
      ),      
  },
  {
    path: '/admin/user',
    name: 'usermanagement',
    component: () =>
      import(
        /* webpackChunkName: "login" */ '../components/views/admin/admin-users.vue'
      ),      
  },
  {
    path: '/admin/ticket',
    name: 'ticketmanagement',
    component: () =>
      import(
        /* webpackChunkName: "login" */ '../components/views/admin/admin-tickets.vue'
      ),      
  },
//   {
//     path: '/',
//     name: 'login',
//     component: () =>
//       import(
//         /* webpackChunkName: "login" */ '../components/views/auth/login.vue'
//       ),      
//   },
];



    const router = createRouter({
        history: createWebHistory(),
        routes
      });

      export default router;