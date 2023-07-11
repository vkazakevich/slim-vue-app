<template>
  <div class="card p-fluid">
    <DataTable
        :value="bookStore.items"
        :rows="bookStore.perPage"
        :loading="loading"
        :totalRecords="bookStore.total"
        lazy
        paginator
        tableStyle="min-width: 50rem"
        @sort="onSort($event)"
        @page="onPage($event)"
    >
      <template #header>
        <div class="table__header">
          <span class="p-input-icon-left form-search">
              <i class="pi pi-search"/>
              <InputText placeholder="Search Book" @input="onSearch($event)"/>
          </span>
          <Button label="Add Book" icon="pi pi-plus" @click="addBook"/>
        </div>
      </template>

      <Column field="title" header="Title" sortable/>
      <Column field="author" header="Author" sortable/>
      <Column field="genre" header="Genre" sortable/>
      <Column field="publication_year" header="Publication Year" sortable style="width: 12rem"/>

      <Column :exportable="false">
        <template #body="slotProps">
          <div class="book__controls">
            <Button icon="pi pi-pencil" outlined rounded style="margin-right: 10px;" @click="editBook(slotProps.data)"/>
            <Button icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDeleteBook(slotProps.data)"/>
          </div>
        </template>
      </Column>
    </DataTable>

    <Dialog
        v-model:visible="deleteBookDialog"
        header="Confirm"
        modal
        :style="{ width: '100%', maxWidth: '450px' }"
    >
      <div class="confirmation-content">
        Are you sure you want to delete <strong>{{ selectedBook ? selectedBook.title : '' }}</strong>?
      </div>
      <template #footer>
        <Button label="No" icon="pi pi-times" @click="deleteBookDialog = false"/>
        <Button label="Yes" icon="pi pi-check" @click="deleteBook"/>
      </template>
    </Dialog>

    <Dialog
        v-model:visible="addOrEditDialog"
        modal
        :header="selectedBook ? 'Edit Book' : 'Add Book'"
        :style="{ width: '100%', maxWidth: '450px' }"
    >
      <template v-if="addOrEditDialog">
        <BookForm :book="selectedBook" @updated="onUpdated" @created="onCreated" @error="onError"/>
      </template>
    </Dialog>
  </div>
</template>

<script>
import { mapStores } from 'pinia'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'

import { useBookStore } from '../stores/book.store'
import BookForm from './BookForm.vue'

export default {
  components: {
    BookForm,
    DataTable,
    Column
  },

  data: () => ({
    loading: false,

    options: {
      search: '',
      sortField: '',
      sortOrder: ''
    },

    deleteBookDialog: false,
    addOrEditDialog: false,
    selectedBook: false,
  }),

  computed: {
    ...mapStores(useBookStore)
  },

  methods: {
    fetchItems (payload = {}) {
      this.loading = true
      this.bookStore.fetchItems(payload)
          .finally(() => (this.loading = false))
    },

    onSort ({ sortField, sortOrder }) {
      this.options = Object.assign({}, this.options, {
        sortField,
        sortOrder: sortOrder > 0 ? 'DESC' : 'ASC'
      })

      this.fetchItems(this.options)
    },

    onPage ({ page }) {
      this.fetchItems({
        page: page + 1,
        ...this.options
      })
    },

    onSearch ({ target }) {
      this.options = Object.assign({}, this.options, {
        search: target.value
      })

      this.fetchItems(this.options)
    },

    addBook () {
      this.selectedBook = null
      this.addOrEditDialog = true
    },

    editBook (book) {
      this.selectedBook = book
      this.addOrEditDialog = true
    },

    confirmDeleteBook (book) {
      this.selectedBook = book
      this.deleteBookDialog = true
    },

    async deleteBook () {
      await this.bookStore.deleteItem(this.selectedBook.id)
      this.fetchItems(this.options)
      this.successToast('The book was deleted')
      this.deleteBookDialog = false
    },

    onUpdated () {
      this.successToast('The book was updated')
      this.addOrEditDialog = false
    },

    onCreated () {
      this.successToast('The book was created')
      this.fetchItems()
    },

    onError (message) {
      this.$toast.add({
        severity: 'error',
        summary: 'Unsuccessful',
        life: 3000,
        detail: message
      })
    },

    successToast (detail) {
      this.$toast.add({
        severity: 'success',
        summary: 'Successful',
        life: 3000,
        detail
      })
    }
  },

  created () {
    this.fetchItems()
  }
}
</script>
