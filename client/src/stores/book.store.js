import axios from 'axios'
import { defineStore } from 'pinia'

export const useBookStore = defineStore('book', {
  state: () => ({
    items: [],
    total: 0,
    currentPage: 1,
    perPage: 10
  }),

  actions: {
    async fetchItems (params = {}) {
      const { data } = await axios.get('/api/books', { params })

      this.items = data.data

      this.total = data.total
      this.currentPage = data.current_page
      this.perPage = data.per_page
    },

    async createItem (params) {
      await axios.post('/api/books', params)
    },

    async editItem (params, bookId) {
      const { data } = await axios.put(`/api/books/${bookId}`, params)

      this.items = this.items.map(item => item.id === bookId ? {...item, ...data} : item)
    },

    async deleteItem (bookId) {
      await axios.delete(`/api/books/${bookId}`)
      this.items = this.items.filter(item => item.id !== bookId)
    }
  },
})