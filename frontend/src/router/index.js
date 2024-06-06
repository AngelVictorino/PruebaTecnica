import { createRouter, createWebHistory } from 'vue-router';
import RegisterView from '../views/RegisterView.vue';
import LoginView from '../views/LoginView.vue'; // Asegúrate de que el nombre del archivo coincida exactamente
import IndexView from '../views/IndexView.vue';

const routes = [
  {
    path: '/register',
    name: 'Register',
    component: RegisterView,
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginView,
  },
  {
    path: '/register',
    name: 'Home',
    // Aquí puedes agregar la vista principal (Home)
    // component: HomeView,
    component: {
      template: '<div>Home</div>'
    }
  },
  {
    path: '/index',
    name: 'IndexView',
    component: IndexView
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
