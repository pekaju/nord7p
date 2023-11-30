<template>
    <div id="form-div">
      <form @submit.prevent="handleSubmit">
        <div v-for="field in formFields" :key="field.name">
          <label>{{ field.label }}:</label>
          <input v-model="newCustomer[field.name]" :type="field.type" :max="field.max" :min="field.min" :required="field.required" />
        </div>
        <button class="button-4" role="button">Add Customer</button>
      </form>
    </div>
  </template>
  
<script>
import { ref } from 'vue';

export default {
    props: {
        newCustomer: Object,
        getMaxDate: Function,
        getMinDate: Function,
        addCustomer: Function,
    },
    setup(props) {
        const formFields = ref([
            { name: 'FirstName', label: 'First Name', type: 'text', required: true },
            { name: 'LastName', label: 'Last Name', type: 'text', required: true },
            { name: 'DateOfBirth', label: 'Date of Birth', type: 'date', max: props.getMaxDate(), min: props.getMinDate(), required: true },
            { name: 'Username', label: 'Username', type: 'text', required: true },
            { name: 'Password', label: 'Password', type: 'password', required: true },
        ]);

        const handleSubmit = () => {
            props.addCustomer();
        };

        return { formFields, handleSubmit };
    },
};
</script>
  
<style>
#form-div {
    border: 1px rgba(255, 255, 255, 0.25) solid;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-top: 20px;
}

form button {
    margin-left: 530px;
    margin-top: 20px;
    margin-bottom: 20px;
}

form div {
    display: flex;
    margin: 5px;
    margin-left: 450px;
}

form div label {
    display: inline-flex;
    width: 100px;
}

form div input {
    position: relative;
    left: 30px;
    width: 130px;
}
</style>