import axios from 'axios';

const API_URL = process.env.VUE_APP_API_URL || 'http://127.0.0.1:8000/api/';

const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

// user
export const getPaginatedPosts = (page, perPage) => api.get(`/posts/paginated?page=${page}&per_page=${perPage}`);
export const getPost = (id) => api.get(`/posts/${id}`);

// admin
export const getPosts = () => api.get('/posts');
export const savePost = (post, token) => api.post('/v1/post/save', post, {
  headers: {
    'Authorization': `Bearer ${token}`,
  },
});
export const deletePost = (id, token) => api.post('/v1/post/delete', { id }, {
  headers: {
    'Authorization': `Bearer ${token}`,
  },
});
