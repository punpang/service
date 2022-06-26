export default {
    namespaced: true,
    state: {
        fetch_options: [],
        product: {
            a_product_id: "",
            price: 0,
            name_goods: "",
            a_price: {},
            add_ons: [],
            message: "-",
            detail: "-",
            sum: {
                addOn: 0,
                total: 0,
            },
        },
        productDetail: {},
        fetchProduct: {},
        fetchAddOn: [],
        op1: [],
        op2: [],
        op3: [],
        op4: [],
        msg: {
            text: {
                op1: "ประเภท",
                op2: "เนื้อเค้ก",
                op3: "ตกแต่ง",
                op4: "ขนาด",
                add: "เพิ่ม",
                edit: "แก้ไข",
                select: "เลือก",
                exit: "ออก",
                price: "ราคา",
                save: "บันทึก",
                editSuccess: "เปลี่ยนแปลงสำเร็จ",
                editError: "เปลี่ยนแปลงไม่สำเร็จ",
                addSuccess: "เพิ่มสินค้าสำเร็จ",
                addError: "เพิ่มสินค้าไม่สำเร็จ",
                detail: "รายละเอียด",
                message: "เขียนข้อความ",
                clear: "ล้าง",
                goods: "สินค้า",
                moreOptions: "ตัวเลือกเพิ่มเติม",
                detailProduct: "รายละเอียดสินค้า",
            },
            icon: {
                add: "add",
                edit: "edit",
                select: "check_circle_outline",
                exit: "exit_to_app",
                save: "save",
                clear: "clear",
                goods: "shopping_cart",
            },
        },
        rules: {
            op: [(v) => !!v || "ห้ามเว้นว่าง"],
            price: [(v) => !!v || "ห้ามเว้นว่าง"],
            message: [(v) => !!v || "ห้ามเว้นว่าง"],
            detail: [(v) => !!v || "ห้ามเว้นว่าง"],
        },
    },
    mutations: {
        fetch_options(state, data) {
            state.fetch_options = data;
        },
        fetchProduct(state, data) {
            state.fetchProduct = data;
        },
        product(state, data) {
            console.log(data);
            // a_price_id: "",
            // price: 0,
            // name_goods: "",
            // a_price: {},
            // add_ons: [],
            // message: "-",
            // detail: "-",
            // sum:{
            //     addOn:0,
            //     total:0
            // },
            state.product = {
                a_product_id: data.id,
                price: data.price,
                name_goods: data.name_goods,
                a_price: data,
                add_ons: state.product.add_ons,
                message: state.product.message,
                detail: state.product.detail,
                sum: {
                    addOn: state.product.sum.addOn,
                    total: state.product.sum.addOn + data.price,
                },
            };
        },
        setProduct(state, data) {
            state.product = data;
        },
        fetchAddOn(state, data) {
            state.fetchAddOn = data;
        },
        addProductAddOn(state, data) {
            state.product.addOns.push(data);
            state.product.sumAddOn = state.product.addOns.reduce(
                (sum, { price }) => {
                    return parseInt(sum + price);
                },
                0
            );
            state.product.sumTotal =
                state.product.sumAddOn + state.product.data.price;
        },
        removeProductAddOn(state, data) {
            state.product.addOns.splice(data, 1);
            state.product.sumAddOn = state.product.addOns.reduce(
                (sum, { price }) => {
                    return parseInt(sum + price);
                },
                0
            );
            state.product.sumTotal =
                state.product.sumAddOn + state.product.data.price;
        },
        sumAddOn(state) {
            state.product.sumAddOn = state.product.addOns.reduce(
                (sum, { price }) => {
                    return parseInt(sum + price);
                },
                0
            );
        },
        resetProduct(state, data) {
            state.product = {
                a_product_id: "",
                price: 0,
                name_goods: "",
                a_price: {},
                add_ons: [],
                message: "-",
                detail: "-",
                sum: {
                    addOn: 0,
                    total: 0,
                },
            };
        },
        op1(state, data) {
            state.op1 = data;
        },
        op2(state, data) {
            state.op2 = data;
        },
        op3(state, data) {
            state.op3 = data;
        },
        op4(state, data) {
            state.op4 = data;
        },
    },
    getters: {
        msg: (state) => state.msg,
        rules: (state) => state.rules,
        fetchProduct: (state) => state.fetchProduct,
        op1: (state) => state.op1,
        op2: (state) => state.op2,
        op3: (state) => state.op3,
        op4: (state) => state.op4,
        product: (state) => state.product,
        fetchAddOn: (state) => state.fetchAddOn,
        fetch_options: (state) => state.fetch_options,
    },
    actions: {
        async fetchProduct({ commit }, payload) {
            return await axios
                .post(`/api/admin/v1/order/product/fetchPriceOfCake`, payload)
                .then((response) => {
                    commit("fetchProduct", response.data);
                    return response.status;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async fetchOption({ commit }) {
            return await axios
                .get(`/api/admin/v1/order/product/fetchOption`)
                .then((response) => {
                    commit("op1", response.data.op1);
                    commit("op2", response.data.op2);
                    commit("op3", response.data.op3);
                    commit("op4", response.data.op4);
                    return response.status;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async editPrice({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/product/${payload.id}/editPrice`,
                    payload
                )
                .then((response) => {
                    return response.status;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async addPrice({ dispatch }, payload) {
            return await axios
                .post(`/api/admin/v1/order/product/addPrice`, payload)
                .then((response) => {
                    dispatch("fetchProduct", payload.ops);
                    return response.status;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async fetchAddOn({ commit }, payload) {
            return await axios
                .get(
                    `/api/admin/v1/order/product/fetchAddOn?am4=${payload.am4}&name=${payload.addOnName}`
                )
                .then((response) => {
                    commit("fetchAddOn", response.data);
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async uploadImageProduct({ commit }, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/product/${payload.product_id}/uploadImageProduct`,
                    payload
                )
                .then((response) => {
                    commit("fetchProduct", response.data.product);
                    return response.status;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async fetch_options({}, payload) {
            return await axios
                .get(
                    `/api/admin/v1/order/product/${payload.option_id}/fetch_options`,
                    payload
                )
                .then((response) => {
                    // commit("fetch_options", response.data.options);
                    return response.data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async update_sort({}, payload) {
            return await axios
                .post(`/api/admin/v1/order/product/update_sort`, payload)
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async add_option({}, payload) {
            return await axios
                .post(`/api/admin/v1/order/product/add_option`, payload)
                .then((response) => {
                    return response.data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
