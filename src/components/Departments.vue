<template>
  <div class="departments">
    <transition>
      <div v-if="!departments">
        Loading...
      </div>
      <div v-else>
        <div v-for="department in departments"
             :key="'department' + department.id"
             v-if="department.show"
             class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-8 col-md-10">
                <div v-if="department.edit">
                  <Input :text="department.name" :item="department" class="pull-left" v-on:saved="updatedHandle"/>
                  <button class="btn btn-link" @click="editHandle(department, false)">Отменить</button>
                </div>
                <h4 v-else>{{ department.name }}</h4>
              </div>
              <div class="col-xs-4 col-md-2 text-right">
                <button class="btn btn-default btn-sm" @click="editHandle(department)">
                  <span class="glyphicon glyphicon-edit"></span>
                </button>
                <button class="btn btn-danger btn-sm"
                        @click="deleteHandle(department)">
                  <span class="glyphicon glyphicon-minus"></span>
                </button>
              </div>
            </div>
          </div>
          <ul class="employees list-group">
            <li v-for="employee in department.employees"
                :key="'department' + department.id + 'employee' + employee.id"
                v-if="employee.show"
                class="list-group-item">
              <div class="row">
                <div class="col-xs-8 col-md-10">
                  <div v-if="employee.edit">
                    <Input :text="employee.name" :item="employee" class="pull-left" v-on:saved="updatedHandle"/>
                    <button class="btn btn-link" @click="editHandle(employee, false)">Отменить</button>
                  </div>
                  <div v-else>{{ employee.name }}</div>
                </div>
                <div class="col-xs-4 col-md-2 text-right">
                  <button class="btn btn-default btn-sm" @click="editHandle(employee)">
                    <span class="glyphicon glyphicon-edit"></span>
                  </button>
                  <button class="btn btn-danger btn-sm"
                          @click="deleteHandle(employee)">
                    <span class="glyphicon glyphicon-minus"></span>
                  </button>
                </div>
              </div>
            </li>
          </ul>
          <div class="panel-body">
            <Input title="Добавить сотрудника" :item="{department_id: department.id}" v-on:saved="insertedHandle"/>
          </div>
        </div>
        <Input title="Добавить отдел" v-on:saved="insertedHandle"/>
      </div>
    </transition>
  </div>
</template>

<script>
import axios from 'axios'
import Input from './Input'

export default {
  name: 'Departments',
  data () {
    return {
      departments: null
    }
  },
  methods: {
    get () {
      let url = process.env.API_URL + 'departments?expand=employees'
      axios
        .get(url)
        .then(response => {
          let departments = {}
          response.data.map(department => {
            department.edit = false
            department.show = true
            let employees = {}
            department.employees.map(employee => {
              employee.edit = false
              employee.show = true
              employees[employee.id] = employee
            })
            department.employees = employees
            departments[department.id] = department
          })
          this.departments = departments
        })
        .catch(error =>
          console.log(error)
        )
    },
    editHandle (item = {}) {
      if (!item.id) return
      item.edit = !item.edit
    },
    deleteHandle (item = {}) {
      if (!item.id) return
      let table = 'department'
      let name = 'отдел ' + item.name
      if (item.department_id) {
        name = 'сотрудника ' + item.name
        table = 'employee'
      } else if (item.employees && Object.keys(item.employees).length) {
        name += ' и всех его сторудников'
      }
      let confirm = window.confirm('Вы действительно хотите удалить ' + name + '?')
      if (confirm) {
        let url = process.env.API_URL + table + 's/' + item.id
        axios
          .delete(url)
          .then(response => {
            item.show = false
          })
          .catch(error =>
            console.log(error)
          )
      }
    },
    insertedHandle (item = {}) {
      if (!item.id) return
      item.edit = false
      item.show = true
      if (item.department_id) {
        this.$set(this.departments[item.department_id].employees, item.id, item)
      } else {
        item.employees = {}
        this.$set(this.departments, item.id, item)
      }
    },
    updatedHandle (item = {}) {
      if (!item.id) return
      let itemOld = (item.department_id) ? this.departments[item.department_id].employees[item.id] : this.departments[item.id]
      let itemUpdated = itemOld
      itemUpdated.edit = false
      itemUpdated.name = item.name
      if (item.department_id) {
        this.$set(this.departments[item.department_id].employees, item.id, itemUpdated)
      } else {
        this.$set(this.departments, item.id, itemUpdated)
      }
    }
  },
  created () {
    this.get()
  },
  components: {
    Input
  }
}
</script>
