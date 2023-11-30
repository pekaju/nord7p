<template>
	<div id="app">
		<div id="inner-app">
			<customer-form :newCustomer="newCustomer" :getMaxDate="getMaxDate" :getMinDate="getMinDate"
				:addCustomer="addCustomer" />
			<table-container :customers="customers" :editCustomer="editCustomer" :deleteCustomer="askForDeleteConfirmation" />
			<modal v-show="showConfirmation" :confirmDelete="confirmDelete" :cancelDelete="cancelDelete" />
		</div>
	</div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
	setup() {
		const customers = ref([]);
		const newCustomer = ref({
			FirstName: '',
			LastName: '',
			DateOfBirth: '',
			Username: '',
			Password: '',
		});
		const showConfirmation = ref(false);
		let customerToDelete = null;
		const fetchCustomers = () => {
			fetch("http://localhost:3000/server.php") // Update URL
				.then((response) => response.json())
				.then((data) => {
					console.log(data);
					customers.value = data;
				});
		};
		const addCustomer = () => {
			fetch("http://localhost:3000/server.php", {
				// Update URL
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
				body: JSON.stringify(newCustomer.value),
			})
				.then((response) => response.json())
				.then((data) => {
					console.log(data.message);
					newCustomer.value = {
						FirstName: "",
						LastName: "",
						DateOfBirth: "",
						Username: "",
						Password: "",
					};
					fetchCustomers();
				})
				.catch((error) => {
					console.error("Error adding customer:", error);
				});
};
const editCustomer = (customer) => {
	customer.editMode = !customer.editMode;
	if (customer.editMode && !validateSaveOperation(customer)) {
		customer.editMode = false;
	} else if (!customer.editMode) {
		// If you want to save changes when exiting edit mode
		fetch("http://localhost:3000/server.php", {
			method: "PUT",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify(customer),
		})
			.then((response) => response.json())
			.then((data) => {
				fetchCustomers();
			});
	}
};
const deleteCustomer = (customerId) => {
	console.log(customerId)
	fetch("http://localhost:3000/server.php", {
		method: "DELETE",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({ ID: customerId }),
	})
		.then((response) => response.json())
		.then((data) => {
			console.log(data.message);
			fetchCustomers();
		});
};
const validateSaveOperation = (customer) => {
	if (customer.FirstName.length === 0 || customer.LastName.length === 0 || customer.Username.length === 0
		|| customer.Password.length === 0 || customer.DateOfBirth.length === 0) {
		alert("All fields are required.");
		return false;
	}
	if (!validateDateOfBirth(customer)) {
		return false;
	}
	return true;
};
const validateDateOfBirth = (customer) => {
	const dateOfBirth = customer.DateOfBirth;
	const dobDate = new Date(dateOfBirth);
	if (isNaN(dobDate.getTime())) {
		alert("Invalid date.");
		return false;
	}
	const minDate = new Date(getMinDate());
	const maxDate = new Date(getMaxDate());

	if (dobDate < minDate || dobDate > maxDate) {
		alert("Date must be between 01-01-1900 and the current date.");
		return false;
	}
	return true;
};
const getMaxDate = () => {
	const today = new Date();
	const maxYear = today.getFullYear();
	const maxMonth = today.getMonth() + 1; // Note: Months are 0-indexed
	const maxDay = today.getDate();
	return `${maxYear}-${maxMonth.toString().padStart(2, "0")}-${maxDay
		.toString()
		.padStart(2, "0")}`;
};

const getMinDate = () => {
	const minYear = 1900;
	const minMonth = 1;
	const minDay = 1;
	return `${minYear}-${minMonth.toString().padStart(2, "0")}-${minDay
		.toString()
		.padStart(2, "0")}`;
};
const askForDeleteConfirmation = (customer) => {
	customerToDelete = customer;
	showConfirmation.value = true;
	console.log(showConfirmation.value)
};

const confirmDelete = () => {
	console.log(customerToDelete)
	deleteCustomer(customerToDelete);
	showConfirmation.value = false;
};

const cancelDelete = () => {
	customerToDelete = null;
	showConfirmation.value = false;

};
onMounted(fetchCustomers);
return {
	customers,
	newCustomer,
	showConfirmation,
	fetchCustomers,
	addCustomer,
	cancelDelete,
	confirmDelete,
	askForDeleteConfirmation,
	getMaxDate,
	getMinDate,
	validateDateOfBirth,
	validateSaveOperation,
	editCustomer
};
	},
}
</script>

<style>
html,
body {
	height: 100%;
}

body {
	margin: 0;
	background: linear-gradient(45deg, #49a09d, #5f2c82);
	font-family: sans-serif;
	font-weight: 100;
}

#app {
	position: absolute;
	top: 50%;
	left: 50%;
	width: 100%;
	height: 100%;
	transform: translate(-50%, -50%);
	overflow:hidden;
}

#inner-app {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}

.button-4 {
	appearance: none;
	background-color: #fafbfc;
	border: 1px solid rgba(27, 31, 35, 0.15);
	border-radius: 6px;
	box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0,
		rgba(255, 255, 255, 0.25) 0 1px 0 inset;
	box-sizing: border-box;
	color: #24292e;
	cursor: pointer;
	display: inline-block;
	font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial,
		sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
	font-size: 14px;
	font-weight: 500;
	line-height: 20px;
	list-style: none;
	padding: 6px 16px;
	position: relative;
	transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
	user-select: none;
	-webkit-user-select: none;
	touch-action: manipulation;
	vertical-align: middle;
	white-space: nowrap;
	word-wrap: break-word;
}

.button-4:hover {
	background-color: #f3f4f6;
	text-decoration: none;
	transition-duration: 0.1s;
}

.button-4:disabled {
	background-color: #fafbfc;
	border-color: rgba(27, 31, 35, 0.15);
	color: #959da5;
	cursor: default;
}

.button-4:active {
	background-color: #edeff2;
	box-shadow: rgba(225, 228, 232, 0.2) 0 1px 0 inset;
	transition: none 0s;
}

.button-4:focus {
	outline: 1px transparent;
}

.button-4:before {
	display: none;
}

.button-4:-webkit-details-marker {
	display: none;
}
</style>
