export default {
    namespaced: true,
    state: {
        msg: {
            text: {
                titleMain: "วัน-เวลารับสินค้า",
                dateGet: "วันที่นัดรับ",
                timeGet: "เวลานัดรับ",
                clearTimeGet: "ล้างเวลา"
            },
            icon: {
                main: "schedule",
                event: "event",
                dateGet: "calendar_today",
                timeGet: "timer",
                clear: "refresh"
            }
        },
        rules: {
            dateGet: [
                v => !!v || "ห้ามเว้นว่าง",
                v => {
                    const pattern = /[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/;
                    return (
                        pattern.test(v) ||
                        "กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น"
                    );
                }
            ],
            timeGet: [
                v => !!v || "ห้ามเว้นว่าง",
                v => {
                    const pattern = /[0-9]{2}[:]{1}[0-9]{2}/;
                    return (
                        pattern.test(v) ||
                        "กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น"
                    );
                }
            ]
        }
    },
    mutations: {
    },
    getters: {
        msg: state => state.msg,
        rules: state => state.rules
    },
    actions: {
        async checkDateTimeGet({}, payload) {
            return await axios
                .post(`/api/admin/v1/order/checkDateTimeGet`, payload)
                .then(response => {
                    return response;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        
    }
};
