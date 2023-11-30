import { createApp } from 'vue';
import App from './App.vue';
import CustomerForm from './components/CustomerForm.vue';
import TableContainer from './components/TableContainer.vue';
import Modal from './components/Modal.vue';

const app = createApp(App);

app.component('customer-form', CustomerForm);
app.component('table-container', TableContainer);
app.component('modal', Modal);

app.mount('#app');
