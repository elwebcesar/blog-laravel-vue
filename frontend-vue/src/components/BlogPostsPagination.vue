<template>
  <div class="container-fluid">
    <div class="row">
        <header class="col-12 col-lg-2">
            <BlogInfo />
        </header>
        <div class="col-12 col-lg-10">
            <section class="col-md-12" v-for="post in posts" :key="post.id">
                <article class="post-home">
                    <header class="container-fluid py-5 px-3">
                        <div class="d-flex">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M30 15L0 -1.31134e-06L-1.31134e-06 30L30 15ZM17.8125 15L5.625 21.0937L5.625 8.96485L17.8125 15Z" fill="#0D6EFD"/>
                            </svg>
                            <div>
                                <h3 class="card-title">{{ post.title }}</h3>
                                <p class="fs-date">{{ post.fc }}</p>
                            </div>
                        </div>
                    </header>
                    <aside class="d-flex bg-primary">
                        <router-link :to="{ name: 'BlogPostDetail', params: { id: post.id } }" class="container-fluid d-flex justify-content-end">
                            <svg width="91" height="50" viewBox="0 0 91 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M65.2607 50L58.827 43.0442L73.5781 28.0695H-3.8147e-06V19.2982H73.5781L58.827 5.8283L65.2607 0L91 23.8681L65.2607 50Z" fill="#F3F3F3"/>
                            </svg>
                        </router-link>
                    </aside>
                </article>
            </section>
            <hr>
            <nav aria-label="Page navigation" class="d-flex justify-content-end navigation">
                <ul class="list-inline">
                    <li class="list-inline-item" v-if="currentPage > 1">
                        <a class="bg-primary text-white py-2 px-5" href="#" @click="goToPage(currentPage - 1)">Anterior</a>
                    </li>
                    <li
                        class="list-inline-item"
                        v-for="page in totalPages"
                        :key="page"
                        :class="{ active: page === currentPage }"
                    >
                        <a class="bg-primary text-white py-2 px-5" href="#" @click="goToPage(page)">{{ page }}</a>
                    </li>
                    <li class="list-inline-item" v-if="currentPage < totalPages">
                        <a class="bg-primary text-white py-2 px-5" href="#" @click="goToPage(Number(currentPage) + 1)">Siguiente</a>
                    </li>                
                </ul>
            </nav>
        </div>
    </div>
  </div>
</template>

<script>
import BlogInfo from './interface/BlogInfo.vue';
import { getPaginatedPosts } from '../services/api';

/*
export default {
  name: 'BlogPost',
  data() {
    return {
      posts: [],
    };
  },
  created() {
    this.fetchPosts();
  },
  methods: {
    async fetchPosts() {
      try {
        const response = await getPaginatedPosts(1, 2);
        const data = response.data.resultado.data.regs;
        this.posts = data.map(post => ({
          id: post.id,
          title: post.title,
          intro: post.content.substring(0, 100) + '...', // Tomar los primeros 100 caracteres del contenido
          path: post.path,
        }));
      } catch (error) {
        console.error('Error al obtener las publicaciones:', error);
      }
    },
  },
};
*/

// With pagination

const totalPostInPage = 3;

export default {
  name: 'BlogPostsPagination',

  // load components
  components: {
    BlogInfo
  },

  // api gestion
  data() {
    return {
      posts: [],
      currentPage: 1,
      totalPages: 1,
    };
  },
  created() {
    this.fetchPosts();
  },
  methods: {
    async fetchPosts(page = 1) {
      console.log(`Fetching posts for page ${page}`);
      try {
        const response = await getPaginatedPosts(page, totalPostInPage);
        const data = response.data.resultado.data;
        this.posts = data.regs.map(post => ({
          id: post.id,
          title: post.title,
          intro: post.content.substring(0, 100) + '...', // Get first 100 characters of content
          path: post.path,
          fc: post.fc,
        }));
        console.log('Datos del array posts:', this.posts);
        this.currentPage = data.current_page;
        this.totalPages = data.last_page;
        console.log(`Current page: ${this.currentPage}, Total pages: ${this.totalPages}`);
      } catch (error) {
        console.error('Error al obtener las publicaciones:', error);
      }
    },
    goToPage(page) {
      console.log(`Attempting to go to page ${page}`);
      if (page < 1 || page > this.totalPages) {
        console.log(`Invalid page number: ${page}`);
        return;
      }
      this.fetchPosts(page);
    },
  },
};
</script>
