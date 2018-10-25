<template>
  <form class="add-form form-inline" @submit.prevent="formHandle()">
    <div class="form-group">
      <label class="control-label" :for="formId">{{ propTitle }}</label>
      <input type="text" :id="formId" class="form-control" v-model="propText">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
  </form>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Input',
  props: ['text', 'title', 'item'],
  data () {
    return {
      propText: this.text || '',
      propTitle: this.title || 'Редактировать'
    }
  },
  computed: {
    propItem: function () {
      let item = this.item || {}
      if (!item.id) item.id = 0
      return item
    },
    formId: function () {
      let departmentid = (this.propItem.department_id) ? this.propItem.department_id + 'employee' : ''
      return 'form-department' + departmentid + this.propItem.id
    }
  },
  methods: {
    formHandle () {
      let method = 'post'
      let table = (this.propItem.department_id) ? 'employees' : 'departments'
      let url = process.env.API_URL + table
      let data = {
        name: this.propText
      }
      if (this.propItem.id) {
        method = 'put'
        url += '/' + this.propItem.id
      } else if (this.propItem.department_id) {
        data.department_id = this.propItem.department_id
      }
      axios({ method, url, data })
        .then(response => {
          this.propText = ''
          this.$emit('saved', response.data)
        })
        .catch(error =>
          console.log(error)
        )
    }
  }
}
</script>
