<template>
  <div></div>
</template>

<script>
import { toast } from "vue3-toastify";

export default {
  methods: {
    showToastError(errorMessage) {
      toast.error(errorMessage, {
        timeout: 3500,
      });
    },
    showToastSuccess(successMessage) {
      toast.info(successMessage, {
        timeout: 3500,
      });
    },
  },
};
</script>
