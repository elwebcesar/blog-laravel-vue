<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ isEditing ? 'Editar Post' : 'Crear Post' }}</h2>
                <hr>
                <div class="list-group">
                    <form @submit.prevent="savePost">
                        <div class="form-group">
                        <label for="title">Título</label>
                        <input
                            type="text"
                            class="form-control"
                            id="title"
                            v-model="post.title"
                            required
                        />
                        </div>
                        <div class="form-group">
                        <label for="content">Contenido</label>
                        <textarea
                            class="form-control"
                            id="content"
                            v-model="post.content"
                            required
                        ></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" @click="cancel">&#xd7; Cancelar</button>
                            <button type="submit" class="btn btn-primary">{{ isEditing ? 'Actualizar' : 'Crear' }} &#x2713;</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { getPost, savePost } from '../../services/api';

export default {
  name: 'CreateEditPost',
  props: {
    id: {
      type: String,
      required: false,
      default: null,
    },
  },
  data() {
    return {
      post: {
        id: 0,
        title: '',
        content: '',
      },
    };
  },
  computed: {
    ...mapGetters(['isAuthenticated', 'token']),
    isEditing() {
      return this.id !== null;
    },
  },
  created() {
    if (!this.isAuthenticated) {
      this.$router.push('/login');
    }
    if (this.isEditing) {
      this.fetchPost();
    }
  },
  methods: {
    async fetchPost() {
      try {
        const response = await getPost(this.id);
        this.post = response.data.resultado.data;
      } catch (error) {
        console.error('Error al obtener el post:', error);
      }
    },
    async savePost() {
      try {
        const response = await savePost(this.post, this.token);
        console.log('Respuesta del servidor:', response.data);
        this.$router.push('/dashboard');
      } catch (error) {
        console.error('Error al guardar el post:', error);
      }
    },
    cancel() {
      this.$router.push('/dashboard');
    },
  },
};
</script>
