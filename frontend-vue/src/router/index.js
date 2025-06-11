import { createRouter, createWebHistory } from 'vue-router';

// components user
import BlogPostsPagination from '../components/BlogPostsPagination.vue';
import BlogPostDetail from '../components/BlogPostDetail.vue';

// components admin
import Login from '../components/admin/Login.vue';
import Dashboard from '../components/admin/Dashboard.vue';
import CreateEditPost from '../components/admin/CreateEditPost.vue';

const routes = [

  // routes user
  {
    path: '/',
    name: 'BlogPostsPagination',
    component: BlogPostsPagination,
  },
  {
    path: '/post/:id',
    name: 'BlogPostDetail',
    component: BlogPostDetail,
    props: true,
  },

  // routes admin
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
  },
    // posts
    {
      path: '/post/create',
      name: 'CreatePost',
      component: CreateEditPost,
    },
    {
      path: '/post/edit/:id',
      name: 'EditPost',
      component: CreateEditPost,
      props: true,
    },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
