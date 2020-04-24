export default {
    namespaced: true,
    state: {
        snackbar: {
            text: {
                error: {
                    status: true,
                    color: "error",
                    text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้ง"},
                success: {
                    status: true,
                    color: "success",
                    text: "ทำรายการสำเร็จ"
                }
            }
        }
    },
    mutations: {},
    getters: {
        error: state => state.snackbar.text.error,
        success: state => state.snackbar.text.success
    },
    actions: {}
};
