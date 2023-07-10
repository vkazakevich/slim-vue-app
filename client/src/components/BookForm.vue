<template>
  <form @submit.prevent="submitForm" class="form">
    <div>
      <InputText v-model="form.title" placeholder="Title"/>
      <small></small>
    </div>
    <div>
      <InputText v-model="form.author" placeholder="Author"/>
      <small></small>
    </div>
    <div>
      <InputText v-model="form.publication_year" placeholder="Publication year"/>
      <small></small>
    </div>
    <div>
      <InputText v-model="form.genre" placeholder="Genre"/>
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
      this.reset()
    },

    async createBook () {
      await this.createItem(this.form)
      this.$emit('created')
    },

    async updateBook ({ id }) {
      await this.editItem(this.form, id)
      this.$emit('updated')
    },

    reset () {
      this.form = Object.assign({}, {
        'title': '',
        'author': '',
        'publication_year': '',
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
