export default {
    namespaced: true,
    state: {
        todos: [],
        toRemove: null,
        newTodo: {
            title: "",
            completed: false
        }
    },
    mutations: {
        ADD_TODO(state, todo) {
            state.todos.unshift(todo);
        },
        CACHE_REMOVED(state, todo) {
            state.toRemove = todo;
        },
        GET_TODOS(state, todos) {
            state.todos = todos;
        },
        DELETE_TODO(state, todo) {
            state.todos.splice(state.todos.indexOf(todo), 1);
            state.toRemove = null;
        }
    },
    getters: {
        newTodo: state => {
            return state.newTodo;
        },
        todos: state => {
            return state.todos;
        },
        toRemove: state => {
            return state.toRemove;
        }
    },
    actions: {
        ADD_TODO({ commit }, todo) {
            axios
                .post("/api/todos", todo)
                .then(res => {
                    if (res.data === "added") console.log("ok");
                })
                .catch(err => {
                    console.log(err);
                });
        },
        DELETE_TODO({ commit }, todo) {
            axios
                .delete(`/api/todos/${todo.id}`)
                .then(res => {
                    if (res.data === "deleted") console.log("deleted");
                })
                .catch(err => {
                    console.log(err);
                });
        },
        GET_TODOS({ commit }, payload) {
            axios
                .get("/api/todos/" + payload)
                .then(res => {
                    {
                        console.log(res.data);
                        commit("GET_TODOS", res.data);
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
