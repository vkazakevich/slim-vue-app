<template>
  <form @submit.prevent="submitForm" class="form">
    <div>
      <InputText v-model="form.title" placeholder="Title" required/>
      <small></small>
    </div>
    <div>
      <InputText v-model="form.author" placeholder="Author" required/>
      <small></small>
    </div>
    <div>
      <InputText
          v-model="form.publication_year"
          type="number"
          placeholder="Publication year"
          :min="1901"
          :max="2023"
          required
      />
      <small></small>
    </div>
    <div>
      <InputText v-model="form.genre" placeholder="Genre" required/>
      <small></small>
    </div>

    <Button type="submit">{{ book ? 'Update' : 'Add Book' }}</Button>
  </form>
</template>

<script>
import { mapActions } from 'pinia'
import { useBookStore } from '../stores/book.store'

export default {
  data: () => ({
    form: {}
  }),

  props: {
    book: {
      type: Object,
      required: false
    }
  },

  methods: {
    ...mapActions(useBookStore, [
      'createItem',
      'editItem'
    ]),

    submitForm () {
      if (this.book) {
        this.updateBook(this.book)
        return
      }
      this.createBook()
    },

    async createBook () {
      try {
        await this.createItem(this.form)
        this.$emit('created')
        this.reset()
      } catch (e) {
        this.$emit('error', e.message)
      }
    },

    async updateBook ({ id }) {
      try {
        await this.editItem(this.form, id)
        this.$emit('updated')
      } catch (e) {
        this.$emit('error', e.message)
      }
    },

    reset () {
      this.form = Object.assign({}, {
        'title': '',
        'author': '',
        'publication_year': 2023,
        'genre': ''
      })
    }
  },

  mounted () {
    this.reset()

    if (this.book) {
      this.form = Object.assign({}, this.book)
    }
  }
}
</script>
