export default {
    namespaced: true,
    state: {
        customer: "",
        getSearch: "",
        messages: {
            titleSearch: "ค้นหาลูกค้า",
            iconSearch: "search",
            phoneNumberCustomer: "เบอร์โทรลูกค้า",
            nameCustomer: "ชื่อลูกค้า",
            iconSelect: "check_circle_outline",
            selectCustomerText: "เลือกลูกค้า",
            icon: {
                refresh: "refresh",
                edit: "edit",
                add: "add_circle_outline",
                dataCustomer: "person",
                phone:"phone"
            },
            text: {
                refresh: "ล้างข้อมูล",
                addNewCustomer: "เพิ่มลูกค้าใหม่",
                nameCustomer: "ชื่อลูกค้า",
                phoneNumberCustomer: "เบอร์โทรลูกค้า",
                dataCustomer: "ข้อมูลลูกค้า",
                social: "ช่องทางอื่น",
                successAddNewCustomer:"เพิ่มลูกค้าใหม่สำเร็จ"
            }
        },
        rules: {
            name: [v => !!v || "ห้ามเว้นว่าง"],
            social: [v => !!v || "ห้ามเว้นว่าง"],
            phone_number: [
                v => !!v || "ห้ามเว้นว่าง",
                v => v.length == 10 || "กรอกเบอร์โทร 10 หลักเท่านั้น",
                v => {
                    const pattern = /[0]{1}[0-9]{9}/;
                    return (
                        pattern.test(v) ||
                        "กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น"
                    );
                }
            ]
        }
    },
    mutations: {
        getSearch(state, data) {
            state.getSearch = data;
        },
        messages(state, data) {
            state.messages = data;
        },
        setCustomer(state) {
            state.customer = state.getSearch;
        },
        resetCustomer(state) {
            state.getSearch = "";
        }
    },
    getters: {
        getSearch: state => state.getSearch,
        messages: state => state.messages,
        customer: state => state.customer,
        rules: state => state.rules
    },
    actions: {
        async getSearch({ commit }, payload) {
            await axios
                .post(`/api/admin/v1/customer/getSearchByPhoneNumber`, {
                    phone_number: payload
                })
                .then(response => {
                    // console.log(response.data);
                    commit("getSearch", response.data);
                })
                .catch(err => console.error(err));
        },
        async store({ commit }, payload) {
            return await axios
                .post(`/api/admin/v1/customer`, payload)
                .then(response => {
                    commit("getSearch", response.data);
                    return response;
                })
                .catch(err => console.error(err));
        }
    }
};
