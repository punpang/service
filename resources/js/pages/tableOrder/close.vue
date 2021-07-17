<template>
  <div>
    <h1>ขอบคุณที่ใช้บริการ</h1>
  </div>
</template>

<script>
export default {
  async mounted() {
    await axios.post("/api/test/logOut");
    localStorage.removeItem("token");
    this.$store.commit("main/logoutUser");
  },
};
</script>