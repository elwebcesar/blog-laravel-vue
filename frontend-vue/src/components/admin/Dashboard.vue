<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <h2>Posts</h2>
        <div class="container-fluid d-flex justify-content-between">
          <button class="btn btn-primary mt-3" @click="createPost">Crear Post</button>
          <button class="btn btn-dark mt-3" @click="handleLogout">Cerrar Sesión &#x2197;</button>
        </div>
        <hr>
        <ul class="list-group">
          <li class="list-group-item" v-for="post in posts" :key="post.id">
            <h3>{{ post.title }}</h3>
            <p>{{ post.content }}</p>
            <p class="fs-date">Publicado el {{ post.fc }}</p>
            <hr>
            <div class="btn-group mb-2" role="group">
              <button class="btn btn-primary btn-sm" @click="editPost(post.id)">Editar</button>
              <!-- <button class="btn btn-outline-danger btn-sm" @click="deletePost(post.id)">Eliminar</button> -->
              <button class="btn btn-outline-danger btn-sm" @click="confirmDelete(post.id, post.title)">Eliminar</button>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import { getPosts, deletePost } from '../../services/api';

export default {
  name: 'Dashboard',
  computed: {
    ...mapGetters(['isAuthenticated', 'token']),
  },
  data() {
    return {
      posts: [],
    };
  },
  created() {
    if (!this.isAuthenticated) {
      this.$router.push('/login');
    }
    this.fetchPosts();
  },
  methods: {
    ...mapActions(['logout']),
    async fetchPosts() {
      try {
        const response = await getPosts();
        this.posts = response.data.resultado.data.regs;
      } catch (error) {
        console.error('Error al obtener los posts:', error);
      }
    },
    editPost(postId) {
      this.$router.push({ name: 'EditPost', params: { id: postId } });
    },
    async deletePost(postId) {
      try {
        await deletePost(postId, this.token);
        this.fetchPosts(); // Actualizar la lista de posts
      } catch (error) {
        console.error('Error al eliminar el post:', error);
      }
    },
    createPost() {
      this.$router.push({ name: 'CreatePost' });
    },
    handleLogout() {
      this.logout({ router: this.$router });
    },
    confirmDelete(postId, postTitle) {
      if (confirm(`¿Estás seguro de que deseas eliminar el post: ${postTitle}?`)) {
        this.deletePost(postId);
      }
    },
  },
};
</script>
