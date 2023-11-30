<template>
  <div class="modal" v-show="showConfirmation">
    <div class="modal-content">
      <p>Are you sure you want to delete this item?</p>
      <button class="button-4" @click="confirmDelete()">Yes</button>
      <button class="button-4" @click="cancelDelete()">No</button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    showConfirmation: Boolean,
    confirmDelete: Function,
    cancelDelete: Function
  },
  setup(props) {
    const confirmDelete = () => {
     props.confirmDelete();
    };

    const cancelDelete = () => {
      props.cancelDelete();
    };

    return { confirmDelete, cancelDelete };
  },
};
</script>

<style>
.modal {
    display: block;
    position: fixed;
    width: 100%;
    height: 100%;
    top:0;
    left:0;
    backdrop-filter: blur(10px);
    z-index: 1;
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
    text-align: center;
    border-radius: 10px;
}
</style>