<template>
    <div id="table-container">
      <table border="1">
        <thead>
          <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Username</th>
            <th>Password</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="customer in customers" :key="customer.ID">
            <td>{{ customer.ID }}</td>
            <td>
              <span v-if="!customer.editMode">{{ customer.FirstName }}</span>
              <input v-else v-model="customer.FirstName" :maxlength="fieldMaxLength" required />
            </td>
            <td>
              <span v-if="!customer.editMode">{{ customer.LastName }}</span>
              <input v-else v-model="customer.LastName" :maxlength="fieldMaxLength" required />
            </td>
            <td id="dob-td">
              <span v-if="!customer.editMode">{{ customer.DateOfBirth }}</span>
              <input v-else type="date" v-model="customer.DateOfBirth" :maxlength="fieldMaxLength" required />
            </td>
            <td>
              <span v-if="!customer.editMode">{{ customer.Username }}</span>
              <input v-else v-model="customer.Username" :maxlength="fieldMaxLength" required />
            </td>
            <td>
              <span v-if="!customer.editMode">{{ customer.Password }}</span>
              <input v-else v-model="customer.Password" :maxlength="fieldMaxLength" required />
            </td>
            <td>
              <button class="button-4" role="button" @click="editCustomer(customer)">
                {{ customer.editMode ? 'Save' : 'Edit' }}
              </button>
              <button class="button-4" role="button" @click="deleteCustomer(customer.ID)">
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  
  export default {
    props: {
      customers: Array,
      editCustomer: Function,
      deleteCustomer: Function,
    },
    setup(props) {
      const fieldMaxLength = ref(20);
  
      const editCustomer = (customer) => {
        props.editCustomer(customer);
      };
  
      const deleteCustomer = (customerId) => {
        props.deleteCustomer(customerId);
      };
  
      return { fieldMaxLength, editCustomer, deleteCustomer };
    },
  };
  </script>

<style>
table {
    width: 800px;
    border-collapse: collapse;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

#table-container {
    max-height: 310px;
    overflow-y: auto;
    height: 310px;
}

th,
td {
    padding: 15px;
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
    max-width: 170px;
    min-width: 170px;
    overflow-x: auto;
    white-space: nowrap;
    box-sizing: border-box;
    overflow-y: hidden;
}

td input,
td span {
    max-width: 130px;
}

th {
    text-align: left;
}

#dob-td {
    max-width: 100px;
    min-width: 100px;
}

thead th {
    background-color: #55608f;

}

tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.3);
}

tbody td {
    position: relative;
}

tbody td:hover:before {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    top: -9999px;
    bottom: -9999px;
    background-color: rgba(255, 255, 255, 0.2);
    z-index: -1;
}
</style>