<template>
  <div>
    <h1>กำลังเปลี่ยนหน้า</h1>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  async mounted() {
    let loader = this.$loading.show();
    const form = {
      uuid: this.$route.params.uuid,
    };
    await axios
      .post("/api/loginByQrCode", form)
      .then((response) => {
          console.log(response);
        // login user, store the token and redirect to dashboard
        if (response.status === 201) {
          this.$router.replace("/table/close");
        }
        this.$store.commit("main/loginUser");
        localStorage.setItem("token", response.data.access_token);
        // ค่าเริ่มต้น headers auth
        axios.defaults.headers.common["Authorization"] =
          "Bearer " + localStorage.getItem("token");
        //
        axios
          .get("/api/user", {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          })
          .then((res) => {
            this.$store.commit("main/User", res.data);
            this.$store.dispatch("menuBar/lists");
            if (this.$route.query.from == null) {
              this.$router.replace("/table/" + form.uuid);
            }
            //this.$router.replace(this.$route.query.from);
          });
        loader.hide();
      })
      .catch((error) => {
        if (error.response.status == "500") {
          this.$toast.warning(
            "ลองอีกครั้ง ! ไม่สามารถเชิ่อมต่อไปยังเซิร์ฟเวอร์ได้"
          );
        } else {
          this.$toast.error("ไม่สามารถเข้าสู่ระบบได้ กรุณาลองอีกครั้งค่ะ");
        }
        this.loginError = true;
        this.loading = false;
      });
  },
};
</script>