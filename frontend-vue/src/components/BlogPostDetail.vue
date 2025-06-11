<template>
  <div class="container-fluid">
      <div class="row">
          <header class="col-12 col-lg-2">
              <BlogInfo />
          </header>
          <div class="col-12 col-lg-10">
                <section class="col-md-12">
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
                      <div class="container-fluid py-5 px-3">
                          <p>{{ post.content }}</p>
                      </div>
                      <aside class="d-flex bg-primary">
                            <router-link :to="{ name: 'BlogPostsPagination' }" class="back">
                              <svg width="91" height="50" viewBox="0 0 91 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M65.2607 50L58.827 43.0442L73.5781 28.0695H-3.8147e-06V19.2982H73.5781L58.827 5.8283L65.2607 0L91 23.8681L65.2607 50Z" fill="#F3F3F3"/>
                              </svg>
                            </router-link>
                      </aside>
                  </article>
              </section>
          </div>
      </div>
  </div>
</template>

<script>
import BlogInfo from './interface/BlogInfo.vue';
import { getPost } from '../services/api';

export default {
  name: 'BlogPostDetail',

  // load components
  components: {
    BlogInfo
  },

  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      post: {
        id: null,
        title: '',
        content: '',
        fc: '',
      },
    };
  },
  created() {
    this.fetchPost();
  },
  methods: {
    async fetchPost() {
      try {
        const response = await getPost(this.id);
        const data = response.data.resultado.data;
        this.post = {
          id: data.id,
          title: data.title,
          content: data.content,
          fc: data.fc,
        };
      } catch (error) {
        console.error('Error al obtener el post:', error);
      }
    },
  },
};
</script>
